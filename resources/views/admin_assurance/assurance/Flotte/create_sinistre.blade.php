@extends('layouts.app')

@section('title', 'Créer un Sinistre Flotte')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Créer un Nouveau Sinistre Flotte</h2>

    <!-- Formulaire de création d'un sinistre -->
    <form action="{{ route('admin.assurance.flotte.sinistres.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" name="compagnie_assurance" class="form-control form-control-lg">
        </div>

        <!-- Immatriculation -->
        <div class="form-group">
            <label for="immatriculation">Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control input-lg">
        </div>

        <!-- Véhicule -->
        <div class="form-group">
            <label for="vehicule">Véhicule</label>
            <input type="text" name="vehicule" class="form-control input-lg">
        </div>

        <!-- Chauffeur -->
        <div class="form-group">
            <label for="chauffeur">Chauffeur</label>
            <input type="text" name="chauffeur" class="form-control input-lg">
        </div>

        <!-- Fautif -->
        <div class="form-group">
            <label for="fautif">Fautif</label>
            <select name="fautif" class="form-control form-control-lg" style="width: 100%;">
                <option value="">-- Sélectionnez une option --</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>

        <!-- Date du sinistre -->
        <div class="form-group">
            <label for="date_sinistre">Date du Sinistre</label>
            <input type="date" name="date_sinistre" class="form-control form-control-lg">
        </div>

        <!-- Nature du sinistre -->
        <div class="form-group row">
            <label for="nature_sinistre" class="col-sm-2 col-form-label">Nature du Sinistre</label>
            <div class="col-sm-10">
                <select name="nature_sinistre" class="form-control form-control-lg" style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                    <option value="">-- Sélectionnez une nature de sinistre --</option>
                    <option value="Connexe">Connexe</option>
                    <option value="Recours">Recours</option>
                    <option value="Incendie">Incendie</option>
                    <option value="Dommage Collision">Dommage Collision</option>
                    <option value="Bris de Glace">Bris de Glace</option>
                </select>
            </div>
        </div>

        <!-- Situation du dossier -->
        <div class="form-group">
            <label for="situation_dossier">Status</label>
            <select name="situation_dossier" class="form-control form-control-lg">
                <option value="">-- Sélectionnez une option --</option>
                <option value="Avant Constat">Avant Constat</option>
                <option value="Constat Déposé">Constat Déposé</option>
                <option value="Expert">Expert</option>
                <option value="En Attente Du Remboursement">En Attente Du Remboursement</option>
            </select>
        </div>

        <!-- Date de clôture du dossier -->
        <div class="form-group">
            <label for="date_cloture_dossier">Date Clôture Dossier</label>
            <input type="date" name="date_cloture_dossier" class="form-control form-control-lg">
        </div>

        <!-- Règlement -->
        <div class="form-group">
            <label for="reglement">Règlement</label>
            <input type="text" name="reglement" class="form-control form-control-lg">
        </div>

        <!-- Expert -->
        <div class="form-group">
            <label for="Expert">Expert</label>
            <input type="text" name="Expert" class="form-control form-control-lg">
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
    </form>
</div>

@endsection
