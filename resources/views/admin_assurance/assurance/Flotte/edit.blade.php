@extends('layouts.app')

@section('title', 'Modifier Contrat Flotte')

@section('content')

<div class="container">
    <h2 class="text-center mb-4">Modifier Contrat Flotte</h2>

    <!-- Formulaire pour modifier un contrat -->
    <form action="{{ route('admin.assurance.flotte.update', $contrat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" class="form-control @error('compagnie_assurance') is-invalid @enderror"
                   id="compagnie_assurance" name="compagnie_assurance" value="{{ old('compagnie_assurance', $contrat->compagnie_assurance) }}" required>
            @error('compagnie_assurance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="ref_contrat">Référence Contrat</label>
            <input type="text" class="form-control @error('ref_contrat') is-invalid @enderror"
                   id="ref_contrat" name="ref_contrat" value="{{ old('ref_contrat', $contrat->ref_contrat) }}" required>
            @error('ref_contrat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" class="form-control @error('date_effet') is-invalid @enderror"
                   id="date_effet" name="date_effet" value="{{ old('date_effet', $contrat->date_effet) }}" required>
            @error('date_effet')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="echeance">Echéance</label>
            <input type="date" class="form-control @error('echeance') is-invalid @enderror"
                   id="echeance" name="echeance" value="{{ old('echeance', $contrat->echeance) }}" required>
            @error('echeance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <textarea class="form-control @error('condition_renouvellement') is-invalid @enderror"
                      id="condition_renouvellement" name="condition_renouvellement" rows="3" required>{{ old('condition_renouvellement', $contrat->condition_renouvellement) }}</textarea>
            @error('condition_renouvellement')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select class="form-control @error('avenant') is-invalid @enderror" id="avenant" name="avenant" required>
                <option value="1" {{ old('avenant', $contrat->avenant) == true ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('avenant', $contrat->avenant) == false ? 'selected' : '' }}>Non</option>
            </select>
            @error('avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="objet_avenant">Objet Avenant</label>
            <input type="text" name="objet_avenant" id="objet_avenant" class="form-control @error('objet_avenant') is-invalid @enderror" value="{{ old('objet_avenant', $contrat->objet_avenant) }}" required>
            @error('objet_avenant')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <div class="form-group">
            <label for="attachement_contrat">Attachement Contrat</label>
            <input type="file" class="form-control-file @error('attachement_contrat') is-invalid @enderror"
                   id="attachement_contrat" name="attachement_contrat">
            @if($contrat->attachement_contrat)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $contrat->attachement_contrat) }}" target="_blank" class="btn btn-info btn-sm">Voir le fichier actuel</a>
                </div>
            @endif
            @error('attachement_contrat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="attachement_avenant">Attachement Avenant</label>
            <input type="file" class="form-control-file @error('attachement_avenant') is-invalid @enderror"
                   id="attachement_avenant" name="attachement_avenant">
            @if($contrat->attachement_avenant)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $contrat->attachement_avenant) }}" target="_blank" class="btn btn-info btn-sm">Voir le fichier actuel</a>
                </div>
            @endif
            @error('attachement_avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success btn-block">Mettre à jour le contrat</button>
    </form>
</div>

@endsection
