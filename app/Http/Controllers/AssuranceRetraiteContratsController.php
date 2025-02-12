<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssuranceRetraiteModel;
use Illuminate\Http\Request;

class AssuranceRetraiteContratsController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function bouttonsAssuranceRetraite(){
        return view('admin_assurance.assurance.Assurance Retraite.index');
     }


    public function index()
    {
        //
        $contrats = AssuranceRetraiteModel::all();
        return view('admin_assurance.assurance.Assurance Retraite.contrats', compact('contrats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin_assurance.assurance.Assurance Retraite.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'compagnie_assurance' => 'required|string|max:255',
            'ref_contrat' => 'required|string|max:255|unique:assurance_retraite_contracts',
            'date_effet' => 'required|date',
            'echeance' => 'required|date',
            'condition_renouvellement' => 'nullable|string',
            'avenant' => 'required|in:oui,non',
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
        ]);

        // Récupérer toutes les données sauf les fichiers
        $data = $request->except(['attachement_contrat', 'attachement_avenant']);

        // Gestion de l'attachement du contrat
        if ($request->hasFile('attachement_contrat')) {
            $data['attachement_contrat'] = $request->file('attachement_contrat')->store('assurance_retraite/contrats', 'public');
        }

        // Gestion de l'attachement de l'avenant
        if ($request->hasFile('attachement_avenant')) {
            $data['attachement_avenant'] = $request->file('attachement_avenant')->store('assurance_retraite/avenants', 'public');
        }

        // Enregistrement du contrat avec les données et les chemins des fichiers
        $contrat = new AssuranceRetraiteModel($data);
        $contrat->avenant = $request->avenant === 'oui'; // "oui" devient true, "non" devient false

        // Sauvegarder le contrat
        $contrat->save();

        // Redirection avec message de succès
        return redirect()->route('admin.assurance.AssuranceRetraite.contrats')->with('success', 'Contrat créé avec succès.');
    }



    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contrat = AssuranceRetraiteModel::findOrFail($id); // Récupération du contrat à modifier
        return view('admin_assurance.assurance.Assurance Retraite.edit', compact('contrat'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contrat = AssuranceRetraiteModel::findOrFail($id);

        // Validation des champs
        $request->validate([
            'compagnie_assurance' => 'required|string|max:255',
            'ref_contrat' => 'required|string|max:255',
            'date_effet' => 'required|date',
            'echeance' => 'required|date',
            'condition_renouvellement' => 'nullable|string',
            'avenant' => 'required|boolean',
            'objet_avenant' => 'nullable|string',
            'attachement_contrat' => 'nullable|file|max:102400',
            'attachement_avenant' => 'nullable|file|max:102400',
        ]);

        // Mise à jour des champs
        $contrat->update($request->except(['attachement_contrat', 'attachement_avenant']));

        // Gestion des fichiers uploadés
        if ($request->hasFile('attachement_contrat')) {
            $path = $request->file('attachement_contrat')->store('assurance_retraite/contrats', 'public');
            $contrat->attachement_contrat = $path;
        }

        if ($request->hasFile('attachement_avenant')) {
            $path = $request->file('attachement_avenant')->store('assurance_retraite/avenants', 'public');
            $contrat->attachement_avenant = $path;
        }


        $contrat->save();

        return redirect()->route('admin.assurance.AssuranceRetraite.contrats')->with('success', 'Contrat modifié avec succès !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contrat = AssuranceRetraiteModel::findOrFail($id);

        // Suppression des fichiers associés


        // Suppression du contrat
        $contrat->delete();

        return redirect()->route('admin.assurance.AssuranceRetraite.contrats')->with('success', 'Contrat supprimé avec succès !');
    }
}
