<?php

namespace App\Http\Controllers;

use App\Models\FactureComplimentaireThonModel;
use App\Models\ChequePaiement;
use Illuminate\Http\Request;

class ResponsableFinanceDetailleTimbrageEtSurestarie extends Controller
{
    public function index()
    {
        // Récupérer toutes les factures avec leurs chèques associés
        $factures = FactureComplimentaireThonModel::with('cheques')->get();

        // Passer les données à la vue
        return view('responsable_finance.detaille_timbrage_et_avance_surestarie', compact('factures'));
    }
}