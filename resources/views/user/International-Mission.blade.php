@extends('layouts.app')

@section('title', 'Mission Internationale')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #0B3D91;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #1E3D58;
            border-radius: 10px;
            padding: 20px;
            max-width: 1200px;
            width: 100%;
        }

        .card {
            background-color: #2A4B67;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            color: #F4F4F9;
        }

        .section-header {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #F4A261;
        }

        .form-group input, .form-group select, .form-group textarea {
            background-color: #F4F4F9;
            color: #1E3D58;
            border: none;
        }

        .btn-submit {
            background-color: #F4A261;
            color: #1E3D58;
            padding: 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #E76F51;
            transform: scale(1.05);
        }

        .card-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            margin: 10px;
            min-width: 250px;
        }

        .submit-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

    </style>
</head>
<body>

<div class="container mt-6">
    <h2 class="text-center mb-4">Nouvelle Demande De Mission Internationale</h2>
 

    <form id="mission-form" action="{{ route('international-mission.store') }}" method="post">
        @csrf

        <div class="card-container">
            <div class="card">
                <div class="section-header">
                    <h4>Détails de l'Employé et de la Mission</h4>
                </div>
                <div class="form-group">
                    <label for="employeeId">MLE</label>
                    <input type="text" class="form-control" id="employeeId" name="employeeId" value="{{ $mle }}" readonly>
                </div>
                <div class="form-group">
                    <label for="missionId">ID Mission</label>
                    <input type="text" class="form-control" id="missionId" name="missionId" value="{{ $missionId }}" readonly>
                </div>


                <div class="form-group">
                    <label for="Superviseur">Nom Du Supérieur Hiérarchique </label>
                    <input type="text" class="form-control" id="Superviseur" name="superviseur" required>
                </div>
                <div class="form-group">
                    <label for="purpose">Objectif de la Mission</label>
                    <input type="text" class="form-control" id="purpose" name="purpose" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="startDate">Date de Début</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="endDate">Date de Fin</label>
                        <input type="date" class="form-control" id="endDate" name="end_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="destination">Destination</label>
                    <input type="text" class="form-control" id="destination" name="destination" required>
                </div>
            </div>

            <div class="card">
                <div class="section-header">
                    <h4>Dépenses de Mission</h4>
                </div>
                <div class="form-group">
                    <label for="expenses">Coût des Indemnités (100 EUR par jour)</label>
                    <input type="number" class="form-control" id="expenses" name="expenses" required>
                </div>
                <div class="form-group">
                    <label for="interim">Interim</label>
                    <input type="text" class="form-control" id="interim" name="interim">
                </div>
                <div class="form-group">
                    <label for="divers">Dépenses avec Facture</label>
                    <input type="text" class="form-control" id="divers" name="divers">
                </div>
                
            </div>
        </div>

        <div class="submit-container">
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Soumettre la Demande</button>
        </div>
    </form>
</div>

</body>
</html>

@endsection
