@extends('layouts.app')

@section('title', 'Rédiger Ton Rapport')

@section('content')
<div class="container mt-4">
    <h2>Rédiger Ton Rapport pour la Mission ID: {{ $mission->mission_id }}</h2>

    <!-- Affichage des messages d'erreur -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire de soumission du rapport -->
    <form action="{{ route('user.submitMissionReport', $mission->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="reportDetails">Détails du Rapport</label>
            <textarea class="form-control" id="reportDetails" name="reportDetails" rows="10" style="height: 200px; width: 100%;" required></textarea>
        </div>

        <div class="form-group">
            <label for="reportDate">Date du Rapport</label>
            <input type="date" class="form-control" id="reportDate" name="reportDate" style="width: 100%;" required>
        </div>

        <div class="form-group">
            <label for="receipt">Télécharger le Reçu (Carburant)</label>
            <input type="file" class="form-control-file" id="receipt" name="receipt">
        </div>

        <button type="submit" class="btn btn-success">Envoyer le Rapport</button>
    </form>
</div>
@endsection
