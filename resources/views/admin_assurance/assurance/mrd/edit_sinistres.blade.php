@extends('layouts.app')

@section('title', 'Modifier un Sinistre')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-edit me-2"></i>Modifier un Sinistre</h2>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.mrd.sinistres.update', $sinistre->id) }}" method="POST" id="sinistreForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Colonne de gauche -->
                <div class="card">
                    <!-- Compagnie Assurance -->
                    <div class="form-group">
                        <label for="compagnie_assurance">Compagnie Assurance</label>
                        <input type="text" id="compagnie_assurance" name="compagnie_assurance" 
                               class="form-control @error('compagnie_assurance') is-invalid @enderror" 
                               value="{{ old('compagnie_assurance', $sinistre->compagnie_assurance) }}">
                        @error('compagnie_assurance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nature du Sinistre -->
                    <div class="form-group">
                        <label for="nature_sinistre">Nature du Sinistre</label>
                        <input type="text" id="nature_sinistre" name="nature_sinistre" 
                               class="form-control @error('nature_sinistre') is-invalid @enderror" 
                               value="{{ old('nature_sinistre', $sinistre->nature_sinistre) }}">
                        @error('nature_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lieu du Sinistre -->
                    <div class="form-group">
                        <label for="lieu_sinistre">Lieu du Sinistre</label>
                        <input type="text" id="lieu_sinistre" name="lieu_sinistre" 
                               class="form-control @error('lieu_sinistre') is-invalid @enderror" 
                               value="{{ old('lieu_sinistre', $sinistre->lieu_sinistre) }}">
                        @error('lieu_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date du Sinistre -->
                    <div class="form-group">
                        <label for="date_sinistre">Date du Sinistre</label>
                        <input type="date" id="date_sinistre" name="date_sinistre" 
                               class="form-control @error('date_sinistre') is-invalid @enderror" 
                               value="{{ old('date_sinistre', $sinistre->date_sinistre) }}">
                        @error('date_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Colonne centrale -->
                <div class="card">
                    <!-- Degâts -->
                    <div class="form-group">
                        <label for="degats">Dégâts</label>
                        <textarea id="degats" name="degats" 
                                  class="form-control @error('degats') is-invalid @enderror" 
                                  rows="3" >{{ old('degats', $sinistre->degats) }}</textarea>
                        @error('degats')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Charge -->
                    <div class="form-group">
                        <label for="charge">Charge </label>
                        <input type="number" id="charge" name="charge" 
                               class="form-control @error('charge') is-invalid @enderror" 
                               value="{{ old('charge', $sinistre->charge) }}">
                        @error('charge')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Perte -->
                    <div class="form-group">
                        <label for="perte">Perte</label>
                        <input type="number" id="perte" name="perte" 
                               class="form-control @error('perte') is-invalid @enderror" 
                               value="{{ old('perte', $sinistre->perte) }}">
                        @error('perte')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Colonne de droite -->
                <div class="card">
                    <!-- Responsable -->
                    <div class="form-group">
                        <label for="responsable">Responsable</label>
                        <input type="text" id="responsable" name="responsable" 
                               class="form-control @error('responsable') is-invalid @enderror" 
                               value="{{ old('responsable', $sinistre->responsable) }}">
                        @error('responsable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commentaires -->
                    <div class="form-group">
                        <label for="commentaires">Commentaires</label>
                        <textarea id="commentaires" name="commentaires" 
                                  class="form-control @error('commentaires') is-invalid @enderror" 
                                  rows="3">{{ old('commentaires', $sinistre->commentaires) }}</textarea>
                        @error('commentaires')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut" 
                                class="department-select @error('statut') is-invalid @enderror" >
                            <option value="Avant Constat" {{ old('statut', $sinistre->statut) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                            <option value="Constat Deposé" {{ old('statut', $sinistre->statut) == 'Constat Deposé' ? 'selected' : '' }}>Constat Déposé</option>
                            <option value="Expert" {{ old('statut', $sinistre->statut) == 'Expert' ? 'selected' : '' }}>Expert</option>
                            <option value="En attente du remboursement" {{ old('statut', $sinistre->statut) == 'En attente du remboursement' ? 'selected' : '' }}>En attente du remboursement</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Boutons d'action -->
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="btn-group">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </div>
                </div>
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