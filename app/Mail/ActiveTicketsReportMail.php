<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActiveTicketsReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Aktyvių problemų PDF ataskaita')
            ->view('emails.active-tickets-report')
            ->attachData($this->pdfContent, 'aktyvios-problemos.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}