@extends('layouts.app')

@section('title', 'Mes Demandes de Stage')

<!-- Include Google Fonts -->

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Mes Demandes de Stage</h1>

    <div class="table-responsive">
        <table id="internshipTable" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Employé</th>
                    <th>Département</th>
                    <th>Type de Stage</th>
                    <th>Durée</th>
                    <th>Date de Début</th>
                    <th>Compétences Requises</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                <tr class="text-center align-middle">
                    <td>{{$request->user->name}} </td>
                    <td>{{ $request->department }}</td>
                    <td>{{ $request->internship_type }}</td>
                    <td>{{ $request->duration }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }}</td>
                    <td>{{ $request->further_skills }}</td>

                    <td>
                        @if($request->status == 'approved')
                            <span class="badge status-approved">Approuvé</span>
                        @elseif($request->status == 'pending')
                            <span class="badge status-pending">En Attente</span>
                        @else
                            <span class="badge status-rejected">Rejeté</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#internshipTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune demande trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Aucune entrée disponible",
                "infoFiltered": "(filtré sur _MAX_ entrées au total)",
                "search": "Rechercher:",
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

<!-- Custom CSS -->
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead {
        background-color: #343a40;
        color: white;
    }

   

    .badge {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
    }

    .status-approved {
        background-color: #28a745;
        color: white;
    }

    .status-pending {
        background-color: #ffc107;
        color: black;
    }

    .status-rejected {
        background-color: #dc3545;
        color: white;
    }
</style>

@endsection
