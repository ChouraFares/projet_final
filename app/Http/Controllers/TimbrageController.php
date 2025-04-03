<?php

namespace App\Http\Controllers;

use App\Models\ChequePaiement;
use App\Models\FactureComplimentaireThonModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TimbrageController extends Controller
{

    public function index($id)
    {
        $cheques = ChequePaiement::with('facture')
            ->where('facture_id', $id)
            ->get();
        
        // Get the facture directly if needed
        $facture = FactureComplimentaireThonModel::findOrFail($id);
        
        return view('TransitAchat.detaille_timbrage_et_avance_surestarie', compact('cheques', 'facture'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'cheque_id' => 'required|exists:cheque_paiements,id',
            'echeance_timbrage' => 'nullable|date',
            'timbrage_montant_retenue_a_la_source' => 'nullable|numeric|min:0',
            'Etat' => 'nullable|in:virement,chèque,traité',
            'Attachement_Timbrage' => 'nullable|file|mimes:pdf|max:5120',
        ]);
    
        // Log des données reçues
        Log::info('Données reçues dans update:', $request->all());
    
        $cheque = ChequePaiement::findOrFail($request->cheque_id);
    
        // Préparer les données à mettre à jour
        $data = [];
        if ($request->filled('echeance_timbrage')) {
            $data['echeance_timbrage'] = $request->echeance_timbrage;
        }
        if ($request->filled('timbrage_montant_retenue_a_la_source')) {
            $data['timbrage_montant_retenue_a_la_source'] = $request->timbrage_montant_retenue_a_la_source;
        }
        if ($request->filled('Etat')) {
            $data['Etat'] = $request->Etat;
        }
    
        if ($request->hasFile('Attachement_Timbrage')) {
            if ($cheque->Attachement_Timbrage) {
                Storage::disk('public')->delete($cheque->Attachement_Timbrage);
            }
            $filePath = $request->file('Attachement_Timbrage')->store('timbrage_attachments', 'public');
            $data['Attachement_Timbrage'] = $filePath;
        }
    
        // Mettre à jour uniquement les champs fournis
        $cheque->update($data);
    
        // Log après sauvegarde pour vérifier
        Log::info('Chèque mis à jour:', $cheque->toArray());
    
        $response = ['message' => 'Les informations de timbrage ont été mises à jour avec succès.'];
        if (isset($filePath)) {
            $response['file_path'] = $filePath;
            $response['file_url'] = asset('storage/' . $filePath);
        }
    
        return response()->json($response);
    }


}