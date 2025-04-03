@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Responsabilité Civile')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">Liste des Sinistres - Responsabilité Civile</h2>

    <!-- Section pour les boutons et la recherche -->


    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Table DataTables -->
    <table id="sinistresTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Numero De Sinistre</th>
                <th>Compagnie Assurance</th> <!-- Assureur -->
                <th>Nature du Sinistre</th>
                <th>Lieu du Sinistre</th>
                <th>Date du Sinistre</th>
                <th>Dégâts</th>
                <th>Charge</th>
                <th>Perte</th>
                <th>Responsable</th>
                <th>Status</th> <!-- Situation du dossier -->
                <th>Commentaires</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->numero_de_sinistre }}</td>
                <td>{{ $sinistre->assureur }}</td>
                <td>{{ $sinistre->nature_sinistre }}</td>
                <td>{{ $sinistre->lieu_sinistre }}</td>
                <td>{{ $sinistre->date_sinistre }}</td>
                <td>{{ $sinistre->degats }}</td>
                <td>{{ $sinistre->charge }}</td>
                <td>{{ $sinistre->perte }}</td>
                <td>{{ $sinistre->responsable }}</td>
                <td>{{ $sinistre->situation_du_dossier }}</td>
                <td>{{ $sinistre->commentaires }}</td>
             
            </tr>
            @endforeach
        </tbody>
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
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        var table = $('#sinistresTable').DataTable({
            scrollX: true,
            autoWidth: false,
            dom: 'Bfrtip',
            pageLength: 10, // Affichage de 10 lignes par page avec pagination
            language: {
                paginate: {
                    previous: "Précédent",
                    next: "Suivant"
                },
                lengthMenu: "Afficher _MENU_ enregistrements par page",
                zeroRecords: "Aucun enregistrement trouvé",
                info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
                infoEmpty: "Aucun enregistrement disponible",
                infoFiltered: "(filtré de _MAX_ enregistrements au total)"
            },
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':not(:last-child):not(.no-export)' // Exclure la colonne "Actions"
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:last-child):not(.no-export)' // Exclure la colonne "Actions"
                    },
                    customize: function(doc) {
                        // Réduction de la taille de la police
                        doc.styles.tableHeader.fontSize = 5;
                        doc.styles.tableBodyEven.fontSize = 5;
                        doc.styles.tableBodyOdd.fontSize = 5;

                        // Réduction de la largeur des colonnes
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('10%');

                        // Activation de la compression pour réduire la taille du PDF
                        doc.compress = true;
                    }
                }
            ]
        });

        // Déplacer les boutons vers le conteneur dédié
        table.buttons().container().appendTo('#exportButtons');
    });
</script>


@endsection

@section('styles')
    <style>
        .actions-column {
            width: 100px !important;
            min-width: 100px;
            white-space: nowrap;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #sinistresTable td, #sinistresTable th {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #sinistresTable .btn {
            display: inline-block !important;
            margin: 5px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .table-container {
            margin-top: 20px;
        }
    </style>
@endsection
