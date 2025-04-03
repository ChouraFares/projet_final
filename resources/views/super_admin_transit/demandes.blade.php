@extends('layouts.transit')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Consulter Les Demandes Des Factures Complémentaires Thon</h2>

    <!-- Table DataTables -->
    <div class="dt-container">
        <div class="table-responsive">
            <table id="facturesTable" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2">Date & Heure D'envoi</th>
                        <th rowspan="2">Facture</th>
                        <th rowspan="2">Fournisseur</th>
                        <th rowspan="2">Incoterm</th>
                        <th rowspan="2">Armateur</th>
                        <th rowspan="2">Port</th>
                        <th rowspan="2">Banque</th>
                        <th rowspan="2">Date Déclaration</th>
                        <th rowspan="2">Assureur</th>
                        <th rowspan="2">Date Expiration</th>
                        <th rowspan="2">BL</th>
                        <th colspan="2">Assurance</th>
                        <th colspan="2">Douane</th>
                        <th colspan="2">Recette Finances</th>
                        <th colspan="2">STAM</th>
                        <th colspan="2">Timbrage et avances surestaries</th>
                        <th rowspan="2">Date Récupération</th>
                        <th rowspan="2">Date Enlèvement</th>
                        <th rowspan="2">Validation Transit</th>
                        <th rowspan="2">Validation Finance</th>
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th>Préparer Paiement</th>
                        <th>Détails</th>
                        <th>Préparer Paiement</th>
                        <th>Détails</th>
                        <th>Préparer Paiement</th>
                        <th>Détails</th>
                        <th>Préparer Paiement</th>
                        <th>Détails</th>
                        <th>Préparer Paiement</th>
                        <th>Détails</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $factureGroups = [];
                        $colors = ['group-1', 'group-2', 'group-3', 'group-4', 'group-5', 'group-6', 'group-7', 'group-8', 'group-9', 'group-10'];
                        $colorIndex = 0;
                    @endphp

                    @foreach($factures as $facture)
                        @php
                            if (!array_key_exists($facture->facture, $factureGroups)) {
                                $factureGroups[$facture->facture] = $colors[$colorIndex % count($colors)];
                                $colorIndex++;
                            }
                            $groupClass = $factureGroups[$facture->facture];
                        @endphp
                        <tr>
                            <td class="{{ $groupClass }}">
                                @if($facture->date_demande)
                                    {{ $facture->date_demande->addHour()->format('d/m/Y H:i:s') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="{{ $groupClass }}"><i class="fas fa-folder"></i> {{ $facture->facture }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->fournisseur }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->incoterm }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->armateur }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->port }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->bank }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->date_declaration }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->assureur }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->date_expiration }}</td>
                            <td class="{{ $groupClass }}">{{ $facture->BL }}</td>

                            @php
                                $sections = ['assurance', 'douane', 'recette_finance', 'stam', 'timbrage_et_avances_surestarie'];
                            @endphp

                            @foreach($sections as $section)
                                <td>{{ $facture->{$section.'_preparer_paiement'} ? '✔' : '' }}</td>
                                @if($facture->{$section.'_preparer_paiement'})
                                    <td>
                                        @if($section == 'assurance')
                                            <a href="{{ route('facture.complimentaire.thon.cheques.assurance', ['id' => $facture->id]) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Voir plus
                                            </a>
                                        @elseif($section == 'timbrage_et_avances_surestarie')
                                            <a href="{{ route('detaille_timbrage_avance_surestarie', ['id' => $facture->id]) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Voir plus
                                            </a>
                                        @else
                                            <a href="{{ route('facture.complimentaire.thon.cheques', ['id' => $facture->id, 'type' => $section]) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Voir plus
                                            </a>
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach

                            <td>{{ $facture->date_recuperation }}</td>
                            <td>{{ $facture->date_enlevement }}</td>

                            <!-- Statut de validation Transit -->
                            <td>
                                @php
                                    $validationStatus = $facture->validation_transit ?? 'En attente';
                                    $badgeClass = 'badge-en-attente';
                                    $iconClass = 'fas fa-hourglass-half';
                                    if ($validationStatus == 'Validé') {
                                        $badgeClass = 'badge-valide';
                                        $iconClass = 'fas fa-check-circle';
                                    } elseif ($validationStatus == 'Refusé') {
                                        $badgeClass = 'badge-refuse';
                                        $iconClass = 'fas fa-times-circle';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="{{ $iconClass }}"></i> {{ $validationStatus }}
                                </span>
                            </td>

                            <!-- Statut de validation Finance -->
                            <td>
                                @php
                                    $validationFinanceStatus = $facture->validation_finance ?? 'en attente';
                                    $badgeClass = 'badge-non-cloture';
                                    $iconClass = 'fas fa-hourglass-half';
                                    if ($validationFinanceStatus == 'Validé') {
                                        $badgeClass = 'badge-cloture';
                                        $iconClass = 'fas fa-check-circle';
                                    } elseif ($validationFinanceStatus == 'Refusé') {
                                        $badgeClass = 'badge-danger';
                                        $iconClass = 'fas fa-times-circle';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="{{ $iconClass }}"></i> {{ $validationFinanceStatus }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td>
                                <form action="{{ route('super_admin_transit.validate', $facture->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-success btn-sm btn-approve">
                                        <i class="fas fa-check-circle"></i> Approuver
                                    </button>
                                </form>
                                <form action="{{ route('super_admin_transit.validate', $facture->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-danger btn-sm btn-reject">
                                        <i class="fas fa-times-circle"></i> Refuser
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Ajout des dépendances CSS pour DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
        padding: 5px 10px;
        font-size: 14px;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-approve {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        margin-right: 5px;
    }

    .btn-approve:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-reject {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-reject:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-bordered thead th {
        background-color: #f8f9fa;
    }

    /* Styles pour les groupes de factures */
    td.group-1 { background-color: #f67206 !important; }
    td.group-2 { background-color: #fc0909 !important; }
    td.group-3 { background-color: #7a9b03 !important; }
    td.group-4 { background-color: #7b0ee8 !important; }
    td.group-5 { background-color: #00c0fb !important; }
    td.group-6 { background-color: #2105f9 !important; }
    td.group-7 { background-color: #e542ca !important; }
    td.group-8 { background-color: #f2f843 !important; }
    td.group-9 { background-color: #8c4949 !important; }
    td.group-10 { background-color: #333350 !important; }

    /* Style pour le champ select de DataTables */
    .dataTables_length select {
        color: #000000 !important; /* Texte en noir */
        background-color: #ffffff !important; /* Fond blanc */
        border: 1px solid #ced4da; /* Bordure légère */
        padding: 5px;
    }
</style>

<!-- Ajout des dépendances JS pour DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#facturesTable').DataTable({
        "scrollX": true,
        "paging": true,
        "searching": true, // Active la recherche
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "lengthMenu": [10, 20, 30, 50, 100], // Options pour afficher 10, 20, 30, 50, 100 lignes
        "pageLength": 10, // Par défaut, affiche 10 lignes
        "columnDefs": [
            { "orderable": false, "targets": [1] } // Désactiver tri sur facture
        ],
        "language": {
            "lengthMenu": "Afficher _MENU_ entrées", // Texte personnalisé pour le menu
            "search": "Rechercher :", // Texte pour le champ de recherche
            "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            "infoEmpty": "Aucune entrée disponible",
            "infoFiltered": "(filtré de _MAX_ entrées au total)",
            "paginate": {
                "previous": "Précédent",
                "next": "Suivant"
            }
        },
        "drawCallback": function(settings) {
            // Réappliquer les classes après chaque redraw de DataTables
            @php
                foreach($factureGroups as $factureNum => $groupClass) {
                    echo "document.querySelectorAll('#facturesTable tbody tr td:nth-child(2):contains(\"$factureNum\")').forEach(td => {
                        let row = td.closest('tr');
                        for (let i = 1; i <= 9; i++) {
                            row.cells[i-1].className = '$groupClass';
                        }
                    });\n";
                }
            @endphp
        }
    });
});
</script>
@endsection