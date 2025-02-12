@extends('layouts.app')

@section('title', 'Créer un Sinistre Transport Maritime')

@section('content')

<style>
    .container {
        max-width: 1100px;
        margin: auto;
        padding: 20px;
    }

    .row {
        display: flex;
        justify-content: space-between;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 48%;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    h4 {
        text-align: center;
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-primary {
        width: 100%;
        margin-top: 20px;
    }
</style>

<div class="container">
    <h2>Créer un Sinistre Transport Maritime</h2>

    <form action="{{ route('store_maritime_sinistres') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Première carte : Informations Générales -->
            <div class="card">
                <h4>Informations Générales</h4>

                <div class="form-group">
                    <label for="assureur">Compagnie Assurance</label>
                    <input type="text" name="assureur" id="assureur" class="form-control">
                </div>

                <div class="form-group">
                    <label for="prime">Prime :</label>
                    <input type="text" name="prime" id="prime" class="form-control" oninput="formatNumber(this)">
                </div>

                <div class="form-group">
                    <label for="fournisseur">Fournisseur :</label>
                    <input type="text" name="fournisseur" id="fournisseur" class="form-control">
                </div>

                <div class="form-group">
                    <label for="num_facture">Numéro de Facture :</label>
                    <input type="text" name="num_facture" id="num_facture" class="form-control">
                </div>

                <div class="form-group">
                    <label for="montant_facture_usd">Montant Facture (USD) :</label>
                    <input type="number" step="0.01" name="montant_facture_usd" id="montant_facture_usd" class="form-control">
                </div>

                <div class="form-group">
                    <label for="montant_facture_tnd">Montant Facture (TND) :</label>
                    <input type="number" step="0.01" name="montant_facture_tnd" id="montant_facture_tnd" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nature_de_sinistre">Nature De Sinistre :</label>
                    <input type="text" name="nature_de_sinistre" id="nature_de_sinistre"
                           class="form-control @error('nature_de_sinistre') is-invalid @enderror">
                    @error('nature_de_sinistre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="statut_du_dossier">Status </label>
                    <select name="statut_du_dossier" id="statut_du_dossier" class="form-control @error('statut_du_dossier') is-invalid @enderror">
                        <option value="" disabled selected>Choisissez un statut</option>
                        <option value="Avant Constat">Avant Constat</option>
                        <option value="Constat Déposé">Constat Déposé</option>
                        <option value="Expert">Expert</option>
                        <option value="En Attente Du Remboursement">En Attente Du Remboursement</option>
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
                    <label for="num_conteneur">Numéro de Conteneur :</label>
                    <input type="text" name="num_conteneur" id="num_conteneur" class="form-control">
                </div>

                <div class="form-group">
                    <label for="date_depot">Date Dépôt :</label>
                    <input type="date" name="date_depot" id="date_depot" class="form-control">
                </div>

                <div class="form-group">
                    <label for="transporteur_maritime">Transporteur Maritime :</label>
                    <input type="text" name="transporteur_maritime" id="transporteur_maritime" class="form-control">
                </div>

                <div class="form-group">
                    <label for="date_incident">Date Incident :</label>
                    <input type="date" name="date_incident" id="date_incident" class="form-control">
                </div>

                <div class="form-group">
                    <label for="lieu">Lieu :</label>
                    <input type="text" name="lieu" id="lieu" class="form-control">
                </div>

                <div class="form-group">
                    <label for="mt">MT :</label>
                    <input type="text" name="mt" id="mt" class="form-control">
                </div>

                <div class="form-group">
                    <label for="date_prev_remboursement">Date Prévue de Remboursement :</label>
                    <input type="date" name="date_prev_remboursement" id="date_prev_remboursement" class="form-control">
                </div>

                <div class="form-group">
                    <label for="commentaire">Commentaire :</label>
                    <textarea name="commentaire" id="commentaire" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <!-- Bouton d'enregistrement -->
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<script>
    function formatNumber(input) {
        let value = input.value.replace(/[^0-9,.]/g, '');
        value = value.replace(/,/g, '.');
        let parts = value.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        input.value = parts.join('.');
    }
</script>

@endsection
