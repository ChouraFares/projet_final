@extends('layouts.app')

@section('title', 'Ressources Humaines')

@section('content')
<div class="dashboard">
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" class="logo">
        </div>
        <h2>Bonjour, {{ Auth::user()->name }} !</h2>
        <p>Bienvenue dans votre tableau de bord supervisé pour {{ Auth::user()->employe->Direction }}.</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-logout">Se Déconnecter</button>
        </form>
    </div>
    <div class="widgets options">
        @if(Auth::user()->employe->Direction === 'RH')
            <div class="grid-container">
                @foreach([
                    ['route' => 'admin.loanRequests', 'icon' => 'fas fa-hand-holding-usd', 'text' => 'Les Demandes De Prêts & Avance'],
                    ['route' => 'admin.localMissions', 'icon' => 'fas fa-map-marker-alt', 'text' => 'Demande de mission locale'],
                    ['route' => 'admin.internshipRequests', 'icon' => 'fas fa-user-graduate', 'text' => 'Les Demandes De Stages'],
                    ['route' => 'admin.viewMissionReports', 'icon' => 'fas fa-file-alt', 'text' => 'Rapports des missions locales'],
                    ['route' => 'admin.viewInternationalMissions', 'icon' => 'fas fa-plane-departure', 'text' => 'Demande de mission Internationale'],
                    ['route' => 'admin.rapportMissions', 'icon' => 'fas fa-file-signature', 'text' => 'Rapports des missions Internationales'],
                    ['route' => 'admin.assurance.AssuranceRetraite.bouttons', 'icon' => 'fas fa-user-tie', 'text' => 'Assurance Retraite'],
                    ['route' => 'admin.assurance.AssuranceMaladie.bouttons', 'icon' => 'fas fa-heart', 'text' => 'Assurance Maladie'],
                ] as $option)
                    <a href="{{ route($option['route']) }}" class="option">
                        <i class="{{ $option['icon'] }}"></i>
                        <h3>{{ $option['text'] }}</h3>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection