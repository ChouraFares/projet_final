<?php

namespace App\Http\Controllers;
use App\Models\InternationalMission;
use App\Notifications\InternationalMissionApproved;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LocalMission;
use App\Models\LoanRequest;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }




    public function viewLocalMissions()
    {
        $missions = LocalMission::where('status', 'pending')->get();
        return view('admin.local-missions', compact('missions'));
    }




    public function approveMission($id)
    {
        $mission = LocalMission::findOrFail($id);
        $mission->status = 'Approved';
        $mission->save();



        return redirect()->back()->with('success', 'Mission approuvée avec succès.');
    }

    public function declineMission($id)
    {
        $mission = LocalMission::findOrFail($id);
        $mission->status = 'Declined';
        $mission->save();



        return redirect()->back()->with('success', 'Mission rejetée avec succès.');
    }



public function viewMissionReports()
{
    // Fetch all missions with reports, eager loading the related user
    $missions = LocalMission::whereNotNull('report_details')
                ->with('user')
                ->get();

    return view('admin.viewMissionReports', compact('missions'));
}




public function viewInternationalMissions()
{
    $missions = InternationalMission::where('status', 'pending')->get();
    return view('admin.international-missions', compact('missions'));
}

public function approveInternationalMission($id)
{
    $mission = InternationalMission::findOrFail($id);
    $mission->status = 'Approved';
    $mission->save();


    return redirect()->back()->with('success', 'Mission internationale approuvée avec succès.');
}

public function declineInternationalMission($id)
{
    $mission = InternationalMission::findOrFail($id);
    $mission->status = 'Declined';
    $mission->save();


    return redirect()->back()->with('success', 'Mission internationale rejetée avec succès.');
}


public function viewInternationalMissionReports()
{
    // Fetch international missions that have reports
    $missions = InternationalMission::with('user')
        ->whereNotNull('report_details')  // Ensure that the mission has a report
        ->get();

    // Pass the missions to the view
    return view('admin.viewInternationalMissionReports', compact('missions'));
}




public function LoanRequest()
    {
        $loanRequests = LoanRequest::with('user')->get();
        return view('admin.loan_requests', compact('loanRequests'));
    }
    public function approveLoanRequest($id)
    {
        $loanRequest = LoanRequest::find($id);
        $loanRequest->status = 'approved';
        $loanRequest->save();

        // Vérifiez que $loanRequest->user renvoie bien un utilisateur avec MLE


        return redirect()->route('admin.loanRequests')->with('success', 'Demande approuvée avec succès.');
    }

    public function declineLoanRequest($id)
    {
        $loanRequest = LoanRequest::find($id);
        $loanRequest->status = 'declined';
        $loanRequest->save();

        return redirect()->route('admin.loanRequests')->with('success', 'Demande rejetée avec succès.');
    }
    public function destroyRapportMissionsLocale($id)
    {
        // Récupérer la mission
        $mission = LocalMission::findOrFail($id);
    
        // Supprimer le fichier de reçu s'il existe
        if ($mission->receipt_path && Storage::disk('public')->exists($mission->receipt_path)) {
            Storage::disk('public')->delete($mission->receipt_path);
        }
    
        // Supprimer la mission de la base de données
        $mission->delete();
    
        // Redirection avec un message de succès
        return redirect()->route('admin.viewMissionReports')->with('success', 'Rapport de mission supprimé avec succès.');
    }



    public function editLoanRequest($id)
{
    // Récupérer la demande de prêt/avance par son ID
    $loanRequest = LoanRequest::findOrFail($id);

    // Afficher la vue d'édition avec les données de la demande
    return view('admin.edit-loan-request', compact('loanRequest'));
}

public function updateLoanRequest(Request $request, $id)
{
    // Valider les données du formulaire
    $request->validate([
        'amount' => 'required|numeric',
        'purpose' => 'nullable|string',
        'repayment_month' => 'required|string',
        'type' => 'required|string',
    ]);

    // Récupérer la demande de prêt/avance par son ID
    $loanRequest = LoanRequest::findOrFail($id);

    // Mettre à jour les champs
    $loanRequest->update([
        'amount' => $request->amount,
        'purpose' => $request->purpose,
        'repayment_month' => $request->repayment_month,
        'type' => $request->type,
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('admin.loanRequests')->with('success', 'La demande a été mise à jour avec succès.');
}
    
}






