<?php

namespace App\Http\Controllers;

use App\Models\AssuranceMaladie;
use App\Models\Bordereau;
use Illuminate\Http\Request;

class AssuranceMaladieContratsController extends Controller
{
    /**
     * Afficher la liste des contrats d'assurance maladie.
     */
    public function bouttonsAssuranceMaladie()
    {
return view('admin_assurance.assurance.Assurance Maladie.index');
    }


 // app\Http\Controllers\AssuranceMaladieContratsController.php
public function index()
{
    // Récupérer tous les enregistrements
    $assurances = AssuranceMaladie::orderBy('date_envoi', 'desc')->get();
    
    // Vérifier les données

    return view('admin_assurance.assurance.Assurance Maladie.borderaux', compact('assurances'));
}

    

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('admin_assurance.assurance.Assurance Maladie.create');
    }

    /**
     * Stocker un nouveau contrat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_envoi' => 'required|date',
            'bulletin_numero' => 'required|string|max:50',
            'nom_adherent' => 'required|string|max:255',
            'date_de_soin' => 'required|date',
            'status' => 'required|in:Remis,Non Remis,Cloture',
            'reclamation' => 'nullable|string',
        ]);

        $numero_borderaux = $this->generateNumeroBordereau($request->date_envoi);

        AssuranceMaladie::create([
            'date_envoi' => $request->date_envoi,
            'numero_borderaux' => $numero_borderaux,
            'bulletin_numero' => $request->bulletin_numero,
            'nom_adherent' => $request->nom_adherent,
            'date_de_soin' => $request->date_de_soin,
            'status' => $request->status,
            'reclamation' => $request->reclamation,
        ]);

        return redirect()->route('admin.assurance.AssuranceMaladie.contrats')
                         ->with('success', 'Contrat ajouté avec succès.');
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit($id)
    {
        $assurance = AssuranceMaladie::findOrFail($id);
        return view('admin_assurance.assurance.Assurance Maladie.edit', compact('assurance'));
    }

    /**
     * Mettre à jour un contrat existant.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_envoi' => 'required|date',
            'bulletin_numero' => 'required|string|max:50',
            'nom_adherent' => 'required|string|max:255',
            'date_de_soin' => 'required|date',
            'status' => 'required|in:Remis,Non Remis,Cloture',
            'reclamation' => 'nullable|string',
        ]);

        $assurance = AssuranceMaladie::findOrFail($id);

        // Vérifier si la date a changé
        if ($assurance->date_envoi !== $request->date_envoi) {
            $assurance->numero_borderaux = $this->generateNumeroBordereau($request->date_envoi);
        }

        $assurance->update([
            'date_envoi' => $request->date_envoi,
            'bulletin_numero' => $request->bulletin_numero,
            'nom_adherent' => $request->nom_adherent,
            'date_de_soin' => $request->date_de_soin,
            'status' => $request->status,
            'reclamation' => $request->reclamation,
        ]);

        return redirect()->route('admin.assurance.AssuranceMaladie.contrats')
                         ->with('success', 'Contrat mis à jour avec succès.');
    }


    /**
     * Supprimer un contrat.
     */
    public function destroy($id)
    {
        $assurance = AssuranceMaladie::findOrFail($id);
        $assurance->delete();

        return redirect()->route('admin.assurance.AssuranceMaladie.contrats')
                         ->with('success', 'Contrat supprimé avec succès.');
    }

    /**
     * Générer un numéro bordereau basé sur la date d'envoi.
     */
    private function generateNumeroBordereau($date)
    {
        // Vérifier si un numéro existe déjà pour cette date
        $bordereau = Bordereau::where('date_envoi', $date)->first();

        if (!$bordereau) {
            // Si aucun numéro existant, créer un nouveau bordereau
            $lastBordereau = Bordereau::orderBy('id', 'desc')->first();
            $newNumero = 'C' . (($lastBordereau ? intval(substr($lastBordereau->numero_borderaux, 1)) + 1 : 1));

            $bordereau = Bordereau::create([
                'date_envoi' => $date,
                'numero_borderaux' => $newNumero,
            ]);
        }

        return $bordereau->numero_borderaux;
    }

}
