@extends('layouts.app')
<head>
    <!-- Autres liens CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@section('title', 'Gestion de l\'Assurance MRD')

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

<div class="container">
    <h2 class="text-center">Gestion de l'Assurance Transport Maritime</h2>

    <div class="btn-group-container">
        <a href="{{ route('admin.assurance.transport.maritime.contrats') }}" class="btn btn-success">
            <i class="fas fa-file-contract"></i> Gestion des Contrats
        </a>
        <a href="{{ route('sinistres') }}" class="btn btn-warning">
            <i class="fas fa-exclamation-triangle"></i> Suivi des Sinistres
        </a>
        <a href="{{ route('create_maritime_sinistres') }}" class="btn btn-danger">
            <i class="fas fa-plus-circle"></i> Déclaration des Sinistres
        </a>
    </div>
</div>

@endsection
