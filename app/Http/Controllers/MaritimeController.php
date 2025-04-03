<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MaritimeContract;
use App\Models\MaritimeSinistres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaritimeController extends Controller
{
    //
    public function bouttonsMaritime(){
        return view("admin_assurance.assurance.TransportMaritime.index");
    }

    public function indexContrats()
    {
        $contrats = MaritimeContract::all();
        return view('admin_assurance.assurance.TransportMaritime.contrats', compact('contrats'));
    }

    public function createContrat()
    {
        return view('admin_assurance.assurance.TransportMaritime.create');
    }

    public function storeContrat(Request $request)
    {
        $request->validate([
            'compagnie_assurance' => 'required',
            'ref_contrat' => 'required',
            'date_effet' => 'required|date',
            'echeance' => 'required|date',
            'condition_renouvellement' => 'required',
            'avenant' => 'required',
            'objet_avenant' => 'required',
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
            ]);
            $data = $request->except(['attachement_contrat', 'attachement_avenant']);
            if ($request->hasFile('attachement_contrat')) {
                $data['attachement_contrat'] = $request->file('attachement_contrat')->store('contrats', 'public');
            }
            if ($request->hasFile('attachement_avenant')) {
                $data['attachement_avenant'] = $request->file('attachement_avenant')->store('avenants', 'public');
            }


        MaritimeContract::create($data);

        return redirect()->route('admin.assurance.transport.maritime.contrats')->with('success', 'Contrat créé avec succès.');
    }

    public function editContrat($id)
    {
        $contrat = MaritimeContract::findOrFail($id);
        return view('admin_assurance.assurance.TransportMaritime.edit_contrats', compact('contrat'));
    }

    public function updateContrat(Request $request, $id)
    {
        $request->validate([
            'compagnie_assurance' => 'required',
            'ref_contrat' => 'required',
            'date_effet' => 'required|date',
            'echeance' => 'required|date',
            'condition_renouvellement' => 'required',
            'avenant' => 'required',
            'objet_avenant' => 'required',
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
        ]);

        $contrat = MaritimeContract::findOrFail($id);
        $data = $request->except(['attachement_contrat', 'attachement_avenant']);

        if ($request->hasFile('attachement_contrat')) {
            // Supprimer l'ancien fichier s'il existe
            if ($contrat->attachement_contrat) {
                Storage::disk('public')->delete($contrat->attachement_contrat);
            }
            $data['attachement_contrat'] = $request->file('attachement_contrat')->store('contrats', 'public');
        }

        if ($request->hasFile('attachement_avenant')) {
            // Supprimer l'ancien fichier s'il existe
            if ($contrat->attachement_avenant) {
                Storage::disk('public')->delete($contrat->attachement_avenant);
            }
            $data['attachement_avenant'] = $request->file('attachement_avenant')->store('avenants', 'public');
        }

        $contrat->update($data);

        return redirect()->route('admin.assurance.transport.maritime.contrats')->with('success', 'Contrat mis à jour avec succès.');
    }


    public function destroyContrat($id)
    {
        MaritimeContract::destroy($id);
        return redirect()->route('admin.assurance.transport.maritime.contrats')->with('success', 'Contrat supprimé.');
    }

    // Sinistres
    public function indexSinistres()
    {
        $sinistres = MaritimeSinistres::all();
        return view('admin_assurance.assurance.TransportMaritime.sinistres', compact('sinistres'));
    }

    public function createSinistre()
    {
        return view('admin_assurance.assurance.TransportMaritime.create_maritime_sinistres');
    }

    public function storeSinistre(Request $request)
    {
        // Validation des données
        $request->validate([
            'assureur' => 'nullable',
            'prime' => 'nullable|string', // Accepte les nombres décimaux
            'fournisseur' => 'nullable',
            'num_facture' => 'nullable',
            'montant_facture_usd' => 'nullable|numeric', // Accepte les nombres décimaux
            'montant_facture_tnd' => 'nullable|numeric', // Accepte les nombres décimaux
            'num_conteneur' => 'nullable',
            'date_depot' => 'nullable|date',
            'transporteur_maritime' => 'nullable',
            'date_incident' => 'nullable|date',
            'lieu' => 'nullable',
            'mt' => 'nullable|numeric', // Accepte les nombres décimaux
            'date_prev_remboursement' => 'nullable|date',
            'nature_de_sinistre' => 'nullable',
            'statut_du_dossier' => 'nullable',
            'commentaire' => 'nullable',
        ]);
    
        // Générer un numéro de sinistre unique
        $latestSinistre = MaritimeSinistres::latest()->first();
        $lastId = $latestSinistre ? $latestSinistre->id + 1 : 1;
        $numero_sinistre = 'MSIN-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    
        // Création du sinistre avec le numéro généré
        MaritimeSinistres::create(array_merge($request->all(), ['numero_sinistre' => $numero_sinistre]));
    
        return redirect()->route('sinistres')->with('success', 'Sinistre créé avec succès.');
    }


    public function editSinistre($id)
    {
        $sinistre = MaritimeSinistres::findOrFail($id);
        return view('admin_assurance.assurance.TransportMaritime.edit_maritime_sinistres', compact('sinistre'));
    }

    public function updateSinistre(Request $request, $id)
    {
        $request->validate([
            'assureur' => 'nullable',
            'prime' => 'nullable',
            'fournisseur' => 'nullable',
            'num_facture' => 'nullable',
            'montant_facture_usd' => 'nullable',
            'montant_facture_tnd' => 'nullable',
            'num_conteneur' => 'nullable',
            'date_depot' => 'nullable|date',
            'transporteur_maritime' => 'nullable',
            'date_incident' => 'nullable|date',
            'lieu' => 'nullable',
            'mt' => 'nullable',
            'date_prev_remboursement' => 'nullable|date',
            'nature_de_sinistre' => 'nullable',
            'statut_du_dossier' => 'nullable',
            'commentaire' => 'nullable',
        ]);

        $sinistre = MaritimeSinistres::findOrFail($id);
        $sinistre->update($request->all());

        return redirect()->route('sinistres')->with('success', 'Sinistre mis à jour avec succès.');
    }

    public function destroySinistre($id)
    {
        MaritimeSinistres::destroy($id);
        return redirect()->route('sinistres')->with('success', 'Sinistre supprimé.');
    }


}
