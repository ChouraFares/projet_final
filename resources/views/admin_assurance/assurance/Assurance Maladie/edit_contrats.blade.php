@extends('layouts.app')
@section('title','Modifier le Contrat d\'Assurance Maladie')
@section('content')
<div class="container">
    <h2>Modifier le Contrat d'Assurance Maladie</h1>

    <form action="{{ route('contrats_assurance_maladie.update', $contrat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" class="form-control" id="compagnie_assurance" name="compagnie_assurance" value="{{ $contrat->compagnie_assurance }}" required>
        </div>

        <div class="form-group">
            <label for="ref_contrat">Référence du Contrat</label>
            <input type="text" class="form-control" id="ref_contrat" name="ref_contrat" value="{{ $contrat->ref_contrat }}" required>
        </div>

        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" class="form-control" id="date_effet" name="date_effet" value="{{ $contrat->date_effet }}" required>
        </div>

        <div class="form-group">
            <label for="echeance">Échéance</label>
            <input type="date" class="form-control" id="echeance" name="echeance" value="{{ $contrat->echeance }}" required>
        </div>

        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <textarea class="form-control" id="condition_renouvellement" name="condition_renouvellement" required>{{ $contrat->condition_renouvellement }}</textarea>
        </div>

        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select class="form-control" id="avenant" name="avenant" required>
            <option value="oui" {{ $contrat->avenant == 'oui' ? 'selected' : '' }}>Oui</option>
            <option value="non" {{ $contrat->avenant == 'non' ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label for="objet_avenant">Objet de l'Avenant</label>
            <textarea class="form-control" id="objet_avenant" name="objet_avenant" required>{{ $contrat->objet_avenant }}</textarea>
        </div>

        <div class="form-group">
            <label for="attachement_contrat">Changer la Pièce Jointe </label>
            <input type="file" class="form-control-file" id="attachement_contrat" name="attachement_contrat">
            @if($contrat->attachement_contrat)
                <p>Fichier actuel : <a href="{{ asset('storage/' . $contrat->attachement_contrat) }}" target="_blank" style="color: yellow;">Voir</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
    </form>
</div>
@endsection
