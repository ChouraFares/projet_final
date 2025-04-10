@extends('layouts.app')

@section('title', 'Modifier un Contrat MRD')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-tools me-2"></i>Modifier un Contrat MRD</h2>
        </div>
    </div>

    <div class="form-container">
        <!-- Affichage des messages de succès ou d'erreur -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.mrd.contrats.update', $contrat->id) }}" method="POST" enctype="multipart/form-data" id="editMRDForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Première colonne -->
                <div class="card">
                    <div class="form-group">
                        <label for="compagnie_assurance" class="form-label">Compagnie d'Assurance</label>
                        <input type="text" class="form-control @error('compagnie_assurance') is-invalid @enderror" 
                               id="compagnie_assurance" name="compagnie_assurance" 
                               value="{{ old('compagnie_assurance', $contrat->compagnie_assurance) }}" required>
                        @error('compagnie_assurance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ref_contrat" class="form-label">Référence du Contrat</label>
                        <input type="text" class="form-control @error('ref_contrat') is-invalid @enderror" 
                               id="ref_contrat" name="ref_contrat" 
                               value="{{ old('ref_contrat', $contrat->ref_contrat) }}" required>
                        @error('ref_contrat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_effet" class="form-label">Date d'Effet</label>
                        <input type="date" class="form-control @error('date_effet') is-invalid @enderror" 
                               id="date_effet" name="date_effet" 
                               value="{{ old('date_effet', $contrat->date_effet) }}" required>
                        @error('date_effet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième colonne -->
                <div class="card">
                    <div class="form-group">
                        <label for="echeance" class="form-label">Échéance</label>
                        <input type="date" class="form-control @error('echeance') is-invalid @enderror" 
                               id="echeance" name="echeance" 
                               value="{{ old('echeance', $contrat->echeance) }}" required>
                        @error('echeance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="condition_renouvellement" class="form-label">Condition de Renouvellement</label>
                        <input type="text" class="form-control @error('condition_renouvellement') is-invalid @enderror" 
                               id="condition_renouvellement" name="condition_renouvellement" 
                               value="{{ old('condition_renouvellement', $contrat->condition_renouvellement) }}">
                        @error('condition_renouvellement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="avenant" class="form-label">Avenant</label>
                        <select class="form-control @error('avenant') is-invalid @enderror" 
                                id="avenant" name="avenant" required>
                            <option value="oui" {{ old('avenant', $contrat->avenant) == 'oui' ? 'selected' : '' }}>Oui</option>
                            <option value="non" {{ old('avenant', $contrat->avenant) == 'non' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('avenant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Troisième colonne -->
                <div class="card">
                    <div class="form-group">
                        <label for="objet_avenant" class="form-label">Objet Avenant</label>
                        <input type="text" class="form-control @error('objet_avenant') is-invalid @enderror" 
                               id="objet_avenant" name="objet_avenant" 
                               value="{{ old('objet_avenant', $contrat->objet_avenant) }}">
                        @error('objet_avenant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="attachement_contrat" class="form-label">Attachement Contrat (PDF)</label>
                        <input type="file" class="form-control @error('attachement_contrat') is-invalid @enderror" 
                               id="attachement_contrat" name="attachement_contrat" accept=".pdf">
                        @if ($contrat->attachement_contrat)
                            <a href="{{ asset('storage/' . $contrat->attachement_contrat) }}" target="_blank" class="mt-2 d-block">Voir le fichier actuel</a>
                        @endif
                        @error('attachement_contrat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="attachement_avenant" class="form-label">Attachement Avenant (PDF)</label>
                        <input type="file" class="form-control @error('attachement_avenant') is-invalid @enderror" 
                               id="attachement_avenant" name="attachement_avenant" accept=".pdf">
                        @if ($contrat->attachement_avenant)
                            <a href="{{ asset('storage/' . $contrat->attachement_avenant) }}" target="_blank" class="mt-2 d-block">Voir le fichier actuel</a>
                        @endif
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
                    <i class="fas fa-save me-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Validation côté client
    document.getElementById('editMRDForm').addEventListener('submit', function(e) {
        const requiredFields = ['compagnie_assurance', 'ref_contrat', 'date_effet', 'echeance', 'avenant'];
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
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush
@endsection