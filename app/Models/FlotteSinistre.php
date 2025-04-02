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
        'situation_dossier',
        'date_cloture_dossier',
        'reglement',
        'Expert',
    ];
 
}
