<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssuranceRetraiteModel extends Model
{
    use HasFactory;

    protected $table = 'assurance_retraite_contracts'; // Nom de la table
    protected $primaryKey = 'id'; // Clé primaire
    public $timestamps = true; // Utilise les timestamps (created_at et updated_at)

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
