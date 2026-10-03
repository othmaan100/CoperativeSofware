<?php

namespace App\Livewire\Support;

use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Notifications\TicketReplyNotification;
use App\Notifications\TicketResolvedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TicketShow extends Component
{
    public Ticket $ticket;

    public string $replyBody = '';

    public function mount(Ticket $ticket): void
    {
        abort_unless($ticket->userCanView(Auth::user()), 403);

        $this->ticket = $ticket;
    }

    protected function isHandler(): bool
    {
        return $this->ticket->is_confidential
            ? Auth::user()->can('handle_confidential_complaints')
            : Auth::user()->can('handle_complaints');
    }

    protected function isOwner(): bool
    {
        return $this->ticket->member->user_id === Auth::id();
    }

    public function claim(): void
    {
        abort_unless($this->isHandler(), 403);

        $this->ticket->update([
            'assigned_to' => Auth::id(),
            'status' => Ticket::STATUS_IN_PROGRESS,
        ]);

        ActivityLog::record('ticket.claimed', "Claimed ticket {$this->ticket->ticket_no}.", $this->ticket);
        session()->flash('status', 'Ticket assigned to you.');
    }

    public function reply(): void
    {
        abort_unless($this->isHandler() || $this->isOwner(), 403);

        $this->validate(['replyBody' => ['required', 'string']]);

        $this->ticket->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->replyBody,
            'created_at' => now(),
        ]);

        if ($this->isOwner() && $this->ticket->status === Ticket::STATUS_RESOLVED) {
            $this->ticket->update(['status' => Ticket::STATUS_IN_PROGRESS]);
        } elseif ($this->isHandler() && $this->ticket->status === Ticket::STATUS_OPEN) {
            $this->ticket->update(['status' => Ticket::STATUS_IN_PROGRESS, 'assigned_to' => $this->ticket->assigned_to ?? Auth::id()]);
        }

        ActivityLog::record('ticket.replied', "Replied to ticket {$this->ticket->ticket_no}.", $this->ticket);

        // Notify "the other side": the member if a handler replied, the
        // assigned handler (or the whole queue, if unclaimed) if the member
        // replied — never notifying the replier about their own message.
        if ($this->isHandler()) {
            $this->ticket->member->user?->notify(new TicketReplyNotification($this->ticket, Auth::user()->name));
        } else {
            $recipient = $this->ticket->assignedTo;
            if ($recipient) {
                $recipient->notify(new TicketReplyNotification($this->ticket, Auth::user()->name));
            }
        }

        $this->reset('replyBody');
    }

    public function resolve(): void
    {
        abort_unless($this->isHandler(), 403);

        $this->ticket->update([
            'status' => Ticket::STATUS_RESOLVED,
            'resolved_by' => Auth::id(),
            'resolved_at' => now(),
        ]);

        ActivityLog::record('ticket.resolved', "Resolved ticket {$this->ticket->ticket_no}.", $this->ticket);

        $this->ticket->member->user?->notify(new TicketResolvedNotification($this->ticket));

        session()->flash('status', 'Ticket marked resolved.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->ticket->load(['messages.user', 'member', 'raisedBy', 'assignedTo']);

        return view('livewire.support.ticket-show', [
            'canHandle' => $this->isHandler(),
            'isOwner' => $this->isOwner(),
        ]);
    }
}
