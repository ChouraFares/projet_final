@extends('layouts.app')
@section('title', 'Tableau de Bord Utilisateur')
@include('components.navbar')

<style>
    :root {
        --olive: #887630;
        --federal-blue: #00004F;
        --navy-blue: #000080;
        --gold: #F4A261;
        --dark-blue: #2A4B67;
    }

    .dashboard {
        padding: 20px;
        background-color: var(--light-gray);
        min-height: 100vh;
    }

    .header {
        background-color: var(--dark-blue);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .logo-container h2 {
        color: var(--gold);
        margin: 0;
        font-size: 1.8rem;
    }

    .options {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .option {
        background-color: white;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        text-decoration: none;
        color: var(--federal-blue);
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-left: 4px solid var(--gold);
    }

    .option:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-left-color: var(--olive);
    }

    .option i {
        font-size: 2.5rem;
        color: var(--gold);
        margin-bottom: 15px;
        display: block;
    }

    .option h3 {
        font-size: 1.2rem;
        margin: 10px 0;
        color: var(--navy-blue);
    }

    .btn-logout {
        background-color: transparent;
        border: 2px solid var(--gold);
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn-logout:hover {
        background-color: var(--gold);
        color: var(--federal-blue);
    }

    /* Styles pour les animations */
    .animate__animated {
        animation-duration: 0.5s;
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
        
        .options {
            grid-template-columns: 1fr;
        }
    }

    /* Styles des notifications (conservés de votre exemple) */
    .notification-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        overflow-y: auto;
    }

    .notification-modal-content {
        background-color: var(--dark-blue);
        margin: 5% auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        width: 80%;
        max-width: 800px;
        color: white;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* ... (conservez le reste de vos styles de notification existants) ... */
</style>

<div class="dashboard">
    <div class="header animate__animated animate__fadeInDown">
        <div class="logo-container">
            <h2>Bonjour, {{ Auth::user()->name }} !</h2>
        </div>
  
    </div>

    <div class="options animate__animated animate__fadeInUp animate__delay-1s">
        <a href="{{ route('user.loan') }}" class="option">
            <i class="fas fa-hand-holding-usd"></i>
            <h3>Demander un Prêt/Avance</h3>
            <p>Formulaire de demande</p>
        </a>
        
        <a href="{{ route('user.view_loan_requests') }}" class="option">
            <i class="fas fa-file-invoice-dollar"></i>
            <h3>État des Demandes</h3>
            <p>Suivi des prêts/avances</p>
        </a>
        
        <a href="{{ route('user.Local-Mission') }}" class="option">
            <i class="fas fa-home"></i>
            <h3>Mission Locale</h3>
            <p>Nouvelle demande</p>
        </a>
        
        <a href="{{ route('international-mission.create') }}" class="option">
            <i class="fas fa-globe"></i>
            <h3>Mission Internationale</h3>
            <p>Nouvelle demande</p>
        </a>
        
        <a href="{{ route('user.viewMissionsLocal') }}" class="option">
            <i class="fas fa-clipboard-list"></i>
            <h3>Suivi Missions Locales</h3>
            <p>État des demandes</p>
        </a>
        
        <a href="{{ route('user.viewMissionsInternational') }}" class="option">
            <i class="fas fa-globe-americas"></i>
            <h3>Suivi Missions Internationales</h3>
            <p>État des demandes</p>
        </a>
        
        <a href="{{ route('user.createInternshipRequest') }}" class="option">
            <i class="fas fa-file-alt"></i>
            <h3>Demande de Stage</h3>
            <p>Nouvelle demande</p>
        </a>
        
        <a href="{{ route('user.internshipRequests') }}" class="option">
            <i class="fas fa-tasks"></i>
            <h3>Suivi Demandes de Stage</h3>
            <p>État des demandes</p>
        </a>
    </div>
</div>

<!-- Modal Notifications (identique à votre exemple) -->
<div class="notification-modal" id="notificationModal">
    <!-- ... (conservez votre modal de notification existant) ... -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ... (conservez votre script de notification existant) ...
    
    // Animation au survol des options
    document.querySelectorAll('.option').forEach(option => {
        option.addEventListener('mouseenter', function() {
            this.querySelector('i').style.transform = 'scale(1.1)';
            this.querySelector('i').style.color = 'var(--olive)';
        });
        
        option.addEventListener('mouseleave', function() {
            this.querySelector('i').style.transform = 'scale(1)';
            this.querySelector('i').style.color = 'var(--gold)';
        });
    });
});
</script>