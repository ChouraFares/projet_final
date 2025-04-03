@extends('layouts.app')

@section('title', 'Sinistres - TM')

<style>
    /* Styles existants inchangés */
    .container-fluid {
        padding: 20px;
        width: 100%;
        max-width: 100%;
    }

    #sinistresTable {
        width: 100% !important;
        margin-bottom: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #sinistresTable th, #sinistresTable td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
    }

    #sinistresTable thead th {
        background-color: #343a40;
        color: white;
        font-weight: bold;
    }

    #sinistresTable tbody tr:hover {
        background-color: #051627;
        transition: background-color 0.3s;
    }

    /* Styles pour les filtres */
    tfoot input {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 12px;
    }

    /* Mise en forme conditionnelle */
    .status-en-attente {
        background-color: #fff3cd !important; /* Jaune pâle */
    }

    .status-termine {
        background-color: #d4edda !important; /* Vert pâle */
    }

    .status-rejete {
        background-color: #f8d7da !important; /* Rouge pâle */
    }
</style>

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
            <tr class="{{ $sinistre->statut_du_dossier == 'En attente' ? 'status-en-attente' : ($sinistre->statut_du_dossier == 'Terminé' ? 'status-termine' : ($sinistre->statut_du_dossier == 'Rejeté' ? 'status-rejete' : '')) }}">
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
        <tfoot>
            <tr>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th><input type="text" placeholder="Filtrer..."></th>
                <th></th> <!-- Pas de filtre pour la colonne Actions -->
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

<script>
$(document).ready(function() {
    var table = $('#sinistresTable').DataTable({
        scrollX: true,
        autoWidth: false,
        dom: 'lBfrtip',
        pageLength: 5,
        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Tous"]],
        lengthChange: true,
        order: [[0, 'desc']], // Tri par défaut sur la première colonne
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                className: 'btn btn-primary',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                className: 'btn btn-danger',
                exportOptions: { columns: ':not(:last-child)' },
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
            paginate: { previous: "Précédent", next: "Suivant" },
            lengthMenu: "Afficher _MENU_ enregistrements par page",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
            emptyTable: "Aucune donnée disponible dans le tableau",
            zeroRecords: "Aucun enregistrement trouvé",
            infoEmpty: "Aucun enregistrement disponible",
            infoFiltered: "(filtré de _MAX_ enregistrements au total)"
        }
    });

    // Ajouter les filtres par colonne
    $('#sinistresTable tfoot th').each(function() {
        var title = $(this).text();
        if (title) { // Vérifie si le champ n'est pas vide (exclut la colonne Actions)
            $(this).html('<input type="text" placeholder="Filtrer ' + title + '" />');
        }
    });

    // Appliquer le filtrage
    table.columns().every(function() {
        var that = this;
        $('input', this.footer()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    // Déplacer les boutons vers le conteneur dédié
    table.buttons().container().appendTo('#exportButtons');

    // Personnaliser le menu de sélection
    $('.dataTables_length label').addClass('d-flex align-items-center gap-2');
    $('.dataTables_length select').addClass('form-select');
});
</script>
@endsection