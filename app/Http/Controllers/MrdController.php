<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MrdContracts;
use App\Models\sinistre_mrd;
class MrdController extends Controller
{
    // Affichage du menu principal MRD
    public function index()
    {
        $contracts = MrdContracts::all();
        return view('admin_assurance.assurance.mrd.index', compact('contracts'));
    }

    // Gestion des Contrats MRD
    public function contrats()
    {
        $contrats = MrdContracts::all();
        return view('admin_assurance.assurance.mrd.contrats', compact('contrats'));
    }

    public function createContrat()
    {
        return view('admin_assurance.assurance.mrd.create');
    }

    public function storeContrat(Request $request)
    {
        $request->validate([
            'compagnie_assurance' => 'required',
            'ref_contrat' => 'required',
            'date_effet' => 'required|date',
            'echeance' => 'required|date',
            'condition_renouvellement' => 'nullable|string',
            'avenant' => 'in:oui,non',  // Validation de l'énumération
            'objet_avenant' => 'nullable|string',
            'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
            'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
        ]);

        // Créer un nouveau contrat
        $data = $request->except(['attachement_contrat', 'attachement_avenant']);

        // Gestion des fichiers PDF
        if ($request->hasFile('attachement_contrat')) {
            $filePath = $request->file('attachement_contrat')->store('contrats', 'public');
            $data['attachement_contrat'] = $filePath;
        }
        if ($request->hasFile('attachement_avenant')) {
            $filePath = $request->file('attachement_avenant')->store('avenants', 'public');
            $data['attachement_avenant'] = $filePath;
        }

        MrdContracts::create($data);

        return redirect()->route('admin.mrd.contrats')->with('success', 'Contrat ajouté avec succès.');
    }

    public function editContrat($id)
    {
        $contrat = MrdContracts::findOrFail($id);
        return view('admin_assurance.assurance.mrd.edit_conttarts_mrd', compact('contrat'));
    }



 // Mettre à jour les données du contrat
public function updateContrat(Request $request, $id)
{
    $request->validate([
        'compagnie_assurance' => 'required|string|max:255',
        'ref_contrat' => 'required|string|max:255',
        'date_effet' => 'required|date',
        'echeance' => 'required|date',
        'condition_renouvellement' => 'nullable|string',
        'avenant' => 'max:255', // Limite à 255 caractères
        'objet_avenant' => 'nullable|string',
        'attachement_contrat' => 'nullable|mimes:pdf|max:102400',
        'attachement_avenant' => 'nullable|mimes:pdf|max:102400',
    ]);

    $contrat = MrdContracts::findOrFail($id);
    $data = $request->except(['attachement_contrat', 'attachement_avenant']);

    // Gestion des fichiers PDF
    if ($request->hasFile('attachement_contrat')) {
        $filePath = $request->file('attachement_contrat')->store('contrats', 'public');
        $data['attachement_contrat'] = $filePath;
    }
    if ($request->hasFile('attachement_avenant')) {
        $filePath = $request->file('attachement_avenant')->store('avenants', 'public');
        $data['attachement_avenant'] = $filePath;
    }

    $contrat->update($data);

    return redirect()->route('admin.mrd.contrats')->with('success', 'Contrat mis à jour avec succès.');
}

    public function destroyContrat($id)
    {
        $contrat = MrdContracts::findOrFail($id);
        $contrat->delete();

        return redirect()->route('admin.mrd.contrats')->with('success', 'Contrat supprimé avec succès');
    }



    /* ************************************ Sections Des Sinistres MRD ************************************ */

    // Suivi des Sinistres MRD
    public function sinistres()
    {
        // Récupérer tous les sinistres
        $sinistres = sinistre_mrd::all();
        return view('admin_assurance.assurance.mrd.sinistres', compact('sinistres'));
    }

    // Déclaration des Sinistres MRD
    public function createSinistre()
    {
        return view('admin_assurance.assurance.mrd.create_sinistre'); // Créez cette vue pour ajouter un sinistre
    }

    public function storeSinistre(Request $request)
    {
        // Validation des données (sans `numero_sinistre` car il sera généré)
        $request->validate([
            'compagnie_assurance' => 'nullable',
            'fournisseur' => 'nullable',
            'nature_sinistre' => 'nullable',
            'lieu_sinistre' => 'nullable',
            'date_sinistre' => 'nullable|date',
            'degats' => 'nullable',
            'charge' => 'nullable',
            'perte' => 'nullable',
            'estimation_de_remboursement' => 'nullable',
            'responsable' => 'nullable',
            'commentaires' => 'nullable',
            'statut' => 'nullable',
        ]);

        // Générer un numéro de sinistre unique
        $latestSinistre = sinistre_mrd::latest()->first();
        $lastId = $latestSinistre ? $latestSinistre->id + 1 : 1;
        $numero_sinistre = 'SIN-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        // Création du sinistre avec le numéro généré
        sinistre_mrd::create(array_merge($request->all(), ['numero_sinistre' => $numero_sinistre]));

        return redirect()->route('admin.mrd.sinistres')->with('success', 'Sinistre ajouté avec succès');
    }




    public function editSinistre($id)
    {
        $sinistre = sinistre_mrd::findOrFail($id);
        return view('admin_assurance.assurance.mrd.edit_sinistres', compact('sinistre'));
    }

    public function updateSinistre(Request $request, $id)
    {
        $request->validate([
            'compagnie_assurance' => 'nullable',
            'fournisseur' => 'nullable',
            'nature_sinistre' => 'nullable',
            'lieu_sinistre' => 'nullable',
            'date_sinistre' => 'nullable|date',
            'degats' => 'nullable',
            'charge' => 'nullable',
            'perte' => 'nullable',
            'estimation_de_remboursement' => 'nullable',
            'responsable' => 'nullable',
            'commentaires' => 'nullable',
            'statut' => 'nullable',
        ]);

        $sinistre = sinistre_mrd::findOrFail($id);

        // Mise à jour sans modifier `numero_sinistre`
        $sinistre->update($request->except('numero_sinistre'));

        return redirect()->route('admin.mrd.sinistres')->with('success', 'Sinistre mis à jour avec succès');
    }



    public function destroySinistre($id)
    {
        // Supprimer le sinistre
        $sinistre = sinistre_mrd::findOrFail($id);
        $sinistre->delete();

        return redirect()->route('admin.mrd.sinistres')->with('success', 'Sinistre supprimé avec succès');
    }

}
