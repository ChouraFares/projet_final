<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsableCivilContrat extends Model
{
    use HasFactory;

    protected $table = 'responsable_civil_contrats';  // Utilisez le nom correct de votre table

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

    public function sinistres()
    {
        return $this->hasMany(ResponsableCivilSinistre::class, 'contrat_id');
    }
}
