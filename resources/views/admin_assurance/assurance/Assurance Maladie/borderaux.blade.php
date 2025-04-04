@extends('layouts.transit')

@section('title', 'Assurance Maladie')

@section('styles')
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --warning-color: #f8961e;
        --danger-color: #f94144;
        --light-color: #f8961e;
        --dark-color: #212529;
        --text-color: #2b2d42;
        --bg-color: #f8961e;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --hover-transition: all 0.3s ease;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-fluid {
        padding: 2rem;
        max-width: 100%;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .page-title {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0;
    }

    .btn {
        font-weight: 500;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        box-shadow: var(--card-shadow);
        transition: var(--hover-transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-warning:hover {
        background-color: #e07e0e;
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .btn-danger:hover {
        background-color: #d62a2d;
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .table-wrapper {
        background: white;
        border-radius: 10px;
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        overflow-x: auto;
    }

    #contractsTable {
        width: 100% !important;
        margin-bottom: 1rem;
        border-collapse: separate;
        border-spacing: 0;
    }

    #contractsTable thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        padding: 1rem;
        position: sticky;
        top: 0;
        border: none;
    }

    #contractsTable tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    #contractsTable tbody tr:last-child td {
        border-bottom: none;
    }

    #contractsTable tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05);
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .bg-success {
        background-color: #4cc9f0 !important;
    }

    .bg-warning {
        background-color: var(--warning-color) !important;
    }

    .bg-danger {
        background-color: var(--danger-color) !important;
    }

    .actions-column {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .actions-column .btn {
        min-width: 80px;
    }

    .export-buttons {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 0.25rem 0.5rem;
        border: 1px solid #ced4da;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 0.25rem 0.5rem;
        border: 1px solid #ced4da;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        padding: 0.25rem 0.75rem !important;
        margin: 0 0.15rem !important;
        border: 1px solid transparent !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color) !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e0e0e0 !important;
        color: var(--dark-color) !important;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .actions-column {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .actions-column .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Conteneur principal -->
<div class="container-fluid">
    <!-- En-tête de page -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-shield-alt me-2"></i>Gestion des Bordereaux d'Assurance Maladie
        </h1>
        <a href="{{ route('admin.assurance.AssuranceMaladie.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Bordereau
        </a>
    </div>

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="export-buttons" id="exportButtons"></div>

    <!-- Conteneur du tableau -->
    <div class="table-wrapper">
        <table id="contractsTable" class="table table-hover">
            <thead>
                <tr>
                    <th>Date Envoi</th>
                    <th>N° Bordereau</th>
                    <th>N° Bulletin</th>
                    <th>Adhérent</th>
                    <th>Matricule</th>
                    <th>Date Soin</th>
                    <th>Statut</th>
                    <th>Réclamation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assurances as $assurance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($assurance->date_envoi)->format('d/m/Y') }}</td>
                        <td><strong>{{ $assurance->numero_borderaux }}</strong></td>
                        <td>{{ $assurance->bulletin_numero }}</td>
                        <td>{{ $assurance->nom_adherent }}</td>
                        <td>{{ $assurance->matricule }}</td>
                        <td>{{ \Carbon\Carbon::parse($assurance->date_de_soin)->format('d/m/Y') }}</td>
                        <td>
                            @if ($assurance->status == 'Remis')
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Remis</span>
                            @elseif ($assurance->status == 'Non Remis')
                                <span class="badge bg-warning"><i class="fas fa-exclamation-circle me-1"></i> Non Remis</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Clôturé</span>
                            @endif
                        </td>
                        <td>{{ $assurance->reclamation ?? '-' }}</td>
                        <td class="actions-column">
                            <a href="{{ route('AssuranceMaladie.edit', $assurance->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('AssuranceMaladieDestroy', $assurance->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bordereau ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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

<script>
$(document).ready(function() {
    var table = $('#contractsTable').DataTable({
        scrollX: false,
        autoWidth: false,
        dom: '<"top"lfB>rt<"bottom"ip>',
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tous"]],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':not(:last-child)',
                    format: {
                        body: function(data, row, column, node) {
                            // Nettoyer les données pour Excel
                            return data.replace(/<[^>]*>/g, '').trim();
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                customize: function(doc) {
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 10;
                    doc.styles.title.fontSize = 12;
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                    doc.pageMargins = [20, 40, 20, 40];
                }
            }
        ],
        initComplete: function() {
            // Ajouter des classes aux éléments de contrôle
            $('.dataTables_length select').addClass('form-select-sm');
            $('.dataTables_filter input').addClass('form-control-sm');
        }
    });

    // Déplacer les boutons vers le conteneur dédié
    table.buttons().container().appendTo('#exportButtons');
    
    // Ajouter des tooltips
    $('[title]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
});
</script>
@endsection