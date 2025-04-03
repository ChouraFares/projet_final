<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FactureComplimentaireThonModel;
use Illuminate\Http\Request;

class ResponsableFinanceAffectationDesStam extends Controller
{
    //
    public function index()
    {
        // Récupérer toutes les factures avec leurs chèques associés
        $factures = FactureComplimentaireThonModel::with('cheques')->get();

        // Passer les données à la vue
        return view('responsable_finance.detaille_affectation_stam', compact('factures'));
    }
    
}
