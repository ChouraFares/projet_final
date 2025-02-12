@extends('layouts.app')

@section('title', 'Gestion des Contrats - Assurance Responsabilité Civile')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">Liste des Contrats - Assurance Responsabilité Civile</h2>

    <!-- Section pour les boutons et la recherche -->


    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Table DataTables -->
    <table id="contractsTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Compagnie Assurance</th>
                <th>Référence Contrat</th>
                <th>Date Effet</th>
                <th>Échéance</th>
                <th>Condition Renouvellement</th>
                <th>Avenant</th>
                <th>Objet Avenant</th>
                <th class="no-export">Attachement Contrat</th> <!-- Exclure de l'export -->
                <th class="no-export">Attachement Avenant</th> <!-- Exclure de l'export -->
            </tr>
        </thead>
        <tbody>
            @foreach($contrats as $contrat)
                <tr>
                    <td>{{ $contrat->compagnie_assurance }}</td>
                    <td>{{ $contrat->ref_contrat }}</td>
                    <td>{{ $contrat->date_effet }}</td>
                    <td>{{ $contrat->echeance }}</td>
                    <td>{{ $contrat->condition_renouvellement }}</td>
                    <td>{{ $contrat->avenant ? 'Oui' : 'Non' }}</td>
                    <td>{{ $contrat->objet_avenant }}</td>
                    <td>
                        @if($contrat->attachement_contrat)
                            <a href="{{ asset('storage/' . $contrat->attachement_contrat) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-file-alt"></i> Voir
                            </a>
                        @else
                            <span class="text-muted">Aucun fichier</span>
                        @endif
                    </td>
                    <td>
                        @if($contrat->attachement_avenant)
                            <a href="{{ asset('storage/' . $contrat->attachement_avenant) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-file-alt"></i> Voir
                            </a>
                        @else
                            <span class="text-muted">Aucun fichier</span>
                        @endif
                    </td>
               
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
        var table = $('#contractsTable').DataTable({
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
                        columns: ':not(.no-export)' // Exclure les colonnes "Attachement Contrat" et "Attachement Avenant"
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(.no-export)' // Exclure les colonnes "Attachement Contrat" et "Attachement Avenant"
                    },
                    customize: function(doc) {
                        // Réduction de la taille de la police
                        doc.styles.tableHeader.fontSize = 6;
                        doc.styles.tableBodyEven.fontSize = 6;
                        doc.styles.tableBodyOdd.fontSize = 6;

                        // Réduction de la largeur des colonnes
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('15%');

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

        #contractsTable td, #contractsTable th {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #contractsTable .btn {
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

        .btn-primary, .btn-danger {
            display: flex;
            align-items: center;
        }

        .btn-primary i, .btn-danger i {
            margin-right: 5px;
        }
    </style>
@endsection
