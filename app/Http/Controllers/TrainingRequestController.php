<?php

namespace App\Http\Controllers;

use App\Models\TrainingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingRequestController extends Controller
{
    /**
     * Afficher la liste des demandes de formation de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer les demandes de formation pour l'utilisateur connecté
        $trainingRequests = TrainingRequest::where('user_id', Auth::id())->get();

        // Notez l'utilisation de 'user.training-request' et non 'training-request.blade'
        return view('user.training-request', compact('trainingRequests'));
    }


    /**
     * Afficher le formulaire pour soumettre une nouvelle demande de formation.
     *
     * @return \Illuminate\View\View
     */

    /**
     * Stocker une nouvelle demande de formation dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données d'entrée
        $validatedData = $request->validate([
            'hr-trainings-acct' => 'nullable|string',
            'it-trainings-cdg' => 'nullable|string',
            'finance-trainings-supply-chain' => 'nullable|string',
            'hr-trainings-transit' => 'nullable|string',
            'hr-trainings-HSE' => 'nullable|string',
            'hr-trainings-Technique' => 'nullable|string',
            'hr-trainings-PRODUCTION' => 'nullable|string',
            'hr-trainings-Qualité' => 'nullable|string',
            'hr-trainings-Achat' => 'nullable|string',
            'hr-trainings-RH' => 'nullable|string',
            'hr-trainings-Finance' => 'nullable|string',
        ]);

        // Identifying which training field has been selected
        $selectedTraining = null;
        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $selectedTraining = $value;
                break;
            }
        }

        if ($selectedTraining === null) {
            return redirect()->back()->withErrors(['No training selected']);
        }

        // Créer la demande de formation
        $user = Auth::user();
        $employee = $user->employe;
        TrainingRequest::create([
            'MLE' => $user->MLE,
            'user_id' => Auth::id(),
            'department' => $employee->Direction, // Accessing the department from the employee model
            'selected_training' => $selectedTraining,
            'status' => 'Pending', // Par défaut, la demande est en attente
        ]);

        return redirect()->route('training-request.create')->with('success', 'Votre demande de formation a été soumise avec succès.');
    }

    /**
     * Afficher une demande de formation spécifique.
     *
     * @param  \App\Models\TrainingRequest  $trainingRequest
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $trainingRequests = TrainingRequest::where('user_id', Auth::id())->get();

        return view('user.training-request-show-Demand', compact('trainingRequests'));
    }

    /**
     * Afficher le formulaire pour modifier une demande de formation existante.
     *
     * @param  \App\Models\TrainingRequest  $trainingRequest
     * @return \Illuminate\View\View
     */
    public function edit(TrainingRequest $trainingRequest)
    {
        // Vérifier si l'utilisateur est autorisé à modifier cette demande
        if ($trainingRequest->user_id != Auth::id()) {
            abort(403, 'Non autorisé');
        }

        return view('trainingRequests.edit', compact('trainingRequest'));
    }

    /**
     * Mettre à jour une demande de formation existante dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainingRequest  $trainingRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TrainingRequest $trainingRequest)
    {
        // Vérifier si l'utilisateur est autorisé à mettre à jour cette demande
        if ($trainingRequest->user_id != Auth::id()) {
            abort(403, 'Non autorisé');
        }

        // Validation des données mises à jour
        $validatedData = $request->validate([
            'MLE' => 'required|string|max:10',
            'department' => 'required|string|max:50',
            'selected_training' => 'required|string|max:255',
        ]);

        // Mettre à jour la demande de formation
        $trainingRequest->update([
            'MLE' => $validatedData['MLE'],
            'department' => $validatedData['department'],
            'selected_training' => $validatedData['selected_training'],
        ]);

        return redirect()->route('training-requests.index')->with('success', 'Votre demande de formation a été mise à jour avec succès.');
    }

    /**
     * Supprimer une demande de formation existante.
     *
     * @param  \App\Models\TrainingRequest  $trainingRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TrainingRequest $trainingRequest)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer cette demande
        if ($trainingRequest->user_id != Auth::id()) {
            abort(403, 'Non autorisé');
        }

        // Supprimer la demande de formation
        $trainingRequest->delete();

        return redirect()->route('training-requests.index')->with('success', 'Votre demande de formation a été supprimée.');
    }
}
