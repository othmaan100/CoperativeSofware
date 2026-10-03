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

class MyTickets extends Component
{
    public Member $member;

    public bool $showForm = false;

    public string $category = 'general';

    public string $subject = '';

    public string $body = '';

    public bool $is_confidential = false;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('raise_complaint'), 403);

        $this->member = Auth::user()->member()->firstOrFail();
    }

    public function openCreate(): void
    {
        $this->reset(['category', 'subject', 'body', 'is_confidential']);
        $this->category = 'general';
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
    }

    protected function rules(): array
    {
        return [
            'category' => ['required', 'in:'.implode(',', array_keys(Ticket::CATEGORIES))],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_confidential' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $ticket = Ticket::create([
            'ticket_no' => Ticket::generateTicketNo(),
            'member_id' => $this->member->id,
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
            action: 'ticket.raised',
            description: "Raised ticket {$ticket->ticket_no}: {$ticket->subject}.",
            subject: $ticket,
            properties: ['category' => $ticket->category, 'confidential' => $ticket->is_confidential],
        );

        $handlerPermission = $ticket->is_confidential ? 'handle_confidential_complaints' : 'handle_complaints';
        Notification::send(User::permission($handlerPermission)->get(), new NewTicketNotification($ticket));

        $this->closeForm();
        session()->flash('status', "Ticket {$ticket->ticket_no} raised.");
        $this->redirectRoute('support.tickets.show', $ticket, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.support.my-tickets', [
            'categories' => Ticket::CATEGORIES,
            'tickets' => $this->member->tickets()->paginate(15),
        ]);
    }
}
