@extends('layouts.app')

@section('title', 'Gestion des Contrats Flotte')

@section('styles')
@endsection

@section('content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Style pour la colonne Actions */
    .actions-column {
        display: flex;
        flex-direction: row; /* Alignement horizontal */
        gap: 10px; /* Espacement entre les boutons */
        justify-content: center; /* Centre les boutons horizontalement */
        align-items: center; /* Centre les boutons verticalement */
    }

    /* Ajustement des boutons pour cohérence */
    .btn-sm {
        padding: 6px 12px; /* Taille uniforme pour les petits boutons */
    }
</style>

<!-- Conteneur principal -->
<div class="container-fluid">
    <h2 class="text-center mb-4">Liste des Contrats Flotte</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.assurance.flotte.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Ajouter un Contrat
        </a>
    </div>

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Table DataTables -->
    <table id="contratsTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Compagnie Assurance</th>
                <th>Référence Contrat</th>
                <th>Date Effet</th>
                <th>Échéance</th>
                <th>Condition Renouvellement</th>
                <th>Avenant</th>
                <th>Objet Avenant</th>
                <th>Attachement Contrat</th>
                <th>Attachement Avenant</th>
                <th>Actions</th>
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
                <td class="actions-column">
                    <a href="{{ route('admin.assurance.flotte.edit', $contrat->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('admin.assurance.flotte.destroy', $contrat->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?');">
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
        var table = $('#contratsTable').DataTable({
            scrollX: true,
            autoWidth: false,
            dom: 'Bfrtip',
            pageLength: 10, // Nombre d'enregistrements par page
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':not(:nth-child(8)):not(:nth-child(9)):not(:nth-child(10))' // Exclut les colonnes Attachement Contrat (8), Attachement Avenant (9) et Actions (10)
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:nth-child(8)):not(:nth-child(9)):not(:nth-child(10))' // Exclut les colonnes Attachement Contrat (8), Attachement Avenant (9) et Actions (10)
                    },
                    customize: function(doc) {
                        doc.content[1].table.widths = ['15%', '15%', '15%', '15%', '10%', '10%', '10%']; // Ajustement pour PDF
                        doc.styles.tableHeader.fontSize = 10;
                        doc.styles.tableBodyEven.fontSize = 10;
                        doc.styles.tableBodyOdd.fontSize = 10;
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