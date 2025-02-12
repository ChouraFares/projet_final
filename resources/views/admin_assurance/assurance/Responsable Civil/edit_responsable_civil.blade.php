@extends('layouts.app')

@section('title', 'Modifier un Contrat - Assurance Responsabilité Civile')

@section('content')

<div class="container">
    <h2 class="text-center mb-4">Modifier un Contrat - Assurance Responsabilité Civile</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ResponsableCivilUpdate', $contrat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" id="compagnie_assurance" name="compagnie_assurance" class="form-control @error('compagnie_assurance') is-invalid @enderror" value="{{ old('compagnie_assurance', $contrat->compagnie_assurance) }}" required>
            @error('compagnie_assurance') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="ref_contrat">Référence du Contrat</label>
            <input type="text" id="ref_contrat" name="ref_contrat" class="form-control @error('ref_contrat') is-invalid @enderror" value="{{ old('ref_contrat', $contrat->ref_contrat) }}" required>
            @error('ref_contrat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" id="date_effet" name="date_effet" class="form-control @error('date_effet') is-invalid @enderror" value="{{ old('date_effet', $contrat->date_effet) }}" required>
            @error('date_effet') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="echeance">Date d'Échéance</label>
            <input type="date" id="echeance" name="echeance" class="form-control @error('echeance') is-invalid @enderror" value="{{ old('echeance', $contrat->echeance) }}" required>
            @error('echeance') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <textarea id="condition_renouvellement" name="condition_renouvellement" class="form-control @error('condition_renouvellement') is-invalid @enderror" required>{{ old('condition_renouvellement', $contrat->condition_renouvellement) }}</textarea>
            @error('condition_renouvellement') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select id="avenant" name="avenant" class="form-control @error('avenant') is-invalid @enderror">
            <option value="1" {{ old('avenant', $contrat->avenant) == '1' ? 'selected' : '' }}>Oui</option>
            <option value="0" {{ old('avenant', $contrat->avenant) == '0' ? 'selected' : '' }}>Non</option>
            </select>
            @error('avenant') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>



        <div class="form-group">
            <label for="objet_avenant">Objet de l'Avenant</label>
            <textarea id="objet_avenant" name="objet_avenant" class="form-control @error('objet_avenant') is-invalid @enderror">{{ old('objet_avenant', $contrat->objet_avenant) }}</textarea>
            @error('objet_avenant') <div class="invalid-feedback">{{ $message }}</div> @enderror

        </div>

        <div class="form-group">
            <label for="attachement_contrat">Attachement du Contrat (PDF)</label>
            <input type="file" id="attachement_contrat" name="attachement_contrat" class="form-control-file @error('attachement_contrat') is-invalid @enderror">
            @if($contrat->attachement_contrat)
                <p>Fichier actuel : <a href="{{ asset('storage/'.$contrat->attachement_contrat) }}" target="_blank" style="color: yellow;">Voir</a></p>
            @endif
            @error('attachement_contrat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="attachement_avenant">Attachement de l'Avenant (PDF)</label>
            <input type="file" id="attachement_avenant" name="attachement_avenant" class="form-control-file @error('attachement_avenant') is-invalid @enderror">
            @if($contrat->attachement_avenant)
                <p>Fichier actuel : <a href="{{ asset('storage/'.$contrat->attachement_avenant) }}" target="_blank" style="color: yellow;">Voir</a></p>
            @endif
            @error('attachement_avenant') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</div>

@endsection
