@extends('layouts.app')
@section('title', 'Mission Internationale')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary"> <i class="fas fa-globe"></i> Demandes de Missions Internationales en Attente</h2>

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle"></i> Aucune mission internationale en attente n'est disponible.
        </div>
    @else
    <div class="table-responsive">
        <table id="missionsTable" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark text-center">
                <tr>
                    <th><i class="fas fa-hashtag"></i> Mission ID</th>
                    <th><i class="fas fa-user"></i> Employé</th>
                    <th><i class="fas fa-user-tie"></i> Superviseur</th>
                    <th><i class="fas fa-map-marker-alt"></i> Destination</th>
                    <th><i class="fas fa-bullseye"></i> Objectif</th>
                    <th><i class="fas fa-calendar-alt"></i> Date Début</th>
                    <th><i class="fas fa-calendar-alt"></i> Date Fin</th>
                    <th><i class="fas fa-dollar-sign"></i> Coût</th>
                    <th><i class="fas fa-cogs"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                    <tr class="text-center align-middle">
                        <td>{{ $mission->mission_id }}</td>
                        <td>{{ $mission->user->name }}</td>
                        <td>{{ $mission->superviseur }}</td>
                        <td>{{ $mission->destination }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td>{{ \Carbon\Carbon::parse($mission->start_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($mission->end_date)->format('d-m-Y') }}</td>
                        <td>{{ number_format($mission->expenses, 2) }} TND</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.approveInternationalMission', $mission->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Approuver
                                </a>
                                <a href="{{ route('admin.declineInternationalMission', $mission->id) }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Rejeter
                                </a>
                             
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('#missionsTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune mission trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ missions",
                "infoEmpty": "Aucune mission disponible",
                "infoFiltered": "(filtré à partir de _MAX_ missions)",
                "search": "Rechercher :",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            },
            "ordering": true,
            "paging": true,
            "info": true
        });
    });
</script>
<style>
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
@endsection
