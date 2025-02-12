<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChequePaiement extends Model
{
    protected $table = 'cheque_paiements';

    protected $fillable = [
        'facture_id', 'payment_type', 'montant', 'ref_mdp',
        'date_expiration_assurance', 'numero_aliment_assurance',
        'echeance_timbrage', 'timbrage_montant_retenue_a_la_source','Etat', 'Attachement_Timbrage' // Nouveaux champs
    ];

    public function facture()
    {
        return $this->belongsTo(FactureComplimentaireThonModel::class, 'facture_id', 'id');
    }
}