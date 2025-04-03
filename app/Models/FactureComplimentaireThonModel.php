<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureComplimentaireThonModel extends Model
{
    use HasFactory;
    protected $table = 'facture_complimentaire_thon';

// FactureComplimentaireThonModel.php
protected $fillable = [
    'date_demande', 'facture', 'num_conteneur', 'fournisseur', 'armateur', 'incoterm', 'port', 'bank',
    'date_declaration', 'assureur', 'date_expiration', 'total', 'BL',
    'recette_finance_preparer_paiement', 'douane_preparer_paiement',
    'timbrage_et_avances_surestarie_preparer_paiement', 'stam_preparer_paiement',
    'assurance_preparer_paiement', 'date_recuperation', 'date_enlevement',
    'validation_transit', 'statut_finance', 'validation_finance',
];
// FactureComplimentaireThonModel.php
public function hasExistingRequest()
{
    return $this->date_demande !== null; // Ou une autre condition pertinente
}
public function hasExistingRequestForFacture()
{
    return self::where('facture', $this->facture)
        ->whereNotNull('date_demande')
        ->exists();
}

protected $casts = [
    'date_demande' => 'datetime',
    'date_declaration' => 'date',
    'date_expiration' => 'date',
    'date_recuperation' => 'date',
    'date_enlevement' => 'date',
];
protected $attributes = [
    'validation_transit' => 'en_attente', // Par défaut
    'validation_finance' => 'en_attente', // Par défaut
    'validation_DG' => 'en_attente', // Par défaut

];
public function cheques()
    {
        return $this->hasMany(ChequePaiement::class, 'facture_id', 'id');
    }
    
}





