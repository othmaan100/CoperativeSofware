<?php

namespace App\Notifications;

use App\Models\Ticket;

class TicketReplyNotification extends SimpleNotification
{
    public function __construct(protected Ticket $ticket, protected string $replierName) {}

    public function title(): string
    {
        return 'New reply on '.$this->ticket->ticket_no;
    }

    public function body(): string
    {
        return "{$this->replierName} replied to \"{$this->ticket->subject}\".";
    }

    public function url(): ?string
    {
        return route('support.tickets.show', $this->ticket);
    }
}
