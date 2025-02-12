@extends('layouts.app')

@section('title', 'Créer une Assurance Retraite')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Créer une Nouvelle Assurance Retraite</h2>

    <!-- Affichage des erreurs globales -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de création d'une assurance retraite -->
    <form action="{{ route('AssuranceRetraiteStore') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Compagnie d'assurance -->
        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" name="compagnie_assurance" id="compagnie_assurance" class="form-control @error('compagnie_assurance') is-invalid @enderror" value="{{ old('compagnie_assurance') }}" required>
            @error('compagnie_assurance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Réf Contrat -->
        <div class="form-group">
            <label for="ref_contrat">Réf Contrat</label>
            <input type="text" name="ref_contrat" id="ref_contrat" class="form-control @error('ref_contrat') is-invalid @enderror" value="{{ old('ref_contrat') }}" required>
            @error('ref_contrat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date d'effet -->
        <div class="form-group">
            <label for="date_effet">Date d'Effet</label>
            <input type="date" name="date_effet" id="date_effet" class="form-control @error('date_effet') is-invalid @enderror" value="{{ old('date_effet') }}" required>
            @error('date_effet')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Échéance -->
        <div class="form-group">
            <label for="echeance">Échéance</label>
            <input type="date" name="echeance" id="echeance" class="form-control @error('echeance') is-invalid @enderror" value="{{ old('echeance') }}" required>
            @error('echeance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Condition de renouvellement -->
        <div class="form-group">
            <label for="condition_renouvellement">Condition de Renouvellement</label>
            <textarea name="condition_renouvellement" id="condition_renouvellement" class="form-control @error('condition_renouvellement') is-invalid @enderror" rows="3" required>{{ old('condition_renouvellement') }}</textarea>
            @error('condition_renouvellement')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Avenant -->
        <div class="form-group">
            <label for="avenant">Avenant</label>
            <select name="avenant" id="avenant" class="form-control @error('avenant') is-invalid @enderror" required>
                <option value="oui" {{ old('avenant') == 'oui' ? 'selected' : '' }}>Oui</option>
                <option value="non" {{ old('avenant') == 'non' ? 'selected' : '' }}>Non</option>
            </select>
            @error('avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Objet de l'avenant -->
        <div class="form-group">
            <label for="objet_avenant">Objet de l'Avenant</label>
            <textarea name="objet_avenant" id="objet_avenant" class="form-control @error('objet_avenant') is-invalid @enderror" rows="3">{{ old('objet_avenant') }}</textarea>
            @error('objet_avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Attachement Contrat -->
        <div class="form-group">
            <label for="attachement_contrat">Attachement Contrat</label>
            <input type="file" name="attachement_contrat" id="attachement_contrat" class="form-control @error('attachement_contrat') is-invalid @enderror">
            @error('attachement_contrat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Attachement Avenant -->
        <div class="form-group">
            <label for="attachement_avenant">Attachement Avenant</label>
            <input type="file" name="attachement_avenant" id="attachement_avenant" class="form-control @error('attachement_avenant') is-invalid @enderror">
            @error('attachement_avenant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
    </form>
</div>
@endsection
