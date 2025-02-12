@extends('layouts.app')

@section('title', 'Gestion des Contrats d\'Assurance Maladie')

@section('styles')
<style>
    /* Conteneur principal occupant toute la page */
    .container-fluid {
        padding: 20px;
        width: 100%;
        height: 100vh; /* Hauteur totale de la fenêtre */
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* Style du tableau */
    #contractsTable {
        width: 100% !important; /* Toute la largeur */
        height: 100%; /* Toute la hauteur disponible */
        margin-bottom: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    /* Conteneur du tableau avec flex pour occuper l'espace restant */
    .table-wrapper {
        flex: 1; /* Prend tout l'espace restant */
        overflow-y: auto; /* Défilement vertical si nécessaire */
        overflow-x: auto; /* Défilement horizontal si nécessaire */
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
        position: sticky; /* Fixe l'en-tête en haut */
        top: 0;
        z-index: 1;
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

    .btn i {
        margin-right: 5px; /* Conservé de votre style existant */
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

    /* Colonne Actions */
    .actions-column {
        width: 100px !important;
        min-width: 100px;
        white-space: nowrap;
        text-align: center;
        display: flex;
        flex-direction: column; /* Conservé de votre style existant */
        gap: 5px; /* Conservé de votre style existant */
        align-items: center;
    }

    .actions-column .btn {
        margin: 0; /* Ajusté pour éviter un espacement excessif */
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

    /* Ajustement pour le layout parent si nécessaire */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
@endsection

@section('content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container-fluid">
    <h2 class="text-center mb-4">Liste des Contrats d'Assurance Maladie</h2>

    <!-- Bouton Ajouter -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('contrats_assurance_maladie.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Ajouter un Contrat
        </a>
    </div>

    <!-- Conteneur pour les boutons d'exportation -->
    <div class="d-flex justify-content-start mb-3">
        <div id="exportButtons" class="btn-group"></div>
    </div>

    <!-- Conteneur du tableau avec défilement -->
    <div class="table-wrapper">
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
                        <td class="actions-column">
                            <a href="{{ route('contrats_assurance_maladie.edit', $contrat->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('contrats_assurance_maladie.destroy', $contrat->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce contrat ?')">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
                },
                customize: function(doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*'); // Largeur égale pour toutes les colonnes
                    doc.styles.tableHeader.fontSize = 10;
                    doc.styles.tableBodyEven.fontSize = 10;
                    doc.styles.tableBodyOdd.fontSize = 10;
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
            zeroRecords: "Aucun enregistrement correspondant trouvé",
            infoEmpty: "Aucun enregistrement disponible",
            infoFiltered: "(filtré de _MAX_ enregistrements au total)"
        }
    });

    // Déplacer les boutons vers le conteneur dédié
    table.buttons().container().appendTo('#exportButtons');
});
</script>
@endsection