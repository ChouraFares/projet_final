@extends('layouts.app')

@section('title', 'Modifier un Sinistre Transport Maritime')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-ship me-2"></i>Modifier un Sinistre Transport Maritime</h2>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('update_maritime_sinistres', $sinistre->id) }}" method="POST" id="editMaritimeSinistreForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Première colonne -->
                <div class="card">
                    <h4>Informations Générales</h4>

                    <!-- Compagnie Assurance -->
                    <div class="form-group">
                        <label for="assureur">Compagnie Assurance</label>
                        <input type="text" name="assureur" id="assureur" 
                               class="form-control @error('assureur') is-invalid @enderror" 
                               value="{{ old('assureur', $sinistre->assureur) }}" 
                               required>
                        @error('assureur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prime -->
                    <div class="form-group">
                        <label for="prime">Prime (TND)</label>
                        <input type="text" name="prime" id="prime" 
                               class="form-control @error('prime') is-invalid @enderror" 
                               value="{{ old('prime', $sinistre->prime) }}" 
                               required
                               oninput="formatNumber(this)">
                        @error('prime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fournisseur -->
                    <div class="form-group">
                        <label for="fournisseur">Fournisseur</label>
                        <input type="text" name="fournisseur" id="fournisseur" 
                               class="form-control @error('fournisseur') is-invalid @enderror" 
                               value="{{ old('fournisseur', $sinistre->fournisseur) }}" 
                               required>
                        @error('fournisseur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Numéro de Facture -->
                    <div class="form-group">
                        <label for="num_facture">Numéro de Facture</label>
                        <input type="text" name="num_facture" id="num_facture" 
                               class="form-control @error('num_facture') is-invalid @enderror" 
                               value="{{ old('num_facture', $sinistre->num_facture) }}" 
                               required>
                        @error('num_facture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Montant Facture USD -->
                    <div class="form-group">
                        <label for="montant_facture_usd">Montant Facture (USD)</label>
                        <input type="number" step="0.01" name="montant_facture_usd" id="montant_facture_usd" 
                               class="form-control @error('montant_facture_usd') is-invalid @enderror" 
                               value="{{ old('montant_facture_usd', $sinistre->montant_facture_usd) }}" 
                               required>
                        @error('montant_facture_usd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Montant Facture TND -->
                    <div class="form-group">
                        <label for="montant_facture_tnd">Montant Facture (TND)</label>
                        <input type="number" step="0.01" name="montant_facture_tnd" id="montant_facture_tnd" 
                               class="form-control @error('montant_facture_tnd') is-invalid @enderror" 
                               value="{{ old('montant_facture_tnd', $sinistre->montant_facture_tnd) }}" 
                               required>
                        @error('montant_facture_tnd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nature de Sinistre -->
                    <div class="form-group">
                        <label for="nature_de_sinistre">Nature de Sinistre</label>
                        <input type="text" name="nature_de_sinistre" id="nature_de_sinistre"
                               class="form-control @error('nature_de_sinistre') is-invalid @enderror"
                               value="{{ old('nature_de_sinistre', $sinistre->nature_de_sinistre) }}" 
                               required>
                        @error('nature_de_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut du Dossier -->
                    <div class="form-group">
                        <label for="statut_du_dossier">Statut</label>
                        <select name="statut_du_dossier" id="statut_du_dossier" 
                                class="department-select @error('statut_du_dossier') is-invalid @enderror" 
                                required>
                            <option value="Avant Constat" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                            <option value="Constat Déposé" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                            <option value="Expert" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'Expert' ? 'selected' : '' }}>Expert</option>
                            <option value="En Attente Du Remboursement" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
                        </select>
                        @error('statut_du_dossier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième colonne -->
                <div class="card">
                    <h4>Détails du Sinistre</h4>

                    <!-- Numéro de Conteneur -->
                    <div class="form-group">
                        <label for="num_conteneur">Numéro de Conteneur</label>
                        <input type="text" name="num_conteneur" id="num_conteneur" 
                               class="form-control @error('num_conteneur') is-invalid @enderror" 
                               value="{{ old('num_conteneur', $sinistre->num_conteneur) }}" 
                               required>
                        @error('num_conteneur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date de Dépôt -->
                    <div class="form-group">
                        <label for="date_depot">Date de Dépôt</label>
                        <input type="date" name="date_depot" id="date_depot" 
                               class="form-control @error('date_depot') is-invalid @enderror" 
                               value="{{ old('date_depot', $sinistre->date_depot) }}" 
                               required>
                        @error('date_depot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Transporteur Maritime -->
                    <div class="form-group">
                        <label for="transporteur_maritime">Transporteur Maritime</label>
                        <input type="text" name="transporteur_maritime" id="transporteur_maritime" 
                               class="form-control @error('transporteur_maritime') is-invalid @enderror" 
                               value="{{ old('transporteur_maritime', $sinistre->transporteur_maritime) }}" 
                               required>
                        @error('transporteur_maritime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date d'Incident -->
                    <div class="form-group">
                        <label for="date_incident">Date d'Incident</label>
                        <input type="date" name="date_incident" id="date_incident" 
                               class="form-control @error('date_incident') is-invalid @enderror" 
                               value="{{ old('date_incident', $sinistre->date_incident) }}" 
                               required>
                        @error('date_incident')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lieu -->
                    <div class="form-group">
                        <label for="lieu">Lieu</label>
                        <input type="text" name="lieu" id="lieu" 
                               class="form-control @error('lieu') is-invalid @enderror" 
                               value="{{ old('lieu', $sinistre->lieu) }}" 
                               required>
                        @error('lieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Montant de Dégât -->
                    <div class="form-group">
                        <label for="mt">Montant Assuré</label>
                        <input 
                        type="number" 
                        step="0.01" 
                        name="mt" 
                        id="mt"
                        class="form-control @error('mt') is-invalid @enderror"
                        value="{{ str_replace(',', '.', old('mt', $sinistre->mt)) }}"
                        required
                    >


                    
                    </div>

                    <!-- Date Prévue de Remboursement -->
                    <div class="form-group">
                        <label for="date_prev_remboursement">Date Prévue de Remboursement</label>
                        <input type="date" name="date_prev_remboursement" id="date_prev_remboursement" 
                               class="form-control @error('date_prev_remboursement') is-invalid @enderror" 
                               value="{{ old('date_prev_remboursement', $sinistre->date_prev_remboursement) }}" 
                               required>
                        @error('date_prev_remboursement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Commentaire -->
                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea name="commentaire" id="commentaire" 
                                  class="form-control @error('commentaire') is-invalid @enderror" 
                                  rows="4">{{ old('commentaire', $sinistre->commentaire) }}</textarea>
                        @error('commentaire')
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
    function formatNumber(input) {
        let value = input.value.replace(/[^0-9,.]/g, '');
        value = value.replace(/,/g, '.');
        let parts = value.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        input.value = parts.join('.');
    }

    // Validation côté client
    document.getElementById('editMaritimeSinistreForm').addEventListener('submit', function(e) {
        const requiredFields = ['assureur', 'prime', 'fournisseur', 'num_facture', 'nature_de_sinistre', 'statut_du_dossier', 'num_conteneur', 'date_depot', 'transporteur_maritime', 'date_incident', 'lieu', 'mt', 'date_prev_remboursement'];
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