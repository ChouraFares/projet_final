@extends('layouts.app')

@section('Portail','title')

@include('components.navbar')

<div class="dashboard">
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" class="logo">
        </div>
        <h2>Bonjour, {{ Auth::user()->name }} !</h2>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
        </form>
    </div>

    <div class="options">
        <a href="{{route('responsable_finance.suivi-factures-achats')}}" class="option">
            <i class="fas fa-file-invoice-dollar"></i> 
            <h3>Achats en importation</h3>
        </a>
        <a href="{{route('DirecteurGeneral-insurance_types')}}" class="option">
            <i class="fas fa-shield-alt"></i> 
            <h3>Gestion des Assurances</h3>
        </a>
        <a href="{{route('directeur.general.rh.types')}}" class="option">
            <i class="fas fa-users"></i> 
            <h3>Gestion des Ressources Humaines</h3>
        </a>
    </div>
</div>



