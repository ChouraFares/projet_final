@extends('layouts.app')

@section('title', 'Gestion de l\'Assurance Maladie')

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
        border-radius: 5px; /* Coins arrondis */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Légère ombre */
        transition: transform 0.2s; /* Animation de transition */
    }
    .btn-group-container .btn:hover {
        transform: translateY(-2px); /* Légère élévation au survol */
    }
    .btn-group-container .btn i {
        margin-right: 8px; /* Espacement entre l'icône et le texte */
    }
    h2 {
        margin-bottom: 20px; /* Espacement sous le titre */
        font-size: 24px; /* Taille de police du titre */
        font-weight: bold; /* Gras pour le titre */
    }
</style>

<!-- Inclure Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <h2 class="text-center">Gestion de l'Assurance Maladie</h2>

    <div class="btn-group-container">
        <!-- Lien vers la gestion des contrats -->
        <a href="{{ route('contrats_assurance_maladie.index') }}" class="btn btn-success">
            <i class="fas fa-file-contract"></i> Gestion des Contrats
        </a>

        <!-- Lien vers le suivi des sinistres -->
        <a href="{{ route('admin.assurance.AssuranceMaladie.contrats') }}" class="btn btn-warning">
            <i class="fas fa-clipboard-list"></i> Suivi des Bordereaux
        </a>
    </div>
</div>
@endsection
