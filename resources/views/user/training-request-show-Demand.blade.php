@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mes Demandes de Formation</h2>
    @if($trainingRequests->isEmpty())
        <p>Aucune demande de formation pour le moment.</p>
    @else
        <table class="table-training">
            <thead>
                <tr>
                    <th>Département</th>
                    <th>Formation</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainingRequests as $request)
                    <tr>
                        <td>{{ $request->department }}</td>
                        <td>{{ $request->selected_training }}</td>
                        <td class="status {{ strtolower($request->status) }}">{{ $request->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

<style>
    body {
        background-color: #0B3D91;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        background-color: #1E3D58;
        border-radius: 10px;
        padding: 20px;
        max-width: 1300px;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        color: #F4D03F;
        margin-bottom: 20px;
    }

    p {
        font-size: 18px;
        color: #fff;
    }

    .table-training {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-training th, .table-training td {
        border: 1px solid #F4D03F;
        padding: 10px;
        text-align: center;
        font-size: 16px;
    }

    .table-training th {
        background-color: #2C6E91;
        color: #fff;
    }

    .table-training td {
        background-color: #25507B;
    }

    /* Style for the status column */
    .status.pending {
        background-color: #F39C12; /* Orange for pending */
    }

    .status.approved {
        background-color: #28A745; /* Green for approved */
    }

    .status.rejected {
        background-color: #E74C3C; /* Red for rejected */
    }

    .table-training tr:hover {
        background-color: #3D7DAF;
        transition: background-color 0.3s ease;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        .table-training th, .table-training td {
            font-size: 14px;
            padding: 8px;
        }
    }

    @media (max-width: 480px) {
        .table-training {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .table-training th, .table-training td {
            font-size: 12px;
        }
    }
</style>
