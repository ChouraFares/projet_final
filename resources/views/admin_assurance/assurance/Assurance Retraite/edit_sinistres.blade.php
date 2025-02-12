@extends('layouts.app')

@section('title', 'Modifier un Sinistre - Assurance Retraite')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Modifier un Sinistre - Assurance Retraite</h2>

    <!-- Formulaire de modification d'un sinistre -->
    <form action="{{ route('AssuranceRetraite.sinistres.update', $sinistre->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Assureur -->
        <div class="form-group">
            <label for="Assureur">Assureur</label>
            <input type="text" name="Assureur" id="Assureur" class="form-control" value="{{ old('Assureur', $sinistre->Assureur) }}" required>
        </div>

        <!-- Nature du sinistre -->
        <div class="form-group">
            <label for="nature_sinistre">Nature du Sinistre</label>
            <input type="text" name="nature_sinistre" id="nature_sinistre" class="form-control" value="{{ old('nature_sinistre', $sinistre->nature_sinistre) }}" required>
        </div>

        <!-- Lieu du sinistre -->
        <div class="form-group">
            <label for="lieu_sinistre">Lieu du Sinistre</label>
            <input type="text" name="lieu_sinistre" id="lieu_sinistre" class="form-control" value="{{ old('lieu_sinistre', $sinistre->lieu_sinistre) }}" required>
        </div>

        <!-- Date du sinistre -->
        <div class="form-group">
            <label for="date_sinistre">Date du Sinistre</label>
            <input type="date" name="date_sinistre" id="date_sinistre" class="form-control" value="{{ old('date_sinistre', $sinistre->date_sinistre) }}" required>
        </div>

        <!-- Dégâts -->
        <div class="form-group">
            <label for="degats">Dégâts</label>
            <input type="text" name="degats" id="degats" class="form-control" value="{{ old('degats', $sinistre->degats) }}" required>
        </div>

        <!-- Charge -->
        <div class="form-group">
            <label for="charge">Charge</label>
            <input type="number" name="charge" id="charge" class="form-control" value="{{ old('charge', $sinistre->charge) }}" required>
        </div>

        <!-- Perte -->
        <div class="form-group">
            <label for="perte">Perte</label>
            <input type="number" name="perte" id="perte" class="form-control" value="{{ old('perte', $sinistre->perte) }}" required>
        </div>

        <!-- Responsable -->
        <div class="form-group">
            <label for="responsable">Responsable</label>
            <input type="text" name="responsable" id="responsable" class="form-control" value="{{ old('responsable', $sinistre->responsable) }}" required>
        </div>

        <!-- Commentaires -->
        <div class="form-group">
            <label for="commentaires">Commentaires</label>
            <textarea name="commentaires" id="commentaires" class="form-control" rows="3">{{ old('commentaires', $sinistre->commentaires) }}</textarea>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-success mt-3">Mettre à jour</button>
    </form>
</div>
@endsection
