<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsableCivilSinistre extends Model
{
    use HasFactory;

    protected $table = 'responsable_civil_sinistres';

    protected $fillable = [
        'numero_de_sinistre',
        'assureur',
        'nature_sinistre',
        'lieu_sinistre',
        'date_sinistre',
        'degats',
        'charge',
        'perte',
        'responsable',
        'situation_du_dossier',
        'commentaires',
    ];

    public function contrat()
    {
        return $this->belongsTo(ResponsableCivilContrat::class, 'contrat_id');
    }
}
