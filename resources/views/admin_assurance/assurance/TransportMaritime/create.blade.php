@extends('layouts.app')

@section('title', 'Ajouter un Contrat Transport Maritime')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Ajouter un Contrat Transport Maritime</h2>

    <!-- Formulaire de création de contrat -->
    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Compagnie d'Assurance -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="compagnie_assurance">Compagnie d'Assurance</label>
                    <input type="text" class="form-control @error('compagnie_assurance') is-invalid @enderror" id="compagnie_assurance" name="compagnie_assurance" value="{{ old('compagnie_assurance') }}" required>
                    @error('compagnie_assurance')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Référence du Contrat -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ref_contrat">Référence Contrat</label>
                    <input type="text" class="form-control @error('ref_contrat') is-invalid @enderror" id="ref_contrat" name="ref_contrat" value="{{ old('ref_contrat') }}" required>
                    @error('ref_contrat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Date d'Effet -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_effet">Date d'Effet</label>
                    <input type="date" class="form-control @error('date_effet') is-invalid @enderror" id="date_effet" name="date_effet" value="{{ old('date_effet') }}" required>
                    @error('date_effet')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Échéance -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="echeance">Échéance</label>
                    <input type="date" class="form-control @error('echeance') is-invalid @enderror" id="echeance" name="echeance" value="{{ old('echeance') }}" required>
                    @error('echeance')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Condition Renouvellement -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="condition_renouvellement">Condition Renouvellement</label>
                    <input type="text" class="form-control @error('condition_renouvellement') is-invalid @enderror" id="condition_renouvellement" name="condition_renouvellement" value="{{ old('condition_renouvellement') }}">
                    @error('condition_renouvellement')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Avenant (Select Oui/Non) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="avenant">Avenant</label>
                    <select class="form-control @error('avenant') is-invalid @enderror" id="avenant" name="avenant">
                        <option value="0" {{ old('avenant') == 0 ? 'selected' : '' }}>Non</option>
                        <option value="1" {{ old('avenant') == 1 ? 'selected' : '' }}>Oui</option>
                    </select>
                    @error('avenant')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Objet Avenant -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="objet_avenant">Objet Avenant</label>
                    <input type="text" class="form-control @error('objet_avenant') is-invalid @enderror" id="objet_avenant" name="objet_avenant" value="{{ old('objet_avenant') }}">
                    @error('objet_avenant')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Attachement Contrat -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="attachement_contrat">Attachement Contrat</label>
                    <input type="file" class="form-control @error('attachement_contrat') is-invalid @enderror" id="attachement_contrat" name="attachement_contrat">
                    @error('attachement_contrat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Attachement Avenant -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="attachement_avenant">Attachement Avenant</label>
                    <input type="file" class="form-control @error('attachement_avenant') is-invalid @enderror" id="attachement_avenant" name="attachement_avenant">
                    @error('attachement_avenant')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bouton Soumettre -->
        <button type="submit" class="btn btn-success">Créer le Contrat</button>
    </form>
</div>
@endsection
