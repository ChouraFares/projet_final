@extends('layouts.app')
@section('title', 'Mission Internationale')

<!-- Include Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

<!-- Add DataTables CSS & JS -->
<link rel="stylesheet" href="//cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem;
        color: #ffcc00;
        text-shadow: 1px 1px 2px #000;
    }
    table {
        table-layout: auto; /* Let the table adjust its width based on content */
        width: 100%; /* Ensure table takes up full container width */
    }
    table thead th {
        background-color: #333;
        color: #fff;
        padding: 6px; /* Reduced padding for less width */
        font-size: 1rem; /* Slightly smaller font size */
        font-family: 'Montserrat', sans-serif;
    }
    table tbody td {
        padding: 4px; /* Further reduced padding for less width */
        white-space: nowrap; /* Prevent text from wrapping */
        overflow: hidden;
        text-overflow: ellipsis;
    }
    table tr:hover {
        background-color: #444;
    }
    .btn-group {
        display: flex;
        gap: 2px; /* Smaller gap between buttons */
    }
    .btn {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        padding: 4px 8px; /* Reduced padding for smaller buttons */
        transition: background-color 0.3s;
    }
    .btn-success {
        background-color: #28a745;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .btn:hover {
        background-color: #ffc107;
        color: #000;
    }
</style>

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Demandes de Missions Internationales en Attente</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune mission internationale en attente n'est disponible.
        </div>
    @else
    <div class="table-responsive">
        <table id="missionsTable" class="table table-striped table-hover table-bordered" style="color: white;">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Superviseur</th>
                    <th>Destination</th>
                    <th>Objectif</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Coût</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                    <tr class="text-center align-middle">
                        <td>{{ $mission->mission_id }}</td>
                        <td>{{ $mission->superviseur }}</td>
                        <td>{{ $mission->destination }}</td>
                        <td>{{ $mission->purpose }}</td>
                        <td>{{ $mission->start_date }}</td>
                        <td>{{ $mission->end_date }}</td>
                        <td>{{ $mission->expenses }}</td>
                     
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#missionsTable', {
            paging: true,
            searching: true,
            ordering: true
        });
    </script>
    @endif
</div>
@endsection
