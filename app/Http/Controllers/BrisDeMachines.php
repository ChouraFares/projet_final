<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BrisDeMachineContract;
use App\Models\BrisDeMachineSinistre;
use Illuminate\Http\Request;

class BrisDeMachines extends Controller
{
    //
    public function bouttonsBrisDeMachine(){
        return view('admin_assurance.assurance.Bris Des Machines.index');
    }
    public function indexContrats()
    {
        $contrats = BrisDeMachineContract::all();
        return view('admin_assurance.assurance.Bris Des Machines.contrats', compact('contrats'));
    }


public function createContrat(){

    return view ('admin_assurance.assurance.Bris Des Machines.create');
}


public function storeContrat(Request $request)
{
    // Validation des données
    $request->validate([
        'compagnie_assurance' => 'required|string|max:255',
        'ref_contrat' => 'required|string|max:255|unique:bris_de_machine_contracts',
        'date_effet' => 'required|date',
        'echeance' => 'required|date',
        'condition_renouvellement' => 'nullable|string',
        'avenant' => 'required|in:oui,non', // Validation pour "oui" ou "non"
        'objet_avenant' => 'nullable|string',
        'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
        'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
    ]);

    // Récupérer toutes les données sauf les fichiers
    $data = $request->except(['attachement_contrat', 'attachement_avenant']);

    // Gestion de l'attachement du contrat
    if ($request->hasFile('attachement_contrat')) {
        $data['attachement_contrat'] = $request->file('attachement_contrat')->store('contrats', 'public');
    }

    // Gestion de l'attachement de l'avenant
    if ($request->hasFile('attachement_avenant')) {
        $data['attachement_avenant'] = $request->file('attachement_avenant')->store('avenants', 'public');
    }

    // Enregistrement du contrat avec les données et les chemins des fichiers
    $contract = new BrisDeMachineContract($data);
    $contract->avenant = $request->avenant === 'oui'; // "oui" devient true, "non" devient false

    // Sauvegarder le contrat
    $contract->save();

    // Redirection avec message de succès
    return redirect()->route('admin.assurance.BrisDeMachines.contrats')->with('success', 'Contrat créé avec succès.');
}


public function editContrat($id)
{
    $contract = BrisDeMachineContract::findOrFail($id);
    return view('admin_assurance.assurance.Bris Des Machines.edit_bris_de_machine', compact('contract'));
}


public function updateContrat(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'compagnie_assurance' => 'required|string|max:255',
        'ref_contrat' => 'required|string|max:255|unique:bris_de_machine_contracts,ref_contrat,' . $id,
        'date_effet' => 'required|date',
        'echeance' => 'required|date',
        'condition_renouvellement' => 'nullable|string',
        'avenant' => 'required|in:oui,non', // Validation pour "oui" ou "non"
        'objet_avenant' => 'nullable|string',
        'attachement_contrat' => 'nullable|file|max:102400',
        'attachement_avenant' => 'nullable|file|max:102400',
    ]);

    // Trouver le contrat existant et mettre à jour
    $contract = BrisDeMachineContract::findOrFail($id);
    $contract->update([
        'compagnie_assurance' => $request->compagnie_assurance,
        'ref_contrat' => $request->ref_contrat,
        'date_effet' => $request->date_effet,
        'echeance' => $request->echeance,
        'condition_renouvellement' => $request->condition_renouvellement,
        'avenant' => $request->avenant === 'oui', // "oui" devient true, "non" devient false
        'objet_avenant' => $request->objet_avenant,
'attachement_contrat' => $request->file('attachement_contrat') ? $request->file('attachement_contrat')->store('public/contracts') : $contract->attachement_contrat,
'attachement_avenant' => $request->file('attachement_avenant') ? $request->file('attachement_avenant')->store('public/avenants') : $contract->attachement_avenant,
    ]);

    // Redirection ou message de succès
    return redirect()->route('admin.assurance.BrisDeMachines.contrats', $id)->with('success', 'Contrat mis à jour avec succès.');
}

public function destroyContrat($id)
    {
        // Trouver le contrat par ID et le supprimer
        $contract = BrisDeMachineContract::findOrFail($id);
        $contract->delete();

        // Rediriger avec un message de succès
        return redirect()->route('admin.assurance.BrisDeMachines.contrats')->with('success', 'Contrat supprimé avec succès.');
    }


    public function indexSinistres () {
        $sinistres = BrisDeMachineSinistre::all();
        return view('admin_assurance.assurance.Bris Des Machines.sinistres', compact('sinistres'));
    }

    public function createSinistre()
    {
        return view('admin_assurance.assurance.Bris Des Machines.sinistres_create');
    }


    public function storeSinistres(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'assureur' => 'required',
            'nature_sinistre' => 'required',
            'lieu_sinistre' => 'required',
            'date_sinistre' => 'required|date',
            'degats' => 'required',
            'charge' => 'required',
            'perte' => 'required',
            'responsable' => 'required',
            'statu_du_dossier' => 'nullable', // equivalent to 'statu_du_dossier' => 'nullable|string'
            'expert' => 'nullable',
            'commentaires' => 'nullable',
        ]);

        // Générer un numéro de sinistre unique
        $latestSinistre = BrisDeMachineSinistre::latest()->first();
        $lastId = $latestSinistre ? $latestSinistre->id + 1 : 1;
        $numero_sinistre = 'SIN-BM-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        // Ajouter le numéro de sinistre aux données validées
        $validatedData['numero_sinistre'] = $numero_sinistre;

        // Création du sinistre avec le numéro généré
        BrisDeMachineSinistre::create($validatedData);

        // Redirection avec message de succès
        return redirect()->route('admin.BrisDeMachines.sinistres')->with('success', 'Sinistre ajouté avec succès');
    }



    public function edit($id)
    {
        // Trouver le sinistre par son ID
        $sinistre = BrisDeMachineSinistre::findOrFail($id);

        // Retourner la vue avec le sinistre à modifier
        return view('admin_assurance.assurance.Bris Des Machines.sinistres_edit', compact('sinistre'));
    }
    public function update(Request $request, $id)
    {
        // Validation des données
        $validatedData = $request->validate([
            'assureur' => 'required',
            'nature_sinistre' => 'required',
            'lieu_sinistre' => 'required',
            'date_sinistre' => 'required|date',
            'degats' => 'required',
            'charge' => 'required',
            'perte' => 'required',
            'responsable' => 'required',
            'statu_du_dossier' => 'nullable',
            'expert' => 'nullable',
            'commentaires' => 'nullable',
        ]);

        // Récupération du sinistre existant
        $sinistre = BrisDeMachineSinistre::findOrFail($id);

        // Préserver le numéro de sinistre existant
        $validatedData['numero_sinistre'] = $sinistre->numero_sinistre;

        // Mise à jour du sinistre
        $sinistre->update($validatedData);

        // Redirection avec message de succès
        return redirect()->route('admin.BrisDeMachines.sinistres')->with('success', 'Sinistre mis à jour avec succès');
    }


    public function destroy($id)
    {
        // Trouver le sinistre par son ID
        $sinistre = BrisDeMachineSinistre::findOrFail($id);

        // Supprimer le sinistre
        $sinistre->delete();

        // Rediriger avec un message de succès
        return redirect()->route('admin.BrisDeMachines.sinistres')->with('success', 'Sinistre supprimé avec succès');
    }



}
