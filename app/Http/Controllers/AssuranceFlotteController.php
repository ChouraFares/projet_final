<?php

namespace App\Http\Controllers;

use App\Models\FlotteContract;
use App\Models\FlotteSinistre;
use App\Notifications\NewSinistreNotification;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
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
            'fautif' => 'nullable|in:Oui,Non',
            'date_sinistre' => 'nullable|date',
            'nature_sinistre' => 'nullable',
            'avancements' => 'nullable',
            'date_cloture_dossier' => 'nullable|date',
            'reglement' => 'nullable',
            'Expert' => 'nullable',
            'reglement_reçu' => 'nullable|string',
            'attachments_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'statut' => 'nullable|in:En Cours,Clôturé',
            'commentaire' => 'nullable|string',
        ]);
    
        // Générer un numéro de sinistre unique
        $latestSinistre = FlotteSinistre::latest()->first();
        $lastId = $latestSinistre ? $latestSinistre->id + 1 : 1;
        $sinistre_num = 'SIN-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    
        // Gérer l'upload du fichier PDF
        $data = $request->all();
        $data['sinistre_num'] = $sinistre_num;
    
        if ($request->hasFile('attachments_pdf')) {
            $file = $request->file('attachments_pdf');
            $filename = 'sinistre_' . $sinistre_num . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sinistres_pdf', $filename, 'public');
            $data['attachments_pdf'] = $path;
        }
    
        // Création du sinistre
        $sinistre = FlotteSinistre::create($data);
    
        // Envoyer la notification aux utilisateurs avec le rôle supply_chain
        $supplyChainUsers = User::where('role', 'supply_chain')->get();
        foreach ($supplyChainUsers as $user) {
            // Envoyer l'email directement sans passer par la queue
            Mail::to($user->email)->send(new \App\Mail\NewSinistreMail($sinistre));
        
        }    
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
            'fautif' => 'nullable|in:Oui,Non',
            'date_sinistre' => 'nullable|date',
            'nature_sinistre' => 'nullable',
            'avancements' => 'nullable',
            'date_cloture_dossier' => 'nullable|date',
            'reglement' => 'nullable',
            'Expert' => 'nullable',
            'reglement_reçu' => 'nullable|string',
            'attachments_pdf' => 'nullable|file|mimes:pdf|max:2048', // Fichier PDF, max 2MB
            'statut' => 'nullable|in:En Cours,Clôturé',
            'commentaire' => 'nullable|string',
        ]);
    
        $sinistre = FlotteSinistre::findOrFail($id);
        $data = $request->except('sinistre_num'); // Ne pas modifier sinistre_num
    
        // Gérer l'upload du fichier PDF
        if ($request->hasFile('attachments_pdf')) {
            // Supprimer l'ancien fichier s'il existe
            if ($sinistre->attachments_pdf) {
                Storage::disk('public')->delete($sinistre->attachments_pdf);
            }
            $file = $request->file('attachments_pdf');
            $filename = 'sinistre_' . $sinistre->sinistre_num . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sinistres_pdf', $filename, 'public');
            $data['attachments_pdf'] = $path;
        }
    
        // Mise à jour du sinistre
        $sinistre->update($data);
    
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
