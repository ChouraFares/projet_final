@extends('layouts.app')

@section('title', 'Contrats - Bris Des Machines')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<div class="container">
    <h2 class="text-center mb-4">Liste des Contrats - Bris Des Machines</h2>



    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <table id="contratsTable" class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Compagnie Assurance</th>
                <th>Réf Contrat</th>
                <th>Date Effet</th>
                <th>Échéance</th>
                <th>Renouvellement</th>
                <th>Avenant</th>
                <th>Objet Avenant</th>
                <th>Attachement Contrat (PDF)</th>
                <th>Attachement Avenant (PDF)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contrats as $contrat)
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
                            <i class="fas fa-file-pdf"></i> Voir
                        </a>
                    @else
                        <span class="text-muted">Aucun fichier</span>
                    @endif
                </td>
                <td>
                    @if($contrat->attachement_avenant)
                        <a href="{{ asset('storage/' . $contrat->attachement_avenant) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-pdf"></i> Voir
                        </a>
                    @else
                        <span class="text-muted">Aucun fichier</span>
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
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#contratsTable').DataTable({
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
                        columns: ':not(:nth-child(8)):not(:nth-child(9)):not(:nth-child(10))'  // Exclut les colonnes 8, 9 et 10
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:nth-child(8)):not(:nth-child(9)):not(:nth-child(10))'  // Exclut les colonnes 8, 9 et 10
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
                search: "Rechercher :",
                infoEmpty: "Aucun enregistrement disponible",
                zeroRecords: "Aucune correspondance trouvée",
                infoFiltered: "(filtré à partir de _MAX_ enregistrements au total)"
            }
        });

        // Déplacer les boutons vers le conteneur dédié
        table.buttons().container().appendTo('#exportButtons');
    });
</script>


@endsection

