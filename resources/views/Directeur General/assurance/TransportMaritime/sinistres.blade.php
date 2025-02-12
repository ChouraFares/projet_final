@extends('layouts.app')

@section('title', ' Sinistres - TM')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <h2 class="text-center mb-4">Liste des Sinistres - Transport Maritime</h2>

 

    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Numéro Sinistres</th>
                <th>Compagnie Assurance</th> <!-- similaire au assureur -->
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
                <th>Status</th> <!-- similaire au statut du dossier -->
                <th>Commentaire</th>
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
                <td>{{ $sinistre->statut_du_dossier }}</td> <!-- similaire au statuts -->
                <td>{{ $sinistre->commentaire }}</td>
             
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
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:last-child):not(.no-export)' // Exclure la colonne "Actions" et celles marquées "no-export"
                    },
                    customize: function(doc) {
                        // Réduction de la taille de la police
                        doc.styles.tableHeader.fontSize = 4;
                        doc.styles.tableBodyEven.fontSize = 4;
                        doc.styles.tableBodyOdd.fontSize = 4;

                        // Réduction de la largeur des colonnes
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('6.5%');

                        // Activation de la compression
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
                zeroRecords: "Aucun enregistrement trouvé",
                info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
                infoEmpty: "Aucun enregistrement disponible",
                infoFiltered: "(filtré de _MAX_ enregistrements au total)"
            }
        });

        // Déplacer les boutons vers le conteneur dédié
        table.buttons().container().appendTo('#exportButtons');
    });
</script>


@endsection

