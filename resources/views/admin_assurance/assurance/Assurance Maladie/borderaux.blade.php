@extends('layouts.app')

@section('title', 'Assurance Maladie')

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
        flex-direction: column;
        align-items: center;
    }

    .actions-column .btn {
        margin: 5px 0;
    }

    /* Badges */
    .badge {
        font-size: 12px;
        padding: 6px 10px;
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
        .badge {
            font-size: 10px;
            padding: 4px 8px;
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

<!-- Conteneur principal -->
<div class="container-fluid">
    <h2 class="text-center mb-4">Assurance Maladie</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.assurance.AssuranceMaladie.create') }}" class="btn btn-primary btn-lg">
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
                    <th>Date d'Envoi</th>
                    <th>Numéro Bordereau</th>
                    <th>Numéro Bulletin</th>
                    <th>Nom Adhérent</th>
                    <th>Matricule</th>
                    <th>Date de Soin</th>
                    <th>Statut</th>
                    <th>Réclamation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assurances as $assurance)
                    <tr>
                        <td>{{ $assurance->date_envoi }}</td>
                        <td>{{ $assurance->numero_borderaux }}</td>
                        <td>{{ $assurance->bulletin_numero }}</td>
                        <td>{{ $assurance->nom_adherent }}</td>
                        <td>{{ $assurance->matricule }}</td>
                        <td>{{ $assurance->date_de_soin }}</td>
                        <td>
                            @if ($assurance->status == 'Remis')
                                <span class="badge bg-success">Remis</span>
                            @elseif ($assurance->status == 'Non Remis')
                                <span class="badge bg-warning text-dark">Non Remis</span>
                            @else
                                <span class="badge bg-danger">Clôturé</span>
                            @endif
                        </td>
                        <td>{{ $assurance->reclamation ?? 'Aucune' }}</td>
                        <td class="actions-column">
                            <a href="{{ route('AssuranceMaladie.edit', $assurance->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('AssuranceMaladieDestroy', $assurance->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer ce contrat ?');">
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
        dom: 'lBfrtip', // Ajout explicite de 'l' pour le menu de longueur
        pageLength: 10, // Par défaut, 10 enregistrements pour maximiser l'espace
        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Tous"]],
        lengthChange: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter Excel',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclure la colonne "Actions"
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclure la colonne "Actions"
                },
                customize: function(doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
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

    // Personnaliser le menu de sélection
    $('.dataTables_length label').addClass('d-flex align-items-center gap-2');
    $('.dataTables_length select').addClass('form-select');
});
</script>
@endsection