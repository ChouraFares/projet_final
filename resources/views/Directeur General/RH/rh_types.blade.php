@extends('layouts.app')

@section('title', 'Section Ressources Humaines')

@section('content')
    <div class="widgets options">
        @foreach([
            ['route' => 'directeur-general.loanRequests', 'icon' => 'fas fa-money-bill-wave', 'text' => 'Les Demandes De Prêts & Avance'],
            ['route' => 'directeur-general.localMissions', 'icon' => 'fas fa-tasks', 'text' => 'Demande de mission locale'],
            ['route' => 'directeur-general.internshipRequests', 'icon' => 'fas fa-folder', 'text' => 'Les Demandes De Stages'],
            ['route' => 'directeur-general.viewMissionReports', 'icon' => 'fas fa-tasks', 'text' => 'Rapports des missions locales'],
            ['route' => 'directeur-general.viewInternationalMissions', 'icon' => 'fas fa-globe', 'text' => 'Demande de mission Internationalle'],
            ['route' => 'directeur-general.rapportMissions', 'icon' => 'fas fa-globe', 'text' => 'Rapports des missions Internationalle'],
        ] as $option)
            <a href="{{ route($option['route']) }}" class="option">
                <i class="{{ $option['icon'] }}"></i>
                <h3>{{ $option['text'] }}</h3>
            </a>
        @endforeach
    </div>
@endsection

