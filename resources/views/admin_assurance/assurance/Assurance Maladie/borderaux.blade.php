@extends('layouts.transit')

@section('title', 'Assurance Maladie')

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Bootstrap CSS -->



    @section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-shield-alt me-2"></i>Gestion des Bordereaux d'Assurance Maladie
            </h1>
            <a href="{{ route('admin.assurance.AssuranceMaladie.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Nouveau Bordereau
            </a>
        </div>
        <div class="export-buttons" id="exportButtons"></div>
        <div class="table-wrapper">
            <table id="contractsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th data-type="date-eu">Date Envoi</th>                        <th>N° Bordereau</th>
                        <th>N° Bulletin</th>
                        <th>Adhérent</th>
                        <th data-type="date-eu">Date Soin</th>                        <th>Statut</th>
                        <th>Réclamation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assurances as $assurance)
                        <tr>
                            <td data-order="{{ \Carbon\Carbon::parse($assurance->date_envoi)->format('Y-m-d') }}">
                                {{ \Carbon\Carbon::parse($assurance->date_envoi)->format('d/m/Y') }}
                            </td>
                            <td>{{ $assurance->numero_borderaux ?? '-' }}</td> <!-- Ensure null handling -->
                            <td>{{ $assurance->bulletin_numero ?? '-' }}</td>
                            <td>{{ $assurance->nom_adherent ?? '-' }}</td> <!-- Add for safety -->
                            <td data-order="{{ \Carbon\Carbon::parse($assurance->date_de_soin)->format('Y-m-d') }}">
                                {{ \Carbon\Carbon::parse($assurance->date_de_soin)->format('d/m/Y') }}
                            </td>
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

    <!-- Scripts -->
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables Core -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables DateTime sorting -->
<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<!-- Buttons HTML5 export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<!-- PDFMake for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
$(document).ready(function() {
    

    var table = $('#contractsTable').DataTable({
        scrollX: false,
        autoWidth: false,
        dom: '<"top"lfB>rt<"bottom"ip>',
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tous"]],
        order: [[0, 'desc']],
        stateSave: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        columnDefs: [
            { 
                type: 'date-eu',
                targets: [0, 4]
            }
        ],
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':not(:last-child)',
                    format: {
                        body: function(data, row, column, node) {
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
            $('.dataTables_length select').addClass('form-select-sm');
            $('.dataTables_filter input').addClass('form-control-sm');
        }
    });

    table.buttons().container().appendTo('#exportButtons');

    $('[title]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });


});


</script>
@endsection