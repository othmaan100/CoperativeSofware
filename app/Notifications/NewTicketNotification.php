<?php

namespace App\Notifications;

use App\Models\Ticket;

class NewTicketNotification extends SimpleNotification
{
    public function __construct(protected Ticket $ticket) {}

    public function title(): string
    {
        return 'New '.($this->ticket->is_confidential ? 'confidential ' : '').'ticket: '.$this->ticket->subject;
    }

    public function body(): string
    {
        return "{$this->ticket->ticket_no} ({$this->ticket->categoryLabel()}) raised for {$this->ticket->member->full_name}.";
    }

    public function url(): ?string
    {
        return route('support.tickets.show', $this->ticket);
    }
}
