<?php

namespace App\Notifications;

use App\Models\Ticket;

class TicketResolvedNotification extends SimpleNotification
{
    public function __construct(protected Ticket $ticket) {}

    public function title(): string
    {
        return 'Ticket resolved: '.$this->ticket->subject;
    }

    public function body(): string
    {
        return "{$this->ticket->ticket_no} has been marked resolved.";
    }

    public function url(): ?string
    {
        return route('support.tickets.show', $this->ticket);
    }
}
