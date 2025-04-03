@extends('layouts.app')

@section('title', 'Assurance Maladie')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Styles généraux */
    .container {
        max-width: 2000px; /* Augmenté de 1400px à 1800px pour élargir horizontalement */
        width: 100%; /* Utilise toute la largeur disponible */        margin: 0 auto;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2.text-center {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 30px;
    }

    /* Boutons */
    .btn {
        border-radius: 5px;
        padding: 8px 15px;
        transition: all 0.3s ease;
    }


  

    .btn-warning {
        background-color: #f39c12;
        border-color: #f39c12;
    }

    .btn-warning:hover {
        background-color: #e67e22;
        border-color: #e67e22;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    .btn i {
        margin-right: 5px;
    }

    /* Tableaux */
    .table {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .thead-dark th {
        color: #fff;
        font-weight: 500;
        text-align: center;
        padding: 12px;
    }

    .table td {
        vertical-align: middle;
        padding: 12px;
        text-align: center;
    }

 

    /* Badges pour le statut */
    .badge {
        padding: 6px 12px;
        font-size: 0.9rem;
        border-radius: 20px;
    }

    .bg-success {
        background-color: #27ae60 !important;
    }

    .bg-warning {
        background-color: #f1c40f !important;
        color: #333 !important;
    }

    .bg-danger {
        background-color: #c0392b !important;
    }

    /* Colonne Actions */
    .actions-column {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: center;
    }

    /* Boutons d'exportation */
    #exportButtons .btn {
        margin-right: 10px;
        font-size: 0.9rem;
    }

    /* Pagination et filtres DataTables */
    .dataTables_wrapper .dataTables_length select {
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
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
        color: #fff;
        border: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #2980b9;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #2c3e50;
    }
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">Assurance Maladie</h2>

    <!-- Section pour les boutons et la recherche -->
   

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Table DataTables -->
    <table id="contractsTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Date d'Envoi</th>
                <th>Numéro Bordereau</th>
                <th>Numéro Bulletin</th>
                <th>Nom Adhérent</th>
                <th>Matricule</th>
                <th>Date de Soin</th>
                <th>Statut</th>
                <th>Réclamation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assurances as $assurance)
                <tr>
                    <td>{{ $assurance->date_envoi }}</td>
                    <td>{{ $assurance->numero_borderaux }}</td>
                    <td>{{ $assurance->bulletin_numero }}</td>
                    <td>{{ $assurance->nom_adherent }}</td>
                    <td>{{ $assurance->matricule }}</td>
                    <td>{{ $assurance->date_de_soin }}</td>
                    <td>
                        @if ($assurance->status == 'Remis')
                            <span class="badge bg-success">Remis</span>
                        @elseif ($assurance->status == 'Non Remis')
                            <span class="badge bg-warning text-dark">Non Remis</span>
                        @else
                            <span class="badge bg-danger">Clôturé</span>
                        @endif
                    </td>
                    <td>{{ $assurance->reclamation ?? 'Aucune' }}</td>
               
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

<script>
$(document).ready(function() {
    var table = $('#contractsTable').DataTable({
        scrollX: true,
        autoWidth: false,
        dom: 'lBfrtip', // Ajout explicite de 'l' pour le menu de longueur
        pageLength: 5, // Par défaut, 5 enregistrements
        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Tous"]], // Options personnalisées
        lengthChange: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)'
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
            zeroRecords: "Aucun enregistrement correspondant trouvé"
        }
    });

    // Déplacer les boutons vers le conteneur dédié
    table.buttons().container().appendTo('#exportButtons');

    // Personnaliser le menu de sélection
    $('.dataTables_length label').addClass('d-flex align-items-center gap-2');
    $('.dataTables_length select').addClass('form-select');
});
</script>

@endsection