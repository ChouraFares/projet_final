@extends('layouts.cheque')

@section('title', 'Détails des Chèques')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h2 class="mb-0">
                <i class="fas fa-money-check-alt me-2"></i>
                Détails des Chèques Timbrage & Avance Surestarie pour Num {{ ucfirst(str_replace('_', ' ', $facture->facture ?? 'N/A')) }}
            </h2>
        </div>
        
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover table-bordered align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Numéro de Facture</th>
                            <th class="text-center">Date & Heure</th>
                            <th class="text-center">N° Conteneur</th>
                            <th class="text-center">Fournisseur</th>
                            <th class="text-center">Référence MDP</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Échéance Timbrage</th>
                            <th class="text-center">Montant Retenue à la Source</th>
                            <th class="text-center">État</th>
                            <th class="text-center">Attachement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cheques as $cheque)
                            <tr class="transition-all hover:bg-gray-100" data-cheque-id="{{ $cheque->id }}">
                                <td class="text-center">{{ $cheque->facture?->facture ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $cheque->facture?->date_demande ? \Carbon\Carbon::parse($cheque->facture->date_demande)->addHour()->format('d/m/Y H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $cheque->facture?->num_conteneur ?? 'N/A' }}</td>
                                <td class="text-center">{{ $cheque->facture?->fournisseur ?? 'N/A' }}</td>
                                <td class="text-center">{{ $cheque->ref_mdp }}</td>
                                <td class="text-center">
                                    @if($cheque->montant == 0)
                                        <span class="text-warning fw-bold cheque-blanc">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Chèque Blanc
                                        </span>
                                    @else
                                        <span class="text-success fw-bold">
                                            {{ number_format($cheque->montant, 2, ',', ' ') }} TND
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center position-relative">
                                    <input type="date" class="form-control editable" name="echeance_timbrage" 
                                           value="{{ $cheque->echeance_timbrage ? \Carbon\Carbon::parse($cheque->echeance_timbrage)->format('Y-m-d') : '' }}">
                                    <span class="loading-spinner"></span>
                                </td>
                                <td class="text-center position-relative">
                                    <input type="number" step="0.01" class="form-control editable" name="timbrage_montant_retenue_a_la_source" 
                                           value="{{ $cheque->timbrage_montant_retenue_a_la_source ?? '' }}" placeholder="Montant">
                                    <span class="loading-spinner"></span>
                                </td>
                                <td class="text-center position-relative">
                                    <select class="form-control editable" name="Etat">
                                        <option value="" {{ !$cheque->Etat ? 'selected' : '' }}>N/A</option>
                                        <option value="virement" {{ $cheque->Etat === 'virement' ? 'selected' : '' }}>Virement</option>
                                        <option value="chèque" {{ $cheque->Etat === 'chèque' ? 'selected' : '' }}>Chèque</option>
                                        <option value="traité" {{ $cheque->Etat === 'traité' ? 'selected' : '' }}>Traité</option>
                                    </select>
                                    <span class="loading-spinner"></span>
                                </td>
                                <td class="text-center position-relative">
                                    <div class="attachement-actions d-flex gap-2 justify-content-center align-items-center">
                                        @if($cheque->Attachement_Timbrage)
                                            <a href="{{ asset('storage/' . $cheque->Attachement_Timbrage) }}" class="btn btn-sm btn-download" download>
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button class="btn btn-sm btn-view" data-file="{{ asset('storage/' . $cheque->Attachement_Timbrage) }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                        <label class="file-upload btn btn-sm">
                                            <input type="file" class="editable" name="Attachement_Timbrage" accept=".pdf" style="display: none;">
                                            <i class="fas fa-upload"></i>
                                        </label>
                                    </div>
                                    <span class="loading-spinner"></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">Aucun chèque trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour visualiser le PDF -->
<div class="modal" id="pdfModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Visualisation du fichier</h3>
            <button class="modal-close">×</button>
        </div>
        <div class="modal-body">
            <iframe id="pdfViewer" frameborder="0"></iframe>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #020659;
        --secondary-color: #102D40;
        --accent-color: #F2E205;
        --accent-light: #F2C744;
        --accent-dark: #BF9039;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: var(--secondary-color);
    }

    .card-header {
        background-color: var(--primary-color);
        color: #fff;
        border-radius: 8px 8px 0 0;
    }

    .card-body {
        padding: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table-dark th {
        background-color: var(--secondary-color);
        color: #fff;
    }

    tbody td {
        color: #fff;
        background-color: var(--secondary-color);
    }

    tbody tr:hover {
        background-color: var(--accent-light);
        color: var(--primary-color);
    }

    .editable {
        padding: 6px;
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
        padding: 4px 8px;
        border-radius: 4px;
        color: #fff;
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
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    @keyframes spin {
        to { transform: translateY(-50%) rotate(360deg); }
    }

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
        z-index: 1000;
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

    .modal-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
    }

    .modal-close:hover {
        color: var(--accent-light);
    }

    #pdfViewer {
        width: 100%;
        height: 500px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const viewButtons = document.querySelectorAll('.btn-view');
    const pdfModal = document.getElementById('pdfModal');
    const pdfViewer = document.getElementById('pdfViewer');
    const modalClose = document.querySelector('.modal-close');
    const editables = document.querySelectorAll('.editable');

    viewButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const fileUrl = button.getAttribute('data-file');
            pdfViewer.src = fileUrl;
            pdfModal.style.display = 'flex';
        });
    });

    modalClose.addEventListener('click', () => {
        pdfModal.style.display = 'none';
        pdfViewer.src = '';
    });

    pdfModal.addEventListener('click', (e) => {
        if (e.target === pdfModal) {
            pdfModal.style.display = 'none';
            pdfViewer.src = '';
        }
    });

    editables.forEach(input => {
        input.addEventListener('change', function () {
            const tr = this.closest('tr');
            const chequeId = tr.getAttribute('data-cheque-id');
            const spinner = tr.querySelector(`[name="${this.name}"]`).parentElement.querySelector('.loading-spinner');

            spinner.style.display = 'block';
            this.disabled = true;

            const formData = new FormData();
            formData.append('cheque_id', chequeId);
            formData.append('_token', '{{ csrf_token() }}');

            // Récupérer tous les champs éditables de la ligne
            const allEditables = tr.querySelectorAll('.editable');
            allEditables.forEach(field => {
                if (field.name === 'Attachement_Timbrage' && field.files && field.files.length > 0) {
                    formData.append('Attachement_Timbrage', field.files[0]);
                } else if (field.name !== 'Attachement_Timbrage') {
                    formData.append(field.name, field.value || '');
                }
            });

            // Débogage des données envoyées
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            axios.post('/update-cheque-timbrage', formData)
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

                    if (response.data.file_url) {
                        const actions = tr.querySelector('.attachement-actions');
                        actions.innerHTML = `
                            <a href="${response.data.file_url}" class="btn btn-sm btn-download" download>
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn btn-sm btn-view" data-file="${response.data.file_url}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <label class="file-upload btn btn-sm">
                                <input type="file" class="editable" name="Attachement_Timbrage" accept=".pdf" style="display: none;">
                                <i class="fas fa-upload"></i>
                            </label>
                        `;
                        actions.querySelector('.btn-view').addEventListener('click', (e) => {
                            e.preventDefault();
                            pdfViewer.src = response.data.file_url;
                            pdfModal.style.display = 'flex';
                        });
                    }
                })
                .catch(error => {
                    spinner.style.display = 'none';
                    this.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: error.response?.data?.message || 'Une erreur est survenue',
                        confirmButtonColor: '#dc3545'
                    });
                });
        });
    });
});
</script>
@endsection