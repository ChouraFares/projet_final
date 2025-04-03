@extends('layouts.transit')

@section('title', 'Détails Timbrage et Avances sur Surestarie')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Conteneur principal */
    .container {
        max-width: 1900px;
        width: 100%;
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Titre */
    h1 {
        color: #F4A261;
        font-size: 2rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Tableau */
    .table {
        background-color: #224459; /* Arrière-plan demandé */
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
    }

    .table thead th {
        background-color: #34495e;
        color: #fff;
        font-weight: 500;
        text-align: center;
        padding: 12px;
        border-bottom: 2px solid #2c3e50;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 12px;
        text-align: center;
        font-size: 14px;
        color: #ffffff; /* Texte blanc pour contraste avec #224459 */
        border-bottom: 1px solid #34495e; /* Bordure assortie */
    }

    /* Style pour les valeurs "N/A" */
    .na-value {
        color: #e74c3c; /* Rouge */
        font-weight: 500;
    }

    .na-value i {
        margin-right: 5px;
    }

    /* Liens dans la colonne Pièce Jointe */
    .table td a {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
    }

    .table td a:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    /* DataTables personnalisation */
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 15px;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        color: #fff; /* Texte "Show entries" et "Search" en blanc */
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 5px;
        border-radius: 5px;
        min-width: 80px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 5px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 10px;
        margin: 0 2px;
        border-radius: 5px;
        background-color: #3498db;
        border: none;
        transition: background-color 0.3s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #2980b9;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #2c3e50;
        font-weight: bold;
    }

    .dataTables_wrapper .dataTables_info {
        padding-top: 10px;
        color: #fff; /* Info en blanc pour contraste */
    }

    /* Boutons d'exportation */
    #exportButtons .btn {
        margin-right: 10px;
        font-size: 0.9rem;
        padding: 8px 15px;
        border-radius: 5px;
    }

    #exportButtons .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
    }

    #exportButtons .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    #exportButtons .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    #exportButtons .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }
</style>

<div class="container">
    <h1>Détails Timbrage et Avances sur Surestarie</h1>

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <table id="timbrageTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Facture</th>
                <th>Numéro Conteneur</th>
                <th>Fournisseur</th>
                <th>Montant Timbrage</th>
                <th>Date Expiration Timbrage</th>
                <th>Montant Avance Surestarie</th>
                <th>État</th>
                <th>Pièce Jointe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
                @foreach($facture->cheques as $cheque)
                    <tr>
                        <td>{{ $facture->facture }}</td>
                        <td>{{ $facture->num_conteneur }}</td>
                        <td>{{ $facture->fournisseur }}</td>
                        <td>
                            @if($cheque->timbrage_montant_retenue_a_la_source)
                                {{ $cheque->timbrage_montant_retenue_a_la_source }}
                            @else
                                <span class="na-value"><i class="fas fa-exclamation-circle"></i> Pas de Montant</span>
                            @endif
                        </td>
                        <td>
                            @if($cheque->echeance_timbrage)
                                {{ $cheque->echeance_timbrage }}
                            @else
                                <span class="na-value"><i class="fas fa-exclamation-circle"></i> Pas de Date</span>
                            @endif
                        </td>
                        <td>
                            @if($cheque->montant)
                                {{ $cheque->montant }}
                            @else
                                <span class="na-value"><i class="fas fa-exclamation-circle"></i> Pas de Montant</span>
                            @endif
                        </td>
                        <td>
                            @if($cheque->Etat)
                                {{ $cheque->Etat }}
                            @else
                                <span class="na-value"><i class="fas fa-exclamation-circle"></i> Pas d'État</span>
                            @endif
                        </td>
                        <td>
                            @if($cheque->Attachement_Timbrage)
                                <a href="{{ asset('storage/' . $cheque->Attachement_Timbrage) }}" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Voir
                                </a>
                            @else
                                <span class="na-value"><i class="fas fa-times-circle"></i> Aucun fichier</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables Core JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
    // Initialiser DataTables
    var table = $('#timbrageTable').DataTable({
        scrollX: true,
        autoWidth: false,
        dom: 'lBfrtip', // 'l' pour le menu de longueur, 'B' pour les boutons
        pageLength: 5, // Par défaut, afficher 5 entrées
        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Tous"]], // Options personnalisées
        order: [[0, 'asc']], // Tri par défaut sur la colonne Facture
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: ':visible' // Exporter uniquement les colonnes visibles
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function(doc) {
                    doc.styles.tableHeader.fontSize = 8;
                    doc.styles.tableBodyEven.fontSize = 8;
                    doc.styles.tableBodyOdd.fontSize = 8;
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                    doc.compress = true;
                }
            }
        ],
        language: {
            paginate: {
                previous: "Précédent",
                next: "Suivant"
            },
            lengthMenu: "Afficher _MENU_ enregistrements par page",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
            emptyTable: "Aucune donnée disponible dans le tableau",
            zeroRecords: "Aucun enregistrement trouvé",
            infoEmpty: "Aucun enregistrement disponible",
            infoFiltered: "(filtré de _MAX_ enregistrements au total)",
            search: "Rechercher :" // Label personnalisé pour la recherche
        }
    });

    // Déplacer les boutons d'exportation vers le conteneur dédié
    table.buttons().container().appendTo('#exportButtons');
});
</script>
@endsection