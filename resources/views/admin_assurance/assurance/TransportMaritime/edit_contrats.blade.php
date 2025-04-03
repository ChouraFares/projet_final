@extends('layouts.app')

@section('title', 'Modifier l\'Assurance Transport Maritime')

@section('content')
<div class="container">
    <h2>Modifier l'Assurance Transport Maritime</h2>

    <!-- Display error messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de modification -->
    <form action="{{ route('update', $contrat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" name="compagnie_assurance" id="compagnie_assurance" class="form-control @error('compagnie_assurance') is-invalid @enderror" value="{{ old('compagnie_assurance', $contrat->compagnie_assurance) }}" required>
            @error('compagnie_assurance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="ref_contrat">Référence Contrat</label>
            <input type="text" name="ref_contrat" id="ref_contrat" class="form-control @error('ref_contrat') is-invalid @enderror" value="{{ old('ref_contrat', $contrat->ref_contrat) }}" required>
            @error('ref_contrat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" name="date_effet" id="date_effet" class="form-control @error('date_effet') is-invalid @enderror" value="{{ old('date_effet', $contrat->date_effet) }}" required>
            @error('date_effet')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="echeance">Échéance</label>
            <input type="date" name="echeance" id="echeance" class="form-control @error('echeance') is-invalid @enderror" value="{{ old('echeance', $contrat->echeance) }}" required>
            @error('echeance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <input type="text" name="condition_renouvellement" id="condition_renouvellement" class="form-control @error('condition_renouvellement') is-invalid @enderror" value="{{ old('condition_renouvellement', $contrat->condition_renouvellement) }}" required>
            @error('condition_renouvellement')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select name="avenant" id="avenant" class="form-control @error('avenant') is-invalid @enderror">
            <option value="1" {{ old('avenant', $contrat->avenant) == 1 ? 'selected' : '' }}>Oui</option>
            <option value="0" {{ old('avenant', $contrat->avenant) == 0 ? 'selected' : '' }}>Non</option>
            </select>
            @error('avenant')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="objet_avenant">Objet de l'Avenant</label>
            <input type="text" name="objet_avenant" id="objet_avenant" class="form-control @error('objet_avenant') is-invalid @enderror" value="{{ old('objet_avenant', $contrat->objet_avenant) }}">
            @error('objet_avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="attachement_contrat">Attachement Contrat</label>
            <input type="file" name="attachement_contrat" id="attachement_contrat" class="form-control @error('attachement_contrat') is-invalid @enderror">
            @error('attachement_contrat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($contrat->attachement_contrat)
                <p>Fichier actuel : <a href="{{ asset('storage/'.$contrat->attachement_contrat) }}" target="_blank" style="color: blue; text-decoration: underline; background-color: yellow;">Voir le contrat</a></p>
            @endif
        </div>

        <div class="form-group">
            <label for="attachement_avenant">Attachement Avenant</label>
            <input type="file" name="attachement_avenant" id="attachement_avenant" class="form-control @error('attachement_avenant') is-invalid @enderror">
            @error('attachement_avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($contrat->attachement_avenant)
                <p>Fichier actuel : <a href="{{ asset('storage/'.$contrat->attachement_avenant) }}" target="_blank" style="color: blue; text-decoration: underline; background-color: yellow;">Voir l'avenant</a></p>
            @endif
        </div>


        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
</div>
@endsection
