@extends('layouts.transit')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Gestion des Demandes de Factures Complémentaires Thon</h2>



    <div class="dt-container">
        <div class="table-responsive">
            <table id="facturesTable" class="display nowrap" style="width:100%">
                <!-- Votre thead reste identique -->
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
                                    } elseif ($validationStatus == 'Validé par DG') {
                                        $badgeClass = 'badge-dg';
                                        $iconClass = 'fas fa-user-check';
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
                                @if($facture->validation_finance != 'Validé') 
                                    @if($facture->validation_transit == 'Validé')
                                        <form action="{{ route('responsable_finance.validate', $facture->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn btn-success btn-sm btn-approve">
                                                <i class="fas fa-check-circle"></i> Approuver
                                            </button>
                                        </form>
                                        <form action="{{ route('responsable_finance.validate', $facture->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn btn-danger btn-sm btn-reject">
                                                <i class="fas fa-times-circle"></i> Refuser
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-warning btn-sm btn-waiting" disabled>
                                            <i class="fas fa-hourglass-half"></i> En Attente
                                        </button>
                                    @endif
                                @endif
                            </td>

                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


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

    .btn-waiting {
        background-color: #83827f;
        border-color: #8e8d8c;
        color: #212529;
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
</style>


@endsection

@section('scripts')
<!-- Charger jQuery en premier -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Puis DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Puis les extensions Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
jQuery(document).ready(function($) {
    $('#facturesTable').DataTable({
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Exporter en Excel',
                className: 'btn btn-success',
                title: 'Demandes_Finance_' + new Date().toLocaleDateString(),
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> Exporter en PDF',
                className: 'btn btn-danger',
                title: 'Demandes_Finance_' + new Date().toLocaleDateString(),
                exportOptions: {
                    columns: ':visible'
                },
                customize: function(doc) {
                    doc.pageMargins = [10, 10, 10, 10];
                    doc.defaultStyle.fontSize = 7;
                    doc.styles.tableHeader.fontSize = 7;
                }
            }
        ],
        "scrollX": true,
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [1] }
        ],
        "drawCallback": function(settings) {
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