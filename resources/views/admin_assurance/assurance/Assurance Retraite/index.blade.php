@extends('layouts.app')

@section('title', 'Gestion de l\'Assurance Retraite')

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
        margin-right: 8px; /* Espacement entre l'icône et le texte */
    }
</style>

<!-- Inclure Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <h2 class="text-center">Gestion de l'Assurance Retraite</h2>

    <div class="btn-group-container">
        <!-- Lien vers la gestion des contrats -->
        <a href="{{ route('admin.assurance.AssuranceRetraite.contrats') }}" class="btn btn-success">
            <i class="fas fa-file-contract"></i> Gestion des Contrats
        </a>

   
    </div>
</div>
@endsection
