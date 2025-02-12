@extends('layouts.app')

@section('title', 'Gestion de l\'Assurance Responsabilité Civile ')

@section('content')
<style>
    .btn-group-container {
        display: flex;
        justify-content: center;
        gap: 20px; /* Espacement entre les boutons */
        margin-top: 20px;
    }
    .btn-group-container .btn {
        flex: 1; /* Permet aux boutons de prendre une taille égale */
        text-align: center;
        padding: 15px 20px;
        font-size: 16px;
    }
    .btn i {
        margin-right: 8px; /* Espacement entre l'icône et le texte */
    }
</style>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <h2 class="text-center">Gestion de l'Assurance Responsabilité Civile</h2>

    <div class="btn-group-container">
        <a href="{{ route('directeur-general.responsable-civil.contrats') }}" class="btn btn-success">
            <i class="fas fa-file-contract"></i> Gestion des Contrats
        </a>
        <a href="{{ route('directeur-general.responsable-civil.sinistres') }}" class="btn btn-warning">
            <i class="fas fa-exclamation-triangle"></i> Suivi des Sinistres
        </a>
      
    </div>
</div>

@endsection
