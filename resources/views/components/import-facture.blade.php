<!-- resources/views/components/import-facture.blade.php -->
<style>
    .import-facture-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 100%;
    }

    .import-export-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-import {
        background-color: #28a745;
        color: white;
    }

    .btn-import:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-import i {
        margin-right: 8px;
    }

    .btn-export {
        background-color: #17a2b8;
        color: white;
    }

    .btn-export:hover {
        background-color: #138496;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-export i {
        margin-right: 8px;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-dialog {
        max-width: 600px;
        margin: 1.75rem auto;
    }

    .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-title {
        font-weight: 600;
        font-size: 18px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel {
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .btn-cancel:hover {
        background-color: #e2e6ea;
    }

    .btn-submit {
        background-color: #007bff;
        color: white;
    }

    .btn-submit:hover {
        background-color: #0069d9;
    }

    /* File Upload Styles */
    .file-upload-wrapper {
        margin-bottom: 20px;
    }

    .file-upload-content {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .file-upload-content:hover {
        border-color: #F4A261; /* Nouvelle couleur au hover, cohérente avec le design */
        background-color: #2A4B67;

    }

    .file-upload-input {
        display: block;
        width: 100%;
        padding: 10px;
        margin: 15px 0;
        border: 1px solid #ced4da;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .file-upload-input:hover {
        border-color: #F4A261; /* Remplace #80bdff par une couleur plus chaude et visible */
    }

    .file-upload-input:focus {
        border-color: #F4A261; /* Cohérence avec le hover */
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(244, 162, 97, 0.25); /* Ombre assortie */
    }

    .file-requirements {
        text-align: left;
        padding: 15px;
        border-radius: 6px;
        margin-top: 20px;
    }

    .file-requirements h6 {
        color: #E76F51;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .required-columns {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 12px;
        background-color: #e9ecef;
        color: #495057;
        position: relative;
    }

    .badge:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        margin-bottom: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px;
            max-width: calc(100% - 20px);
        }
        
        .import-export-buttons {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="import-facture-container">
    <div class="import-export-buttons">
        <div class="import-btn-container">
            <button class="btn btn-import" id="openImportModalBtn">
                <i class="fas fa-file-excel"></i> Importer Excel
            </button>
        </div>
        
        <div class="export-btn-container" style="display: none;">
            <button class="btn btn-export">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
    </div>

    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="importExcelModalLabel">
                        <i class="fas fa-file-import me-2"></i> Importer des factures
                    </h5>
                </div>
                <form action="{{ route('facture.complimentaire.thon.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="file-upload-wrapper">
                            <div class="file-upload-content">
                                <label for="excel_file" class="form-label">Sélectionnez un fichier Excel</label>
                                <input type="file" class="form-control file-upload-input" id="excel_file" name="excel_file" accept=".xlsx, .xls" required>
                                <div class="file-requirements mt-3">
                                    <h6><i class="fas fa-info-circle text-primary me-2"></i>Format requis :</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Extensions : .xlsx ou .xls</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i>Colonnes obligatoires :</li>
                                    </ul>
                                    <div class="required-columns">
                                        <span class="badge bg-light text-dark me-2 mb-2">facture</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">num_conteneur</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">fournisseur</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">armateur</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">incoterm</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">port</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">bank</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">date_declaration</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">assureur</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">date_expiration</span>
                                        <span class="badge bg-light text-dark me-2 mb-2">BL</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" id="cancelImportBtn">
                            <i class="fas fa-times me-2"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-upload me-2"></i> Importer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('importExcelModal');
    const openBtn = document.getElementById('openImportModalBtn');
    const cancelBtn = document.getElementById('cancelImportBtn');

    openBtn.addEventListener('click', function() {
        modal.style.display = 'block';
        document.body.classList.add('modal-open');
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
    });

    function closeModal() {
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }

    cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    const fileInput = document.getElementById('excel_file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                this.classList.add('file-selected');
            }
        });
    }

    const badges = document.querySelectorAll('.required-columns .badge');
    badges.forEach(badge => {
        badge.setAttribute('title', 'Colonne obligatoire');
    });

    function toggleExportButton(show = false) {
        const exportContainer = document.querySelector('.export-btn-container');
        if (exportContainer) {
            exportContainer.style.display = show ? 'block' : 'none';
        }
    }

    toggleExportButton(false);
});
<<<<<<< HEAD
</script>
=======
</script>
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
