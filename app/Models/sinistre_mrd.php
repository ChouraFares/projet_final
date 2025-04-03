<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sinistre_mrd extends Model
{
    use HasFactory;
    protected $fillable = [
         'numero_sinistre','compagnie_assurance','fournisseur' ,'nature_sinistre', 'lieu_sinistre',
        'date_sinistre', 'degats', 'charge', 'perte','estimation_de_remboursement', 'responsable', 'commentaires', 'statut',
    ];

}
