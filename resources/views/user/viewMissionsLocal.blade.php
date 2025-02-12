@extends('layouts.app')
@section('title', "Mes Demandes De Mission Locale")

@section('content')
<div class="container mt-5">

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            Vous n'avez aucune mission locale en attente.
        </div>
    @else
    <div class="table-responsive">
        <!-- Ajout du champ de recherche -->
      
        <table id="missionsTable" class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>ID de Mission</th>
                    <th>Superviseur</th>
                    <th>Région</th>
                    <th>Objectif</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Personne Accompagnant</th>
                    <th>Matricule De Voiture</th>
                    <th>Types De Véhicule</th>
                    <th>Carburant</th>
                    <th>Carte Carburant</th>
                    <th>Total Des Charges</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                    <tr class="text-center align-middle">
                        <td>{{ $mission->mission_id }}</td>
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
                        <td>{{ $mission->total_cost }}</td>
                        <td>
                            @if($mission->status == 'Approved')
                                <a href="{{ route('user.createMissionReport', $mission->id) }}" class="btn btn-primary">
                                    Rédiger le Rapport
                                </a>
                            @elseif($mission->status == 'pending')
                                <button class="btn btn-secondary" disabled>En Attente</button>
                            @else
                                <button class="btn btn-danger" disabled>Rapport Soumis</button>
                            @endif
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
@endsection
