@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Assurance Retraite')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .actions-column {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .btn i {
        margin-right: 5px;
    }
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">Liste des Sinistres - Assurance Retraite</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('AssuranceRetraiteSinistres') }}" class="btn btn-primary btn-lg">
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
                <th>Assureur</th>
                <th>Nature du Sinistre</th>
                <th>Lieu du Sinistre</th>
                <th>Date du Sinistre</th>
                <th>Dégâts</th>
                <th>Charge</th>
                <th>Perte</th>
                <th>Responsable</th>
                <th>Commentaires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->Assureur }}</td>
                <td>{{ $sinistre->nature_sinistre }}</td>
                <td>{{ $sinistre->lieu_sinistre }}</td>
                <td>{{ $sinistre->date_sinistre }}</td>
                <td>{{ $sinistre->degats }}</td>
                <td>{{ $sinistre->charge }}</td>
                <td>{{ $sinistre->perte }}</td>
                <td>{{ $sinistre->responsable }}</td>
                <td>{{ $sinistre->commentaires }}</td>
                <td class="actions-column">
                    <a href="{{ route('AssuranceRetraite.sinistres.edit', $sinistre->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('AssuranceRetraite.sinistres.destroy', $sinistre->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre ?');">
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
    var table = $('#contractsTable').DataTable({
        scrollX: true,  // Active le défilement horizontal si nécessaire
        autoWidth: false,
        dom: 'Bfrtip',
        pageLength: 10, // Nombre d'éléments affichés par page
        lengthMenu: [10, 25, 50, 100], // Options de pagination
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
            info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements"
        }
    });
});
</script>

@endsection
