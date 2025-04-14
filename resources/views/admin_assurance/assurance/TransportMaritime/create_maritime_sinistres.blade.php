@extends('layouts.app')

@section('title', 'Créer un Sinistre Transport Maritime')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-ship me-2"></i>Créer un Sinistre Transport Maritime</h2>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('store_maritime_sinistres') }}" method="POST" id="maritimeSinistreForm">
            @csrf

            <div class="row">
                <!-- Première carte : Informations Générales -->
                <div class="card">
                    <h4>Informations Générales</h4>

                    <div class="form-group">
                        <label for="assureur">Compagnie Assurance</label>
                        <input type="text" name="assureur" id="assureur" 
                               class="form-control @error('assureur') is-invalid @enderror"
                               value="{{ old('assureur') }}">
                        @error('assureur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prime">Prime (TND)</label>
                        <input type="text" name="prime" id="prime" 
                               class="form-control @error('prime') is-invalid @enderror"
                               value="{{ old('prime') }}" oninput="formatNumber(this)">
                        @error('prime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fournisseur">Fournisseur</label>
                        <input type="text" name="fournisseur" id="fournisseur" 
                               class="form-control @error('fournisseur') is-invalid @enderror"
                               value="{{ old('fournisseur') }}">
                        @error('fournisseur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="num_facture">Numéro de Facture</label>
                        <input type="text" name="num_facture" id="num_facture" 
                               class="form-control @error('num_facture') is-invalid @enderror"
                               value="{{ old('num_facture') }}">
                        @error('num_facture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="montant_facture_usd">Montant Facture (USD)</label>
                        <input type="number" step="0.01" name="montant_facture_usd" id="montant_facture_usd" 
                               class="form-control @error('montant_facture_usd') is-invalid @enderror"
                               value="{{ old('montant_facture_usd') }}">
                        @error('montant_facture_usd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="montant_facture_tnd">Montant Facture (TND)</label>
                        <input type="number" step="0.01" name="montant_facture_tnd" id="montant_facture_tnd" 
                               class="form-control @error('montant_facture_tnd') is-invalid @enderror"
                               value="{{ old('montant_facture_tnd') }}">
                        @error('montant_facture_tnd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nature_de_sinistre">Nature De Sinistre</label>
                        <input type="text" name="nature_de_sinistre" id="nature_de_sinistre"
                               class="form-control @error('nature_de_sinistre') is-invalid @enderror"
                               value="{{ old('nature_de_sinistre') }}">
                        @error('nature_de_sinistre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="statut_du_dossier">Statut</label>
                        <select name="statut_du_dossier" id="statut_du_dossier" 
                                class="department-select @error('statut_du_dossier') is-invalid @enderror">
                            <option value="" disabled selected>Choisissez un statut</option>
                            <option value="Avant Constat" {{ old('statut_du_dossier') == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                            <option value="Constat Déposé" {{ old('statut_du_dossier') == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                            <option value="Expert" {{ old('statut_du_dossier') == 'Expert' ? 'selected' : '' }}>Expert</option>
                            <option value="En Attente Du Remboursement" {{ old('statut_du_dossier') == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
                        </select>
                        @error('statut_du_dossier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième carte : Détails du Sinistre -->
                <div class="card">
                    <h4>Détails du Sinistre</h4>

                    <div class="form-group">
                        <label for="num_conteneur">Numéro de Conteneur</label>
                        <input type="text" name="num_conteneur" id="num_conteneur" 
                               class="form-control @error('num_conteneur') is-invalid @enderror"
                               value="{{ old('num_conteneur') }}">
                        @error('num_conteneur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_depot">Date Dépôt</label>
                        <input type="date" name="date_depot" id="date_depot" 
                               class="form-control @error('date_depot') is-invalid @enderror"
                               value="{{ old('date_depot') }}">
                        @error('date_depot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="transporteur_maritime">Transporteur Maritime</label>
                        <input type="text" name="transporteur_maritime" id="transporteur_maritime" 
                               class="form-control @error('transporteur_maritime') is-invalid @enderror"
                               value="{{ old('transporteur_maritime') }}">
                        @error('transporteur_maritime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_incident">Date Incident</label>
                        <input type="date" name="date_incident" id="date_incident" 
                               class="form-control @error('date_incident') is-invalid @enderror"
                               value="{{ old('date_incident') }}">
                        @error('date_incident')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lieu">Lieu</label>
                        <input type="text" name="lieu" id="lieu" 
                               class="form-control @error('lieu') is-invalid @enderror"
                               value="{{ old('lieu') }}">
                        @error('lieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mt">Montant Assuré</label>
                        <input type="text" name="mt" id="mt" 
                               class="form-control @error('mt') is-invalid @enderror"
                               value="{{ old('mt') }}">
                        @error('mt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_prev_remboursement">Date Prévue de Remboursement</label>
                        <input type="date" name="date_prev_remboursement" id="date_prev_remboursement" 
                               class="form-control @error('date_prev_remboursement') is-invalid @enderror"
                               value="{{ old('date_prev_remboursement') }}">
                        @error('date_prev_remboursement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea name="commentaire" id="commentaire" 
                                  class="form-control @error('commentaire') is-invalid @enderror" 
                                  rows="4">{{ old('commentaire') }}</textarea>
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
                    <i class="fas fa-save me-2"></i>Enregistrer
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


    // Réinitialiser la validation lorsqu'on modifie un champ
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endpush
@endsection