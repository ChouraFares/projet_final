<?php

namespace App\Http\Controllers;

use App\Models\ContratsAssuranceMaladie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class contrats_assurance_maladie extends Controller
{
    public function index()
    {
        $contrats = ContratsAssuranceMaladie::all();
        return view('admin_assurance.assurance.Assurance Maladie.contrats', compact('contrats'));
    }

    public function create()
    {
        return view('admin_assurance.assurance.Assurance Maladie.create_contrats');
    }

        public function store(Request $request)
        {
            $request->validate([
                'compagnie_assurance' => 'required|string|max:255',
                'ref_contrat' => 'required|string|max:255',
                'date_effet' => 'required|date',
                'echeance' => 'required|date',
                'condition_renouvellement' => 'nullable|string',
                'avenant' => 'nullable|string',
                'objet_avenant' => 'nullable|string',
                'attachement_contrat' => 'required|file|max:102400',
            ]);

            $filePath = $request->file('attachement_contrat')->store('contrats_assurance_maladie', 'public');

            ContratsAssuranceMaladie::create([
                'compagnie_assurance' => $request->compagnie_assurance,
                'ref_contrat' => $request->ref_contrat,
                'date_effet' => $request->date_effet,
                'echeance' => $request->echeance,
                'condition_renouvellement' => $request->condition_renouvellement,
                'avenant' => $request->avenant,
                'objet_avenant' => $request->objet_avenant,
                'attachement_contrat' => $filePath,
            ]);

            return redirect()->route('contrats_assurance_maladie.index')->with('success', 'Contrat ajouté avec succès.');
        }

        public function edit($id)
        {
            $contrat = ContratsAssuranceMaladie::findOrFail($id);
            return view('admin_assurance.assurance.Assurance Maladie.edit_contrats', compact('contrat'));
        }

        public function update(Request $request, $id)
        {
            $contrat = ContratsAssuranceMaladie::findOrFail($id);

            $request->validate([
                'compagnie_assurance' => 'required|string|max:255',
                'ref_contrat' => 'required|string|max:255',
                'date_effet' => 'required|date',
                'echeance' => 'required|date',
                'condition_renouvellement' => 'nullable|string',
                'avenant' => 'nullable|string',
                'objet_avenant' => 'nullable|string',
                'attachement_contrat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:102400',
            ]);

            if ($request->hasFile('attachement_contrat')) {
                // Supprimer l'ancien fichier
                if ($contrat->attachement_contrat) {
                    Storage::disk('public')->delete($contrat->attachement_contrat);
                }

                // Ajouter le nouveau fichier
                $filePath = $request->file('attachement_contrat')->store('contrats_assurance_maladie', 'public');
                $contrat->attachement_contrat = $filePath;
            }

            $contrat->compagnie_assurance = $request->compagnie_assurance;
            $contrat->ref_contrat = $request->ref_contrat;
            $contrat->date_effet = $request->date_effet;
            $contrat->echeance = $request->echeance;
            $contrat->condition_renouvellement = $request->condition_renouvellement;
            $contrat->avenant = $request->avenant;
            $contrat->objet_avenant = $request->objet_avenant;
            $contrat->save();

            return redirect()->route('contrats_assurance_maladie.index')->with('success', 'Contrat mis à jour avec succès.');
        }

    public function destroy($id)
    {
        $contrat = ContratsAssuranceMaladie::findOrFail($id);

        // Supprimer le fichier
        if ($contrat->attachement_contrat) {
            Storage::disk('public')->delete($contrat->attachement_contrat);
        }

        $contrat->delete();

        return redirect()->route('contrats_assurance_maladie.index')->with('success', 'Contrat supprimé avec succès.');
    }
}
