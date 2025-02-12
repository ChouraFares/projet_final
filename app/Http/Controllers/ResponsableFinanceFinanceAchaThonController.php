<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomNotification;
use App\Models\FactureComplimentaireThonModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsableFinanceFinanceAchaThonController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $unreadNotifications = CustomNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();
        
        $allNotifications = CustomNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('responsable_finance.dashboard', compact('unreadNotifications', 'allNotifications'));
    }
    
    //
    public function showPendingRequests()
    {
        $factures = FactureComplimentaireThonModel::where(function ($query) {
            $sections = [
                'assurance_preparer_paiement',
                'douane_preparer_paiement',
                'recette_finance_preparer_paiement',
                'stam_preparer_paiement',
                'timbrage_et_avances_surestarie_preparer_paiement'
            ];
    
            foreach ($sections as $section) {
                $query->orWhere($section, 1);
            }
        })
        ->orderByRaw("CASE 
            WHEN validation_finance = 'en_attente' THEN 0  -- En attente en haut
            WHEN validation_finance = 'Validé' THEN 1  -- Validé au milieu
            WHEN validation_finance = 'Refusé' THEN 2  -- Refusé en bas
            ELSE 3 
        END")
        ->orderBy('date_demande', 'desc') // Trier par date de demande (les plus récentes en haut)
        ->get();
    
        return view('responsable_finance.demande', compact('factures'));
    }
    
    public function validateRequest(Request $request, $id)
    {
        $facture = FactureComplimentaireThonModel::findOrFail($id);
    
        if ($request->action === 'approve') {
            $facture->update(['validation_finance' => 'Validé']);
        } elseif ($request->action === 'reject') {
            $facture->update(['validation_finance' => 'Refusé']);
        }
    
        return redirect()->route('responsable_finance.demandes')->with('success', 'Demande traitée avec succès.');
    }


}
