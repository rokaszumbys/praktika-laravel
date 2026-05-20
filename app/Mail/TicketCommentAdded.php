<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCommentAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $comment;

    public function __construct(Ticket $ticket, TicketComment $comment)
    {
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    public function build()
    {
        return $this->subject('Pridėtas komentaras prie jūsų bilieto')
            ->view('emails.ticket-comment-added');
    }
}