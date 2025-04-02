<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PrepaymentApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $facture;

    public function __construct($facture)
    {
        $this->facture = $facture;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Validation de la demande de prépaiement',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.prepayment-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}