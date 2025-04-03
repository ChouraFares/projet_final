@extends('layouts.transit')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">
        <i class="fas fa-file-invoice-dollar"></i> Facture Complémentaire Thon
    </h2>
    
    @include('components.import-facture')

    <!-- Table DataTables -->
    <div class="dt-container">
        <div class="table-responsive">
            <table id="facturesTable" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th rowspan="2">Date & Heure D'envoi</th>
                        <th rowspan="2">Facture</th>
                        <th rowspan="2">N° CONTENEUR</th>
                        <th rowspan="2">Fournisseur</th>
                        <th rowspan="2">Incoterm</th>
                        <th rowspan="2">Armateur</th>
                        <th rowspan="2">Port</th>
                        <th rowspan="2">Banque</th>
                        <th rowspan="2">Date Déclaration</th>
                        <th rowspan="2">Assureur</th>
                        <th rowspan="2">Date Expiration</th>
                        <th rowspan="2">Total</th>
                        <th rowspan="2">BL</th>
                        <th colspan="1">Assurance</th>
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
                        $colors = ['group-1', 'group-2', 'group-3', 'group-4', 'group-5', 'group-6', 'group-7', 'group-8', 'group-9', 'group-10'];
                        $colorIndex = 0;
                    @endphp
    
                    @foreach($groupedFactures as $factureNumber => $factures)
                        @php
                            $groupClass = $colors[$colorIndex % count($colors)];
                            $colorIndex++;
                        @endphp
                        @foreach($factures as $facture)
                            <tr class="{{ $facture->cheques_count > 0 ? 'has-request' : '' }}">
                                <td class="{{ $groupClass }}">
                                    @if($facture->date_demande)
                                        {{ $facture->date_demande->addHour()->format('d/m/Y H:i:s') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="{{ $groupClass }}"><i class="fas fa-folder"></i> {{ $facture->facture }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->num_conteneur }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->fournisseur }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->incoterm }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->armateur }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->port }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->bank }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->date_declaration }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->assureur }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->date_expiration }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->total }}</td>
                                <td class="{{ $groupClass }}">{{ $facture->BL }}</td>
    
                                @php
                                    $sections = ['assurance', 'douane', 'recette_finance', 'stam', 'timbrage_et_avances_surestarie'];
                                @endphp
    
                                @foreach($sections as $section)
                                    @if($section != 'assurance')
                                        <td>{{ $facture->{$section.'_preparer_paiement'} ? '✔' : '' }}</td>
                                    @endif
                                    @if($facture->{$section.'_preparer_paiement'})
                                        <td>
                                            @if($section == 'assurance')
                                                <a href="{{ route('facture.complimentaire.thon.cheques.assurance', ['id' => $facture->id]) }}" class="btn-custom btn-info-custom">
                                                    <i class="fas fa-eye"></i> Voir plus
                                                </a>
                                            @elseif($section == 'timbrage_et_avances_surestarie')
                                                <a href="{{ route('detaille_timbrage_avance_surestarie', ['id' => $facture->id]) }}" class="btn-custom btn-info-custom">
                                                    <i class="fas fa-eye"></i> Voir plus
                                                </a>
                                            @else
                                                <a href="{{ route('facture.complimentaire.thon.cheques', ['id' => $facture->id, 'type' => $section]) }}" class="btn-custom btn-info-custom">
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
                                <td>
                                    @php
                                        $validationStatus = $facture->validation_transit ?? 'en_attente';
                                        // Remplacer "en_attente" par "En Attente"
                                        if ($validationStatus === 'en_attente') {
                                            $validationStatus = 'En Attente';
                                        }
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
                                <td>
                                    @php
                                        $validationFinanceStatus = $facture->validation_finance ?? 'en_attente';
                                        // Remplacer "en_attente" par "En Attente"
                                        if ($validationFinanceStatus === 'en_attente') {
                                            $validationFinanceStatus = 'En Attente';
                                        }
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
                                <td>
                                    @if($facture->hasExistingRequestForFacture())
                                        <button class="btn-custom btn-secondary-custom" disabled>
                                            <i class="fas fa-lock"></i> Demande Déposée
                                        </button>
                                        <a href="{{ route('facture.complimentaire.thon.edit', $facture->id) }}" class="btn-custom btn-primary-custom">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                    @else
                                        <a href="{{ route('facture.complimentaire.thon.demander', $facture->id) }}" class="btn-custom btn-warning-custom">
                                            <i class="fas fa-paper-plane"></i> Déposer Demande
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Styles personnalisés pour les boutons */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 2px;
        min-width: 100px;
    }

    .btn-custom i {
        margin-right: 6px;
    }

    .btn-info-custom {
        background-color: #17a2b8;
        color: white;
        border: none;
    }

    .btn-info-custom:hover {
        background-color: #138496;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-secondary-custom {
        background-color: #6c757d;
        color: white;
        border: none;
        cursor: not-allowed;
    }

    .btn-secondary-custom:disabled {
        opacity: 0.8;
    }

    .btn-primary-custom {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .btn-primary-custom:hover {
        background-color: #0069d9;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-warning-custom {
        background-color: #ff9800;
        color: white;
        border: none;
    }

    .btn-warning-custom:hover {
        background-color: #e68a00;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .btn-custom {
            min-width: 80px;
            padding: 6px 10px;
            font-size: 12px;
        }
    }
</style>

<!-- jQuery -->
<script>
    if (typeof jQuery == 'undefined') {
        document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
    }
</script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#facturesTable').DataTable({
        "pageLength": 20,
        "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Tout"]],
        "ordering": true,
        "order": [],
        "searching": true,
        "responsive": true,
        "language": {
            "lengthMenu": "Afficher _MENU_ enregistrements par page",
            "zeroRecords": "Aucune facture trouvée",
            "info": "Affichage de _START_ à _END_ sur _TOTAL_ factures",
            "infoEmpty": "Aucune facture disponible",
            "infoFiltered": "(filtré à partir de _MAX_ factures)",
            "search": "Rechercher :",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            }
        }
    });
});
</script>
@endsection
