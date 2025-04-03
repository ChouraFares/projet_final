@extends('layouts.cheque')

@section('title', 'Détails des Chèques Assurance')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h2 class="mb-0">
                <i class="fas fa-money-check-alt me-2"></i>
                Détails Des Chèques Pour {{ ucfirst(str_replace('_', ' ', $type)) }}
            </h2>
        </div>
        
        <div class="card-body">
       
            
            

            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover table-bordered align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Numéro de Facture</th>
                            <th class="text-center">Date & Heure d'Envoi</th>
                            <th class="text-center">N° Conteneur</th>
                            <th class="text-center">Référence MDP</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Date Expiration</th>
                            <th class="text-center">Numéro Aliment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cheques as $cheque)
                            <tr class="transition-all hover:bg-gray-100" data-cheque-id="{{ $cheque->id }}">
                                <td class="text-center">{{ $facture->facture }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $facture->date_demande->addHour()->format('d/m/Y H:i:s') }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $facture->num_conteneur }}</td>
                                <td class="text-center">{{ $cheque->ref_mdp }}</td>
                                <td class="text-center">
                                    @if($cheque->montant == 0)
                                        <span class="text-warning fw-bold cheque-blanc">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Chèque Blanc
                                        </span>
                                    @else
                                        <span class="text-success fw-bold">
                                            {{ number_format($cheque->montant, 2) }} TND
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center position-relative">
                                    <input type="date" class="form-control editable" name="date_expiration_assurance" 
                                           value="{{ $cheque->date_expiration_assurance ? \Carbon\Carbon::parse($cheque->date_expiration_assurance)->format('Y-m-d') : '' }}">
                                    <span class="loading-spinner" style="display: none;"></span>
                                </td>
                                <td class="text-center position-relative">
                                    <input type="text" class="form-control editable" name="numero_aliment_assurance" 
                                           value="{{ $cheque->numero_aliment_assurance ?? '' }}">
                                    <span class="loading-spinner" style="display: none;"></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Aucun chèque trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Couleurs principales */
    :root {
        --primary-color: #020659;
        --secondary-color: #102D40;
        --accent-color: #F2E205;
        --accent-light: #F2C744;
        --accent-dark: #BF9039;
    }

    /* Styles généraux */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: var(--secondary-color);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: var(--primary-color);
        color: #fff;
        padding: 20px;
        border-radius: 8px 8px 0 0;
        text-align: center;
    }

    .card-header h2 {
        margin: 0;
        font-size: 24px;
    }

    .card-body {
        padding: 20px;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: var(--secondary-color);
        color: #fff;
    }

    /* Ajout pour rendre le texte du tbody blanc */
    tbody td {
        color: #fff;
        background-color: var(--secondary-color); /* Fond sombre pour contraste */
    }

    tbody tr:hover {
        background-color: var(--accent-light); /* Couleur claire au survol */
        color: var(--primary-color); /* Texte sombre au survol pour lisibilité */
    }

    .editable {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .editable:focus {
        border-color: var(--accent-color);
        outline: none;
    }

    .cheque-blanc {
        background-color: #f67a84;
        border: 1px solid #dc3545;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        color: #fff;
    }

    .montant {
        color: var(--accent-dark);
        font-weight: bold;
    }

    .attachement-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-download, .btn-view {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .btn-download {
        background-color: var(--accent-light);
        color: var(--primary-color);
    }

    .btn-view {
        background-color: var(--accent-color);
        color: var(--primary-color);
    }

    .btn-download:hover, .btn-view:hover {
        opacity: 0.9;
    }

    .loading-spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid var(--accent-color);
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #fff; /* Changé en blanc pour cohérence */
        background-color: var(--secondary-color); /* Fond sombre */
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 8px;
        width: 80%;
        max-width: 800px;
    }

    .modal-header {
        background-color: var(--primary-color);
        color: #fff;
        padding: 16px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
    }

    .modal-body {
        padding: 20px;
    }

    iframe {
        width: 100%;
        height: 500px;
        border: none;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Configurer Axios avec le token CSRF
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    const inputs = document.querySelectorAll('.editable');

    inputs.forEach(input => {
        input.addEventListener('change', function () {
            const tr = this.closest('tr');
            const chequeId = tr.getAttribute('data-cheque-id');
            const dateExpirationInput = tr.querySelector('input[name="date_expiration_assurance"]');
            const numeroAlimentInput = tr.querySelector('input[name="numero_aliment_assurance"]');
            const spinner = this.nextElementSibling;

            const dateExpirationValue = dateExpirationInput.value;
            const numeroAlimentValue = numeroAlimentInput.value;

            spinner.style.display = 'block';
            this.disabled = true;

            axios.post('/update-cheque-assurance', {
                cheque_id: chequeId,
                date_expiration_assurance: dateExpirationValue,
                numero_aliment_assurance: numeroAlimentValue
            })
            .then(response => {
                spinner.style.display = 'none';
                this.disabled = false;

                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: response.data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .catch(error => {
                spinner.style.display = 'none';
                this.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: error.response?.data?.error || 'Une erreur est survenue',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    });
});
</script>
@endsection