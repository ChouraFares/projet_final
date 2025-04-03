@extends('layouts.app')

@section('title', 'Ajouter un Sinistre - Bris de Machine')

@section('content')

<div class="container">
    <h2 class="text-center mb-4">Ajouter un Sinistre - Bris de Machine</h2>

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

    <!-- Formulaire de création d'un sinistre -->
    <form action="{{ route('admin.BrisDeMachines.sinistres.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="assureur">Compagnie Assurance</label>
            <input type="text" class="form-control" id="assureur" name="assureur" value="{{ old('assureur') }}" required>
        </div>

        <div class="form-group">
            <label for="nature_sinistre">Nature du Sinistre</label>
            <input type="text" class="form-control" id="nature_sinistre" name="nature_sinistre" value="{{ old('nature_sinistre') }}" required>
        </div>

        <div class="form-group">
            <label for="lieu_sinistre">Lieu du Sinistre</label>
            <input type="text" class="form-control" id="lieu_sinistre" name="lieu_sinistre" value="{{ old('lieu_sinistre') }}" required>
        </div>

        <div class="form-group">
            <label for="date_sinistre">Date du Sinistre</label>
            <input type="date" class="form-control" id="date_sinistre" name="date_sinistre" value="{{ old('date_sinistre') }}" required>
        </div>

        <div class="form-group">
            <label for="degats">Dégâts</label>
            <textarea class="form-control" id="degats" name="degats" rows="3" required>{{ old('degats') }}</textarea>
        </div>

        <div class="form-group">
            <label for="charge">Chargé</label>
            <input type="text" class="form-control" id="charge" name="charge" value="{{ old('charge') }}" required>             </div>

        <div class="form-group">
            <label for="perte">Perte</label>
            <input type="number" class="form-control" id="perte" name="perte" value="{{ old('perte') }}" required>
        </div>

        <div class="form-group">
            <label for="responsable">Responsable</label>
            <input type="text" class="form-control" id="responsable" name="responsable" value="{{ old('responsable') }}" required>
        </div>

        <div class="form-group">
            <label for="statu_du_dossier">Status</label>
            <select class="form-control" id="statu_du_dossier" name="statu_du_dossier" required>
                <option value="">Sélectionner un statut</option>
                <option value="Avant Constat" {{ old('statu_du_dossier') == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
                <option value="Constat Déposé" {{ old('statu_du_dossier') == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
                <option value="Expert" {{ old('statu_du_dossier') == 'Expert' ? 'selected' : '' }}>Expert</option>
                <option value="En attente du remboursement" {{ old('statu_du_dossier') == 'En attente du remboursement' ? 'selected' : '' }}>En attente du remboursement</option>
            </select>
        </div>


        <div class="form-group">
            <label for="expert">Expert</label>
            <input type="text" class="form-control" id="expert" name="expert" value="{{ old('expert') }}" >
        </div>

        <div class="form-group">
            <label for="commentaires">Commentaires</label>
            <textarea class="form-control" id="commentaires" name="commentaires" rows="3">{{ old('commentaires') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le Sinistre</button>
    </form>
</div>

@endsection
