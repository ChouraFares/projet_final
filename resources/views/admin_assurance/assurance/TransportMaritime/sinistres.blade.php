@extends('layouts.app')

@section('title', 'Sinistres - TM')


@section('styles')
<style>
    /* Conteneur principal */
    .container-fluid {
        padding: 20px;
        width: 100%;
        max-width: 100%; /* Supprime la limitation de largeur */
    }

    /* Style du tableau */
    #sinistresTable {
        width: 100% !important; /* Forcer le tableau à prendre toute la largeur */
        margin-bottom: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    #sinistresTable th, #sinistresTable td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
    }

    #sinistresTable thead th {
        background-color: #343a40; /* Gris foncé pour l'en-tête */
        color: white;
        font-weight: bold;
    }

    #sinistresTable tbody tr:nth-child(even) {
        background-color: #f8f9fa; /* Gris clair pour les lignes paires */
    }

    #sinistresTable tbody tr:hover {
        background-color: #e9ecef; /* Survol des lignes */
        transition: background-color 0.3s;
    }

    /* Boutons */
    .btn {
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 12px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #c82333;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
    }

    /* Boutons d'exportation */
    #exportButtons .btn {
        margin-right: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #sinistresTable th, #sinistresTable td {
            font-size: 12px;
            padding: 8px;
        }
        .btn {
            font-size: 12px;
            padding: 6px 10px;
        }
    }
</style>
@endsection

@section('content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container-fluid">
    <h2 class="text-center mb-4">Liste des Sinistres - Transport Maritime</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('create_maritime_sinistres') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Ajouter un Sinistre
        </a>
    </div>

    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Numéro Sinistres</th>
                <th>Compagnie Assurance</th>
                <th>Prime</th>
                <th>Fournisseur</th>
                <th>Num Facture</th>
                <th>Montant Facture (USD)</th>
                <th>Montant Facture (TND)</th>
                <th>Num Conteneur</th>
                <th>Date Dépôt</th>
                <th>Transporteur Maritime</th>
                <th>Date Incident</th>
                <th>Lieu</th>
                <th>MT</th>
                <th>Date Prévue Remboursement</th>
                <th>Nature De Sinistre</th>
                <th>Status</th>
                <th>Commentaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->numero_sinistre }}</td>
                <td>{{ $sinistre->assureur }}</td>
                <td>{{ $sinistre->prime }}</td>
                <td>{{ $sinistre->fournisseur }}</td>
                <td>{{ $sinistre->num_facture }}</td>
                <td>{{ $sinistre->montant_facture_usd }}</td>
                <td>{{ $sinistre->montant_facture_tnd }}</td>
                <td>{{ $sinistre->num_conteneur }}</td>
                <td>{{ $sinistre->date_depot }}</td>
                <td>{{ $sinistre->transporteur_maritime }}</td>
                <td>{{ $sinistre->date_incident }}</td>
                <td>{{ $sinistre->lieu }}</td>
                <td>{{ $sinistre->mt }}</td>
                <td>{{ $sinistre->date_prev_remboursement }}</td>
                <td>{{ $sinistre->nature_de_sinistre }}</td>
                <td>{{ $sinistre->statut_du_dossier }}</td>
                <td>{{ $sinistre->commentaire }}</td>
                <td class="actions-column">
                    <a href="{{ route('edit_maritime_sinistres', $sinistre->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('destroy_maritime_sinistres', $sinistre->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Supprimer
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
                    columns: ':not(:last-child)' // Exclut la colonne Actions
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclut la colonne Actions
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
@endsection