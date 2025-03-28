<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\CustomNotification;
=======
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
use App\Models\FactureComplimentaireThonModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureComplimentaireThonSuperAdminTransit extends Controller
{
    //

    public function index()
    {
<<<<<<< HEAD
        $user = Auth::user();
        
        // Notifications non lues
        $unreadNotifications = CustomNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();
        
        // Toutes les notifications
        $allNotifications = CustomNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('super_admin_transit.dashboard', compact('unreadNotifications', 'allNotifications'));
    }
=======
        // Récupérer les notifications non lues de l'utilisateur connecté
        $unreadNotifications = Auth::user()->unreadNotifications;

        // Passer les données à la vue
        return view('super_admin_transit.dashboard', compact('unreadNotifications'));
    } 
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a

    public function showPendingRequests()
{
    // Récupérer les factures où au moins une section a "preparer_paiement" = 1
    $factures = FactureComplimentaireThonModel::where('validation_transit', 'en_attente')
    ->where(function ($query) {
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
    ->get();

    return view('super_admin_transit.demandes', compact('factures'));
}

public function validateRequest(Request $request, $id)
{
    $facture = FactureComplimentaireThonModel::findOrFail($id);

    if ($request->action === 'approve') {
        $facture->update(['validation_transit' => 'Validé']);
    } elseif ($request->action === 'reject') {
        $facture->update(['validation_transit' => 'Refusé']);
    }

    return redirect()->route('super_admin_transit.demandes')->with('success', 'Demande traitée avec succès.');
}

}
