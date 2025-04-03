<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ResponsableCivilSinistre;
use Illuminate\Http\Request;

class ResponsableCivilSinistreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sinistres = ResponsableCivilSinistre::all();
        return view('admin_assurance.assurance.Responsable Civil.index_sinistres', compact('sinistres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_assurance.assurance.Responsable Civil.create_sinistres');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'assureur' => 'required|string|max:255',
            'nature_sinistre' => 'required|string|max:255',
            'lieu_sinistre' => 'required|string|max:255',
            'date_sinistre' => 'required|date',
            'degats' => 'required|string|max:255',
            'charge' => 'required|string|max:255',
            'perte' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'situation_du_dossier' => 'nullable|string|max:255',
            'commentaires' => 'nullable|string',
        ]);

        // Générer un numéro de sinistre unique
        $latestSinistre = ResponsableCivilSinistre::latest()->first();
        $lastId = $latestSinistre ? $latestSinistre->id + 1 : 1;
        $numero_sinistre = 'SIN-RC-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        // Ajouter le numéro de sinistre aux données validées
        $validatedData['numero_de_sinistre'] = $numero_sinistre;

        // Création du sinistre avec le numéro généré
        ResponsableCivilSinistre::create($validatedData);

        // Redirection avec message de succès
        return redirect()->route('admin.ResponsableCivil.sinistres.contrats')->with('success', 'Sinistre ajouté avec succès.');
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
    public function edit($id)
    {
        $sinistre = ResponsableCivilSinistre::findOrFail($id);
        return view('admin_assurance.assurance.Responsable Civil.edit_responsable_civil_sinistres', compact('sinistre'));
    }
    /**
     * Update the specified resource in storage.
     */
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
            'situation_du_dossier' => 'nullable',
            'commentaires' => 'nullable',
        ]);

        // Récupération du sinistre existant
        $sinistre = ResponsableCivilSinistre::findOrFail($id);

        // Préserver le numéro de sinistre existant
        $validatedData['numero_sinistre'] = $sinistre->numero_sinistre;

        // Mise à jour du sinistre
        $sinistre->update($validatedData);

        // Redirection avec message de succès
        return redirect()->route('admin.ResponsableCivil.sinistres.contrats')->with('success', 'Sinistre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sinistre = ResponsableCivilSinistre::findOrFail($id);
        $sinistre->delete();
        return redirect()->route('admin.ResponsableCivil.sinistres.contrats')->with('success', 'Sinistre supprimé avec succès.');
    }
}
