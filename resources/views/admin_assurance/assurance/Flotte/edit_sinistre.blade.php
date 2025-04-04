@extends('layouts.app')

@section('title', 'Modifier un Sinistre Flotte')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Modifier le Sinistre #{{ $sinistre->sinistre_num }}</h2>

    <form action="{{ route('admin.assurance.flotte.sinistres.update', $sinistre->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Champs existants -->
        <div class="form-group">
            <label for="compagnie_assurance">Compagnie d'Assurance</label>
            <input type="text" name="compagnie_assurance" class="form-control" value="{{ old('compagnie_assurance', $sinistre->compagnie_assurance) }}" required>
        </div>
        <div class="form-group">
            <label for="sinistre_num">Numéro Sinistre</label>
            <input type="text" name="sinistre_num" class="form-control" value="{{ old('sinistre_num', $sinistre->sinistre_num) }}" readonly>
        </div>
        <div class="form-group">
            <label for="immatriculation">Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control" value="{{ old('immatriculation', $sinistre->immatriculation) }}" required>
        </div>
        <div class="form-group">
            <label for="vehicule">Véhicule</label>
            <input type="text" name="vehicule" class="form-control" value="{{ old('vehicule', $sinistre->vehicule) }}" required>
        </div>
        <div class="form-group">
            <label for="chauffeur">Chauffeur</label>
            <input type="text" name="chauffeur" class="form-control" value="{{ old('chauffeur', $sinistre->chauffeur) }}" required>
        </div>
        <div class="form-group">
            <label for="fautif">Fautif</label>
            <select name="fautif" class="form-control form-control-lg" required style="width: 100%;">
                <option value="Oui" {{ old('fautif', $sinistre->fautif) == 'Oui' ? 'selected' : '' }}>Oui</option>
                <option value="Non" {{ old('fautif', $sinistre->fautif) == 'Non' ? 'selected' : '' }}>Non</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_sinistre">Date du Sinistre</label>
            <input type="date" name="date_sinistre" class="form-control" value="{{ old('date_sinistre', $sinistre->date_sinistre ? $sinistre->date_sinistre->format('Y-m-d') : '') }}" required>
        </div>
        <div class="form-group">
            <label for="nature_sinistre">Nature du Sinistre</label>
            <select name="nature_sinistre" class="form-control" required style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                <option value="">-- Sélectionnez une nature de sinistre --</option>
                <option value="Connexe" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Connexe' ? 'selected' : '' }}>Connexe</option>
                <option value="Recours" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Recours' ? 'selected' : '' }}>Recours</option>
                <option value="Incendie" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Incendie' ? 'selected' : '' }}>Incendie</option>
                <option value="Dommage Collision" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Dommage Collision' ? 'selected' : '' }}>Dommage Collision</option>
                <option value="Bris de Glace" {{ old('nature_sinistre', $sinistre->nature_sinistre) == 'Bris de Glace' ? 'selected' : '' }}>Bris de Glace</option>
            </select>
        </div>
        <div class="form-group">
            <label for="avancements">Avancements</label>
            <select name="avancements" class="form-control" required>
                <option value="">Sélectionnez une option</option>
                <option value="Avant Constat" {{ old('avancements', $sinistre->avancements) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                <option value="Constat Déposé" {{ old('avancements', $sinistre->avancements) == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                <option value="Expert" {{ old('avancements', $sinistre->avancements) == 'Expert' ? 'selected' : '' }}>Expert</option>
                <option value="En Attente Du Remboursement" {{ old('avancements', $sinistre->avancements) == 'En Attente Du Remboursement' ? 'selected' : '' }}>En Attente Du Remboursement</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_cloture_dossier">Date Clôture Dossier</label>
            <input type="date" name="date_cloture_dossier" class="form-control" value="{{ old('date_cloture_dossier', $sinistre->date_cloture_dossier ? $sinistre->date_cloture_dossier->format('Y-m-d') : '') }}">
        </div>
        <div class="form-group">
            <label for="reglement">Règlement</label>
            <input type="text" name="reglement" class="form-control" value="{{ old('reglement', $sinistre->reglement) }}" required>
        </div>
        <div class="form-group">
            <label for="Expert">Expert</label>
            <input type="text" name="Expert" class="form-control" value="{{ old('Expert', $sinistre->Expert) }}" required>
        </div>

        <!-- Champ pour uploader un fichier PDF -->
        <div class="form-group">
            <label for="attachments_pdf">Fichier PDF Attaché</label>
            <input type="file" name="attachments_pdf" class="form-control" accept=".pdf">
            @if($sinistre->attachments_pdf)
                <small>Fichier actuel : <a href="{{ Storage::url($sinistre->attachments_pdf) }}" target="_blank">Voir PDF</a></small>
            @endif
            @error('attachments_pdf')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" class="form-control">
                <option value="En Cours" {{ old('statut', $sinistre->statut) == 'En Cours' ? 'selected' : '' }}>En Cours</option>
                <option value="Clôturé" {{ old('statut', $sinistre->statut) == 'Clôturé' ? 'selected' : '' }}>Clôturé</option>
            </select>
        </div>
        <div class="form-group">
            <label for="commentaire">Commentaire</label>
            <textarea name="commentaire" class="form-control" rows="3">{{ old('commentaire', $sinistre->commentaire) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Mettre à jour</button>
    </form>
</div>
@endsection