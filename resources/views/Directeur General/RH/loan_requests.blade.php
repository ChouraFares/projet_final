@extends('layouts.app')
@section('title', 'Demande Prêt & Avance')

@section('content')
<div class="container mt-5">
    @if($loanRequests->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune demande de prêt/avance en attente n'est disponible.
        </div>
    @else
    <div class="table-responsive">
        <table id="loanRequestsTable" class="table table-striped table-hover table-bordered text-white custom-table">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>MLE Employé</th>
                    <th>Nom Employé</th>
                    <th>Département</th>
                    <th>Montant</th>
                    <th>Objet</th>
                    <th>Documents Supplémentaires</th>
                    <th>Mois de Remboursement</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loanRequests as $request)
                    <tr class="text-center align-middle">
                        <td>{{ $request->MLE }}</td>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->Direction }}</td>
                        <td>{{ number_format($request->amount, 0, ',', ' ') }} TND</td>
                        <td>{{ $request->purpose }}</td>
                        <td>
                            @if($request->additional_documents_path)
                                <a href="{{ Storage::url($request->additional_documents_path) }}" target="_blank" class="btn btn-warning btn-sm text-dark fw-bold custom-btn">
                                    <i class="fas fa-folder-open"></i> Voir les documents
                                </a>
                            @else
                                <span class="text-danger fw-bold">Non disponible</span>
                            @endif
                        </td>
                        <td>{{ $request->repayment_month }}</td>
                        <td>{{ $request->type }}</td>
               
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Activation de DataTables --}}
<script>
    $(document).ready(function () {
        $('#loanRequestsTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune demande trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ demandes",
                "infoEmpty": "Aucune donnée disponible",
                "infoFiltered": "(filtré à partir de _MAX_ entrées au total)",
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

{{-- Ajout de styles personnalisés --}}
<style>
    /* Personnalisation du tableau */
  /* Personnalisation du tableau */
 
    .custom-table thead {
        background-color: #343a40;
        color: white;
    }
    .custom-table tbody tr:hover {
        background-color: #2a2d3e;
    }
    .custom-table th, .custom-table td {
        padding: 15px;
        text-align: center;
        vertical-align: middle;
    }

    /* Boutons personnalisés */
    .custom-btn {
        border-radius: 8px;
        padding: 8px 12px;
        transition: all 0.3s ease;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
    }
    .custom-btn i {
        margin-right: 5px;
    }

    /* Bouton "Voir les documents supplémentaires" en jaune */
    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: black;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        transform: scale(1.05);
    }

    /* Bouton "Approuver" en vert */
    .btn-success {
        background-color: #28a745;
        border: none;
    }
    .btn-success:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    /* Bouton "Rejeter" en rouge */
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
    .btn-danger:hover {
        background-color: #c82333;
        transform: scale(1.05);
    }
</style>
</style>
@endsection
