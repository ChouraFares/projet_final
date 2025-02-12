@extends('layouts.app')

@section('title', 'Modifier un Sinistre Transport Maritime')

@section('content')

<style>
    .container {
        padding: 20px;
        max-width: 100%;
        margin: 0 auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
        border-radius: 4px;
    }

    .btn-warning.btn-sm {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
    }

    .card {
        margin-bottom: 20px;
    }

    .card-body {
        padding: 20px;
    }

    .row {
        display: flex;
        justify-content: space-between;
    }

    .col-md-6 {
        width: 48%;
    }
</style>

<div class="container">
    <h2>Modifier un Sinistre Transport Maritime</h2>

    <!-- Formulaire de modification de sinistre -->
    <form action="{{ route('update_maritime_sinistres', $sinistre->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Carte 1 -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Champ Assureur -->

                  

                        <div class="form-group">
                            <label for="assureur">Compagnie Assurance</label>
                            <input type="text" name="assureur" id="assureur" class="form-control @error('assureur') is-invalid @enderror" value="{{ old('assureur', $sinistre->assureur) }}" required>
                            @error('assureur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Prime -->
                        <div class="form-group">
                            <label for="prime">Prime</label>
                            <input type="text" name="prime" id="prime" class="form-control @error('prime') is-invalid @enderror" value="{{ old('prime', $sinistre->prime) }}" required>
                            @error('prime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Fournisseur -->
                        <div class="form-group">
                            <label for="fournisseur">Fournisseur</label>
                            <input type="text" name="fournisseur" id="fournisseur" class="form-control @error('fournisseur') is-invalid @enderror" value="{{ old('fournisseur', $sinistre->fournisseur) }}" required>
                            @error('fournisseur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Numéro de Facture -->
                        <div class="form-group">
                            <label for="num_facture">Numéro de Facture</label>
                            <input type="text" name="num_facture" id="num_facture" class="form-control @error('num_facture') is-invalid @enderror" value="{{ old('num_facture', $sinistre->num_facture) }}" required>
                            @error('num_facture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Montant Facture USD -->
                        <div class="form-group">
                            <label for="montant_facture_usd">Montant Facture USD</label>
                            <input type="number" step="0.01" name="montant_facture_usd" id="montant_facture_usd" class="form-control @error('montant_facture_usd') is-invalid @enderror" value="{{ old('montant_facture_usd', $sinistre->montant_facture_usd) }}" required>
                            @error('montant_facture_usd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Montant Facture TND -->
                        <div class="form-group">
                            <label for="montant_facture_tnd">Montant Facture TND</label>
                            <input type="number" step="0.01" name="montant_facture_tnd" id="montant_facture_tnd" class="form-control @error('montant_facture_tnd') is-invalid @enderror" value="{{ old('montant_facture_tnd', $sinistre->montant_facture_tnd) }}" required>
                            @error('montant_facture_tnd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nature_de_sinistre">Nature De Sinistre :</label>
                            <input type="text" name="nature_de_sinistre" id="nature_de_sinistre"
                                   class="form-control" value="{{ old('nature_de_sinistre', $sinistre->nature_de_sinistre) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="statut_du_dossier">Status</label>
                            <select name="statut_du_dossier" id="statut_du_dossier" class="form-control" required>
                                <option value="Avant Constat" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                                <option value="Constat Déposé" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                                <option value="Expert" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'Expert' ? 'selected' : '' }}>Expert</option>
                                <option value="En Attente Du Remboursement" {{ old('statut_du_dossier', $sinistre->statut_du_dossier) == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 2 -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Champ Numéro de Conteneur -->
                        <div class="form-group">
                            <label for="num_conteneur">Numéro de Conteneur</label>
                            <input type="text" name="num_conteneur" id="num_conteneur" class="form-control @error('num_conteneur') is-invalid @enderror" value="{{ old('num_conteneur', $sinistre->num_conteneur) }}" required>
                            @error('num_conteneur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Date de Dépôt -->
                        <div class="form-group">
                            <label for="date_depot">Date de Dépôt</label>
                            <input type="date" name="date_depot" id="date_depot" class="form-control @error('date_depot') is-invalid @enderror" value="{{ old('date_depot', $sinistre->date_depot) }}" required>
                            @error('date_depot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Transporteur Maritime -->
                        <div class="form-group">
                            <label for="transporteur_maritime">Transporteur Maritime</label>
                            <input type="text" name="transporteur_maritime" id="transporteur_maritime" class="form-control @error('transporteur_maritime') is-invalid @enderror" value="{{ old('transporteur_maritime', $sinistre->transporteur_maritime) }}" required>
                            @error('transporteur_maritime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Date d'Incident -->
                        <div class="form-group">
                            <label for="date_incident">Date d'Incident</label>
                            <input type="date" name="date_incident" id="date_incident" class="form-control @error('date_incident') is-invalid @enderror" value="{{ old('date_incident', $sinistre->date_incident) }}" required>
                            @error('date_incident')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Lieu -->
                        <div class="form-group">
                            <label for="lieu">Lieu</label>
                            <input type="text" name="lieu" id="lieu" class="form-control @error('lieu') is-invalid @enderror" value="{{ old('lieu', $sinistre->lieu) }}" required>
                            @error('lieu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Montant de Dégât -->
                        <div class="form-group">
                            <label for="mt">Montant de Dégât</label>
                            <input type="number" step="0.01" name="mt" id="mt" class="form-control @error('mt') is-invalid @enderror" value="{{ old('mt', $sinistre->mt) }}" required>
                            @error('mt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Date Prévue de Remboursement -->
                        <div class="form-group">
                            <label for="date_prev_remboursement">Date Prévue de Remboursement</label>
                            <input type="date" name="date_prev_remboursement" id="date_prev_remboursement" class="form-control @error('date_prev_remboursement') is-invalid @enderror" value="{{ old('date_prev_remboursement', $sinistre->date_prev_remboursement) }}" required>
                            @error('date_prev_remboursement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Commentaire -->
                        <div class="form-group">
                            <label for="commentaire">Commentaire</label>
                            <textarea name="commentaire" id="commentaire" class="form-control @error('commentaire') is-invalid @enderror">{{ old('commentaire', $sinistre->commentaire) }}</textarea>
                            @error('commentaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Bouton de Soumission -->
        <div class="form-group text-center">
            <button type="submit" class="btn btn-warning btn-lg">Mettre à jour</button>
        </div>
    </form>
</div>

@endsection
