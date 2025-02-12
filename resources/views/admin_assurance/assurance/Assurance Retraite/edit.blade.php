@extends('layouts.app')

@section('title', 'Modifier Assurance Retraite')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Modifier Assurance Retraite</h2>

    <form action="{{ route('AssuranceRetraiteUpdate', $contrat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" name="compagnie_assurance" id="compagnie_assurance" class="form-control" value="{{ $contrat->compagnie_assurance }}" required>
        </div>

        <div class="form-group">
            <label for="ref_contrat">Réf Contrat</label>
            <input type="text" name="ref_contrat" id="ref_contrat" class="form-control" value="{{ $contrat->ref_contrat }}" required>
        </div>

        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" name="date_effet" id="date_effet" class="form-control" value="{{ $contrat->date_effet }}" required>
        </div>

        <div class="form-group">
            <label for="echeance">Échéance</label>
            <input type="date" name="echeance" id="echeance" class="form-control" value="{{ $contrat->echeance }}" required>
        </div>

        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <textarea name="condition_renouvellement" id="condition_renouvellement" class="form-control" rows="3">{{ $contrat->condition_renouvellement }}</textarea>
        </div>

        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select name="avenant" id="avenant" class="form-control" required>
                <option value="1" {{ $contrat->avenant == 1 ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ $contrat->avenant == 0 ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label for="objet_avenant">Objet de l'Avenant</label>
            <textarea name="objet_avenant" id="objet_avenant" class="form-control" rows="3">{{ $contrat->objet_avenant }}</textarea>
        </div>

        <div class="form-group">
            <label for="attachement_contrat">Attachement Contrat</label>
            <input type="file" name="attachement_contrat" id="attachement_contrat" class="form-control">
            @if($contrat->attachement_contrat)
                <p>Fichier actuel : <a href="{{ asset('storage/'.$contrat->attachement_contrat) }}" target="_blank" style="color: yellow;">Voir</a></p>
            @endif
        </div>

        <div class="form-group">
            <label for="attachement_avenant">Attachement Avenant</label>
            <input type="file" name="attachement_avenant" id="attachement_avenant" class="form-control">
            @if($contrat->attachement_avenant)
                <p>Fichier actuel : <a href="{{ asset('storage/'.$contrat->attachement_avenant) }}" target="_blank" style="color: yellow;">Voir</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-3">Modifier</button>
    </form>
</div>
@endsection
