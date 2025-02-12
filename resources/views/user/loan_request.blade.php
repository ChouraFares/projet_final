@extends('layouts.app')

@section('title', 'Prêts et Avances')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <style>
 
        .form-container {
            background-color: #1E3D58;
            border-radius: 10px;
            padding: 20px;
            max-width: 1200px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .btn {
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

        .btn:hover {
            background-color: #E76F51;
            transform: scale(1.05);
        }

    </style>
</head>
<body>

<div class="form-container">

    <h1>Prêts et Avances</h1>
    <h2>Formulaire de Demande de Prêt/Avance</h2>
    <form action="{{ route('user.submitLoanRequest') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- This is necessary for Laravel forms to protect against CSRF attacks -->
        <div class="form-group">
            <label for="employeeId">MLE :</label>
            <input type="text" id="employeeId" name="employeeId" value="{{ $employeeId }}" required readonly>
        </div>

        <div class="form-group">
            <label for="department">Direction :</label>
            <input type="text" id="department" name="department" value="{{ $department }}" required readonly>
        </div>


        <div class="form-group">
            <label for="amountRequested">Montant Demandé (TND) :</label>
            <select id="amountRequested" name="amountRequested" required>
                <option value="" disabled selected>Sélectionnez un montant</option>
                <option value="50">50 TND</option>
                <option value="100">100 TND</option>
                <option value="150">150 TND</option>
                <option value="200">200 TND</option>
                <option value="250">250 TND</option>
                <option value="500">500 TND</option>
                <option value="1000">1000 TND</option>
                <option value="1500">1500 TND</option>
                <option value="2000">2000 TND</option>
                <option value="2500">2500 TND</option>
                <option value="3000">3000 TND</option>
                <!-- Continuer avec des incréments de 50 TND -->
            </select>
        </div>

        <div class="form-group">
            <label for="purpose">Prêt/Avance (optionnel) :</label>
            <select id="purpose" name="purpose" required>
                <option value="" disabled selected>Sélectionnez l'objet</option>
                <option value="Urgence">Urgence</option>
                <option value="Médical">Médical</option>
                <option value="Éducation">Éducation</option>
                <option value="Vacances">Vacances</option>
                <option value="Autre">Autre</option>
            </select>
        </div>

        <div class="form-group">
            <label for="type">Sélectionnez le Type : Prêt/Avance :</label>
            <select id="type" name="type" required onchange="togglePurposeField()">
                <option value="" disabled selected>Sélectionnez le type</option>
                <option value="Prêt">Prêt</option>
                <option value="Avance">Avance</option>
            </select>
        </div>
        <div class="form-group" id="purposeField">
            <label for="purpose">Objet du Prêt :</label>
            <select id="purpose" name="purpose">
                <option value="" disabled selected>Sélectionnez l'objet</option>
                <option value="Urgence">Urgence</option>
                <option value="Médical">Médical</option>
                <option value="Éducation">Éducation</option>
                <option value="Vacances">Vacances</option>
                <option value="Autre">Autre</option>
            </select>
        </div>

        <div class="form-group">
            <label for="repaymentMonth">Premier Mois de Remboursement :</label>
            <select id="repaymentMonth" name="repaymentMonth" required>
                <option value="" disabled selected>Sélectionnez le mois</option>
                <option value="JAN">JAN</option>
                <option value="FEB">FEB</option>
                <option value="MAR">MAR</option>
                <option value="APR">APR</option>
                <option value="MAY">MAY</option>
                <option value="JUN">JUN</option>
            </select>
        </div>



        <div class="form-group">
            <label for="additionalDocuments">Téléchargez des Documents Supplémentaires : (PDF uniquement)</label>
            <input type="file" id="additionalDocuments" name="additionalDocuments" accept="image/*,application/pdf" class="file-input">
        </div>

        <!-- Bouton de Soumission -->
        <button type="submit" class="btn">Soumettre la Demande</button>
    </form>
</div>

</body>
</html>
<script>
    function togglePurposeField() {
        var typeSelect = document.getElementById("type");
        var purposeField = document.getElementById("purposeField");

        if (typeSelect.value === "Avance") {
            purposeField.style.display = "none"; // Masquer l'objet pour l'avance
        } else {
            purposeField.style.display = "block"; // Afficher l'objet pour le prêt
        }
    }

    // Masquer l'objet au chargement initial
    document.addEventListener("DOMContentLoaded", function() {
        togglePurposeField();
    });
</script>
@endsection

