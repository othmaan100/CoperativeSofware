<?php

namespace App\Livewire\Support;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NewTicketNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class TicketQueue extends Component
{
    use WithPagination;

    public string $tab = 'unassigned';

    public bool $showCreateForm = false;

    public string $memberSearch = '';

    public string $selectedMemberId = '';

    public string $category = 'general';

    public string $subject = '';

    public string $body = '';

    public bool $is_confidential = false;

    public function mount(): void
    {
        abort_unless(Auth::user()->canAny(['handle_complaints', 'handle_confidential_complaints']), 403);
    }

    public function setTab(string $tab): void
    {
        abort_if($tab === 'confidential' && ! Auth::user()->can('handle_confidential_complaints'), 403);

        $this->tab = $tab;
        $this->resetPage();
    }

    public function openCreate(): void
    {
        abort_unless(Auth::user()->can('raise_complaint_on_behalf'), 403);

        $this->reset(['memberSearch', 'selectedMemberId', 'category', 'subject', 'body', 'is_confidential']);
        $this->category = 'general';
        $this->showCreateForm = true;
    }

    public function closeCreateForm(): void
    {
        $this->showCreateForm = false;
    }

    public function getSearchedMembersProperty()
    {
        if (mb_strlen($this->memberSearch) < 2) {
            return collect();
        }

        return Member::query()
            ->where('status', 'active')
            ->where(fn ($q) => $q->where('full_name', 'like', "%{$this->memberSearch}%")->orWhere('staff_id', 'like', "%{$this->memberSearch}%"))
            ->limit(10)
            ->get();
    }

    protected function rules(): array
    {
        return [
            'selectedMemberId' => ['required', 'exists:members,id'],
            'category' => ['required', 'in:'.implode(',', array_keys(Ticket::CATEGORIES))],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_confidential' => ['boolean'],
        ];
    }

    public function save(): void
    {
        abort_unless(Auth::user()->can('raise_complaint_on_behalf'), 403);

        $validated = $this->validate();
        $member = Member::findOrFail($validated['selectedMemberId']);

        $ticket = Ticket::create([
            'ticket_no' => Ticket::generateTicketNo(),
            'member_id' => $member->id,
            'raised_by' => Auth::id(),
            'category' => $validated['category'],
            'subject' => $validated['subject'],
            'is_confidential' => $validated['is_confidential'],
            'status' => Ticket::STATUS_OPEN,
        ]);

        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'body' => $validated['body'],
            'created_at' => now(),
        ]);

        ActivityLog::record(
            action: 'ticket.raised_on_behalf',
            description: "Logged ticket {$ticket->ticket_no} on behalf of {$member->full_name}: {$ticket->subject}.",
            subject: $ticket,
            properties: ['category' => $ticket->category, 'confidential' => $ticket->is_confidential],
        );

        $handlerPermission = $ticket->is_confidential ? 'handle_confidential_complaints' : 'handle_complaints';
        Notification::send(User::permission($handlerPermission)->get(), new NewTicketNotification($ticket));

        $this->closeCreateForm();
        $this->redirectRoute('support.tickets.show', $ticket, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = Ticket::query()->with(['member', 'assignedTo']);

        if (! Auth::user()->can('handle_confidential_complaints')) {
            $query->where('is_confidential', false);
        }

        match ($this->tab) {
            'mine' => $query->where('assigned_to', Auth::id())->whereIn('status', [Ticket::STATUS_OPEN, Ticket::STATUS_IN_PROGRESS]),
            'confidential' => $query->where('is_confidential', true)->whereIn('status', [Ticket::STATUS_OPEN, Ticket::STATUS_IN_PROGRESS]),
            'resolved' => $query->where('status', Ticket::STATUS_RESOLVED),
            'all' => $query->whereIn('status', [Ticket::STATUS_OPEN, Ticket::STATUS_IN_PROGRESS]),
            default => $query->whereNull('assigned_to')->where('status', Ticket::STATUS_OPEN)->where('is_confidential', false),
        };

        return view('livewire.support.ticket-queue', [
            'tickets' => $query->latest()->paginate(15),
            'categories' => Ticket::CATEGORIES,
        ]);
    }
}
