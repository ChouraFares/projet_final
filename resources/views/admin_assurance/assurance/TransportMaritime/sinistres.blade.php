@extends('layouts.app')

@section('title', 'Sinistres - TM')

@section('content')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        transform: scale(0.6);
        transform-origin: 0 0;
        /* pour ancrer le zoom en haut à gauche */
        width: 200%;
        /* ajuster la largeur pour éviter les scrolls horizontaux */
    }

    :root {
        --primary-color: #f39c12;
        --secondary-color: #060401;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --info-color: #2980b9;
        --en-attente-color: #f39c12;
        --termine-color: #27ae60;
        --rejete-color: #e74c3c;
        --perte-color: #3498db;
        --avarie-color: #9b59b6;
        --retard-color: #e67e22;
        --contamination-color: #e74c3c;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .container-fluid {
        padding: 2rem;
        max-width: 100%;
    }

    h2.text-center {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #f39c12;
        border-bottom: 2px solid #eee;
        padding-bottom: 1rem;
    }

    /* Badges génériques */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    /* Badges pour Statut */
    .status-en-attente {
        background-color: rgba(243, 156, 18, 0.1);
        color: var(--en-attente-color);
        border: 1px solid rgba(243, 156, 18, 0.3);
    }

    .status-termine {
        background-color: rgba(39, 174, 96, 0.1);
        color: var(--termine-color);
        border: 1px solid rgba(39, 174, 96, 0.3);
    }

    .status-rejete {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--rejete-color);
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    /* Badges pour Nature */
    .nature-perte {
        background-color: rgba(52, 152, 219, 0.1);
        color: var(--perte-color);
        border: 1px solid rgba(52, 152, 219, 0.3);
    }

    .nature-avarie {
        background-color: rgba(155, 89, 182, 0.1);
        color: var(--avarie-color);
        border: 1px solid rgba(155, 89, 182, 0.3);
    }

    .nature-retard {
        background-color: rgba(230, 126, 34, 0.1);
        color: var(--retard-color);
        border: 1px solid rgba(230, 126, 34, 0.3);
    }

    .nature-contamination {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--contamination-color);
        border: 1px solid rgba(231, 76, 60, 0.3);
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

    #sinistresTable tfoot th {
        padding: 0.5rem;
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }

    #sinistresTable tfoot input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ced4da;
        border-radius: var(--border-radius);
        font-size: 0.9rem;
        box-sizing: border-box;
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

    .actions-column {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    #exportButtons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Icônes spécifiques */
    .fa-hourglass-half {
        color: var(--en-attente-color);
    }

    .fa-check-circle {
        color: var(--termine-color);
    }

    .fa-times-circle {
        color: var(--rejete-color);
    }

    .fa-box-open {
        color: var(--perte-color);
    }

    .fa-tools {
        color: var(--avarie-color);
    }

    .fa-clock {
        color: var(--retard-color);
    }

    .fa-biohazard {
        color: var(--contamination-color);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .container-fluid {
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
            border-bottom: 1px solid #eee;
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

    /* Style personnalisé pour le sélecteur lengthMenu */
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--border-radius);
        border: 1px solid #ced4da;
        padding: 0.3rem;
    }
    .comment-cell {
        cursor: pointer;
        position: relative;
    }

    .comment-cell:hover {
        background-color: rgba(52, 152, 219, 0.1);
    }

    /* Style pour la modale */
    .comment-modal .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .comment-modal .modal-header {
        background-color: #f39c12;
        color: white;
        border-bottom: none;
        border-radius: 10px 10px 0 0;
    }

    .comment-modal .modal-body {
        padding: 20px;
        white-space: pre-wrap;
        font-size: 16px;
        line-height: 1.6;
    }

    .comment-modal .modal-footer {
        border-top: none;
        justify-content: center;
    }

    /* Style pour le texte tronqué */
    .truncated-comment {
        display: inline-block;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="container-fluid">
    <h2 class="text-center mb-4">
        <i class="fas fa-ship me-2"></i>Liste des Sinistres - Transport Maritime
    </h2>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <a href="{{ route('create_maritime_sinistres') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Sinistre
        </a>
        <div id="exportButtons" class="d-flex gap-2"></div>
    </div>

    <table id="sinistresTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Compagnie</th>
                <th>Prime</th>
                <th>Fournisseur</th>
                <th>N° Facture</th>
                <th>Montant (USD)</th>
                <th>Montant (TND)</th>
                <th>N° Conteneur</th>
                <th>Date Dépôt</th>
                <th>Transporteur</th>
                <th>Date Incident</th>
                <th>Lieu</th>
                <th>Montant Assuré</th>
                <th>Date Remb.</th>
                <th>Nature</th>
                <th>Statut</th>
                <th>Commentaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sinistres as $sinistre)
            <tr>
                <td data-label="Numéro">{{ $sinistre->numero_sinistre }}</td>
                <td data-label="Compagnie">{{ $sinistre->assureur }}</td>
                <td data-label="Prime">{{ $sinistre->prime }}</td>
                <td data-label="Fournisseur">{{ $sinistre->fournisseur }}</td>
                <td data-label="N° Facture">{{ $sinistre->num_facture }}</td>
                <td data-label="Montant (USD)">{{ number_format($sinistre->montant_facture_usd, 2) }}</td>
                <td data-label="Montant (TND)">{{ number_format($sinistre->montant_facture_tnd, 3) }}</td>
                <td data-label="N° Conteneur">{{ $sinistre->num_conteneur }}</td>
                <td data-label="Date Dépôt">{{ $sinistre->date_depot }}</td>
                <td data-label="Transporteur">{{ $sinistre->transporteur_maritime }}</td>
                <td data-label="Date Incident">{{ $sinistre->date_incident }}</td>
                <td data-label="Lieu">{{ $sinistre->lieu }}</td>
                <td data-label="MT">{{ $sinistre->mt }}</td>
                <td data-label="Date Remb.">{{ $sinistre->date_prev_remboursement }}</td>
                <td data-label="Nature">
                    @switch($sinistre->nature_de_sinistre)
                    @case('Perte totale')
                    <span class="badge nature-perte">
                        <i class="fas fa-box-open me-1"></i> Perte
                    </span>
                    @break
                    @case('Avarie')
                    <span class="badge nature-avarie">
                        <i class="fas fa-tools me-1"></i> Avarie
                    </span>
                    @break
                    @case('Retard')
                    <span class="badge nature-retard">
                        <i class="fas fa-clock me-1"></i> Retard
                    </span>
                    @break
                    @case('Contamination')
                    <span class="badge nature-contamination">
                        <i class="fas fa-biohazard me-1"></i> Contamination
                    </span>
                    @break
                    @default
                    <span class="badge">{{ $sinistre->nature_de_sinistre }}</span>
                    @endswitch
                </td>
                <td data-label="Statut">
                    @switch($sinistre->statut_du_dossier)
                    @case('En attente')
                    <span class="badge status-en-attente">
                        <i class="fas fa-hourglass-half me-1"></i> En attente
                    </span>
                    @break
                    @case('Terminé')
                    <span class="badge status-termine">
                        <i class="fas fa-check-circle me-1"></i> Terminé
                    </span>
                    @break
                    @case('Rejeté')
                    <span class="badge status-rejete">
                        <i class="fas fa-times-circle me-1"></i> Rejeté
                    </span>
                    @break
                    @default
                    <span class="badge">{{ $sinistre->statut_du_dossier }}</span>
                    @endswitch
                </td>
                <td data-label="Commentaire">{{ Str::limit($sinistre->commentaire, 60) }}</td>
                <td data-label="Actions" class="actions-column">
                    <a href="{{ route('edit_maritime_sinistres', $sinistre->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('destroy_maritime_sinistres', $sinistre->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Supprimer">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Numéro</th>
                <th>Compagnie</th>
                <th>Prime</th>
                <th>Fournisseur</th>
                <th>N° Facture</th>
                <th>Montant (USD)</th>
                <th>Montant (TND)</th>
                <th>N° Conteneur</th>
                <th>Date Dépôt</th>
                <th>Transporteur</th>
                <th>Date Incident</th>
                <th>Lieu</th>
                <th>Montant Assuré</th>
                <th>Date Remb.</th>
                <th>Nature</th>
                <th>Statut</th>
                <th>Commentaire</th>
                <th></th> {{-- Colonne Actions, pas de filtre --}}
            </tr>
        </tfoot>

    </table>
</div>
<!-- jQuery et DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        // Ajout d’un champ de recherche dans chaque cellule du pied de table
        $('#sinistresTable tfoot th').each(function(i) {
            if (i < 17) { // On ne met pas de filtre sur la colonne "Actions"
                $(this).html('<input type="text" placeholder="Rechercher..." style="width: 100%;" />');
            } else {
                $(this).html('');
            }
        });

        // Initialisation de DataTable avec options
        var table = $('#sinistresTable').DataTable({
            dom: 'lBfrtip', // 'l' pour lengthMenu (le sélecteur du nombre d'enregistrements par page)
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            lengthMenu: [
                [10, 15, 20, 30, -1],
                [10, 15, 20, 30, 'Tous']
            ],
            pageLength: 10, // Nombre d'enregistrements par défaut à l'affichage
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    $('input', this.footer()).on('keyup change clear', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                });

                // Placement des boutons d'exportation dans le conteneur dédié
                $('#exportButtons').append(table.buttons().container());
            },
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            }
        });

        // Mise en forme du sélecteur lengthMenu
        $('.dataTables_length').addClass('d-flex align-items-center');
        $('.dataTables_length label').addClass('me-2');
        $('.dataTables_length select').css('margin-left', '0.5rem'); // Ajustez l'espacement selon vos besoins
    });
</script>

@endsection

