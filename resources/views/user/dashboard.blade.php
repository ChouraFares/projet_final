@extends('layouts.app')

@section('title', 'Tableau de Bord Utilisateur')

@section('content')

<div class="dashboard">
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('images/bk-food.png') }}" alt="Logo BK FOOD" class="logo">
        </div>
        <div class="user-info">
            <h2>Bonjour, {{ Auth::user()->name }}!</h2>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">Se Déconnecter</button>
            </form>
        </div>
    </div>

    <div class="options">
        <a href="{{ route('user.loan') }}" class="option">
            <i class="fas fa-hand-holding-usd"></i> Demander un Prêt/Avance
        </a>
        <a href="{{ route('user.view_loan_requests') }}" class="option">
            <i class="fas fa-hand-holding-usd"></i> Etat De La Demande Du Prêt/Avance
        </a>
        <a href="{{ route('user.Local-Mission') }}" class="option">
            <i class="fas fa-home"></i> Mission Locale
        </a>
        <a href="{{ route('international-mission.create') }}" class="option">
            <i class="fas fa-globe"></i> Mission Internationale
        </a>
        <a href="{{ route('user.viewMissionsLocal') }}" class="option">
            <i class="fas fa-chalkboard-teacher"></i> Etat De La Demande Mission Locale
        </a>
        <a href="{{ route("user.viewMissionsInternational") }}" class="option">
            <i class="fas fa-globe"></i> Etat De La Demande Mission International
        </a>
        <a href="{{ route('user.createInternshipRequest') }}" class="option">
            <i class="fas fa-file-alt"></i> Déposer une Demande De Stage
        </a>
        <a href="{{ route('user.internshipRequests') }}" class="option">
            <i class="fas fa-file-alt"></i> Etat Des Demandes De Stages
        </a>
  
    </div>
</div>

<style>
    .dashboard {
        padding: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .logo-container {
        margin-bottom: 15px;
    }

    .logo {
        width: 150px;
    }

    .user-info h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .btn-logout {
        background-color: #dc3545;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-logout:hover {
        background-color: #c82333;
    }

    .options {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .option {
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: #333;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .option:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .option i {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .option h3 {
        font-size: 16px;
        font-weight: 600;
        margin-top: 10px;
    }
</style>

@endsection
