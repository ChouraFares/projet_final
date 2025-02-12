<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrepaymentRequestNotification extends Notification
{
    use Queueable;

    private $facture;
    private $fournisseur;
    private $dateDemande;
    private $transitAgentName;

    public function __construct($facture, $fournisseur, $dateDemande, $transitAgentName)
    {
        $this->facture = $facture; // Objet complet
        $this->fournisseur = $fournisseur;
        $this->dateDemande = $dateDemande;
        $this->transitAgentName = $transitAgentName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $cheque = $this->facture->cheques->first();
    
        return [
            'facture_id' => $this->facture->id,
            'facture_number' => $this->facture->facture,
            'fournisseur' => $this->fournisseur,
            'date_demande' => $this->dateDemande->format('Y-m-d H:i:s'),
            'transit_agent' => $this->transitAgentName,
            'transit_agent_name' => $this->transitAgentName,
            'cheque_montant' => $cheque ? $cheque->montant : null,
            'cheque_ref_mdp' => $cheque ? $cheque->ref_mdp : null,
        ];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle demande de prépaiement')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle demande de prépaiement a été soumise.')
            ->line('**Détails :**')
            ->line('Numéro de facture : ' . $this->facture->facture)
            ->line('Fournisseur : ' . $this->fournisseur)
            ->line('Date de demande : ' . \Carbon\Carbon::parse($this->dateDemande)->format('d/m/Y H:i'))
            ->line('Agent de transit : ' . $this->transitAgentName)
            ->action('Voir les notifications', url('/responsable-finance'))
            ->line('Merci de vérifier cette demande dans le tableau de bord.');
    }
    public function toDatabase($notifiable)
    {
        return [
            'facture_id' => $this->facture->id,
            'facture_number' => $this->facture->facture,
            'fournisseur' => $this->fournisseur,
            'date_demande' => $this->dateDemande->format('Y-m-d H:i:s'),
            'transit_agent' => $this->transitAgentName,
            'transit_agent_name' => $this->transitAgentName,
        ];
    }
}