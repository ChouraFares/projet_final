@extends('layouts.app')

@section('title', ' Ajouter un Sinistre  - Assurance Responsabilité Civile')

@section('content')

<div class="container">
    <h2 class="text-center mb-4">{{ isset($sinistre) ? 'Modifier un Sinistre' : 'Ajouter un Sinistre Responsabilité Civile' }}</h2>

    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($sinistre) ? route('ResponsableCivil.sinistres.update', $sinistre->id) : route('admin.ResponsableCivil.sinistres.store') }}" method="POST">
        @csrf
        @if(isset($sinistre))
            @method('PUT')
        @endif



        <div class="form-group">
            <label for="assureur">Compagnie Assurance</label> <!-- Assureur -->
            <input type="text" id="assureur" name="assureur" class="form-control @error('assureur') is-invalid @enderror" value="{{ old('assureur', $sinistre->assureur ?? '') }}" required>
            @error('assureur')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nature_sinistre">Nature du Sinistre</label>
            <input type="text" id="nature_sinistre" name="nature_sinistre" class="form-control @error('nature_sinistre') is-invalid @enderror" value="{{ old('nature_sinistre', $sinistre->nature_sinistre ?? '') }}" required>
            @error('nature_sinistre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="lieu_sinistre">Lieu du Sinistre</label>
            <input type="text" id="lieu_sinistre" name="lieu_sinistre" class="form-control @error('lieu_sinistre') is-invalid @enderror" value="{{ old('lieu_sinistre', $sinistre->lieu_sinistre ?? '') }}" required>
            @error('lieu_sinistre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_sinistre">Date du Sinistre</label>
            <input type="date" id="date_sinistre" name="date_sinistre" class="form-control @error('date_sinistre') is-invalid @enderror" value="{{ old('date_sinistre', $sinistre->date_sinistre ?? '') }}" required>
            @error('date_sinistre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="degats">Dégâts</label>
            <input type="text" id="degats" name="degats" class="form-control @error('degats') is-invalid @enderror" value="{{ old('degats', $sinistre->degats ?? '') }}">
            @error('degats')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="charge">Charge</label>
            <input type="text" id="charge" name="charge" class="form-control @error('charge') is-invalid @enderror" value="{{ old('charge', $sinistre->charge ?? '') }}">
            @error('charge')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="perte">Perte</label>
            <input type="text" id="perte" name="perte" class="form-control @error('perte') is-invalid @enderror" value="{{ old('perte', $sinistre->perte ?? '') }}">
            @error('perte')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="responsable">Responsable</label>
            <input type="text" id="responsable" name="responsable" class="form-control @error('responsable') is-invalid @enderror" value="{{ old('responsable', $sinistre->responsable ?? '') }}">
            @error('responsable')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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


        <div class="form-group">
            <label for="commentaires">Commentaires</label>
            <textarea id="commentaires" name="commentaires" class="form-control @error('commentaires') is-invalid @enderror">{{ old('commentaires', $sinistre->commentaires ?? '') }}</textarea>
            @error('commentaires')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($sinistre) ? 'Mettre à jour' : 'Ajouter' }}</button>
    </form>
</div>

@endsection
