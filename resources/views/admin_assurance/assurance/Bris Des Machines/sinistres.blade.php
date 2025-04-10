@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Bris de Machine')

@section('content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-tools me-2"></i>Liste des Sinistres - Bris de Machine</h2>
        </div>
    </div>

    <div class="form-container p-0">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 px-3 pt-3">
            <a href="{{ route('create_BrisDeMachines_sinistres') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un Sinistre
            </a>
            <div id="exportButtons" class="btn-group"></div>
        </div>

        <div class="table-container">
            <table id="sinistresTable" class="table table-striped table-bordered display" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Numéro</th>
                        <th>Assurance</th>
                        <th>Nature</th>
                        <th>Lieu</th>
                        <th>Date</th>
                        <th>Dégâts</th>
                        <th>Chargé</th>
                        <th>Perte (TND)</th>
                        <th>Responsable</th>
                        <th>Statut</th>
                        <th>Expert</th>
                        <th>Commentaires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sinistres as $sinistre)
                    <tr>
                        <td>{{ $sinistre->numero_sinistre }}</td>
                        <td>{{ $sinistre->assureur }}</td>
                        <td>{{ $sinistre->nature_sinistre }}</td>
                        <td>{{ $sinistre->lieu_sinistre }}</td>
                        <td>{{ \Carbon\Carbon::parse($sinistre->date_sinistre)->format('d/m/Y') }}</td>
                        <td>{{ Str::limit($sinistre->degats, 30) }}</td>
                        <td>{{ $sinistre->charge }}</td>
                        <td class="text-end">{{ number_format($sinistre->perte, 2) }}</td>
                        <td>{{ $sinistre->responsable }}</td>
                        <td>
                            <span class="badge 
                                @if($sinistre->statu_du_dossier == 'Avant Constat') bg-warning
                                @elseif($sinistre->statu_du_dossier == 'Constat Déposé') bg-info
                                @elseif($sinistre->statu_du_dossier == 'Expert') bg-primary
                                @elseif($sinistre->statu_du_dossier == 'En attente du remboursement') bg-success
                                @endif">
                                {{ $sinistre->statu_du_dossier }}
                            </span>
                        </td>
                        <td>{{ $sinistre->expert }}</td>
                        <td>{{ Str::limit($sinistre->commentaires, 30) }}</td>
                        <td class="actions-column">
                            <div class="d-flex flex-nowrap align-items-center gap-2">
                                <a href="{{ route('bris_de_machine.edit', $sinistre->id) }}" 
                                   class="btn btn-sm btn-warning edit-btn" 
                                   title="Modifier"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('bris_de_machine.destroy', $sinistre->id) }}" method="POST" 
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger delete-btn" 
                                            title="Supprimer"
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable without scrolling
    var table = $('#sinistresTable').DataTable({
        scrollX: false,           // Désactiver le scroll horizontal
        scrollCollapse: false,    // Désactiver le collapse
        fixedColumns: false,      // Désactiver les colonnes fixes
        dom: '<"top"lfB>rt<"bottom"ip>',
        pageLength: 10,
        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Tous"]],
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: { 
                    columns: ':not(:last-child)',
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 4) return data.replace(/\//g, '-');
                            if (column === 7) return data.replace(/[^\d.-]/g, '');
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: { columns: ':not(:last-child)' },
                customize: function(doc) {
                    doc.styles.tableHeader = {
                        fontSize: 8,
                        bold: true,
                        alignment: 'center'
                    };
                    doc.defaultStyle.fontSize = 8;
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        columnDefs: [
            { width: 'auto', targets: '_all' } // Ajuster automatiquement la largeur des colonnes
        ],
        autoWidth: true, // Activer l'ajustement automatique de la largeur
        initComplete: function() {
            this.api().buttons().container().appendTo('#exportButtons');
            $('.dataTables_length label').addClass('d-flex align-items-center gap-2 mb-0');
            $('.dataTables_length select').addClass('form-select form-select-sm w-auto');
            $('.dataTables_filter label').addClass('d-flex align-items-center gap-2 mb-0');
            $('.dataTables_filter input').addClass('form-control form-control-sm');
        }
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Custom delete confirmation
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var form = this;
        
        Swal.fire({
            title: 'Confirmer la suppression',
            text: "Êtes-vous sûr de vouloir supprimer ce sinistre ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Ajuster les colonnes après le chargement initial
    table.columns.adjust().draw();
});
</script>

<style>
    .dashboard {
        width: 100%;
        max-width: 100%;
    }

    .form-container {
        width: 100%;
        max-width: 100%;
    }

    .table-container {
        width: 100%;
        max-width: 100%;
    }
    
    #sinistresTable {
        width: 100% !important;    /* Forcer la largeur à 100% */
        table-layout: auto;        /* Ajustement automatique des colonnes */
    }
    
    .dataTables_wrapper {
        width: 100%;
        max-width: 100%;
    }

    .actions-column {
        min-width: 100px;
    }
    
    .table th {
        white-space: nowrap;
        vertical-align: middle;
        background-color: #343a40;
    }
    
    .table td {
        vertical-align: middle;
        white-space: normal;      /* Permettre le retour à la ligne si nécessaire */
        word-wrap: break-word;    /* Césure des mots longs */
        max-width: 150px;         /* Limiter la largeur maximale des cellules pour éviter l'étirement excessif */
    }
    
    .edit-btn, .delete-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
</style>
@endsection