@extends('layouts.app')

@section('title', 'Modifier un Sinistre Flotte')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-car-crash me-2"></i>Modifier le Sinistre #{{ $sinistre->sinistre_num }}</h2>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.assurance.flotte.sinistres.update', $sinistre->id) }}" method="POST" enctype="multipart/form-data" id="editSinistreForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Première colonne -->
                <div class="card">
                    <!-- Compagnie d'Assurance -->
                    <div class="form-group">
                        <label for="compagnie_assurance">Compagnie d'Assurance</label>
                        <input type="text" name="compagnie_assurance" 
                               class="form-control @error('compagnie_assurance') is-invalid @enderror" 
                               value="{{ old('compagnie_assurance', $sinistre->compagnie_assurance) }}" 
                               required>
                        @error('compagnie_assurance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Numéro Sinistre -->
                    <div class="form-group">
                        <label for="sinistre_num">Numéro Sinistre</label>
                        <input type="text" name="sinistre_num" 
                               class="form-control" 
                               value="{{ old('sinistre_num', $sinistre->sinistre_num) }}" 
                               readonly>
                    </div>

                    <!-- Immatriculation -->
                    <div class="form-group">
                        <label for="immatriculation">Immatriculation</label>
                        <input type="text" name="immatriculation" 
                               class="form-control @error('immatriculation') is-invalid @enderror" 
                               value="{{ old('immatriculation', $sinistre->immatriculation) }}" 
                               required>
                        @error('immatriculation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Véhicule -->
                    <div class="form-group">
                        <label for="vehicule">Véhicule</label>
                        <input type="text" name="vehicule" 
                               class="form-control @error('vehicule') is-invalid @enderror" 
                               value="{{ old('vehicule', $sinistre->vehicule) }}" 
                               required>
                        @error('vehicule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième colonne -->
                <div class="card">
                    <!-- Chauffeur -->
                    <div class="form-group">
                        <label for="chauffeur">Chauffeur</label>
                        <input type="text" name="chauffeur" 
                               class="form-control @error('chauffeur') is-invalid @enderror" 
                               value="{{ old('chauffeur', $sinistre->chauffeur) }}" 
                               required>
                        @error('chauffeur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fautif -->
                    <div class="form-group">
                        <label for="fautif">Fautif</label>
                        <select name="fautif" 
                                class="department-select @error('fautif') is-invalid @enderror" 
                                required>
                            <option value="Oui" {{ old('fautif', $sinistre->fautif) == 'Oui' ? 'selected' : '' }}>Oui</option>
                            <option value="Non" {{ old('fautif', $sinistre->fautif) == 'Non' ? 'selected' : '' }}>Non</option>
                        </select>
                        @error('fautif')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date du Sinistre -->
                    <div class="form-group">
                        <label for="date_sinistre">Date du Sinistre</label>
                        <input type="date" name="date_sinistre" 
                               class="form-control @error('date_sinistre') is-invalid @enderror" 
                               value="{{ old('date_sinistre', $sinistre->date_sinistre ? $sinistre->date_sinistre->format('Y-m-d') : '') }}" 
                               required>
                        @error('date_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nature du Sinistre -->
                    <div class="form-group">
                        <label for="nature_sinistre">Nature du Sinistre</label>
                        <select name="nature_sinistre" 
                                class="department-select @error('nature_sinistre') is-invalid @enderror" 
                                required>
                            <option value="">-- Sélectionnez une nature de sinistre --</option>
                            <option value="Connexe" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Connexe' ? 'selected' : '' }}>Connexe</option>
                            <option value="Recours" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Recours' ? 'selected' : '' }}>Recours</option>
                            <option value="Incendie" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Incendie' ? 'selected' : '' }}>Incendie</option>
                            <option value="Dommage Collision" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Dommage Collision' ? 'selected' : '' }}>Dommage Collision</option>
                            <option value="Bris de Glace" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Bris de Glace' ? 'selected' : '' }}>Bris de Glace</option>
                        </select>
                        @error('nature_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Troisième colonne -->
                <div class="card">
                    <!-- Avancements -->
                    <div class="form-group">
                        <label for="avancements">Avancements</label>
                        <select name="avancements" 
                                class="department-select @error('avancements') is-invalid @enderror" 
                                required>
                            <option value="">Sélectionnez une option</option>
                            <option value="Avant Constat" {{ old('avancements', $sinistre->avancements) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                            <option value="Constat Déposé" {{ old('avancements', $sinistre->avancements) == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                            <option value="Expert" {{ old('avancements', $sinistre->avancements) == 'Expert' ? 'selected' : '' }}>Expert</option>
                            <option value="En Attente Du Remboursement" {{ old('avancements', $sinistre->avancements) == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
                        </select>
                        @error('avancements')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date Clôture Dossier -->
                    <div class="form-group">
                        <label for="date_cloture_dossier">Date Clôture Dossier</label>
                        <input type="date" name="date_cloture_dossier" 
                               class="form-control @error('date_cloture_dossier') is-invalid @enderror" 
                               value="{{ old('date_cloture_dossier', $sinistre->date_cloture_dossier ? $sinistre->date_cloture_dossier->format('Y-m-d') : '') }}">
                        @error('date_cloture_dossier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Règlement -->
                    <div class="form-group">
                        <label for="reglement">Règlement</label>
                        <input type="text" name="reglement" 
                               class="form-control @error('reglement') is-invalid @enderror" 
                               value="{{ old('reglement', $sinistre->reglement) }}" 
                               required>
                        @error('reglement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Expert -->
                    <div class="form-group">
                        <label for="Expert">Expert</label>
                        <input type="text" name="Expert" 
                               class="form-control @error('Expert') is-invalid @enderror" 
                               value="{{ old('Expert', $sinistre->Expert) }}" 
                               required>
                        @error('Expert')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="reglement_reçu">Réglement Reçu </label>
                        <input type="text" name="reglement_reçu" 
                               class="form-control @error('reglement_reçu') is-invalid @enderror" 
                               value="{{ old('reglement_reçu', $sinistre->reglement_reçu) }}" 
                               required>
                        @error('Expert')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Quatrième colonne -->
                <div class="card">
                    <!-- Fichier PDF -->
                    <div class="form-group">
                        <label for="attachments_pdf">Fichier PDF Attaché</label>
                        <input type="file" name="attachments_pdf" 
                               class="form-control @error('attachments_pdf') is-invalid @enderror" 
                               accept=".pdf">
                        @if($sinistre->attachments_pdf)
                            <small class="d-block mt-2">
                                Fichier actuel : 
                                <a href="{{ Storage::url($sinistre->attachments_pdf) }}" 
                                   target="_blank" 
                                   class="text-primary">
                                    <i class="fas fa-file-pdf me-1"></i>Voir PDF
                                </a>
                            </small>
                        @endif
                        @error('attachments_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select name="statut" 
                                class="department-select @error('statut') is-invalid @enderror">
                            <option value="En Cours" {{ old('statut', $sinistre->statut) == 'En Cours' ? 'selected' : '' }}>En Cours</option>
                            <option value="Clôturé" {{ old('statut', $sinistre->statut) == 'Clôturé' ? 'selected' : '' }}>Clôturé</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commentaire -->
                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea name="commentaire" 
                                  class="form-control @error('commentaire') is-invalid @enderror" 
                                  rows="4">{{ old('commentaire', $sinistre->commentaire) }}</textarea>
                        @error('commentaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Validation côté client
    document.getElementById('editSinistreForm').addEventListener('submit', function(e) {
        const requiredFields = ['compagnie_assurance', 'immatriculation', 'vehicule', 'chauffeur', 'fautif', 'date_sinistre', 'nature_sinistre', 'avancements', 'reglement', 'Expert'];
        let isValid = true;

        requiredFields.forEach(field => {
            const element = document.querySelector(`[name="${field}"]`);
            if (element && !element.value.trim()) {
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