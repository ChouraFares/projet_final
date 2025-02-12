@extends('layouts.app')

@section('title', 'Suivi Des Demandes Des Factures Complémentaires Sur Achats')

@section('content')
<style>
    :root {
        --olive: #887630;
        --federal-blue: #00004F;
        --navy-blue: #887630;
    }

    .content-wrapper {
        padding: 40px 20px;
        background: linear-gradient(135deg, var(--light-gray), var(--white));
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        background: var(--white);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-body {
        padding: 30px;
    }

    .card-body h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--navy-blue);
        text-align: center;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 1px;
        animation: fadeInDown 1s ease-out;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .col-md-4 {
        flex: 1 1 300px;
        max-width: 350px;
    }

    .btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--olive);
        border: none;
        padding: 15px 20px;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 10px;
        color: var(--white);
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: fadeInUp 1s ease-out;
        text-decoration: none;
        height: 100%;
        text-align: center;
    }

    .btn-primary i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .btn-primary:hover {
        background-color: var(--federal-blue);
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .text-danger {
        font-size: 1.1rem;
        font-weight: 500;
        margin-top: 20px;
        animation: fadeIn 1s ease-out;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-body h2 {
            font-size: 1.5rem;
        }

        .col-md-4 {
            flex: 1 1 100%;
            max-width: 100%;
        }

        .btn-primary {
            font-size: 0.9rem;
            padding: 12px 15px;
        }
    }
</style>

<!-- Ajouter le lien vers Font Awesome -->
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

<div class="container content-wrapper">
    <div class="card">
        <div class="card-body">
            <h2>Choisissez Votre Type De Suivi De Demande</h2>
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ route('responsable_finance.demandes') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-fish"></i> Les Demandes Des Factures Complémentaires Sur Thon
                    </a>
                </div>

                @if(auth()->check() && in_array(auth()->user()->role, ['responsable_finance', 'DirecteurGeneral']))                    <div class="col-md-4">
                        <a href="{{ route('responsable_finance.detaille_timbrage_surestarie') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-stamp"></i> Détails d'Affectation Des Timbrages & Surestaries
                        </a>
                    </div>
                    
                    <div class="col-md-4">
                        <a href="{{ route('responsable_finance.detaille_affectation_stam') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-file-invoice"></i> Détails d'Affectation Des Stam
                        </a>
                    </div>
                @else
                    <div class="col-md-12">
                        <p class="text-center text-danger">Accès réservé aux responsables financiers.</p>
                    </div>
                @endif

                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-oil-can"></i> Les Demandes Des Factures Complémentaires Sur Huile
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-box"></i> Les Demandes Des Factures Complémentaires Sur Boîtes
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-tools"></i> Les Demandes Des Factures Complémentaires Sur Immobilisations
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection