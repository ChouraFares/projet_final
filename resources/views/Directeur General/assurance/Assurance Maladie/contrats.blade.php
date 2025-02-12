@extends('layouts.app')

@section('title', 'Gestion des Contrats d\'Assurance Maladie')

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

<div class="container">
    <h2 class="text-center mb-4">Liste des Contrats d'Assurance Maladie</h2>

    <!-- Bouton Ajouter -->
 

    <!-- Table DataTables -->
    <table id="contractsTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Compagnie d'Assurance</th>
                <th>Référence Contrat</th>
                <th>Date d'Effet</th>
                <th>Échéance</th>
                <th>Condition de Renouvellement</th>
                <th>Avenant</th>
                <th>Objet de l'Avenant</th>
                <th>Attachement Contrat</th>
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
                    <td>{{ $contrat->avenant }}</td>
                    <td>{{ $contrat->objet_avenant }}</td>
                    <td>
                        @if($contrat->attachement_contrat)
                        <a href="{{ asset('storage/' . $contrat->attachement_contrat) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-alt"></i> Voir
                        </a>
                        @else
                            Aucun fichier
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
                    columns: ':not(:nth-child(8), :last-child)' // Exclure la colonne Attachement Contrat et Actions
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:nth-child(8), :last-child)' // Exclure la colonne Attachement Contrat et Actions
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
