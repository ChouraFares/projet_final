@extends('layouts.app')

@section('title', 'Créer un Sinistre Flotte')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Créer un Nouveau Sinistre Flotte</h2>

    <form action="{{ route('admin.assurance.flotte.sinistres.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Champs existants -->
        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" name="compagnie_assurance" class="form-control form-control-lg" value="{{ old('compagnie_assurance') }}">
        </div>
        <div class="form-group">
            <label for="immatriculation">Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control input-lg" value="{{ old('immatriculation') }}">
        </div>
        <div class="form-group">
            <label for="vehicule">Véhicule</label>
            <input type="text" name="vehicule" class="form-control input-lg" value="{{ old('vehicule') }}">
        </div>
        <div class="form-group">
            <label for="chauffeur">Chauffeur</label>
            <input type="text" name="chauffeur" class="form-control input-lg" value="{{ old('chauffeur') }}">
        </div>
        <div class="form-group">
            <label for="fautif">Fautif</label>
            <select name="fautif" class="form-control form-control-lg" required style="width: 100%;">
                <option value="Oui" {{ old('fautif') == 'Oui' ? 'selected' : '' }}>Oui</option>
                <option value="Non" {{ old('fautif') == 'Non' ? 'selected' : '' }}>Non</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_sinistre">Date du Sinistre</label>
            <input type="date" name="date_sinistre" class="form-control form-control-lg" value="{{ old('date_sinistre') }}">
        </div>
        <div class="form-group row">
            <label for="nature_sinistre" class="col-sm-2 col-form-label">Nature du Sinistre</label>
            <div class="col-sm-10">
                <select name="nature_sinistre" class="form-control form-control-lg" style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                    <option value="">-- Sélectionnez une nature de sinistre --</option>
                    <option value="Connexe" {{ old('nature_sinistre') == 'Connexe' ? 'selected' : '' }}>Connexe</option>
                    <option value="Recours" {{ old('nature_sinistre') == 'Recours' ? 'selected' : '' }}>Recours</option>
                    <option value="Incendie" {{ old('nature_sinistre') == 'Incendie' ? 'selected' : '' }}>Incendie</option>
                    <option value="Dommage Collision" {{ old('nature_sinistre') == 'Dommage Collision' ? 'selected' : '' }}>Dommage Collision</option>
                    <option value="Bris de Glace" {{ old('nature_sinistre') == 'Bris de Glace' ? 'selected' : '' }}>Bris de Glace</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="avancements">Avancements</label>
            <select name="avancements" class="form-control form-control-lg">
                <option value="">-- Sélectionnez une option --</option>
                <option value="Avant Constat" {{ old('avancements') == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                <option value="Constat Déposé" {{ old('avancements') == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                <option value="Expert" {{ old('avancements') == 'Expert' ? 'selected' : '' }}>Expert</option>
                <option value="En Attente Du Remboursement" {{ old('avancements') == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_cloture_dossier">Date Clôture Dossier</label>
            <input type="date" name="date_cloture_dossier" class="form-control form-control-lg" value="{{ old('date_cloture_dossier') }}">
        </div>
        <div class="form-group">
            <label for="reglement">Règlement</label>
            <input type="text" name="reglement" class="form-control form-control-lg" value="{{ old('reglement') }}">
        </div>
        <div class="form-group">
            <label for="Expert">Expert</label>
            <input type="text" name="Expert" class="form-control form-control-lg" value="{{ old('Expert') }}">
        </div>

        <!-- Nouveau champ pour uploader un fichier PDF -->
        <div class="form-group">
            <label for="attachments_pdf">Fichier PDF Attaché</label>
            <input type="file" name="attachments_pdf" class="form-control form-control-lg" accept=".pdf">
            @error('attachments_pdf')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" class="form-control form-control-lg">
                <option value="En Cours" {{ old('statut', 'En Cours') == 'En Cours' ? 'selected' : '' }}>En Cours</option>
                <option value="Clôturé" {{ old('statut') == 'Clôturé' ? 'selected' : '' }}>Clôturé</option>
            </select>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" class="form-control" rows="3">{{ old('commentaire') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
    </form>
</div>
@endsection