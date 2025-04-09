@extends('layouts.app')

@section('title', 'Créer un Sinistre Flotte')

@section('content')
<div class="dashboard">
    <div class="header mb-4">
        <h2><i class="fas fa-car-crash me-2"></i>Créer un Nouveau Sinistre Flotte</h2>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.assurance.flotte.sinistres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Carte : Informations du Véhicule -->
            <div class="card mb-4">
                <h4>Informations du Véhicule</h4>

                <div class="form-group">
                    <label for="compagnie_assurance">Compagnie d'Assurance</label>
                    <input type="text" name="compagnie_assurance" class="form-control @error('compagnie_assurance') is-invalid @enderror" value="{{ old('compagnie_assurance') }}">
                    @error('compagnie_assurance')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="immatriculation">Immatriculation</label>
                    <input type="text" name="immatriculation" class="form-control @error('immatriculation') is-invalid @enderror" value="{{ old('immatriculation') }}">
                    @error('immatriculation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="vehicule">Véhicule</label>
                    <input type="text" name="vehicule" class="form-control @error('vehicule') is-invalid @enderror" value="{{ old('vehicule') }}">
                    @error('vehicule')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="chauffeur">Chauffeur</label>
                    <input type="text" name="chauffeur" class="form-control @error('chauffeur') is-invalid @enderror" value="{{ old('chauffeur') }}">
                    @error('chauffeur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Carte : Détails du Sinistre -->
            <div class="card mb-4">
                <h4>Détails du Sinistre</h4>

                <div class="form-group">
                    <label for="fautif">Fautif</label>
                    <select name="fautif" class="form-control" required>
                        <option value="Oui" {{ old('fautif') == 'Oui' ? 'selected' : '' }}>Oui</option>
                        <option value="Non" {{ old('fautif') == 'Non' ? 'selected' : '' }}>Non</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_sinistre">Date du Sinistre</label>
                    <input type="date" name="date_sinistre" class="form-control" value="{{ old('date_sinistre') }}">
                </div>

                <div class="form-group">
                    <label for="nature_sinistre">Nature du Sinistre</label>
                    <select name="nature_sinistre" class="form-control">
                        <option value="">-- Sélectionnez une nature --</option>
                        <option value="Connexe" {{ old('nature_sinistre') == 'Connexe' ? 'selected' : '' }}>Connexe</option>
                        <option value="Recours" {{ old('nature_sinistre') == 'Recours' ? 'selected' : '' }}>Recours</option>
                        <option value="Incendie" {{ old('nature_sinistre') == 'Incendie' ? 'selected' : '' }}>Incendie</option>
                        <option value="Dommage Collision" {{ old('nature_sinistre') == 'Dommage Collision' ? 'selected' : '' }}>Dommage Collision</option>
                        <option value="Bris de Glace" {{ old('nature_sinistre') == 'Bris de Glace' ? 'selected' : '' }}>Bris de Glace</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="avancements">Avancements</label>
                    <select name="avancements" class="form-control">
                        <option value="">-- Sélectionnez une étape --</option>
                        <option value="Avant Constat" {{ old('avancements') == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                        <option value="Constat Déposé" {{ old('avancements') == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                        <option value="Expert" {{ old('avancements') == 'Expert' ? 'selected' : '' }}>Expert</option>
                        <option value="En Attente Du Remboursement" {{ old('avancements') == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_cloture_dossier">Date Clôture Dossier</label>
                    <input type="date" name="date_cloture_dossier" class="form-control" value="{{ old('date_cloture_dossier') }}">
                </div>

                <div class="form-group">
                    <label for="reglement">Règlement</label>
                    <input type="text" name="reglement" class="form-control" value="{{ old('reglement') }}">
                </div>

                <div class="form-group">
                    <label for="Expert">Expert</label>
                    <input type="text" name="Expert" class="form-control" value="{{ old('Expert') }}">
                </div>

                <div class="form-group">
                    <label for="attachments_pdf">Fichier PDF Attaché</label>
                    <input type="file" name="attachments_pdf" class="form-control" accept=".pdf">
                    @error('attachments_pdf')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Carte : Informations Supplémentaires -->
            <div class="card mb-4">
                <h4>Informations Supplémentaires</h4>

                <div class="form-group">
                    <label for="statut">Statut</label>
                    <select name="statut" class="form-control">
                        <option value="En Cours" {{ old('statut', 'En Cours') == 'En Cours' ? 'selected' : '' }}>En Cours</option>
                        <option value="Clôturé" {{ old('statut') == 'Clôturé' ? 'selected' : '' }}>Clôturé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="commentaire">Commentaire</label>
                    <textarea name="commentaire" class="form-control" rows="3">{{ old('commentaire') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Enregistrer</button>
        </form>
    </div>
</div>
@endsection
