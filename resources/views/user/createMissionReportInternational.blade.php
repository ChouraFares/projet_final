@extends('layouts.app')

@section('title', 'Rédiger Ton Rapport International')

@section('content')
<div class="container mt-4">
    <h2>Rédiger Ton Rapport pour la Mission Internationale ID: {{ $mission->mission_id }}</h2>
    <form action="{{ route('international-mission.submitReport', $mission->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Champ pour les détails du rapport -->
        <div class="form-group">
            <label for="reportDetails">Détails du Rapport</label>
            <textarea class="form-control" id="reportDetails" name="reportDetails" rows="10" style="height: 200px; width: 100%;" required></textarea>
        </div>

        <!-- Champ pour la date du rapport -->
        <div class="form-group">
            <label for="reportDate">Date du Rapport</label>
            <input type="date" class="form-control" id="reportDate" name="reportDate" required>
        </div>

        <!-- Champ pour télécharger le reçu -->
        <div class="form-group">
            <label for="receipt">Télécharger le Reçu (Frais Divers)</label>
            <input type="file" class="form-control-file" id="receipt" name="receipt">
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-success">Envoyer le Rapport</button>
    </form>
</div>
@endsection
