<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Imports\FacturesImport; // "App" avec une majuscule
use App\Mail\PrepaymentApprovedMail;
use App\Models\ChequePaiement;

use App\Models\FactureComplimentaireThonModel;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\PrepaymentRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FactureComplimentaireThon extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true); // Calculer les formules
    
        foreach (array_slice($data, 1) as $index => $row) { // Ignorer les en-têtes
            try {
                DB::table('facture_complimentaire_thon')->insert([
                    'facture' => $row['A'] ?? null,
                    'num_conteneur' => $row['B'] ?? null,
                    'fournisseur' => $row['C'] ?? null,
                    'armateur' => $row['F'] ?? null, // Décalé à cause des colonnes supplémentaires
                    'incoterm' => $row['E'] ?? null,
                    'port' => $row['G'] ?? null,
                    'bank' => $row['H'] ?? null,
                    'date_declaration' => $this->parseDate($row['I']),
                    'assureur' => $row['J'] ?? null,
                    'date_expiration' => $this->parseDate($row['K']),
                    'BL' => $row['L'] ?? null,
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', "Erreur ligne " . ($index + 2) . ": " . $e->getMessage());
            }
        }
    
        return redirect()->back()->with('success', 'Importation réussie');
    }
    
    private function parseDate($value)
    {
        // Gérer les formules ou nombres Excel
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        // Gérer les dates textuelles (ex. 14/12/2023)
        if ($date = \DateTime::createFromFormat('d/m/Y', $value)) {
            return $date->format('Y-m-d');
        }
        // Cas par défaut (ex. texte non valide)
        return null;
    }



    public function showDetailleChequeAssurance($id)
    {
        $facture = FactureComplimentaireThonModel::findOrFail($id);
        $cheques = $facture->cheques()->where('payment_type', 'assurance')->get();
        $type = 'assurance';
        return view('TransitAchat.detaille_cheque_assurance', compact('facture', 'cheques', 'type'));
    }
    public function updateChequeAssurance(Request $request)
    {
        $request->validate([
            'cheque_id' => 'required|exists:cheque_paiements,id',
            'date_expiration_assurance' => 'nullable|date',
            'numero_aliment_assurance' => 'nullable|string|max:255',
        ]);
    
        $cheque = ChequePaiement::findOrFail($request->cheque_id);
        $cheque->update([
            'date_expiration_assurance' => $request->date_expiration_assurance,
            'numero_aliment_assurance' => $request->numero_aliment_assurance,
        ]);
    
        return response()->json(['message' => 'Chèque mis à jour avec succès']);
    }

 

    public function showCheques($id, $type)
{
    // Récupérer la facture
    $facture = FactureComplimentaireThonModel::findOrFail($id);

    // Récupérer les chèques pour le type de paiement spécifié
    $cheques = $facture->cheques()->where('payment_type', $type)->get();

    return view('TransitAchat.detaille_cheque', compact('facture', 'cheques', 'type'));
}
public function index()
{
    $factures = FactureComplimentaireThonModel::withCount('cheques')
        ->orderBy('date_demande', 'desc') // Tri principal par date décroissante (les plus récentes en haut)
        ->orderByRaw('CASE 
            WHEN validation_transit != "en_attente" THEN 1  -- Demandes validées ou refusées en haut
            WHEN cheques_count > 0 THEN 2                  -- Factures avec chèques ensuite
            ELSE 3                                        -- Le reste en bas
        END')
        ->get();

    // Grouper les factures par numéro de facture
    $groupedFactures = $factures->groupBy('facture');

    return view('TransitAchat.facture_complimentaire_thon', compact('groupedFactures'));
}


    





    public function create()
{
    return view('TransitAchat.create_facture_complimentaire_thon');
}

public function store(Request $request)
{
    $data = $request->all();

    // Créer la facture
    $facture = FactureComplimentaireThonModel::create($data);

    // Vérifier si "Préparer Paiement" est coché pour une section
    $sections = ['assurance', 'douane', 'recette_finance', 'stam', 'surestarie'];
    $hasPreparerPaiement = false;

    foreach ($sections as $section) {
        if ($request->has($section . '_preparer_paiement')) {
            $hasPreparerPaiement = true;
            break;
        }
    }

    // Si une section est cochée, envoyer la demande au super_admin_transit
    if ($hasPreparerPaiement) {
        // Envoyer une notification ou marquer la facture comme "en attente de validation"
        $facture->update(['validation_transit' => 'en_attente']);
    }

    return redirect()->route('transit-achat.facture-complimentaire-thon')->with('success', 'Facture ajoutée avec succès.');
}


public function demander($id)
{
    $facture = FactureComplimentaireThonModel::findOrFail($id);
    return view('TransitAchat.demander_facture_complimentaire_thon', compact('facture'));
}

public function edit($id)
{
    $facture = FactureComplimentaireThonModel::with('cheques')->findOrFail($id);    
    // Vérifiez si des chèques sont associés à cette facture
    if (!$facture->hasExistingRequest()) {
        return redirect()->back()->with('error', 'Aucune demande existante à modifier.');
    }

    return view('TransitAchat.edit', compact('facture'));
}


public function update(Request $request, $id)
{
    $facture = FactureComplimentaireThonModel::findOrFail($id);

    // Validation des données
    $request->validate([
        'facture' => 'nullable|string|max:255',
        'fournisseur' => 'nullable|string|max:255',
        'armateur' => 'nullable|string|max:255',
        'incoterm' => 'nullable|string|max:255',
        'port' => 'nullable|string|max:255',
        'bank' => 'nullable|string|max:255',
        'date_declaration' => 'nullable|date',
        'assureur' => 'nullable|string|max:255',
        'date_expiration' => 'nullable|date',
        'total' => 'nullable|numeric',
        'date_recuperation' => 'nullable|date',
        'date_enlevement' => 'nullable|date',
        'cheques' => 'array',
        'cheques.*.*.montant' => 'nullable|numeric',
        'cheques.*.*.ref_mdp' => 'nullable|string|max:255',
    ]);

    // Mise à jour des champs principaux de la facture
    $facture->update($request->only([
        'facture', 'fournisseur', 'armateur', 'incoterm', 'port', 'bank',
        'date_declaration', 'assureur', 'date_expiration', 'total',
        'date_recuperation', 'date_enlevement',
    ]));

    // Gestion des chèques
    if ($request->has('cheques')) {
        foreach ($request->cheques as $paymentType => $cheques) {
            foreach ($cheques as $chequeId => $data) {
                if (strpos($chequeId, 'new_') === 0) {
                    // Nouveau chèque
                    if (!empty($data['montant']) || !empty($data['ref_mdp'])) {
                        ChequePaiement::create([
                            'facture_id' => $facture->id,
                            'payment_type' => $paymentType,
                            'montant' => $data['montant'],
                            'ref_mdp' => $data['ref_mdp'],
                        ]);
                    }
                } else {
                    // Mise à jour d'un chèque existant
                    $cheque = ChequePaiement::find($chequeId);
                    if ($cheque) {
                        $cheque->update([
                            'montant' => $data['montant'],
                            'ref_mdp' => $data['ref_mdp'],
                        ]);
                    }
                }
            }
        }
    }

    return redirect()->route('transit-achat.facture-complimentaire-thon')
        ->with('success', 'Facture et chèques mis à jour avec succès.');
}

public function demander_prepayement(Request $request, $id)
{
    Log::info('Début de demander_prepayement pour facture ID: ' . $id);

    // Validation des données
    $request->validate([
        'facture' => 'required|string|max:255',
        'fournisseur' => 'required|string|max:255',
        'armateur' => 'nullable|string|max:255',
        'incoterm' => 'nullable|string|max:50',
        'port' => 'nullable|string|max:255',
        'bank' => 'nullable|string|max:255',
        'date_declaration' => 'nullable|date',
        'assureur' => 'nullable|string|max:255',
        'date_expiration' => 'nullable|date',
        'total' => 'nullable|numeric',
        'date_recuperation' => 'nullable|date',
        'date_enlevement' => 'nullable|date',
        'payment_types' => 'required|array',
        'payment_types.*' => 'in:recette_finance,douane,timbrage_et_avances_surestarie,stam,assurance',
        'cheque_count' => 'array',
        'cheque_count.*' => 'required|integer|min:1',
        'cheques' => 'array',
        'cheques.*.*.montant' => 'nullable|numeric',
        'cheques.*.*.ref_mdp' => 'nullable|string|max:255',
    ]);

    Log::info('Validation réussie');

    DB::beginTransaction();
    try {
        // Récupérer la facture
        $facture = FactureComplimentaireThonModel::findOrFail($id);
        Log::info('Facture trouvée: ' . $facture->id);

        // Vérifier si une demande existe déjà
        if ($facture->hasExistingRequest()) {
            Log::info('Demande existante détectée');
            return redirect()->back()->with('error', 'Une demande de prépaiement existe déjà pour cette facture.');
        }

        // Mettre à jour la facture avec les données du formulaire
        $factureData = $request->except(['statut_finance', 'validation_finance', 'payment_types', 'cheque_count', 'cheques', 'date_demande']);
        $factureData['date_demande'] = now();
        $facture->update($factureData);
        Log::info('Facture mise à jour avec date_demande');

        // Gérer les types de paiement et les chèques
        $paymentTypes = $request->input('payment_types', []);
        foreach ($paymentTypes as $paymentType) {
            $facture->update(["{$paymentType}_preparer_paiement" => true]);
            Log::info("Type de paiement mis à jour: {$paymentType}");

            ChequePaiement::where('facture_id', $facture->id)
                ->where('payment_type', $paymentType)
                ->delete();

            $cheques = $request->input("cheques.{$paymentType}", []);
            foreach ($cheques as $cheque) {
                if (!empty($cheque['montant']) || !empty($cheque['ref_mdp'])) {
                    ChequePaiement::create([
                        'facture_id' => $facture->id,
                        'payment_type' => $paymentType,
                        'montant' => $cheque['montant'],
                        'ref_mdp' => $cheque['ref_mdp'],
                    ]);
                    Log::info("Chèque créé pour {$paymentType}");
                }
            }
        }

        // Mettre à jour la validation finance si nécessaire
        if ($facture->validation_transit === 'Validé') {
            $facture->validation_finance = 'Clôturé';
            $facture->save();
            Log::info('Validation finance mise à Clôturé');
        }

        // Récupérer le nom de l'agent de transit (TransitAgent)
        $transitAgentName = Auth::user()->name;
        Log::info('Agent transit: ' . $transitAgentName);

        // Envoyer les notifications aux responsables finance
        $responsablesFinance = User::where('role', 'responsable_finance')->get();
        foreach ($responsablesFinance as $responsable) {
            $responsable->notify(new PrepaymentRequestNotification(
                $facture,
                $facture->fournisseur,
                $facture->date_demande,
                $transitAgentName
            ));
            Log::info('Notification envoyée à responsable_finance: ' . $responsable->id);
        }

        // Envoyer les notifications aux super admins transit
        $superAdminsTransit = User::where('role', 'super_admin_transit')->get();
        foreach ($superAdminsTransit as $superAdmin) {
            $superAdmin->notify(new PrepaymentRequestNotification(
                $facture,
                $facture->fournisseur,
                $facture->date_demande,
                $transitAgentName
            ));
            Log::info('Notification envoyée à super_admin_transit: ' . $superAdmin->id);
        }

        // Vérifier les validations et envoyer un email aux TransitAgent si les deux sont approuvées
        if ($facture->validation_finance === 'Validé' && $facture->validation_transit === 'Validé') {
            // Récupérer tous les utilisateurs ayant le rôle TransitAgent
            $transitAgents = User::where('role', 'TransitAgent')->get();
            foreach ($transitAgents as $transitAgent) {
                try {
                    Mail::to($transitAgent->email)->send(new PrepaymentApprovedMail(
                        $facture->facture,
                        $facture->fournisseur,
                        $facture->date_demande,
                        $transitAgentName
                    ));
                    Log::info('Email envoyé à TransitAgent: ' . $transitAgent->id);
                } catch (\Exception $e) {
                    Log::warning('Erreur lors de l\'envoi de l\'email à TransitAgent ' . $transitAgent->id . ': ' . $e->getMessage());
                    // Continuer l'exécution même si l'envoi échoue
                }
            }
        } else {
            Log::info('Validations non approuvées, aucun email envoyé aux TransitAgent.');
        }

        DB::commit();
        Log::info('Transaction validée');

        return redirect()->route('transit-achat.facture-complimentaire-thon')
            ->with('success', 'Demande de prépaiement envoyée avec succès !');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur lors de la demande de prépaiement : ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString());
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}

public function destroy($id)
{
    $facture = FactureComplimentaireThonModel::findOrFail($id);
    $facture->delete();
    return redirect()->route('transit-achat.facture-complimentaire-thon')->with('success', 'Facture supprimée avec succès.');
}

}
