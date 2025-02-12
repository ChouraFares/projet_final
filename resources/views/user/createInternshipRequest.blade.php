@extends('layouts.app')

@section('title', 'Demande de Stage')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail RH SWIB - Demande de Stage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>


        .form-container {
            border-radius: 10px;
            padding: 80px;
            max-width: 1800px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 0.5rem;
        }

        h1, h2 {
            text-align: center;
            color: #F4A261;
        }

        .form-group label {
            color: #F4A261;
        }

        .form-group input, .form-group select, .form-group textarea {
            background-color: #F4F4F9;
            color: #1E3D58;
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }

        .file-input {
            padding: 5px;
        }

        .btn {
            background-color: #F4A261;
            color: #1E3D58;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #E76F51;
            transform: scale(1.05);
        }
        .checkbox-group {
        gap: 20px;
    }

    .checkbox-label {
        background-color: #F4F4F9;
        color: #1E3D58;
        padding: 10px;
        border-radius: 5px;
        margin-right: 15px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"] {
        margin-right: 10px;
    }

    </style>
</head>
<body>

    <div class="form-container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Demande de Stage</h1>
        <h2>Formulaire de Demande de Stage</h2>
        <form action="{{ route('user.storeInternshipRequest') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Afficher le nom et l'ID de l'utilisateur -->
            <div class="form-group">
                <label for="employee_name">Nom d'employé :</label>
                <input type="text" id="employee_name" name="employee_name" value="{{ $user->name }}" readonly>
            </div>

            <div class="form-group">
                <label for="employee_id">ID d'employé :</label>
                <input type="text" id="employee_id" name="employee_id" value="{{ $user->MLE }}" readonly>
            </div>

            <div class="form-group">
                <label for="execution_date">Date de l’exécution de la demande :</label>
                <input type="date" id="execution_date" name="execution_date" required>
            </div>

            <!-- Rest of the form -->
            <div class="form-group">
                <label for="department">Département :</label>
                <select id="department" name="department" required>
                    <option value="" disabled selected>Sélectionnez le département</option>
                    <option value="COMMUNICATION">COMMUNICATION</option>
                    <option value="TRADE MARKETING">TRADE MARKETING</option>
                    <option value="SUPPLY CHAIN">SUPPLY CHAIN</option>
                    <option value="RH">RH</option>
                    <option value="FINANCE">FINANCE</option>
                    <option value="ACCT">ACCT</option>
                </select>
            </div>

            <div class="form-group">
                <label for="internship_type">Type de Stage :</label>
                <select id="internship_type" name="internship_type" required>
                    <option value="" disabled selected>Sélectionnez le type de stage</option>
                    <option value="PFE">PFE (Projet de Fin d'Études)</option>
                    <option value="Stage D'été">Stage D'été</option>
                </select>
            </div>

            <div class="form-group">
                <label for="duration">Durée du Stage :</label>
                <select id="duration" name="duration" required>
                    <option value="" disabled selected>Sélectionnez la durée</option>
                    <option value="1MOIS">1 MOIS</option>
                    <option value="2MOIS">2 MOIS</option>
                    <option value="3MOIS">3 MOIS</option>
                    <option value="6MOIS">6 MOIS</option>
                </select>
            </div>

            <div class="form-group">
                <label for="further_skills">Compétences requises :</label>
                <input type="text" class="form-control" id="further_skills" name="further_skills" placeholder="Entrez les compétences requises">
            </div>
            
          

            <div class="form-group">
                <label for="start_date">Date limite pour commencer le stage :</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="cv_path">Télécharger le CV :</label>
                <input type="file" id="cv_path" name="cv_path" accept="application/pdf" class="file-input" required>
            </div>

            <button type="submit" class="btn">Soumettre la Demande</button>
        </form>
    </div>

    </body>
    </html>

@endsection
