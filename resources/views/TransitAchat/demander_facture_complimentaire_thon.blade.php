@extends('layouts.app')

@section('title', 'Demander une Facture Complémentaire Thon')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <h2>Demander une Facture Complémentaire Thon</h2>
  
    <form action="{{ route('facture.complimentaire.thon.demander_prepayement', $facture->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Première carte : Informations de base -->
            <div class="col-md-4">
                <div class="card">
                    <h4>Informations de base</h4>
                
                    <div class="form-group">
                        <label for="facture">Facture</label>
                        <input type="text" class="form-control" id="facture" name="facture" value="{{ $facture->facture }}">
                    </div>

                    <div class="form-group">
                        <label for="fournisseur">Fournisseur</label>
                        <input type="text" class="form-control" id="fournisseur" name="fournisseur" value="{{ $facture->fournisseur }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="armateur">Armateur</label>
                        <input type="text" class="form-control" id="armateur" name="armateur" value="{{ $facture->armateur }}">
                    </div>
                    <div class="form-group">
                        <label for="incoterm">Incoterm</label>
                        <input type="text" class="form-control" id="incoterm" name="incoterm" value="{{ $facture->incoterm }}">
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="text" class="form-control" id="port" name="port" value="{{ $facture->port }}">
                    </div>
                    <div class="form-group">
                        <label for="bank">Banque</label>
                        <input type="text" class="form-control" id="bank" name="bank" value="{{ $facture->bank }}">
                    </div>
                    <div class="form-group">
                        <label for="date_declaration">Date de Déclaration</label>
                        <input type="date" class="form-control" id="date_declaration" name="date_declaration" value="{{ $facture->date_declaration }}">
                    </div>
                </div>
            </div>

            <!-- Deuxième carte : Sections de paiement -->
            <div class="col-md-4">
                <div class="card">
                    <h4>Sections de paiement</h4>
                    <div class="form-group">
                        <label>Type de demande de paiement</label>
                        <div class="switch-group">
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" name="payment_types[]" value="recette_finance" id="recette_finance">
                                    <span class="slider round"></span>
                                </label>
                                <label for="recette_finance" class="switch-label">Recette Finance</label>
                            </div>
                            
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" name="payment_types[]" value="douane" id="douane">
                                    <span class="slider round"></span>
                                </label>
                                <label for="douane" class="switch-label">Douane</label>
                            </div>
                            
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" name="payment_types[]" value="timbrage_et_avances_surestarie" id="timbrage_et_avances_surestarie">
                                    <span class="slider round"></span>
                                </label>
                                <label for="timbrage_et_avances_surestarie" class="switch-label">Timbrage et avances surestaries</label>
                            </div>
                            
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" name="payment_types[]" value="stam" id="stam">
                                    <span class="slider round"></span>
                                </label>
                                <label for="stam" class="switch-label">STAM</label>
                            </div>
                            
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" name="payment_types[]" value="assurance" id="assurance">
                                    <span class="slider round"></span>
                                </label>
                                <label for="assurance" class="switch-label">Assurance</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Champs pour le nombre de chèques par type de paiement -->
                    <div id="cheque_inputs"></div>
            
                    <div id="payment_sections"></div> <!-- Conteneur pour les champs dynamiques -->
                </div>
            </div>

            <!-- Troisième carte : Informations supplémentaires -->
            <div class="col-md-4">
                <div class="card">
                    <h4>Informations supplémentaires</h4>
                    <div class="form-group">
                        <label for="assureur">Assureur</label>
                        <input type="text" class="form-control" id="assureur" name="assureur" value="{{ $facture->assureur }}">
                    </div>
                    <div class="form-group">
                        <label for="date_expiration">Date d'Expiration</label>
                        <input type="date" class="form-control" id="date_expiration" name="date_expiration" value="{{ $facture->date_expiration }}">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" class="form-control" id="total" name="total" value="{{ $facture->total }}" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="date_recuperation">Date de Récupération</label>
                        <input type="date" class="form-control" id="date_recuperation" name="date_recuperation" value="{{ $facture->date_recuperation }}">
                    </div>
                    <div class="form-group">
                        <label for="date_enlevement">Date d'Enlèvement</label>
                        <input type="date" class="form-control" id="date_enlevement" name="date_enlevement" value="{{ $facture->date_enlevement }}">
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="validation_transit" value="{{ $facture->validation_transit }}">
        <input type="hidden" name="statut_finance" value="{{ $facture->statut_finance }}">
        <input type="hidden" name="validation_finance" value="{{ $facture->validation_finance }}">

        <button type="submit" class="btn btn-primary mt-3">Demander</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentTypeCheckboxes = document.querySelectorAll('input[name="payment_types[]"]');
    const chequeInputsDiv = document.getElementById('cheque_inputs');

    paymentTypeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updateChequeInputs();
        });
    });

    function updateChequeInputs() {
        chequeInputsDiv.innerHTML = '';
        const selectedTypes = Array.from(paymentTypeCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        selectedTypes.forEach(type => {
            const typeDiv = document.createElement('div');
            typeDiv.className = 'payment-type-section';
            typeDiv.innerHTML = `
                <h5>${type.replace(/_/g, ' ').toUpperCase()}</h5>
                <label>Nombre de chèques pour ${type}</label>
                <input type="number" name="cheque_count[${type}]" class="form-control cheque-count" min="1" value="1" data-type="${type}">
                <div class="cheque-details" id="cheque_details_${type}"></div>
            `;
            chequeInputsDiv.appendChild(typeDiv);

            const countInput = typeDiv.querySelector('.cheque-count');
            countInput.addEventListener('input', () => updateChequeDetails(type));
            updateChequeDetails(type); // Initial call
        });
    }

    function updateChequeDetails(type) {
        const countInput = document.querySelector(`input[name="cheque_count[${type}]"]`);
        const count = parseInt(countInput.value) || 0;
        const chequeDetailsDiv = document.getElementById(`cheque_details_${type}`);
        chequeDetailsDiv.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            const chequeItem = document.createElement('div');
            chequeItem.className = 'cheque-item';
            chequeItem.innerHTML = `
                <label>Chèque ${i} - Montant</label>
                <input type="number" name="cheques[${type}][${i}][montant]" class="form-control" step="0.01" placeholder="Montant du chèque ${i}">
                <label>Chèque ${i} - Référence MDP</label>
                <input type="text" name="cheques[${type}][${i}][ref_mdp]" class="form-control" placeholder="Référence MDP du chèque ${i}">
            `;
            chequeDetailsDiv.appendChild(chequeItem);
        }
    }
});
</script>

<style>
    /* Conteneur principal */
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 30px;
    }

    /* Titre principal */
    h2 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 30px;
        color: #F4A261;
    }

    /* Conteneur des cartes */
    .row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    /* Carte individuelle */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 25px;
        flex: 1;
    }

    /* Titre des cartes */
    h4 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 20px;
        color: #887630;
    }

    /* Groupes de formulaire */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 8px;
        color: #fbfbfb;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        transition: all 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    /* Style des switches */
    .switch-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .switch-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #3498db;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #3498db;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .switch-label {
        font-size: 16px;
        color: #34495e;
        cursor: pointer;
    }

    /* Bouton de soumission */
    .btn-primary {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

 
    /* Section des chèques */
    .payment-type-section {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 6px;
    }

    .payment-type-section h5 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #887630;
    }

    .cheque-details {
        margin-top: 10px;
    }

    .cheque-item {
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .cheque-item label {
        display: block;
        font-size: 16px;
        margin-bottom: 8px;
        color: #fcfcfc;
    }

    .cheque-item input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .row {
            flex-direction: column;
        }
        
        .card {
            margin-bottom: 20px;
        }
    }
</style>
@endsection
