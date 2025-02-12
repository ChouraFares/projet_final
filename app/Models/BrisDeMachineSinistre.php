<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BrisDeMachineSinistre extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_sinistre',
        'assureur',
        'nature_sinistre',
        'lieu_sinistre',
        'date_sinistre',
        'degats',
        'charge',
        'perte',
        'responsable',
        'statu_du_dossier',
        'expert',
        'commentaires',
    ];
}
