@extends('layouts.app')

@section('title', 'Suivi Des Demandes Des Factures Complimentaires Sur Achats')

@section('content')
<style>
    .container {
        padding: 20px;
    }

    h2 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 30px;
    }

    .row {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .col-md-4 {
        width: 100%;
        margin-bottom: 45px;
    }

    .btn-block {
        padding: 15px;
        font-size: 1.1rem;
        border-radius: 8px;
        text-align: center;
        width: 80%;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-block i {
        margin-right: 10px;
    }

    .btn-block:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .content-wrapper {
        margin-top: 30px;
    }
</style>
<!-- Ajouter le lien vers Font Awesome -->

<div class="container content-wrapper">
    <div class="card">
        <div class="card-body">
            <h2>Choisissez Votre Type De Suivi De Demande</h2>
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ route('Directeur_generale.demandes') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-fish"></i>Les Demandes Des Factures complémentaires sur thon
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-oil-can"></i> Les Demandes Des Factures complémentaires sur huile
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-box"></i> Les Demandes Des Factures complémentaires sur boîtes
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-tools"></i>Les Demandes Des Factures complémentaires sur immobilisations
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
