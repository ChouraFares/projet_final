@extends('layouts.app')
@section('title', "Mes Demandes de Missions Internationales")

@section('content')
<style>
    /* Styles pour les boutons */
    .btn-pending {
        background-color: gray;
        color: white;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .btn-approved {
        background-color: #ffc107; /* Jaune */
        color: black;
        font-weight: bold;
    }

    .btn-rejected {
        background-color: #dc3545; /* Rouge */
        color: white;
        font-weight: bold;
    }

    /* Styles pour le tableau */

 

    .badge {
        font-size: 14px;
        padding: 8px;
        border-radius: 8px;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-warning {
        background-color: #ffc107;
        color: black;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
</style>

<div class="container mt-5">

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            🚨 Vous n'avez aucune mission internationale en attente.
        </div>
    @else
    <div class="table-responsive">
        <table id="missionsTable" class="table table-striped table-hover table-bordered shadow-lg">
            <thead>
                <tr class="text-center">
                    <th>ID de Mission</th>
                    <th>Destination</th>
                    <th>Objectif</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                    <tr class="text-center align-middle">
                        <td><strong>#{{ $mission->mission_id }}</strong></td>
                        <td class="text-uppercase">{{ $mission->destination }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td>{{ \Carbon\Carbon::parse($mission->start_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($mission->end_date)->format('d-m-Y') }}</td>
                        <td>
                            @if($mission->status == 'Approved')
                                <span class="badge badge-success">✅ Approuvé</span>
                            @elseif($mission->status == 'pending')
                                <span class="badge badge-warning">⏳ En Attente</span>
                            @else
                                <span class="badge badge-danger">❌ Rejeté</span>
                            @endif
                        </td>
                        <td>
                            @if($mission->status === 'Approved')
                                <a href="{{ route('international-mission.createReport', $mission->id) }}" class="btn btn-approved">✍ Rédiger Ton Rapport</a>
                            @elseif($mission->status === 'pending')
                                <button class="btn btn-pending" disabled>⏳ En Attente</button>
                            @else
                                <button class="btn btn-rejected" disabled>❌ Rejeté</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Activation de DataTables --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#missionsTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ missions par page",
                "zeroRecords": "Aucune mission trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ missions",
                "infoEmpty": "Aucune mission disponible",
                "infoFiltered": "(filtré sur _MAX_ missions au total)",
                "search": "🔍 Rechercher :",
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
@endpush
@endsection
