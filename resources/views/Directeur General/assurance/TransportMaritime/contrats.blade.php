@extends('layouts.app')

@section('title', 'Gestion des Contrats - Transport Maritime')

@section('content')

<!-- DataTables CSS -->

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">Liste des Contrats - Transport Maritime</h2>

    <!-- Section pour les boutons et la recherche -->
 

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
            dom: 'Bfrtip', // Les éléments de l'interface utilisateur (Boutons, Pagination, etc.)
            pageLength: 10, // Affiche 10 enregistrements par page
            lengthMenu: [10, 25, 50, 100], // Options de pagination
            language: {
                paginate: {
                    previous: "Précédent", // Texte pour le bouton précédent
                    next: "Suivant" // Texte pour le bouton suivant
                },
                lengthMenu: "Afficher _MENU_ enregistrements par page",
                info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
                search: "Rechercher :",
                infoEmpty: "Aucun enregistrement disponible",
                zeroRecords: "Aucune correspondance trouvée",
                infoFiltered: "(filtré à partir de _MAX_ enregistrements au total)"
            },
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
            ]
        });

        // Déplacer les boutons vers le conteneur dédié
        table.buttons().container().appendTo('#exportButtons');
    });
</script>

@endsection



