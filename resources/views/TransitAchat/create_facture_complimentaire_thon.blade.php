@extends('layouts.transit')

@section('title', 'Demander une Facture Complémentaire Thon')

@section('content')
<div class="container">
    <h2>Demander une Facture Complémentaire Thon</h2>

    <form action="{{ route('facture.complimentaire.thon.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Première carte : Informations de base -->
            <div class="card">
                <h4>Informations de base</h4>
                <div class="form-group">
                    <label for="fournisseur">Fournisseur</label>
                    <input type="text" class="form-control" id="fournisseur" name="fournisseur">
                </div>

                <div class="form-group">
                    <label for="facture">Facture</label>
                    <input type="text" class="form-control" id="facture" name="facture">
                </div>

                <div class="form-group">
                    <label for="num_conteneur">N° CONTENEUR</label>
                    <input type="text" class="form-control" id="num_conteneur" name="num_conteneur">
                </div>


             
                <div class="form-group">
                    <label for="armateur">Armateur</label>
                    <input type="text" class="form-control" id="armateur" name="armateur">
                </div>
                <div class="form-group">
                    <label for="incoterm">Incoterm</label>
                    <input type="text" class="form-control" id="incoterm" name="incoterm">
                </div>
                <div class="form-group">
                    <label for="port">Port</label>
                    <input type="text" class="form-control" id="port" name="port">
                </div>
                <div class="form-group">
                    <label for="bank">Banque</label>
                    <input type="text" class="form-control" id="bank" name="bank">
                </div>
                <div class="form-group">
                    <label for="date_declaration">Date de Déclaration</label>
                    <input type="date" class="form-control" id="date_declaration" name="date_declaration">
                </div>
            </div>

            <!-- Deuxième carte : Sections de paiement -->
            <div class="card">
                <h4>Sections de paiement</h4>
                @foreach(['recette_finance', 'douane', 'timbrage_et_avances_surestarie', 'stam', 'assurance'] as $section)
                    <div class="form-group">

                        <input type="checkbox" class="form-check-input" id="{{ $section }}_preparer_paiement" name="{{ $section }}_preparer_paiement" value="1">
                        <label class="form-check-label" for="{{ $section }}_preparer_paiement">{{ ucfirst(str_replace('_', ' ', $section)) }}</label>
                    </div>
                    <div class="form-group">
                        <label for="{{ $section }}_montant">Montant</label>
                        <input type="number" class="form-control" id="{{ $section }}_montant" name="{{ $section }}_montant">
                    </div>
                    <div class="form-group">
                        <label for="{{ $section }}_ref_mdp">Référence MDP</label>
                        <input type="text" class="form-control" id="{{ $section }}_ref_mdp" name="{{ $section }}_ref_mdp">
                    </div>
                @endforeach
            </div>

            <!-- Troisième carte : Informations supplémentaires -->
            <div class="card">
                <h4>Informations supplémentaires</h4>
                <div class="form-group">
                    <label for="assureur">Assureur</label>
                    <input type="text" class="form-control" id="assureur" name="assureur">
                </div>
                <div class="form-group">
                    <label for="date_expiration">Date d'Expiration</label>
                    <input type="date" class="form-control" id="date_expiration" name="date_expiration">
                </div>
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="number" class="form-control" id="total" name="total">
                </div>
                <div class="form-group">
                    <label for="date_recuperation">Date de Récupération</label>
                    <input type="date" class="form-control" id="date_recuperation" name="date_recuperation">
                </div>
                <div class="form-group">
                    <label for="date_enlevement">Date d'Enlèvement</label>
                    <input type="date" class="form-control" id="date_enlevement" name="date_enlevement">
                </div>
                <div class="form-group">
                    <label for="BL">BL</label>
                    <input type="text" class="form-control" id="BL" name="BL">
                </div>
            </div>
        </div>

        <input type="hidden" name="validation_transit" value="en attente">
        <input type="hidden" name="statut_finance" value="non_entame">
        <input type="hidden" name="validation_finance" value="en attente">

        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
@endsection
