@extends('layouts.app')

@section('title', 'Ajouter un Sinistre - Bris de Machine')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-tools me-2"></i>Ajouter un Sinistre - Bris de Machine</h2>
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

        <form action="{{ route('admin.BrisDeMachines.sinistres.store') }}" method="POST" id="brisMachineForm">
            @csrf

            <div class="row">
                <!-- Première colonne -->
                <div class="card">
                    <!-- Compagnie Assurance -->
                    <div class="form-group">
                        <label for="assureur" class="form-label">Compagnie Assurance</label>
                        <input type="text" class="form-control @error('assureur') is-invalid @enderror" 
                               id="assureur" name="assureur" 
                               value="{{ old('assureur') }}" required>
                        @error('assureur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nature du Sinistre -->
                    <div class="form-group">
                        <label for="nature_sinistre" class="form-label">Nature du Sinistre</label>
                        <input type="text" class="form-control @error('nature_sinistre') is-invalid @enderror" 
                               id="nature_sinistre" name="nature_sinistre" 
                               value="{{ old('nature_sinistre') }}" required>
                        @error('nature_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lieu du Sinistre -->
                    <div class="form-group">
                        <label for="lieu_sinistre" class="form-label">Lieu du Sinistre</label>
                        <input type="text" class="form-control @error('lieu_sinistre') is-invalid @enderror" 
                               id="lieu_sinistre" name="lieu_sinistre" 
                               value="{{ old('lieu_sinistre') }}" required>
                        @error('lieu_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date du Sinistre -->
                    <div class="form-group">
                        <label for="date_sinistre" class="form-label">Date du Sinistre</label>
                        <input type="date" class="form-control @error('date_sinistre') is-invalid @enderror" 
                               id="date_sinistre" name="date_sinistre" 
                               value="{{ old('date_sinistre') }}" required>
                        @error('date_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième colonne -->
                <div class="card">
                    <!-- Dégâts -->
                    <div class="form-group">
                        <label for="degats" class="form-label">Dégâts</label>
                        <textarea class="form-control @error('degats') is-invalid @enderror" 
                                  id="degats" name="degats" 
                                  rows="4" required>{{ old('degats') }}</textarea>
                        @error('degats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Chargé -->
                    <div class="form-group">
                        <label for="charge" class="form-label">Chargé</label>
                        <input type="text" class="form-control @error('charge') is-invalid @enderror" 
                               id="charge" name="charge" 
                               value="{{ old('charge') }}" required>
                        @error('charge')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Perte -->
                    <div class="form-group">
                        <label for="perte" class="form-label">Perte (TND)</label>
                        <input type="number" step="0.01" class="form-control @error('perte') is-invalid @enderror" 
                               id="perte" name="perte" 
                               value="{{ old('perte') }}" required>
                        @error('perte')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Troisième colonne -->
                <div class="card">
                    <!-- Responsable -->
                    <div class="form-group">
                        <label for="responsable" class="form-label">Responsable</label>
                        <input type="text" class="form-control @error('responsable') is-invalid @enderror" 
                               id="responsable" name="responsable" 
                               value="{{ old('responsable') }}" required>
                        @error('responsable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label for="statu_du_dossier" class="form-label">Statut</label>
                        <select class="department-select @error('statu_du_dossier') is-invalid @enderror" 
                                id="statu_du_dossier" name="statu_du_dossier" required>
                            <option value="">Sélectionner un statut</option>
                            <option value="Avant Constat" {{ old('statu_du_dossier') == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                            <option value="Constat Déposé" {{ old('statu_du_dossier') == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                            <option value="Expert" {{ old('statu_du_dossier') == 'Expert' ? 'selected' : '' }}>Expert</option>
                            <option value="En attente du remboursement" {{ old('statu_du_dossier') == 'En attente du remboursement' ? 'selected' : '' }}>En attente du remboursement</option>
                        </select>
                        @error('statu_du_dossier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Expert -->
                    <div class="form-group">
                        <label for="expert" class="form-label">Expert</label>
                        <input type="text" class="form-control @error('expert') is-invalid @enderror" 
                               id="expert" name="expert" 
                               value="{{ old('expert') }}">
                        @error('expert')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commentaires -->
                    <div class="form-group">
                        <label for="commentaires" class="form-label">Commentaires</label>
                        <textarea class="form-control @error('commentaires') is-invalid @enderror" 
                                  id="commentaires" name="commentaires" 
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
                    <i class="fas fa-save me-2"></i>Ajouter le Sinistre
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Validation côté client
    document.getElementById('brisMachineForm').addEventListener('submit', function(e) {
        const requiredFields = ['assureur', 'nature_sinistre', 'lieu_sinistre', 'date_sinistre', 'degats', 'charge', 'perte', 'responsable', 'statu_du_dossier'];
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