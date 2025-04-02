<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PrepaymentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $facture;
    public $fournisseur;
    public $dateDemande;
    public $transitAgentName;
    public $recipientName;

    public function __construct($facture, $fournisseur, $dateDemande, $transitAgentName, $recipientName)
    {
        $this->facture = $facture;
        $this->fournisseur = $fournisseur;
        $this->dateDemande = $dateDemande;
        $this->transitAgentName = $transitAgentName;
        $this->recipientName = $recipientName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de prépaiement',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.prepayment-request',
            with: [
                'recipientName' => $this->recipientName,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}