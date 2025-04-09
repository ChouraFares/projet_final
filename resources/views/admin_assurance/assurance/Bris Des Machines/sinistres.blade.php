@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Bris de Machine')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<div class="container">
    <h2 class="text-center mb-4">Liste des Sinistres - Bris de Machine</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('create_BrisDeMachines_sinistres') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Ajouter un Sinistre
        </a>
    </div>

    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Numero De Sinistre</th>
                <th>Compagnie Assurance</th>
                <th>Nature du Sinistre</th>
                <th>Lieu du Sinistre</th>
                <th>Date du Sinistre</th>
                <th>Dégâts</th>
                <th>Chargé</th>
                <th>Perte</th>
                <th>Responsable</th>
                <th>Status</th>
                <th>Expert</th>
                <th>Commentaires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->numero_sinistre }}</td>
                <td>{{ $sinistre->assureur }}</td>
                <td>{{ $sinistre->nature_sinistre }}</td>
                <td>{{ $sinistre->lieu_sinistre }}</td>
                <td>{{ $sinistre->date_sinistre }}</td>
                <td>{{ $sinistre->degats }}</td>
                <td>{{ $sinistre->charge }}</td>
                <td>{{ $sinistre->perte }}</td>
                <td>{{ $sinistre->responsable }}</td>
                <td>{{ $sinistre->statu_du_dossier }}</td>
                <td>{{ $sinistre->expert }}</td>
                <td>{{ $sinistre->commentaires }}</td>
                <td class="actions-column">
                    <a href="{{ route('bris_de_machine.edit', $sinistre->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('bris_de_machine.destroy', $sinistre->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce sinistre ?');">
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

@endsection