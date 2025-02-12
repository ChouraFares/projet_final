@extends('layouts.app')
@section('title','Modifier Bris De Machine')
@section('content')
    <div class="container">
        <h2>Éditer le Contrat d'Assurance Bris de Machine</h2>

        <!-- Affichage des messages de succès ou d'erreur -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('BrisDeMachineUpdate', $contract->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="compagnie_assurance">Compagnie d'Assurance</label>
                <input type="text" class="form-control" id="compagnie_assurance" name="compagnie_assurance" value="{{ old('compagnie_assurance', $contract->compagnie_assurance) }}" required>
            </div>

            <div class="form-group">
                <label for="ref_contrat">Référence du Contrat</label>
                <input type="text" class="form-control" id="ref_contrat" name="ref_contrat" value="{{ old('ref_contrat', $contract->ref_contrat) }}" required>
            </div>

            <div class="form-group">
                <label for="date_effet">Date d'Effet</label>
                <input type="date" class="form-control" id="date_effet" name="date_effet" value="{{ old('date_effet', $contract->date_effet) }}" required>
            </div>

            <div class="form-group">
                <label for="echeance">Echéance</label>
                <input type="date" class="form-control" id="echeance" name="echeance" value="{{ old('echeance', $contract->echeance) }}" required>
            </div>

            <div class="form-group">
                <label for="condition_renouvellement">Condition de Renouvellement</label>
                <input type="text" class="form-control" id="condition_renouvellement" name="condition_renouvellement" value="{{ old('condition_renouvellement', $contract->condition_renouvellement) }}">
            </div>

            <div class="form-group">
                <label for="avenant">Avenant</label>
                <select class="form-control" id="avenant" name="avenant" required>
                    <option value="oui" {{ $contract->avenant ? 'selected' : '' }}>Oui</option>
                    <option value="non" {{ !$contract->avenant ? 'selected' : '' }}>Non</option>
                </select>
            </div>

            <div class="form-group">
                <label for="objet_avenant">Objet Avenant</label>
                <input type="text" class="form-control" id="objet_avenant" name="objet_avenant" value="{{ old('objet_avenant', $contract->objet_avenant) }}">
            </div>
            <div class="form-group">
                <label for="attachement_contrat">Attachement du Contrat</label>
                <input type="file" class="form-control" id="attachement_contrat" name="attachement_contrat">
                @if($contract->attachement_contrat)
                    <a href="{{ asset('storage/' . $contract->attachement_contrat) }}" target="_blank">Voir le fichier actuel</a>
                @endif
            </div>

            <div class="form-group">
                <label for="attachement_avenant">Attachement de l'Avenant</label>
                <input type="file" class="form-control" id="attachement_avenant" name="attachement_avenant">
                @if($contract->attachement_avenant)
                    <a href="{{ asset('storage/' . $contract->attachement_avenant) }}" target="_blank">Voir le fichier actuel</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour le Contrat</button>
        </form>
    </div>
@endsection
