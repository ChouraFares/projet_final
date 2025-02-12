@extends('layouts.app')

@section('title', 'Modifier une Facture Complémentaire Thon')

@section('content')
<div class="container">
    <h2>Modifier une Facture Complémentaire Thon</h2>

    <form action="{{ route('facture.complimentaire.thon.update', $facture->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Première carte : Informations de base -->
            <div class="col-md-4">
                <div class="card">
                    <h4>Informations de base</h4>
                    <div class="form-group">
                        <label>Date et Heure de la Demande</label>
                        <input type="text" class="form-control" value="{{ $facture->date_demande ? $facture->date_demande->format('Y-m-d H:i:s') : 'Non définie' }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="facture">Facture</label>
                        <input type="text" class="form-control @error('facture') is-invalid @enderror" id="facture" name="facture" value="{{ old('facture', $facture->facture) }}">
                        @error('facture') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="fournisseur">Fournisseur</label>
                        <input type="text" class="form-control @error('fournisseur') is-invalid @enderror" id="fournisseur" name="fournisseur" value="{{ old('fournisseur', $facture->fournisseur) }}">
                        @error('fournisseur') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="armateur">Armateur</label>
                        <input type="text" class="form-control @error('armateur') is-invalid @enderror" id="armateur" name="armateur" value="{{ old('armateur', $facture->armateur) }}">
                        @error('armateur') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="incoterm">Incoterm</label>
                        <input type="text" class="form-control @error('incoterm') is-invalid @enderror" id="incoterm" name="incoterm" value="{{ old('incoterm', $facture->incoterm) }}">
                        @error('incoterm') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="text" class="form-control @error('port') is-invalid @enderror" id="port" name="port" value="{{ old('port', $facture->port) }}">
                        @error('port') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="bank">Banque</label>
                        <input type="text" class="form-control @error('bank') is-invalid @enderror" id="bank" name="bank" value="{{ old('bank', $facture->bank) }}">
                        @error('bank') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_declaration">Date de Déclaration</label>
                        <input type="date" class="form-control @error('date_declaration') is-invalid @enderror" id="date_declaration" name="date_declaration" value="{{ old('date_declaration', $facture->date_declaration) }}">
                        @error('date_declaration') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Deuxième carte : Gestion des chèques -->
            <div class="col-md-4">
                <div class="card">
                    <h4>Gestion des chèques</h4>
                    
                    <!-- Section des switches pour les types de paiement -->
                    <div class="form-group">
                        <label>Activer les types de paiement</label>
                        <div class="switch-group">
                            @php
                                $paymentTypes = [
                                    'recette_finance' => 'Recette Finance',
                                    'douane' => 'Douane',
                                    'timbrage_et_avances_surestarie' => 'Timbrage et Avances Surestaries',
                                    'stam' => 'STAM',
                                    'assurance' => 'Assurance'
                                ];
                                
                                $activeTypes = $facture->cheques->pluck('payment_type')->unique()->toArray();
                            @endphp
                            
                            @foreach($paymentTypes as $type => $label)
                                <div class="switch-container">
                                    <label class="switch">
                                        <input type="checkbox" name="payment_types[]" value="{{ $type }}" id="{{ $type }}" 
                                            {{ in_array($type, $activeTypes) ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                    <label for="{{ $type }}" class="switch-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Affichage des chèques existants et nouveaux -->
                    <div id="cheque_container">
                        @foreach($facture->cheques->groupBy('payment_type') as $paymentType => $cheques)
                            <div class="payment-type-section" data-type="{{ $paymentType }}">
                                <h5>{{ ucwords(str_replace('_', ' ', $paymentType)) }}</h5>
                                @foreach($cheques as $index => $cheque)
                                    <div class="cheque-item">
                                        <label>Chèque {{ $index + 1 }} - Montant</label>
                                        <input type="number" name="cheques[{{ $paymentType }}][{{ $cheque->id }}][montant]" 
                                               class="form-control" step="0.01" value="{{ $cheque->montant }}">
                                        <label>Chèque {{ $index + 1 }} - Référence MDP</label>
                                        <input type="text" name="cheques[{{ $paymentType }}][{{ $cheque->id }}][ref_mdp]" 
                                               class="form-control" value="{{ $cheque->ref_mdp }}">
                                        <button type="button" class="btn btn-sm btn-danger remove-cheque" 
                                                data-cheque-id="{{ $cheque->id }}" style="margin-top: 5px;">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                @endforeach
                                
                                <!-- Bouton pour ajouter un nouveau chèque -->
                                <button type="button" class="btn btn-sm btn-primary add-cheque-btn" 
                                        data-payment-type="{{ $paymentType }}" style="margin-top: 10px;">
                                    <i class="fas fa-plus"></i> Ajouter un chèque
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Troisième carte : Informations supplémentaires -->
            <div class="col-md-4">
                <div class="card">
                    <h4>Informations supplémentaires</h4>
                    <div class="form-group">
                        <label for="assureur">Assureur</label>
                        <input type="text" class="form-control @error('assureur') is-invalid @enderror" id="assureur" name="assureur" value="{{ old('assureur', $facture->assureur) }}">
                        @error('assureur') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_expiration">Date d'Expiration</label>
                        <input type="date" class="form-control @error('date_expiration') is-invalid @enderror" id="date_expiration" name="date_expiration" value="{{ old('date_expiration', $facture->date_expiration) }}">
                        @error('date_expiration') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total', $facture->total) }}" step="0.01">
                        @error('total') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_recuperation">Date de Récupération</label>
                        <input type="date" class="form-control @error('date_recuperation') is-invalid @enderror" id="date_recuperation" name="date_recuperation" value="{{ old('date_recuperation', $facture->date_recuperation) }}">
                        @error('date_recuperation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_enlevement">Date d'Enlèvement</label>
                        <input type="date" class="form-control @error('date_enlevement') is-invalid @enderror" id="date_enlevement" name="date_enlevement" value="{{ old('date_enlevement', $facture->date_enlevement) }}">
                        @error('date_enlevement') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gestion des switches pour les types de paiement
    const paymentTypeCheckboxes = document.querySelectorAll('input[name="payment_types[]"]');
    
    paymentTypeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const paymentType = this.value;
            const paymentSection = document.querySelector(`.payment-type-section[data-type="${paymentType}"]`);
            
            if (this.checked && !paymentSection) {
                // Créer une nouvelle section si elle n'existe pas
                createPaymentSection(paymentType);
            } else if (!this.checked && paymentSection) {
                // Supprimer la section si elle existe
                paymentSection.remove();
            }
        });
    });
    
    // Fonction pour créer une nouvelle section de paiement
    function createPaymentSection(paymentType) {
        const container = document.getElementById('cheque_container');
        const section = document.createElement('div');
        section.className = 'payment-type-section';
        section.setAttribute('data-type', paymentType);
        section.innerHTML = `
            <h5>${paymentType.replace(/_/g, ' ').toUpperCase()}</h5>
            <button type="button" class="btn btn-sm btn-primary add-cheque-btn" 
                    data-payment-type="${paymentType}" style="margin-top: 10px;">
                <i class="fas fa-plus"></i> Ajouter un chèque
            </button>
        `;
        container.appendChild(section);
        
        // Ajouter un écouteur d'événement au nouveau bouton
        section.querySelector('.add-cheque-btn').addEventListener('click', addNewCheque);
    }
    
    // Fonction pour ajouter un nouveau chèque
    function addNewCheque() {
        const paymentType = this.getAttribute('data-payment-type');
        const section = document.querySelector(`.payment-type-section[data-type="${paymentType}"]`);
        const timestamp = new Date().getTime();
        
        const chequeItem = document.createElement('div');
        chequeItem.className = 'cheque-item';
        chequeItem.innerHTML = `
            <label>Nouveau Chèque - Montant</label>
            <input type="number" name="cheques[${paymentType}][new_${timestamp}][montant]" 
                   class="form-control" step="0.01" placeholder="Montant" required>
            <label>Nouveau Chèque - Référence MDP</label>
            <input type="text" name="cheques[${paymentType}][new_${timestamp}][ref_mdp]" 
                   class="form-control" placeholder="Référence MDP" required>
            <button type="button" class="btn btn-sm btn-danger remove-cheque" 
                    style="margin-top: 5px;">
                <i class="fas fa-trash"></i> Supprimer
            </button>
        `;
        
        // Insérer avant le bouton "Ajouter un chèque"
        this.parentNode.insertBefore(chequeItem, this);
        
        // Ajouter un écouteur d'événement pour la suppression
        chequeItem.querySelector('.remove-cheque').addEventListener('click', function() {
            chequeItem.remove();
        });
    }
    
    // Gestion des boutons "Ajouter un chèque" existants
    document.querySelectorAll('.add-cheque-btn').forEach(btn => {
        btn.addEventListener('click', addNewCheque);
    });
    
    // Gestion des boutons "Supprimer" pour les chèques existants
    document.querySelectorAll('.remove-cheque').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Voulez-vous vraiment supprimer ce chèque ?')) {
                const chequeId = this.getAttribute('data-cheque-id');
                if (chequeId) {
                    // Pour les chèques existants, ajouter un champ caché pour la suppression
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `cheques[deleted][${chequeId}]`;
                    input.value = '1';
                    this.closest('.payment-type-section').appendChild(input);
                }
                this.closest('.cheque-item').remove();
            }
        });
    });
});
</script>

<style>
    /* Styles des switches */
    .switch-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
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
        background-color: #076ff8;
    }



    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .switch-label {
        font-size: 16px;
        color: #495057;
        cursor: pointer;
    }

    /* Styles des sections de chèques */
    .payment-type-section {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 6px;
    }

    .payment-type-section h5 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #F4A261;
    }

    .cheque-item {
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 6px;
    }

    .cheque-item label {
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
        color: #ffffff;
    }

    .cheque-item input {
        margin-bottom: 10px;
    }

    /* Boutons */
    .btn-sm {
        padding: 5px 10px;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #E76F51;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
        
        .col-md-4 {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>
@endsection
