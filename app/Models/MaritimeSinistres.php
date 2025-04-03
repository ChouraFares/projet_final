<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritimeSinistres extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_sinistre','assureur', 'prime', 'fournisseur', 'num_facture', 'montant_facture_usd',
        'montant_facture_tnd', 'num_conteneur', 'date_depot',
        'transporteur_maritime', 'date_incident', 'lieu', 'mt',
        'date_prev_remboursement','nature_de_sinistre','statut_du_dossier' ,'commentaire'
    ];
    }
