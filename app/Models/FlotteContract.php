<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlotteContract extends Model
{
    use HasFactory;

    protected $table = 'flotte_contracts';

    // Colonnes assignables en masse
    protected $fillable = [
        'compagnie_assurance',
        'ref_contrat',
        'date_effet',
        'echeance',
        'condition_renouvellement',
        'avenant',
        'objet_avenant',
        'attachement_contrat',
        'attachement_avenant',
    ];
}
