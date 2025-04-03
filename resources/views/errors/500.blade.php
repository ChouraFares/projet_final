@extends('layouts.app')

@section('title', 'Erreur')

@section('content')
<div class="error-page">
    <div class="error-container">
        <h1>Erreur</h1>
        <p>Veuillez contacter le développeur à <a href="mailto:Fares.Choura@bkfood.com.tn">Fares.Choura@bkfood.com.tn</a> pour corriger cette erreur.</p>        
        <!-- Redirection en fonction du rôle -->
        @if(Auth::check())
            @if(Auth::user()->role === 'user')
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Retour au Tableau de Bord Utilisateur</a>
            @elseif(Auth::user()->role === 'admin_assurance')
                <a href="{{ route('admin_assurance.dashboard') }}" class="btn btn-primary">Retour au Dashboard Admin Assurance</a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Retour au Dashboard Admin</a>
            @else
                <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
        @endif
    </div>
</div>

<style>
    .error-page {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .error-container {
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .error-container h1 {
        font-size: 2.5em;
        color: #dc3545;
    }
    .error-container p {
        font-size: 1.2em;
        margin: 20px 0;
    }
</style>
@endsection
