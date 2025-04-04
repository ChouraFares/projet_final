@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Assurance Flotte')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Styles personnalisés -->
<style>
    :root {
        --primary-color: #887630;
        --secondary-color: #F4A261;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --info-color: #2980b9;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .container {
        max-width: 100%;
        padding: 2rem;
        margin: 0 auto;
    }

    .page-title {
        color: var(--secondary-color);
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--light-color);
        font-size: 1.8rem;
    }

    /* Badges de statut */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    /* Styles pour les différents avancements */
    .status-avant-constat {
        background-color: #E2F0FD;
        color: #0A58CA;
        border: 1px solid #B6D4FE;
    }

    .status-constat-depose {
        background-color: #D1E7DD;
        color: #0F5132;
        border: 1px solid #BADBCC;
    }

    .status-expert {
        background-color: #FFF3CD;
        color: #664D03;
        border: 1px solid #FFECB5;
    }

    .status-attente-remboursement {
        background-color: #F8D7DA;
        color: #842029;
        border: 1px solid #F5C2C7;
    }

    .status-en-cours {
        background-color: #FFF3CD;
        color: #856404;
        border: 1px solid #FFEEBA;
    }

    .status-cloture {
        background-color: #D4EDDA;
        color: #155724;
        border: 1px solid #C3E6CB;
    }

    /* Tableau */
    #sinistresTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1rem;
    }

    #sinistresTable thead th {
        background-color: var(--secondary-color);
        color: white;
        font-weight: 600;
        position: sticky;
        top: 0;
        padding: 1rem;
        border: none;
    }

    #sinistresTable tbody td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
    }

    #sinistresTable tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    /* Footer avec filtres alignés */
    #sinistresTable tfoot {
        background-color: #f8f9fa;
    }

    #sinistresTable tfoot th {
        padding: 0.5rem 1rem;
        vertical-align: middle;
        border-top: 2px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
    }

    #sinistresTable tfoot input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ced4da;
        border-radius: var(--border-radius);
        font-size: 0.9rem;
        box-sizing: border-box;
    }

    /* Boutons d'action */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: #b9a44e;
        border-color: #b9a44e;
    }

    .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* Cellule d'actions */
    .actions-cell {
        white-space: nowrap;
    }

    .actions-cell .action-btns {
        display: flex;
        gap: 0.5rem;
    }

    /* Fichiers PDF */
    .pdf-link {
        color: var(--danger-color);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: var(--transition);
    }

    .pdf-link:hover {
        color: #c0392b;
        text-decoration: underline;
    }

    /* Commentaire */
    .comment-cell {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Icônes spécifiques */
    .fa-hourglass-half { color: #856404; }
    .fa-check-circle { color: #155724; }
    .fa-file-pdf { color: var(--danger-color); }
    .fa-file-contract { color: #0A58CA; }
    .fa-file-signature { color: #0F5132; }
    .fa-user-tie { color: #664D03; }
    .fa-coins { color: #842029; }

    /* Export buttons */
    .dt-buttons .btn {
        margin-right: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .container {
            padding: 1rem;
        }
        
        #sinistresTable thead {
            display: none;
        }
        
        #sinistresTable tbody td {
            display: block;
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-bottom: 1px solid #eee;
        }
        
        #sinistresTable tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: calc(50% - 1rem);
            padding-right: 1rem;
            text-align: left;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .actions-cell .action-btns {
            justify-content: flex-end;
        }
    }
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="page-title">
        <i class="fas fa-file-contract me-2"></i>Gestion des Sinistres - Assurance Flotte
    </h2>

    <div class="action-buttons">
        <a href="{{ route('admin.assurance.flotte.sinistres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Sinistre
        </a>
        
        <div id="exportButtons" class="d-flex gap-2"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Compagnie</th>
                <th>Immatriculation</th>
                <th>Véhicule</th>
                <th>Chauffeur</th>
                <th>Fautif</th>
                <th>Date Sinistre</th>
                <th>Nature</th>
                <th>Avancements</th>
                <th>Statut</th>
                <th>Clôture</th>
                <th>Règlement</th>
                <th>Expert</th>
                <th>Documents</th>
                <th>Commentaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td data-label="Numéro">{{ $sinistre->sinistre_num }}</td>
                <td data-label="Compagnie">{{ $sinistre->compagnie_assurance }}</td>
                <td data-label="Immatriculation">{{ $sinistre->immatriculation }}</td>
                <td data-label="Véhicule">{{ $sinistre->vehicule }}</td>
                <td data-label="Chauffeur">{{ $sinistre->chauffeur }}</td>
                <td data-label="Fautif">{{ $sinistre->fautif ?? 'N/A' }}</td>
                <td data-label="Date Sinistre">{{ $sinistre->date_sinistre->format('d/m/Y') }}</td>
                <td data-label="Nature">{{ $sinistre->nature_sinistre }}</td>
                <td data-label="Avancements">
                    @switch($sinistre->avancements)
                        @case('Avant Constat')
                            <span class="status-badge status-avant-constat">
                                <i class="fas fa-file-contract me-1"></i> Avant Constat
                            </span>
                            @break
                        @case('Constat Déposé')
                            <span class="status-badge status-constat-depose">
                                <i class="fas fa-file-signature me-1"></i> Constat Déposé
                            </span>
                            @break
                        @case('Expert')
                            <span class="status-badge status-expert">
                                <i class="fas fa-user-tie me-1"></i> Expert
                            </span>
                            @break
                        @case('En Attente Du Remboursement')
                            <span class="status-badge status-attente-remboursement">
                                <i class="fas fa-coins me-1"></i> En Attente
                            </span>
                            @break
                        @default
                            <span class="status-badge">{{ $sinistre->avancements }}</span>
                    @endswitch
                </td>
                <td data-label="Statut">
                    @if($sinistre->statut == 'En Cours')
                        <span class="status-badge status-en-cours">
                            <i class="fas fa-hourglass-half me-1"></i> En Cours
                        </span>
                    @else
                        <span class="status-badge status-cloture">
                            <i class="fas fa-check-circle me-1"></i> Clôturé
                        </span>
                    @endif
                </td>
                <td data-label="Clôture">
                    {{ $sinistre->date_cloture_dossier ? $sinistre->date_cloture_dossier->format('d/m/Y') : '-' }}
                </td>
                <td data-label="Règlement">{{ $sinistre->reglement ?? 'N/A' }}</td>
                <td data-label="Expert">{{ $sinistre->Expert ?? 'N/A' }}</td>
                <td data-label="Documents">
                    @if($sinistre->attachments_pdf)
                        <a href="{{ Storage::url($sinistre->attachments_pdf) }}" class="pdf-link" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                    @else
                        <span class="text-muted">Aucun</span>
                    @endif
                </td>
                <td data-label="Commentaire" class="comment-cell" title="{{ $sinistre->commentaire ?? '' }}">
                    {{ $sinistre->commentaire ? Str::limit($sinistre->commentaire, 30) : 'Aucun' }}
                </td>
                <td data-label="Actions" class="actions-cell">
                    <div class="action-btns">
                        <a href="{{ route('admin.assurance.flotte.sinistres.edit', $sinistre->id) }}" 
                           class="btn btn-warning btn-sm" 
                           data-bs-toggle="tooltip" 
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.assurance.flotte.sinistres.destroy', $sinistre->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm" 
                                    data-bs-toggle="tooltip" 
                                    title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th><input type="text" placeholder="Filtrer Numéro" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Compagnie" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Immatriculation" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Véhicule" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Chauffeur" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Fautif" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Date" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Nature" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Avancements" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Statut" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Clôture" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Règlement" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Expert" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Documents" class="form-control form-control-sm" /></th>
                <th><input type="text" placeholder="Filtrer Commentaire" class="form-control form-control-sm" /></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#sinistresTable').DataTable({
        scrollX: true,
        responsive: true,
        dom: '<"top"lBf>rt<"bottom"ip>',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        pageLength: 25,
        language: {
            lengthMenu: "Afficher _MENU_ enregistrements",
            search: "_INPUT_",
            searchPlaceholder: "Rechercher...",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
            infoEmpty: "Aucun enregistrement disponible",
            infoFiltered: "(filtré de _MAX_ enregistrements au total)",
            paginate: {
                first: "Premier",
                last: "Dernier",
                next: "Suivant",
                previous: "Précédent"
            }
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible:not(:last-child)',
                    format: {
                        body: function(data, row, column, node) {
                            // Nettoyer les données pour l'export
                            return $(node).text().trim() || data;
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                },
                customize: function(doc) {
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 9;
                    doc.pageMargins = [20, 40, 20, 40];
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('auto');
                }
            }
        ],
        initComplete: function() {
            this.api().buttons().container().appendTo('#exportButtons');
            
            // Appliquer la recherche
            this.api().columns().every(function() {
                var column = this;
                var header = $(column.header());
                
                if (header.text() !== 'Actions') {
                    $('input', column.footer()).on('keyup change', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });
        }
    });

    // Initialiser les tooltips
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
});
</script>

@endsection