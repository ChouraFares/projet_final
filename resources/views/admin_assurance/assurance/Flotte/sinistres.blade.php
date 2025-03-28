@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Assurance Flotte')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Styles personnalisés -->
<style>
    :root {
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .container {
        max-width: 2500px;
        width: 100%;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin: 30px auto;
    }

    .page-title {
        color: var(--primary-color);
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--light-color);
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .export-buttons {
        display: flex;
        flex-direction: row;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: nowrap;
        align-items: center;
    }

    .export-buttons .btn {
        padding: 8px 15px;
        min-width: 100px;
    }

    #sinistresTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
        margin: 20px 0;
    }

    #sinistresTable thead th {
        background-color: var(--primary-color);
        font-weight: 600;
        padding: 15px;
        text-align: left;
        position: sticky;
        top: 0;
    }

    #sinistresTable tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    #sinistresTable tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    .actions-cell {
        white-space: nowrap;
        text-align: center;
    }

    .action-btns {
        display: flex;
        flex-direction: row;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    .btn-sm {
        padding: 8px 12px;
        font-size: 13px;
    }

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-warning:hover {
        background-color: #e67e22;
        border-color: #e67e22;
    }

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    .dataTables_length {
        margin-bottom: 20px;
    }

    .dataTables_length label {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
    }

    .dataTables_paginate .paginate_button {
        padding: 6px 12px;
        margin: 0 2px;
        border-radius: var(--border-radius);
        color: var(--primary-color) !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .dataTables_filter input {
        padding: 6px 12px;
        border-radius: var(--border-radius);
        margin-left: 10px;
    }

    /* Style pour les filtres par colonne */
    tfoot input {
        width: 100%;
        padding: 6px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 13px;
    }

    tfoot th {
        padding: 8px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .action-btns {
            flex-direction: column;
            width: 100%;
        }
        
        .action-btns .btn {
            width: 100%;
        }

        .export-buttons {
            flex-direction: column;
            gap: 10px;
        }
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-open {
        background-color: rgba(46, 204, 113, 0.2);
        color: #27ae60;
    }

    .status-closed {
        background-color: rgba(52, 152, 219, 0.2);
        color: #2980b9;
    }

    .status-pending {
        background-color: rgba(241, 196, 15, 0.2);
        color: #f39c12;
    }

    [data-bs-toggle="tooltip"] {
        cursor: pointer;
    }
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="page-title">Liste des Sinistres - Assurance Flotte</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="action-buttons">
        <a href="{{ route('admin.assurance.flotte.sinistres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Sinistre
        </a>
        
        <div id="exportButtons" class="export-buttons"></div>
    </div>

    <!-- Table DataTables -->
    <table id="sinistresTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Numéro Sinistre</th>
                <th>Compagnie d'assurance</th>
                <th>Immatriculation</th>
                <th>Véhicule</th>
                <th>Chauffeur</th>
                <th>Fautif</th>
                <th>Date Sinistre</th>
                <th>Nature Sinistre</th>
                <th>Status</th>
                <th>Date Clôture Dossier</th>
                <th>Règlement</th>
                <th>Expert</th>
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
                <td>{{ $sinistre->fautif ? 'Oui' : 'Non' }}</td>
                <td>{{ $sinistre->date_sinistre }}</td>
                <td>{{ $sinistre->nature_sinistre }}</td>
                <td>
                    <span class="status-badge status-{{ strtolower($sinistre->situation_dossier) }}">
                        {{ $sinistre->situation_dossier }}
                    </span>
                </td>
                <td>
                    {{ $sinistre->date_cloture_dossier ? \Carbon\Carbon::parse($sinistre->date_cloture_dossier)->format('d/m/Y') : 'Non clôturé' }}
                </td>
                <td>{{ $sinistre->reglement }}</td>
                <td>{{ $sinistre->Expert }}</td>
                <td class="actions-cell">
                    <div class="action-btns">
                        <a href="{{ route('admin.assurance.flotte.sinistres.edit', $sinistre->id) }}" 
                           class="btn btn-warning btn-sm" 
                           data-bs-toggle="tooltip" 
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.assurance.flotte.sinistres.destroy', $sinistre->id) }}" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm" 
                                    data-bs-toggle="tooltip" 
                                    title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numéro Sinistre</th>
                <th>Compagnie d'assurance</th>
                <th>Immatriculation</th>
                <th>Véhicule</th>
                <th>Chauffeur</th>
                <th>Fautif</th>
                <th>Date Sinistre</th>
                <th>Nature Sinistre</th>
                <th>Status</th>
                <th>Date Clôture Dossier</th>
                <th>Règlement</th>
                <th>Expert</th>
                <th>Actions</th>
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
    // Initialisation de DataTable
    var table = $('#sinistresTable').DataTable({
        scrollX: true,
        autoWidth: false,
        dom: '<"top"lfB>rt<"bottom"ip>',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        pageLength: 10,
        language: {
            lengthMenu: "Afficher _MENU_ enregistrements",
            search: "Rechercher:",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
            infoEmpty: "Aucun enregistrement disponible",
            infoFiltered: "(filtré de _MAX_ enregistrements au total)",
            paginate: {
                first: "Premier",
                last: "Dernier",
                next: "Suivant",
                previous: "Précédent"
            },
            buttons: {
                copyTitle: 'Copié dans le presse-papier',
                copySuccess: {
                    _: '%d lignes copiées',
                    1: '1 ligne copiée'
                }
            }
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':not(:last-child)',
                    modifier: {
                        page: 'all'
                    }
                },
                filename: 'Sinistres_Assurance_Flotte_' + new Date().toISOString().slice(0, 10)
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                customize: function(doc) {
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 9;
                    doc.content[1].table.widths = 
                        Array(doc.content[1].table.body[0].length).fill('auto');
                    doc.pageMargins = [20, 40, 20, 40];
                },
                filename: 'Sinistres_Assurance_Flotte_' + new Date().toISOString().slice(0, 10)
            }
        ],
        initComplete: function() {
            // Déplacer les boutons d'exportation
            this.api().buttons().container().appendTo('#exportButtons');
            
            // Personnaliser le sélecteur de longueur
            $('.dataTables_length label').contents().filter(function() {
                return this.nodeType === 3;
            }).remove();
            
            $('.dataTables_length label').prepend('Afficher:');

            $('.dataTables_length select').css({
                'padding': '6px 12px',
                'border-radius': 'var(--border-radius)',
                'border': '1px solid #ddd',
                'background-color': 'white',
                'color': '#000',
                'margin': '0 5px'
            });

            // Ajouter les filtres par colonne, sauf pour "Actions"
            this.api().columns().every(function(index) {
                var column = this;
                // Exclure la colonne "Actions" (index 12)
                if (index !== 12) {
                    var title = $(column.footer()).text();
                    $(column.footer()).html(
                        '<input type="text" placeholder="Filtrer ' + title + '" />'
                    );
                    $('input', column.footer()).on('keyup change', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });
        }
    });

    // Initialiser les tooltips Bootstrap
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    $('.dataTables_length select').addClass('form-select-sm');
});
</script>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
