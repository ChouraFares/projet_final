@extends('layouts.app')

@section('title', 'Gestion des Contrats MRD')

@section('styles')
<style>
    /* Conteneur principal */
    .container-fluid {
        padding: 20px;
        width: 100%;
        max-width: 100%; /* Supprime la limitation de largeur */
    }

    /* Style du tableau */
    #contractsTable {
        width: 100% !important; /* Forcer le tableau à prendre toute la largeur */
        margin-bottom: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    #contractsTable th, #contractsTable td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
    }

    #contractsTable thead th {
        background-color: #343a40; /* Gris foncé pour l'en-tête */
        color: white;
        font-weight: bold;
    }

    #contractsTable tbody tr:nth-child(even) {
        background-color: #f8f9fa; /* Gris clair pour les lignes paires */
    }

    #contractsTable tbody tr:hover {
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
        #contractsTable th, #contractsTable td {
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
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Conteneur principal -->
<div class="container-fluid">
    <h2 class="text-center mb-4">Liste des Contrats MRD</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.mrd.contrats.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Ajouter un Contrat
        </a>
    </div>

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Table DataTables -->
    <table id="contractsTable" class="table table-striped table-bordered shadow-sm">
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
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    @else
                        <span class="text-muted">Aucun fichier</span>
                    @endif
                </td>
                <td>
                    @if($contrat->attachement_avenant)
                        <a href="{{ asset('storage/' . $contrat->attachement_avenant) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    @else
                        <span class="text-muted">Aucun fichier</span>
                    @endif
                </td>
                <td class="d-flex justify-content-around">
                    <a href="{{ route('admin.mrd.contrats.edit', $contrat->id) }}" class="btn btn-warning btn-sm mr-2">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('admin.mrd.contrats.destroy', $contrat->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce contrat ?');">
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
        var table = $('#contractsTable').DataTable({
            scrollX: true,
            autoWidth: false,
            dom: 'Bfrtip',
            pageLength: 10, // Afficher 10 lignes par page avec pagination
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':not(:nth-child(8), :nth-child(9), :last-child)' // Exclure les colonnes "Attachement Contrat", "Attachement Avenant" et "Actions"
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:nth-child(8), :nth-child(9), :last-child)' // Exclure les colonnes "Attachement Contrat", "Attachement Avenant" et "Actions"
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