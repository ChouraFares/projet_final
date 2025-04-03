@extends('layouts.app')

@section('title','Mes Demandes Prêt Et Avance')

@section('content')
<div class="container mt-5">
    @if($loanRequests->isEmpty())
        <div class="alert alert-warning text-center">
            Vous n'avez pas encore fait de demande.
        </div>
    @else
    <div class="table-responsive">
        <table id="userLoanRequestsTable" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>MLE</th>
                    <th>Montant</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Documents Supplémentaires</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loanRequests as $request)
                    <tr class="text-center align-middle">
                        <td>{{ $request->MLE }}</td>
                        <td>{{ number_format($request->amount, 0, ',', ' ') }} TND</td>
                        <td>{{ $request->type }}</td>
                        <td>{{ $request->created_at->format('d-m-Y') }}</td>
                  
                        <td>
                            @if($request->additional_documents_path)
                                <a href="{{ Storage::url($request->additional_documents_path) }}" target="_blank" class="text-warning font-weight-bold">
                                    <i class="fas fa-file-alt"></i> Voir les documents supplémentaires
                                </a>
                            @else
                                <span class="text-muted">Non disponible</span>
                            @endif
                        </td>
                        <td>
                            @if($request->status == 'approuvé')
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> {{ ucfirst($request->status) }}</span>
                            @elseif($request->status == 'rejeté')
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> {{ ucfirst($request->status) }}</span>
                            @else
                                <span class="badge bg-warning"><i class="fas fa-clock"></i> {{ ucfirst($request->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<!-- Script pour activer DataTables -->
<script>
    $(document).ready(function() {
        $('#userLoanRequestsTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune demande trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Aucune entrée disponible",
                "infoFiltered": "(filtré à partir de _MAX_ entrées au total)",
                "search": "Rechercher :",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            },
            "order": [[3, "desc"]], // Tri par date par défaut
            "pageLength": 10 // Nombre d'entrées par page
        });
    });
</script>

<style>
    /* Amélioration du style du tableau */
 



    /* Style pour les liens */
    .text-warning {
        color: #ffc107 !important;
    }

    .text-primary {
        color: #007bff !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    /* Style des badges de statut */
    .badge {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 5px;
    }

    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: black;
    }
</style>
@endsection
