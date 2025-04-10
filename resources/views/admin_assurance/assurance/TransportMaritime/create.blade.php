@extends('layouts.app')

@section('title', 'Ajouter un Contrat Transport Maritime')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-ship me-2"></i>Ajouter un Contrat Transport Maritime</h2>
        </div>
    </div>
    <div class="form-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data" id="transportMaritimeForm">
            @csrf
            <div class="row">
                <!-- Première colonne -->
                <div class="card">
                    <!-- Compagnie d'Assurance -->
                    <div class="form-group">
                        <label for="compagnie_assurance" class="form-label">Compagnie d'Assurance</label>
                        <input type="text" class="form-control @error('compagnie_assurance') is-invalid @enderror"
                               id="compagnie_assurance" name="compagnie_assurance" value="{{ old('compagnie_assurance') }}" required>
                        @error('compagnie_assurance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Référence du Contrat -->
                    <div class="form-group">
                        <label for="ref_contrat" class="form-label">Référence Contrat</label>
                        <input type="text" class="form-control @error('ref_contrat') is-invalid @enderror"
                               id="ref_contrat" name="ref_contrat" value="{{ old('ref_contrat') }}" required>
                        @error('ref_contrat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Date d'Effet -->
                    <div class="form-group">
                        <label for="date_effet" class="form-label">Date d'Effet</label>
                        <input type="date" class="form-control @error('date_effet') is-invalid @enderror"
                               id="date_effet" name="date_effet" value="{{ old('date_effet') }}" required>
                        @error('date_effet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Échéance -->
                    <div class="form-group">
                        <label for="echeance" class="form-label">Échéance</label>
                        <input type="date" class="form-control @error('echeance') is-invalid @enderror"
                               id="echeance" name="echeance" value="{{ old('echeance') }}" required>
                        @error('echeance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième colonne -->
                <div class="card">
                    <!-- Condition Renouvellement -->
                    <div class="form-group">
                        <label for="condition_renouvellement" class="form-label">Condition Renouvellement</label>
                        <input type="text" class="form-control @error('condition_renouvellement') is-invalid @enderror"
                               id="condition_renouvellement" name="condition_renouvellement" value="{{ old('condition_renouvellement') }}">
                        @error('condition_renouvellement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Avenant (Select Oui/Non) -->
                    <div class="form-group">
                        <label for="avenant" class="form-label">Avenant</label>
                        <select class="form-control @error('avenant') is-invalid @enderror" id="avenant" name="avenant">
                            <option value="0" {{ old('avenant') == 0 ? 'selected' : '' }}>Non</option>
                            <option value="1" {{ old('avenant') == 1 ? 'selected' : '' }}>Oui</option>
                        </select>
                        @error('avenant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Objet Avenant -->
                    <div class="form-group">
                        <label for="objet_avenant" class="form-label">Objet Avenant</label>
                        <input type="text" class="form-control @error('objet_avenant') is-invalid @enderror"
                               id="objet_avenant" name="objet_avenant" value="{{ old('objet_avenant') }}">
                        @error('objet_avenant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Troisième colonne -->
                <div class="card">
                    <!-- Attachement Contrat -->
                    <div class="form-group">
                        <label for="attachement_contrat" class="form-label">Attachement Contrat</label>
                        <input type="file" class="form-control-file @error('attachement_contrat') is-invalid @enderror"
                               id="attachement_contrat" name="attachement_contrat">
                        @error('attachement_contrat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Attachement Avenant -->
                    <div class="form-group">
                        <label for="attachement_avenant" class="form-label">Attachement Avenant</label>
                        <input type="file" class="form-control-file @error('attachement_avenant') is-invalid @enderror"
                               id="attachement_avenant" name="attachement_avenant">
                        @error('attachement_avenant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="btn-group" style="margin-top: 30px; justify-content: center;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Créer le Contrat
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    // Validation côté client
    document.getElementById('transportMaritimeForm').addEventListener('submit', function(e) {
        const requiredFields = ['compagnie_assurance', 'ref_contrat', 'date_effet', 'echeance'];
        let isValid = true;
        requiredFields.forEach(field => {
            const element = document.getElementById(field);
            if (!element.value.trim()) {
                element.classList.add('is-invalid');
                isValid = false;
            }
        });
        if (!isValid) {
            e.preventDefault();
            alert("Veuillez remplir tous les champs obligatoires");
        }
    });

    // Réinitialiser la validation lorsqu'on modifie un champ
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush
@endsection