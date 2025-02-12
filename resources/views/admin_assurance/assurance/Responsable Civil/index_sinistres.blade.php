@extends('layouts.app')

@section('title', 'Gestion des Sinistres - Responsabilité Civile')

@section('styles')
<style>
    /* Conteneur principal */
    .container-fluid {
        padding: 20px;
        width: 100%;
        max-width: 100%; /* Supprime la limitation de largeur */
    }

    /* Style du tableau */
    #sinistresTable {
        width: 100% !important; /* Forcer le tableau à prendre toute la largeur */
        margin-bottom: 20px;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    #sinistresTable th, #sinistresTable td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
        max-width: 150px; /* Gardé de votre style existant */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #sinistresTable thead th {
        background-color: #343a40; /* Gris foncé pour l'en-tête */
        color: white;
        font-weight: bold;
    }

    #sinistresTable tbody tr:nth-child(even) {
        background-color: #f8f9fa; /* Gris clair pour les lignes paires */
    }

    #sinistresTable tbody tr:hover {
        background-color: #e9ecef; /* Survol des lignes */
        transition: background-color 0.3s;
    }

    /* Boutons */
    .btn {
        border-radius: 5px;
        font-size: 14px;
        padding: 8px 12px; /* Ajusté pour cohérence */
        display: inline-block !important; /* Gardé de votre style existant */
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
        margin-right: 10px; /* Ajusté pour cohérence */
    }

    /* Colonne Actions */
    .actions-column {
        width: 100px !important; /* Gardé de votre style existant */
        min-width: 100px;
        white-space: nowrap;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center; /* Gardé de votre style existant */
    }

    .actions-column .btn {
        margin: 5px; /* Gardé de votre style existant */
    }

    /* Responsive */
    @media (max-width: 768px) {
        #sinistresTable th, #sinistresTable td {
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
    <h2 class="text-center mb-4">Liste des Sinistres - Responsabilité Civile</h2>

    <!-- Section pour les boutons et la recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('create_ResponsableCivil_sinistres') }}" class="btn btn-primary btn-lg">
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
                <th>Numero De Sinistre</th>
                <th>Compagnie Assurance</th> <!-- Assureur -->
                <th>Nature du Sinistre</th>
                <th>Lieu du Sinistre</th>
                <th>Date du Sinistre</th>
                <th>Dégâts</th>
                <th>Charge</th>
                <th>Perte</th>
                <th>Responsable</th>
                <th>Status</th> <!-- Situation du dossier -->
                <th>Commentaires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->numero_de_sinistre }}</td>
                <td>{{ $sinistre->assureur }}</td>
                <td>{{ $sinistre->nature_sinistre }}</td>
                <td>{{ $sinistre->lieu_sinistre }}</td>
                <td>{{ $sinistre->date_sinistre }}</td>
                <td>{{ $sinistre->degats }}</td>
                <td>{{ $sinistre->charge }}</td>
                <td>{{ $sinistre->perte }}</td>
                <td>{{ $sinistre->responsable }}</td>
                <td>{{ $sinistre->situation_du_dossier }}</td>
                <td>{{ $sinistre->commentaires }}</td>
                <td class="actions-column">
                    <a href="{{ route('ResponsableCivil.sinistres.edit', $sinistre->id) }}" class="btn btn-warning btn-sm mb-2">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('ResponsableCivil.sinistres.destroy', $sinistre->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre ?');">
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
            dom: 'Bfrtip',
            pageLength: 10, // Affichage de 10 lignes par page avec pagination
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
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*'); // Largeur égale pour toutes les colonnes
                        doc.styles.tableHeader.fontSize = 8; // Taille ajustée pour lisibilité
                        doc.styles.tableBodyEven.fontSize = 8;
                        doc.styles.tableBodyOdd.fontSize = 8;
                        doc.compress = true; // Compression activée
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