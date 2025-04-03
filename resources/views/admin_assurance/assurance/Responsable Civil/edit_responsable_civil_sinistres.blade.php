@extends('layouts.app')
@section('title','Modifier un sinistre - Responsabilité Civile')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Modifier un sinistre - Responsabilité Civile</h2>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire de modification -->
        <form action="{{ route('ResponsableCivil.sinistres.update', $sinistre->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Assureur -->
            <div class="form-group mb-3">
                <label for="assureur">Compagnie Assurance</label> <!-- Assureur -->
                <input type="text" name="assureur" id="assureur" class="form-control" value="{{ old('assureur', $sinistre->assureur) }}" required>
            </div>

            <!-- Nature du sinistre -->
            <div class="form-group mb-3">
                <label for="nature_sinistre">Nature du sinistre</label>
                <input type="text" name="nature_sinistre" id="nature_sinistre" class="form-control" value="{{ old('nature_sinistre', $sinistre->nature_sinistre) }}" required>
            </div>

            <!-- Lieu du sinistre -->
            <div class="form-group mb-3">
                <label for="lieu_sinistre">Lieu du sinistre</label>
                <input type="text" name="lieu_sinistre" id="lieu_sinistre" class="form-control" value="{{ old('lieu_sinistre', $sinistre->lieu_sinistre) }}" required>
            </div>

            <!-- Date du sinistre -->
            <div class="form-group mb-3">
                <label for="date_sinistre">Date du sinistre</label>
                <input type="date" name="date_sinistre" id="date_sinistre" class="form-control" value="{{ old('date_sinistre', $sinistre->date_sinistre) }}" required>
            </div>

            <!-- Dégâts -->
            <div class="form-group mb-3">
                <label for="degats">Dégâts</label>
                <textarea name="degats" id="degats" class="form-control">{{ old('degats', $sinistre->degats) }}</textarea>
            </div>

            <!-- Chargé de l'affaire -->
            <div class="form-group mb-3">
                <label for="charge">Chargé de l'affaire</label>
                <input type="text" name="charge" id="charge" class="form-control" value="{{ old('charge', $sinistre->charge) }}">
            </div>

            <!-- Montant de la perte -->
            <div class="form-group mb-3">
                <label for="perte">Montant de la perte</label>
                <input type="number" step="0.01" name="perte" id="perte" class="form-control" value="{{ old('perte', $sinistre->perte) }}">
            </div>

            <!-- Responsable -->
            <div class="form-group mb-3">
                <label for="responsable">Responsable</label>
                <input type="text" name="responsable" id="responsable" class="form-control" value="{{ old('responsable', $sinistre->responsable) }}">
            </div>

            <div class="form-group">
                <label for="situation_du_dossier">Status</label>
                <select id="situation_du_dossier" name="situation_du_dossier" class="form-control @error('situation_du_dossier') is-invalid @enderror" required>
                    <option value="">Sélectionnez une option</option>
                    <option value="Avant Constat" {{ old('situation_du_dossier', $sinistre->situation_du_dossier ?? '') == "Avant Constat" ? 'selected' : '' }}>Avant Constat</option>
                    <option value="Constat Déposé" {{ old('situation_du_dossier', $sinistre->situation_du_dossier ?? '') == "Constat Déposé" ? 'selected' : '' }}>Constat Déposé</option>
                    <option value="Expert" {{ old('situation_du_dossier', $sinistre->situation_du_dossier ?? '') == "Expert" ? 'selected' : '' }}>Expert</option>
                    <option value="En Attente Du Remboursement" {{ old('situation_du_dossier', $sinistre->situation_du_dossier ?? '') == "En Attente Du Remboursement" ? 'selected' : '' }}>En Attente Du Remboursement</option>
                </select>
                @error('situation_du_dossier')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Commentaires -->
            <div class="form-group mb-3">
                <label for="commentaires">Commentaires</label>
                <textarea name="commentaires" id="commentaires" class="form-control">{{ old('commentaires', $sinistre->commentaires) }}</textarea>
            </div>

            <!-- Boutons -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
