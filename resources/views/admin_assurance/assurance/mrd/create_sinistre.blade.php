@extends('layouts.app')

@section('title', 'Déclarer un Sinistre')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-exclamation-triangle me-2"></i>Déclarer un Sinistre</h2>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.mrd.sinistres.store') }}" method="POST" id="sinistreForm">
            @csrf

            <div class="row">
                <!-- Première carte : Informations Générales -->
                <div class="card">
                    <h4>Informations Générales</h4>

                    <!-- Assureur -->
                    <div class="form-group">
                        <label for="compagnie_assurance">Compagnie Assurance</label>
                        <input type="text" id="compagnie_assurance" name="compagnie_assurance" 
                               class="form-control @error('compagnie_assurance') is-invalid @enderror" 
                               value="{{ old('compagnie_assurance') }}">
                        @error('compagnie_assurance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fournisseur -->
                    <div class="form-group">
                        <label for="fournisseur">Fournisseur</label>
                        <input type="text" id="fournisseur" name="fournisseur" 
                               class="form-control @error('fournisseur') is-invalid @enderror" 
                               value="{{ old('fournisseur') }}">
                        @error('fournisseur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nature du Sinistre -->
                    <div class="form-group">
                        <label for="nature_sinistre">Nature du Sinistre</label>
                        <input type="text" id="nature_sinistre" name="nature_sinistre" 
                               class="form-control @error('nature_sinistre') is-invalid @enderror" 
                               value="{{ old('nature_sinistre') }}">
                        @error('nature_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lieu du Sinistre -->
                    <div class="form-group">
                        <label for="lieu_sinistre">Lieu du Sinistre</label>
                        <input type="text" id="lieu_sinistre" name="lieu_sinistre" 
                               class="form-control @error('lieu_sinistre') is-invalid @enderror" 
                               value="{{ old('lieu_sinistre') }}">
                        @error('lieu_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date du Sinistre -->
                    <div class="form-group">
                        <label for="date_sinistre">Date du Sinistre</label>
                        <input type="date" id="date_sinistre" name="date_sinistre" 
                               class="form-control @error('date_sinistre') is-invalid @enderror" 
                               value="{{ old('date_sinistre') }}">
                        @error('date_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Responsable -->
                    <div class="form-group">
                        <label for="responsable">Responsable</label>
                        <input type="text" id="responsable" name="responsable" 
                               class="form-control @error('responsable') is-invalid @enderror" 
                               value="{{ old('responsable') }}">
                        @error('responsable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut" 
                                class="department-select @error('statut') is-invalid @enderror">
                            <option value="" selected disabled>Sélectionner un statut</option>
                            <option value="Avant Constat" {{ old('statut') == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                            <option value="Constat Déposé" {{ old('statut') == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                            <option value="Expert" {{ old('statut') == 'Expert' ? 'selected' : '' }}>Expert</option>
                            <option value="En Attente De Remboursement" {{ old('statut') == 'En Attente De Remboursement' ? 'selected' : '' }}>En Attente De Remboursement</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième carte : Détails du Sinistre -->
                <div class="card">
                    <h4>Détails du Sinistre</h4>

                    <!-- Dégâts -->
                    <div class="form-group">
                        <label for="degats">Dégâts</label>
                        <textarea id="degats" name="degats" 
                                  class="form-control @error('degats') is-invalid @enderror" 
                                  rows="4">{{ old('degats') }}</textarea>
                        @error('degats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Charge -->
                    <div class="form-group">
                        <label for="charge">Charge </label>
                        <input type="text" id="charge" name="charge" 
                               class="form-control @error('charge') is-invalid @enderror" 
                               value="{{ old('charge') }}">
                        @error('charge')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Perte -->
                    <div class="form-group">
                        <label for="perte">Perte </label>
                        <input type="number" id="perte" name="perte" 
                               class="form-control @error('perte') is-invalid @enderror" 
                               value="{{ old('perte') }}">
                        @error('perte')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estimation de Remboursement -->
                    <div class="form-group">
                        <label for="estimation_de_remboursement">Estimation de Remboursement (€)</label>
                        <input type="number" step="0.01" id="estimation_de_remboursement" name="estimation_de_remboursement" 
                               class="form-control @error('estimation_de_remboursement') is-invalid @enderror" 
                               value="{{ old('estimation_de_remboursement') }}">
                        @error('estimation_de_remboursement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nature de Sinistre -->
                    <div class="form-group">
                        <label for="nature_de_sinistre">Nature de Sinistre</label>
                        <select id="nature_de_sinistre" name="nature_de_sinistre" 
                                class="department-select @error('nature_de_sinistre') is-invalid @enderror">
                            <option value="" selected disabled>Sélectionner une nature</option>
                            <option value="Incendie" {{ old('nature_de_sinistre') == 'Incendie' ? 'selected' : '' }}>Incendie</option>
                            <option value="Vol" {{ old('nature_de_sinistre') == 'Vol' ? 'selected' : '' }}>Vol</option>
                            <option value="Accident" {{ old('nature_de_sinistre') == 'Accident' ? 'selected' : '' }}>Accident</option>
                            <option value="Catastrophe naturelle" {{ old('nature_de_sinistre') == 'Catastrophe naturelle' ? 'selected' : '' }}>Catastrophe naturelle</option>
                        </select>
                        @error('nature_de_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commentaires -->
                    <div class="form-group">
                        <label for="commentaires">Commentaires</label>
                        <textarea id="commentaires" name="commentaires" 
                                  class="form-control @error('commentaires') is-invalid @enderror" 
                                  rows="4">{{ old('commentaires') }}</textarea>
                        @error('commentaires')
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
                    <i class="fas fa-save me-2"></i>Soumettre
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    

    // Réinitialiser la validation lorsqu'on modifie un champ
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush
@endsection