@extends('layouts.cheque')

@section('title', 'Détails des Chèques')

@section('content')
<div class="container-fluid px-4 py-4"> <!-- Changé container en container-fluid -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h2 class="mb-0">
                <i class="fas fa-money-check-alt me-2"></i>
                Détails Des Chèques Pour {{ ucfirst(str_replace('_', ' ', $type)) }}
            </h2>
        </div>
        
        <div class="card-body">
            <h4 class="text-muted text-center mb-4">
                Facture : <span class="badge bg-secondary">{{ $facture->facture }}</span>
            </h4>

            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover table-bordered align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Numéro de Facture</th>
                            <th class="text-center">Date & Heure d'Envoi</th>
                            <th class="text-center">N° Conteneur</th>
                            <th class="text-center">Fournisseur</th>
                            <th class="text-center">Référence MDP</th>
                            <th class="text-center">Montant du Chèque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cheques as $cheque)
                            <tr class="transition-all hover:bg-gray-100">
                                <td class="text-center">{{ $facture->facture }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $facture->date_demande->addHour()->format('d/m/Y H:i:s') }}                                    </span>
                                </td>
                                <td class="text-center">{{ $facture->num_conteneur }}</td>
                                <td class="text-center">{{ $facture->fournisseur }}</td>

                                <td class="text-center">{{ $cheque->ref_mdp }}</td>
                                <td class="text-center">
                                    @if($cheque->montant == 0)
                                        <span class="text-warning fw-bold cheque-blanc">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Chéque Blanc
                                        </span>
                                    @else
                                        <span class="text-success fw-bold">
                                            {{ number_format($cheque->montant, 2) }} TND
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Aucun chèque trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

         
        </div>
    </div>
</div>

<style>
 .cheque-blanc {
    background-color: #f67a84; /* Fond rouge pâle */
    border: 1px solid #dc3545; /* Bordure rouge */
    padding: 2px 8px;
    border-radius: 4px;
    display: inline-block;
}
    .table-responsive {
        width: 100%;
    }
    
    .table {
        width: 100% !important;
        margin-bottom: 0;
    }
    
    .card {
        width: 100%;
    }
    
</style>
@endsection