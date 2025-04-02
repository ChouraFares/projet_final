<?php

namespace App\Notifications;

use App\Mail\PrepaymentRequestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class PrepaymentRequestNotification extends Notification
{
    use Queueable;

    private $facture;
    private $fournisseur;
    private $dateDemande;
    private $transitAgentName;

    public function __construct($facture, $fournisseur, $dateDemande, $transitAgentName)
    {
        $this->facture = $facture;
        $this->fournisseur = $fournisseur;
        $this->dateDemande = $dateDemande;
        $this->transitAgentName = $transitAgentName;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new PrepaymentRequestMail(
            $this->facture,
            $this->fournisseur,
            $this->dateDemande,
            $this->transitAgentName,
            $notifiable->name // Ajout du nom du destinataire
        ))->to($notifiable->email);
    }

    public function toArray($notifiable)
    {
        $cheque = $this->facture->cheques->first();

        return [
            'facture_id' => $this->facture->id,
            'facture_number' => $this->facture->facture,
            'fournisseur' => $this->fournisseur,
            'date_demande' => $this->dateDemande ? $this->dateDemande->format('Y-m-d H:i:s') : 'Non définie',
            'transit_agent' => $this->transitAgentName,
            'transit_agent_name' => $this->transitAgentName,
            'cheque_montant' => $cheque ? $cheque->montant : null,
            'cheque_ref_mdp' => $cheque ? $cheque->ref_mdp : null,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'facture_id' => $this->facture->id,
            'facture_number' => $this->facture->facture,
            'fournisseur' => $this->fournisseur,
            'date_demande' => $this->dateDemande ? $this->dateDemande->format('Y-m-d H:i:s') : 'Non définie',
            'transit_agent' => $this->transitAgentName,
            'transit_agent_name' => $this->transitAgentName,
        ];
    }
}