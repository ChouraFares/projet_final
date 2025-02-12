<?php

namespace App\Http\Controllers;

use App\Models\FlotteContract;
use App\Models\FlotteSinistre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssuranceFlotteController extends Controller
{
    // Liste des contrats
    public function bouttonsFlotte()
    {
        return view('admin_assurance.assurance.Flotte.index');  // Retourner la vue avec les contrats
    }

    public function indexContracts()
    {
        $contrats = FlotteContract::all();  // Récupérer tous les contrats Flotte
        return view('admin_assurance.assurance.Flotte.contrats', compact('contrats'));  // Retourner la vue avec les contrats
    }

    // Créer un contrat
    public function create()
    {
        return view('admin_assurance.assurance.Flotte.createFlotte');
    }

    // Sauvegarder un nouveau contrat
    public function store(Request $request)
    {
        $request->validate([
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
        ]);

        // Créer un tableau pour les données du contrat
        $data = $request->except(['attachement_contrat', 'attachement_avenant']);

        // Gestion de l'attachement du contrat
        if ($request->hasFile('attachement_contrat')) {
            $data['attachement_contrat'] = $request->file('attachement_contrat')->store('contrats', 'public');
        }

        // Gestion de l'attachement de l'avenant
        if ($request->hasFile('attachement_avenant')) {
            $data['attachement_avenant'] = $request->file('attachement_avenant')->store('avenants', 'public');
        }

        // Sauvegarder le contrat avec les fichiers
        FlotteContract::create($data);

        return redirect()->route('admin.assurance.flotte.index');
    }

    // Modifier un contrat
    public function edit($id)
    {
        $contrat = FlotteContract::findOrFail($id);
        return view('admin_assurance.assurance.Flotte.edit', compact('contrat'));
    }

    // Mettre à jour un contrat
    public function update(Request $request, $id)
    {
        $contrat = FlotteContract::findOrFail($id);

        // Validation des fichiers
        $request->validate([
            'attachement_contrat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:102400',
            'attachement_avenant' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:102400',
        ]);

        // Vérifier et enregistrer l'attachement du contrat
        if ($request->hasFile('attachement_contrat')) {
            // Supprimer l'ancien fichier s'il existe
            if ($contrat->attachement_contrat) {
                Storage::delete('public/' . $contrat->attachement_contrat);
            }
            // Stocker le nouveau fichier
            $contrat->attachement_contrat = $request->file('attachement_contrat')->store('attachements', 'public');
        }

        // Vérifier et enregistrer l'attachement de l'avenant
        if ($request->hasFile('attachement_avenant')) {
            if ($contrat->attachement_avenant) {
                Storage::delete('public/' . $contrat->attachement_avenant);
            }
            $contrat->attachement_avenant = $request->file('attachement_avenant')->store('attachements', 'public');
        }

        // Mise à jour des autres champs
        $contrat->update($request->except(['attachement_contrat', 'attachement_avenant']));

        return redirect()->route('admin.assurance.flotte.index')->with('success', 'Contrat mis à jour avec succès.');
    }

    // Supprimer un contrat
    public function destroy($id)
    {
        $contrat = FlotteContract::findOrFail($id);
        $contrat->delete();
        return redirect()->route('admin_assurance.flotte.index');
    }

    // Liste des sinistres
    public function sinistres()
    {
        $sinistres = FlotteSinistre::all();
        return view('admin_assurance.assurance.Flotte.sinistres', compact('sinistres'));
    }

    // Créer un sinistre
    public function createSinistre()
    {
        return view('admin_assurance.assurance.Flotte.create_sinistre');
    }

    // Sauvegarder un nouveau sinistre
    public function storeSinistre(Request $request)
    {
        // Validation des données
        $request->validate([
            'compagnie_assurance' => 'nullable',
            'immatriculation' => 'nullable',
            'vehicule' => 'nullable',
            'chauffeur' => 'nullable',
            'fautif' => 'nullable',
            'date_sinistre' => 'nullable|date',
            'nature_sinistre' => 'nullable',
            'situation_dossier' => 'nullable',
            'date_cloture_dossier' => 'nullable|date',
            'reglement' => 'nullable',
            'Expert' => 'nullable',
        ]);

        // Générer un numéro de sinistre unique
        $latestSinistre = FlotteSinistre::latest()->first(); // Récupération du dernier sinistre
        $lastId = $latestSinistre ? $latestSinistre->id + 1 : 1;
        $sinistre_num = 'SIN-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        // Création du sinistre avec le numéro généré
        FlotteSinistre::create(array_merge($request->all(), ['sinistre_num' => $sinistre_num]));

        return redirect()->route('admin.assurance.flotte.sinistres')->with('success', 'Sinistre ajouté avec succès');
    }


    // Modifier un sinistre
    public function editSinistre($id)
    {
        $sinistre = FlotteSinistre::findOrFail($id);
        return view('admin_assurance.assurance.Flotte.edit_sinistre', compact('sinistre'));
    }

    // Mettre à jour un sinistre
    public function updateSinistre(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'compagnie_assurance' => 'nullable',
            'immatriculation' => 'nullable',
            'vehicule' => 'nullable',
            'chauffeur' => 'nullable',
            'fautif' => 'nullable',
            'date_sinistre' => 'nullable|date',
            'nature_sinistre' => 'nullable',
            'situation_dossier' => 'nullable',
            'date_cloture_dossier' => 'nullable|date',
            'reglement' => 'nullable',
            'Expert' => 'nullable',
        ]);

        $sinistre = FlotteSinistre::findOrFail($id);

        // Mise à jour sans modifier `sinistre_num`
        $sinistre->update($request->except('sinistre_num'));

        return redirect()->route('admin.assurance.flotte.sinistres')->with('success', 'Sinistre mis à jour avec succès');
    }


    // Supprimer un sinistre
    public function destroySinistre($id)
    {
        $sinistre = FlotteSinistre::findOrFail($id);
        $sinistre->delete();
        return redirect()->route('admin.assurance.flotte.sinistres');
    }
}
