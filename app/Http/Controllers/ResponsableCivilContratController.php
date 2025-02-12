<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ResponsableCivilContrat;
use Illuminate\Http\Request;

class ResponsableCivilContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function bouttonsResponsableCivil(){
        return view('admin_assurance.assurance.Responsable Civil.index');
     }


    public function index()
    {
        //
        $contrats = ResponsableCivilContrat::all();
        return view('admin_assurance.assurance.Responsable Civil.contrats', compact('contrats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin_assurance.assurance.Responsable Civil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'compagnie_assurance' => 'required|string|max:255',
            'ref_contrat' => 'required|string|max:255|unique:responsable_civil_contrats',
            'date_effet' => 'required|date',
            'echeance' => 'required|date',
            'condition_renouvellement' => 'nullable|string',
            'avenant' => 'required|in:oui,non',
            'objet_avenant' => 'nullable|string',
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
        ]);

        $data = $request->except(['attachement_contrat', 'attachement_avenant']);

        // Convertir 'oui' en true et 'non' en false
        $data['avenant'] = $request->avenant === 'oui' ? true : false;

        if ($request->hasFile('attachement_contrat')) {
            $data['attachement_contrat'] = $request->file('attachement_contrat')->store('contrats', 'public');
        }

        if ($request->hasFile('attachement_avenant')) {
            $data['attachement_avenant'] = $request->file('attachement_avenant')->store('avenants', 'public');
        }

        // Enregistrement du contrat dans la base de données
        ResponsableCivilContrat::create($data);

        return redirect()->route('admin.assurance.ResponsableCivil.contrats')->with('success', 'Contrat Responsable Civil créé avec succès.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contrat = ResponsableCivilContrat::findOrFail($id);
        return view('admin_assurance.assurance.Responsable Civil.edit_responsable_civil', compact('contrat'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'compagnie_assurance' => 'required|string|max:255',
            'ref_contrat' => 'required|string|max:255',
            'date_effet' => 'required|date',
            'echeance' => 'required|date|after:date_effet',
            'condition_renouvellement' => 'required|string',
            'avenant' => 'required|boolean',
            'objet_avenant' => 'nullable|string',
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
        ]);

        $contrat = ResponsableCivilContrat::findOrFail($id);

        $contrat->update([
            'compagnie_assurance' => $request->compagnie_assurance,
            'ref_contrat' => $request->ref_contrat,
            'date_effet' => $request->date_effet,
            'echeance' => $request->echeance,
            'condition_renouvellement' => $request->condition_renouvellement,
            'avenant' => $request->avenant,
            'objet_avenant' => $request->objet_avenant,
        ]);

        if ($request->hasFile('attachement_contrat')) {
            $contrat->attachement_contrat = $request->file('attachement_contrat')->store('contrats', 'public');
        }

        if ($request->hasFile('attachement_avenant')) {
            $contrat->attachement_avenant = $request->file('attachement_avenant')->store('avenants', 'public');
        }

        $contrat->save();

        return redirect()->route('admin.assurance.ResponsableCivil.contrats')->with('success', 'Contrat mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Trouver le contrat par son ID
        $contrat = ResponsableCivilContrat::findOrFail($id);

        // Supprimer les fichiers attachés (si existants)


        // Supprimer le contrat
        $contrat->delete();

        // Rediriger avec un message de confirmation
        return redirect()->route('admin.assurance.ResponsableCivil.contrats')
                         ->with('success', 'Contrat supprimé avec succès.');
    }

}
