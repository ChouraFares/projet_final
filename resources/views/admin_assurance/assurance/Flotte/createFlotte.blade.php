@extends('layouts.app')

@section('title', 'Créer un Contrat Flotte')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Créer un Nouveau Contrat Flotte</h2>

    <!-- Formulaire de création -->
    <form action="{{ route('admin.assurance.flotte.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <!-- Compagnie d'Assurance -->
                <div class="form-group">
                    <label for="compagnie_assurance">Compagnie d'Assurance</label>
                    <input type="text" name="compagnie_assurance" id="compagnie_assurance" class="form-control" value="{{ old('compagnie_assurance') }}" required>
                    @error('compagnie_assurance')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Référence Contrat -->
                <div class="form-group">
                    <label for="ref_contrat">Référence Contrat</label>
                    <input type="text" name="ref_contrat" id="ref_contrat" class="form-control" value="{{ old('ref_contrat') }}" required>
                    @error('ref_contrat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date d'Effet -->
                <div class="form-group">
                    <label for="date_effet">Date d'Effet</label>
                    <input type="date" name="date_effet" id="date_effet" class="form-control" value="{{ old('date_effet') }}" required>
                    @error('date_effet')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Echéance -->
                <div class="form-group">
                    <label for="echeance">Echéance</label>
                    <input type="date" name="echeance" id="echeance" class="form-control" value="{{ old('echeance') }}" required>
                    @error('echeance')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <!-- Condition de Renouvellement -->
                <div class="form-group">
                    <label for="condition_renouvellement">Condition de Renouvellement</label>
                    <input type="text" name="condition_renouvellement" id="condition_renouvellement" class="form-control" value="{{ old('condition_renouvellement') }}" required>
                    @error('condition_renouvellement')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Avenant -->
                <div class="form-group">
                    <label for="avenant">Avenant</label>
                    <select class="form-control @error('avenant') is-invalid @enderror" id="avenant" name="avenant" required>
                        <option value="1" {{ old('avenant', false) == true ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ old('avenant', false) == false ? 'selected' : '' }}>Non</option>
                    </select>
                    @error('avenant')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="objet_avenant">Objet Avenant</label>
                    <input type="text" name="objet_avenant" id="objet_avenant" class="form-control" value="{{ old('objet_avenant') }}" required>
                    @error('condition_renouvellement')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Attachement Contrat -->
                <div class="form-group">
                    <label for="attachement_contrat">Attachement Contrat</label>
                    <input type="file" name="attachement_contrat" id="attachement_contrat" class="form-control" accept="application/pdf,image/*">
                    @error('attachement_contrat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Attachement Avenant -->
                <div class="form-group">
                    <label for="attachement_avenant">Attachement Avenant</label>
                    <input type="file" name="attachement_avenant" id="attachement_avenant" class="form-control" accept="application/pdf,image/*">
                    @error('attachement_avenant')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bouton de soumission -->
        <div class="text-center">
            <button type="submit" class="btn btn-success mt-3">Sauvegarder</button>
        </div>
    </form>
</div>
@endsection
