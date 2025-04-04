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
        --secondary-color: #000000;
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
        color: #f39c12;
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

    /* Styles pour les avancements */
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

    /* Styles pour Statut */
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

    /* Styles pour Nature du Sinistre */
    .status-connexe {
        background-color: #D1ECF1;
        color: #0C5460;
        border: 1px solid #BEE5EB;
    }

    .status-recours {
        background-color: #F8D7DA;
        color: #842029;
        border: 1px solid #F5C2C7;
    }

    .status-incendie {
        background-color: #FFD8D8;
        color: #721C24;
        border: 1px solid #FDA4AF;
    }

    .status-dommage-collision {
        background-color: #FFE8CC;
        color: #8A5522;
        border: 1px solid #FFD8A8;
    }

    .status-bris-de-glace {
        background-color: #E9ECEF;
        color: #495057;
        border: 1px solid #CED4DA;
    }

    /* Tableau */
    #sinistresTable {
        width: 100% !important;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    #sinistresTable thead th {
        background-color: var(--secondary-color);
        color: white;
        font-weight: 600;
        position: sticky;
        top: 0;
        padding: 1rem;
        border-bottom: 2px solid #ddd;
        text-align: left;
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
    #sinistresTable tfoot th {
        padding: 0.5rem 1rem;
        border-top: 2px solid #dee2e6;
        background-color: #f8f9fa;
        text-align: left;
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
    .actions-cell .action-btns {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    /* Fichiers PDF */
    .pdf-link {
        color: var(--danger-color);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
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
    .fa-link { color: #0C5460; } /* Connexe */
    .fa-gavel { color: #842029; } /* Recours */
    .fa-fire { color: #721C24; } /* Incendie */
    .fa-car-crash { color: #8A5522; } /* Dommage Collision */
    .fa-shield-alt { color: #495057; } /* Bris de Glace */
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="page-title">
     Gestion des Sinistres - Assurance Flotte
    </h2>

    <div class="action-buttons">
        <a href="{{ route('admin.assurance.flotte.sinistres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Sinistre
        </a>
        <div id="exportButtons" class="d-flex gap-2"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered">
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
                <td>{{ $sinistre->sinistre_num }}</td>
                <td>{{ $sinistre->compagnie_assurance }}</td>
                <td>{{ $sinistre->immatriculation }}</td>
                <td>{{ $sinistre->vehicule }}</td>
                <td>{{ $sinistre->chauffeur }}</td>
                <td>{{ $sinistre->fautif ?? 'N/A' }}</td>
                <td>{{ $sinistre->date_sinistre->format('d/m/Y') }}</td>
                <td>
                    @switch($sinistre->nature_sinistre)
                        @case('Connexe')
                            <span class="status-badge status-connexe">
                                <i class="fas fa-link me-1"></i> Connexe
                            </span>
                            @break
                        @case('Recours')
                            <span class="status-badge status-recours">
                                <i class="fas fa-gavel me-1"></i> Recours
                            </span>
                            @break
                        @case('Incendie')
                            <span class="status-badge status-incendie">
                                <i class="fas fa-fire me-1"></i> Incendie
                            </span>
                            @break
                        @case('Dommage Collision')
                            <span class="status-badge status-dommage-collision">
                                <i class="fas fa-car-crash me-1"></i> Dommage Collision
                            </span>
                            @break
                        @case('Bris de Glace')
                            <span class="status-badge status-bris-de-glace">
                                <i class="fas fa-shield-alt me-1"></i> Bris de Glace
                            </span>
                            @break
                        @default
                            <span class="status-badge">{{ $sinistre->nature_sinistre }}</span>
                    @endswitch
                </td>
                <td>
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
                <td>
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
                <td>{{ $sinistre->date_cloture_dossier ? $sinistre->date_cloture_dossier->format('d/m/Y') : '-' }}</td>
                <td>{{ $sinistre->reglement ?? 'N/A' }}</td>
                <td>{{ $sinistre->Expert ?? 'N/A' }}</td>
                <td>
                    @if($sinistre->attachments_pdf)
                        <a href="{{ Storage::url($sinistre->attachments_pdf) }}" class="pdf-link" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                    @else
                        <span class="text-muted">Aucun</span>
                    @endif
                </td>
                <td class="comment-cell" title="{{ $sinistre->commentaire ?? '' }}">
                    {{ $sinistre->commentaire ? Str::limit($sinistre->commentaire, 30) : 'Aucun' }}
                </td>
                <td class="actions-cell">
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
                <th><input type="text" placeholder="Rechercher Numéro" /></th>
                <th><input type="text" placeholder="Compagnie" /></th>
                <th><input type="text" placeholder="Immatriculation" /></th>
                <th><input type="text" placeholder="Véhicule" /></th>
                <th><input type="text" placeholder="Chauffeur" /></th>
                <th><input type="text" placeholder="Fautif" /></th>
                <th><input type="text" placeholder="Date" /></th>
                <th><input type="text" placeholder="Nature" /></th>
                <th><input type="text" placeholder="Avancement" /></th>
                <th><input type="text" placeholder="Statut" /></th>
                <th><input type="text" placeholder="Clôture" /></th>
                <th><input type="text" placeholder="Règlement" /></th>
                <th><input type="text" placeholder="Expert" /></th>
                <th><input type="text" placeholder="Docs" /></th>
                <th><input type="text" placeholder="Commentaire" /></th>
                <th></th> {{-- Colonne actions, pas besoin de filtre --}}
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
    // Initialisation de la table
    let table = $('#sinistresTable').DataTable({
        dom: 'lBfrtip', // 'l' pour activer le lengthMenu
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger',
                exportOptions: { columns: ':not(:last-child)' },
                customize: function(doc) {
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 9;
                    doc.pageMargins = [20, 40, 20, 40];
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('auto');
                }
            }
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Tous']
        ],
        columnDefs: [
            { targets: 15, searchable: false, orderable: false } // Actions column
        ],
        initComplete: function() {
            this.api().buttons().container().appendTo('#exportButtons');

            // Appliquer les filtres à chaque colonne (sauf Actions)
            this.api().columns().every(function(index) {
                var column = this;
                if (index !== 15) {
                    $('input', column.footer()).on('keyup change clear', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });

             // Tooltips
            $('[data-bs-toggle="tooltip"]').tooltip({ trigger: 'hover', placement: 'top' });
        },
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        }
    });
});
</script>

@endsection

