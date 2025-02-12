@section('content')
@extends('layouts.app')
@section('title', 'Mission Local')

<div class="container mt-5">
    <h2 class="text-center mb-4">Demandes de Missions Locales en Attente</h2>

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune mission locale en attente n'est disponible.
        </div>
    @else
    <div class="table-responsive">
        <table id="missionsTable" class="table table-striped table-hover table-bordered" style="color: white;">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>MLE</th>
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
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                    <tr class="text-center align-middle">
                        <td>{{ $mission->mission_id }}</td>
                        <td>{{ $mission->MLE }}</td>
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
@endsection
