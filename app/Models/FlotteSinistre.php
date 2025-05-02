<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlotteSinistre extends Model
{
    protected $table = 'flotte_sinistres';

    protected $fillable = [
        'compagnie_assurance',
        'sinistre_num',
        'immatriculation',
        'vehicule',
        'chauffeur',
        'fautif',
        'date_sinistre',
        'nature_sinistre',
        'avancements',
        'date_cloture_dossier',
        'reglement',
        'Expert',
        'reglement_reçu',
        'attachments_pdf',
        'statut',
        'commentaire',
    ];

    protected $casts = [
        'date_sinistre' => 'date',
        'date_cloture_dossier' => 'date',
    ];
}