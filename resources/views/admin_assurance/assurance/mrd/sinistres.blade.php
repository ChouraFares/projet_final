@extends('layouts.app')

@section('title', 'Gestion des Sinistres - MRD')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Styles généraux */
    .container {
        max-width: 2500px; /* Augmentation de la taille horizontale */
        width: 100%; /* Utilise toute la largeur disponible */
        margin: 0 auto;
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
        width: 100%; /* Forcer le tableau à prendre toute la largeur */
    }

    .thead-dark th {
        font-weight: 500;
        text-align: center;
        padding: 12px;
    }

    .table td {
        vertical-align: middle;
        padding: 12px;
        text-align: center;
        font-size: 14px;
    }

    /* Colonne Actions - Disposition horizontale */
    .actions-column {
        display: flex;
        flex-direction: row; /* Changement de column à row */
        gap: 10px; /* Espacement entre les boutons */
        justify-content: center; /* Centre les boutons horizontalement */
        align-items: center; /* Aligne verticalement au centre */
    }

    /* Boutons d'exportation */
    #exportButtons .btn {
        margin-right: 10px;
        font-size: 0.9rem;
    }

    /* Pagination et filtres DataTables */
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 15px;
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 5px;
        border-radius: 5px;
        min-width: 80px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 5px;
        padding: 5px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 10px;
        margin: 0 2px;
        border-radius: 5px;
        border: none;
    }

    /* Assurer que le tableau s’étend complètement */
    #sinistresTable {
        width: 100% !important;
    }
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">Liste des Sinistres - MRD</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.mrd.sinistres.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Ajouter un Sinistre
        </a>
    </div>

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Table DataTables -->
    <table id="sinistresTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Numéro De Sinistre</th>
                <th>Compagnie Assurance</th>
                <th>Fournisseur</th>
                <th>Nature du Sinistre</th>
                <th>Lieu du Sinistre</th>
                <th>Date du Sinistre</th>
                <th>Dégâts</th>
                <th>Charge</th>
                <th>Perte</th>
                <th>Estimation De Remboursement</th>
                <th>Responsable</th>
                <th>Commentaires</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->numero_sinistre }}</td>
                <td>{{ $sinistre->compagnie_assurance }}</td>
                <td>{{ $sinistre->fournisseur }}</td>
                <td>{{ $sinistre->nature_sinistre }}</td>
                <td>{{ $sinistre->lieu_sinistre }}</td>
                <td>{{ $sinistre->date_sinistre }}</td>
                <td>{{ $sinistre->degats }}</td>
                <td>{{ $sinistre->charge }}</td>
                <td>{{ $sinistre->perte }}</td>
                <td>{{ $sinistre->estimation_de_remboursement }}</td>
                <td>{{ $sinistre->responsable }}</td>
                <td>{{ $sinistre->commentaires }}</td>
                <td>{{ $sinistre->statut }}</td>
                <td class="actions-column">
                    <a href="{{ route('admin.mrd.sinistres.edit', $sinistre->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('admin.mrd.sinistres.destroy', $sinistre->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce sinistre ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </form>
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

<script>
$(document).ready(function() {
    var table = $('#sinistresTable').DataTable({
        scrollX: true,
        autoWidth: false,
        dom: 'lBfrtip', // 'l' pour le menu de longueur
        pageLength: 5, // Par défaut, afficher 5 entrées
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
            infoFiltered: "(filtré de _MAX_ enregistrements au total)"
        }
    });

    // Déplacer les boutons vers le conteneur dédié
    table.buttons().container().appendTo('#exportButtons');

    // Personnaliser le menu de sélection
    $('.dataTables_length label').addClass('d-flex align-items-center gap-2');
    $('.dataTables_length select').addClass('form-select');
});
</script>

<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
