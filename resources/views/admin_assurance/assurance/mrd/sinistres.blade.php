@extends('layouts.app')

@section('title', 'Gestion des Sinistres - MRD')

@section('content')

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-color: #f39c12;
        --secondary-color: #F4A261;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --success-color: #27ae60;
        --info-color: #2980b9;
        --fire-color: #e74c3c;           /* Rouge pour Incendie */
        --theft-color: #9b59b6;          /* Violet pour Vol */
        --accident-color: #f39c12;       /* Orange pour Accident */
        --natural-disaster-color: #1abc9c; /* Turquoise pour Catastrophe naturelle */
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .container {
        max-width: 100%;
        padding: 2rem;
        margin: 0 auto;
    }

    h2.text-center {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: var(--secondary-color);
    }

    /* Badges pour les types de sinistres */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .badge-incendie {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--fire-color);
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .badge-vol {
        background-color: rgba(155, 89, 182, 0.1);
        color: var(--theft-color);
        border: 1px solid rgba(155, 89, 182, 0.3);
    }

    .badge-accident {
        background-color: rgba(243, 156, 18, 0.1);
        color: var(--accident-color);
        border: 1px solid rgba(243, 156, 18, 0.3);
    }

    .badge-catastrophe {
        background-color: rgba(26, 188, 156, 0.1);
        color: var(--natural-disaster-color);
        border: 1px solid rgba(26, 188, 156, 0.3);
    }

    /* Tableau */
    #sinistresTable {
        width: 100% !important;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    #sinistresTable thead th {
        background-color: var(--secondary-color);
        color: white;
        font-weight: 600;
        padding: 1rem;
        text-align: center;
        position: sticky;
        top: 0;
        border-bottom: 2px solid #ddd;
    }

    #sinistresTable tbody td {
        padding: 0.75rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    #sinistresTable tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    /* Boutons */
    .btn {
        border-radius: var(--border-radius);
        padding: 0.5rem 1rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* Colonne Actions */
    .actions-column {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    /* Export buttons */
    #exportButtons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Icônes spécifiques */
    .fa-fire { color: var(--fire-color); }
    .fa-user-secret { color: var(--theft-color); }
    .fa-car-crash { color: var(--accident-color); }
    .fa-cloud-showers-heavy { color: var(--natural-disaster-color); }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        #sinistresTable thead {
            display: none;
        }
        
        #sinistresTable tbody td {
            display: block;
            text-align: right;
            padding-left: 50%;
            position: relative;
        }
        
        #sinistresTable tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: calc(50% - 1rem);
            padding-right: 1rem;
            text-align: left;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .actions-column {
            justify-content: flex-end;
        }
    }
</style>

<!-- Conteneur principal -->
<div class="container">
    <h2 class="text-center mb-4">
        <i class="fas fa-file-contract me-2"></i>Liste des Sinistres - MRD
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <a href="{{ route('admin.mrd.sinistres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Sinistre
        </a>
        <div id="exportButtons" class="d-flex gap-2"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Numéro</th>
                <th>Compagnie</th>
                <th>Fournisseur</th>
                <th>Nature</th>
                <th>Lieu</th>
                <th>Date</th>
                <th>Dégâts</th>
                <th>Charge</th>
                <th>Perte</th>
                <th>Remboursement</th>
                <th>Responsable</th>
                <th>Commentaires</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td data-label="Numéro">{{ $sinistre->numero_sinistre }}</td>
                <td data-label="Compagnie">{{ $sinistre->compagnie_assurance }}</td>
                <td data-label="Fournisseur">{{ $sinistre->fournisseur }}</td>
                <td data-label="Nature">
                    @switch($sinistre->nature_sinistre)
                        @case('Incendie')
                            <span class="badge badge-incendie">
                                <i class="fas fa-fire me-1"></i> Incendie
                            </span>
                            @break
                        @case('Vol')
                            <span class="badge badge-vol">
                                <i class="fas fa-user-secret me-1"></i> Vol
                            </span>
                            @break
                        @case('Accident')
                            <span class="badge badge-accident">
                                <i class="fas fa-car-crash me-1"></i> Accident
                            </span>
                            @break
                        @case('Catastrophe naturelle')
                            <span class="badge badge-catastrophe">
                                <i class="fas fa-cloud-showers-heavy me-1"></i> Catastrophe naturelle
                            </span>
                            @break
                        @default
                            <span class="badge">{{ $sinistre->nature_sinistre }}</span>
                    @endswitch
                </td>
                <td data-label="Lieu">{{ $sinistre->lieu_sinistre }}</td>
                <td data-label="Date">{{ $sinistre->date_sinistre }}</td>
                <td data-label="Dégâts">{{ $sinistre->degats }}</td>
                <td data-label="Charge">{{ $sinistre->charge }}</td>
                <td data-label="Perte">{{ $sinistre->perte }}</td>
                <td data-label="Remboursement">{{ $sinistre->estimation_de_remboursement }}</td>
                <td data-label="Responsable">{{ $sinistre->responsable }}</td>
                <td data-label="Commentaires">{{ Str::limit($sinistre->commentaires, 20) }}</td>
                <td data-label="Status">{{ $sinistre->statut }}</td>
                <td data-label="Actions" class="actions-column">
                    <a href="{{ route('admin.mrd.sinistres.edit', $sinistre->id) }}" 
                       class="btn btn-warning btn-sm" 
                       data-bs-toggle="tooltip" 
                       title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.mrd.sinistres.destroy', $sinistre->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce sinistre ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-sm" 
                                data-bs-toggle="tooltip" 
                                title="Supprimer">
                            <i class="fas fa-trash-alt"></i>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#sinistresTable').DataTable({
        scrollX: true,
        dom: 'lBfrtip',
        pageLength: 10,
        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Tous"]],
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                customize: function(doc) {
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 9;
                    doc.pageMargins = [20, 40, 20, 40];
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('auto');
                }
            }
        ],
        language: {
            lengthMenu: "Afficher _MENU_ enregistrements",
            search: "_INPUT_",
            searchPlaceholder: "Rechercher...",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
            infoEmpty: "Aucun enregistrement disponible",
            infoFiltered: "(filtré de _MAX_ enregistrements au total)",
            paginate: {
                first: "Premier",
                last: "Dernier",
                next: "Suivant",
                previous: "Précédent"
            }
        },
        initComplete: function() {
            this.api().buttons().container().appendTo('#exportButtons');
        }
    });

    // Initialiser les tooltips
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
});
</script>

@endsection