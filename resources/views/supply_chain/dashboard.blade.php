@extends('layouts.app')

@section('title', 'Admin Assurance Dashboard')


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
        <a href="{{ route('admin_assurance.ressources_humaines') }}" class="option">
            <i class="fas fa-users"></i>
            <h3>Gestion Des Ressources Humaines</h3>
        </a>
        <a href="{{ route('admin_assurance.types') }}" class="option">
            <i class="fas fa-file-medical"></i>
            <h3>Gestion Des Assurances</h3>
        </a>
    </div>
</div>



