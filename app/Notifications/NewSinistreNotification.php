<?php

namespace App\Notifications;

use App\Models\FlotteSinistre;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewSinistreNotification extends Notification implements 
{

    public $sinistre;

    public function __construct(FlotteSinistre $sinistre)
    {
        $this->sinistre = $sinistre;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        Log::info('Début de la méthode toMail pour : ' . $notifiable->email);
    
        // Vérifier que les données nécessaires existent
        if (!$this->sinistre) {
            Log::error('Erreur : Les données du sinistre sont manquantes.');
            return;
        }
    
        Log::info('Données du sinistre : ', [
            'sinistre_num' => $this->sinistre->sinistre_num,
            'vehicule' => $this->sinistre->vehicule,
            'immatriculation' => $this->sinistre->immatriculation,
            'chauffeur' => $this->sinistre->chauffeur,
            'date_sinistre' => $this->sinistre->date_sinistre?->format('d/m/Y'),
            'nature_sinistre' => $this->sinistre->nature_sinistre,
            'statut' => $this->sinistre->statut,
        ]);
    
        return (new MailMessage)
            ->subject('[Urgent] Nouveau sinistre déclaré - ' . $this->sinistre->sinistre_num)
            ->greeting('Bonjour,')
            ->line('Un nouveau sinistre a été déclaré dans le système :')
            ->line('Numéro de sinistre: ' . $this->sinistre->sinistre_num)
            ->line('Véhicule: ' . $this->sinistre->vehicule . ' (' . $this->sinistre->immatriculation . ')')
            ->line('Chauffeur: ' . $this->sinistre->chauffeur)
            ->line('Date du sinistre: ' . $this->sinistre->date_sinistre?->format('d/m/Y'))
            ->line('Nature du sinistre: ' . $this->sinistre->nature_sinistre)
            ->line('Statut: ' . $this->sinistre->statut)
            ->action('Voir le sinistre', url('/admin/assurance/flotte/sinistres'))
            ->line('Merci de prendre les mesures nécessaires.')
            ->salutation('Cordialement,');
    }
}