@section('content')
@extends('layouts.app')
@section('title', 'Mission Local')



<div class="container mt-5">

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune mission locale en attente n'est disponible.
        </div>
    @else
    <div class="table-responsive">
        <table id="missionsTable" class="table table-striped table-hover table-bordered" style="color: white;">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>MLE</th>
                    <th>Employé</th>
                    <th>Superviseur</th>
                    <th>Région</th>
                    <th>Objectif</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Accompagnante</th>
                    <th>Immatriculation</th>
                    <th>Voiture</th>
                    <th>Carburant</th>
                    <th>Carte</th>
                    <th>Distance</th>
                    <th>Péage</th>
                    <th>Hôtel</th>
                    <th>Indemnité</th>
                    <th>Coût</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                    <tr class="text-center align-middle">
                        <td>{{ $mission->MLE }}</td>
                        <td>{{ $mission->employe->Nom . ' ' . $mission->employe->Prenom }}</td>
                        <td>{{ $mission->superviseur }}</td>
                        <td>{{ $mission->region }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td>{{ $mission->start_date }}</td>
                        <td>{{ $mission->end_date }}</td>
                        <td>{{ $mission->accompanying_person }}</td>
                        <td>{{ $mission->license_plate }}</td>
                        <td>{{ $mission->car_type }}</td>
                        <td>{{ $mission->fuel_type }}</td>
                        <td>{{ $mission->carte_carburant }}</td>
                        <td>{{ $mission->distance_traveled }}</td>
                        <td>{{ $mission->toll_expenses }}</td>
                        <td>{{ $mission->hotel }}</td>
                        <td>{{ $mission->indemnity }}</td>
                        <td>{{ $mission->total_cost }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.approveMission', $mission->id) }}" class="btn btn-success btn-sm">Approuver</a>
                                <a href="{{ route('admin.declineMission', $mission->id) }}" class="btn btn-danger btn-sm">Rejeter</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
  



        $(document).ready(function() {
        var table = $('#missionsTable').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: 'Exporter Excel',
                    className: 'btn btn-outline-success',
                    exportOptions: {
                        columns: ':not(:last-child), :not(:nth-last-child(2))' // Exclut les colonnes "État" et "Actions"
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Exporter PDF',
                    className: 'btn btn-outline-danger',
                    exportOptions: {
                        columns: ':not(:last-child), :not(:nth-last-child(2))' // Exclut les colonnes "État" et "Actions"
                    }
                }
            ]
        });

    });
    </script>
    @endif
</div>

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
