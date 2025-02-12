@extends('layouts.app')
@section('title', 'Ajouter un Contrat d\'Assurance Maladie')
@section('content')
<div class="container">
    <h2>Ajouter un Contrat d'Assurance Maladie</h2>

    <form action="{{ route('contrats_assurance_maladie.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" class="form-control" id="compagnie_assurance" name="compagnie_assurance" required>
        </div>

        <div class="form-group">
            <label for="ref_contrat">Référence du Contrat</label>
            <input type="text" class="form-control" id="ref_contrat" name="ref_contrat" required>
        </div>

        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" class="form-control" id="date_effet" name="date_effet" required>
        </div>

        <div class="form-group">
            <label for="echeance">Échéance</label>
            <input type="date" class="form-control" id="echeance" name="echeance" required>
        </div>

        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <textarea class="form-control" id="condition_renouvellement" name="condition_renouvellement" required></textarea>
        </div>

        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select class="form-control" id="avenant" name="avenant" required>
            <option value="oui">Oui</option>
            <option value="non">Non</option>
            </select>
        </div>

        <div class="form-group">
            <label for="objet_avenant">Objet de l'Avenant</label>
            <textarea class="form-control" id="objet_avenant" name="objet_avenant" required></textarea>
        </div>

        <div class="form-group">
            <label for="attachement_contrat">Pièce Jointe (PDF, JPG, PNG)</label>
            <input type="file" class="form-control-file" id="attachement_contrat" name="attachement_contrat" required>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
