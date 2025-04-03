@extends('layouts.app')

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
    .btn-group-container .btn i {
        margin-right: 10px; /* Espacement entre l'icône et le texte */
    }
</style>

<div class="container">
    <h2 class="text-center">Gestion de l'Assurance MRD</h2>

    <div class="btn-group-container">
        <a href="{{ route('admin.mrd.contrats') }}" class="btn btn-success">
            <i class="fas fa-file-contract"></i> Gestion des Contrats
        </a>
        <a href="{{ route('admin.mrd.sinistres') }}" class="btn btn-warning">
            <i class="fas fa-exclamation-triangle"></i> Suivi des Sinistres
        </a>
        <a href="{{ route('admin.mrd.sinistres.create') }}" class="btn btn-danger">
            <i class="fas fa-plus-circle"></i> Déclaration des Sinistres
        </a>
    </div>
</div>

<!-- Ajoutez ce script si Font Awesome n'est pas déjà inclus -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
