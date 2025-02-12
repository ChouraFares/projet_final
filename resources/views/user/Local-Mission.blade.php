@extends('layouts.app')

@section('title', 'Mission Locale')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
     

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
        .alert-success {
    padding: 15px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    margin-bottom: 20px;
}

    </style>
</head>
<body>

<div class="container mt-6">
    <form action="{{ route('user.submitLocalMission') }}" method="POST">
        @csrf
    

        <div class="card-container">
            <div class="card">
                <div class="section-header">
                    <h4>Détails de la Mission</h4>
                </div>
                <!-- Champs du Formulaire Détails de la Mission -->
                <div class="form-group">
                    <label for="employeeId">MLE </label>
                    <input type="text" class="form-control" id="employeeId" name="MLE" value="{{ $employee->MLE ?? '' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="department">Direction</label>
                    <input type="text" class="form-control" id="department" name="department" value="{{ $employee->Direction }}" readonly>
                </div>
                <div class="form-group">
                    <label for="Superviseur">Nom Du Supérieur Hiérarchique  </label>
                    <input type="text" class="form-control" id="Superviseur" name="superviseur">
                </div>

                <div class="form-group">
                    <label for="region">Destination</label>
                    <select class="form-control" id="region" name="region" required>
                        <option value="">Sélectionner...</option>
                        <option value="5">Ariana</option>
                        <option value="10">Tunis</option>
                        <option value="15">Sousse</option>
                        <option value="20">Mahdia</option>
                        <option value="25">Bizerte</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="purpose">Objectif De La Mission</label>
                    <input type="text" class="form-control" id="purpose" name="purpose" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="startDate">Date  de Début</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="endDate">Date de Fin</label>
                        <input type="date" class="form-control" id="endDate" name="end_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="accompanyingPerson">Accompagnant</label>
                    <input type="text" class="form-control" id="accompanyingPerson" name="accompanying_person">
                </div>
            </div>

            <div class="card">
                <div class="section-header">
                    <h4>Informations sur le Véhicule</h4>
                </div>
                <!-- Champs du Formulaire Informations sur le Véhicule -->
                <div class="form-group">
                    <label for="licensePlate">Numéro d'Immatriculation</label>
                    <input type="text" class="form-control" id="licensePlate" name="license_plate" required>
                </div>
                <div class="form-group">
                    <label for="carType">Type de Véhicule</label>
                    <select class="form-control" id="carType" name="car_type" required>
                        <option value="">Sélectionner...</option>
                        <option value="Service">Service</option>
                        <option value="Fonctionnel">Fonctionnel</option>
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="section-header">
                    <h4>Détails de la Consommation de Carburant</h4>
                </div>
                <!-- Champs du Formulaire Détails de la Consommation de Carburant -->
                <div class="form-group">
                    <label for="fuelType">Type de Carburant</label>
                    <select class="form-control" id="fuelType" name="fuel_type" required>
                        <option value="">Sélectionner...</option>
                        <option value="Essence">Essence</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Électrique">Électrique</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Carte Carburant">Carte Carburant </label>
                    <input type="number" class="form-control" id="Carte Carburant" name="carte_carburant" required>
                </div>
                <div class="form-group">
                    <label for="distanceTraveled">Distance Totale Parcourue (km)</label>
                    <input type="number" class="form-control" id="distanceTraveled" name="distance_traveled" required>
                </div>
                <div class="form-group">
                    <label for="fuelCost">Coût du Carburant (TND)</label>
                    <input type="text" class="form-control" id="fuelCost" name="fuel_cost" readonly>
                </div>
                <div class="form-group">
                    <label for="tollExpenses">Frais de Péage (le cas échéant)</label>
                    <select class="form-control" id="tollExpenses" name="toll_expenses">
                        <option value="0">0 TND</option>
                        <option value="5">5 TND</option>
                        <option value="10">10 TND</option>
                        <option value="15">15 TND</option>
                        <option value="20">20 TND</option>
                        <option value="25">25 TND</option>
                        <option value="30">30 TND</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hotel">Hôtel</label>
                    <select class="form-control" id="hotel" name="hotel" required>
                        <option value="" disabled selected>Sélectionnez une option</option>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="indemnity">Indemnité</label>
                    <input type="text" class="form-control" id="indemnity" name="indemnity">
                </div>
                <div class="form-group">
                    <label for="expensesWithInvoice">Dépenses avec Facture</label>
                    <input type="number" class="form-control" id="expensesWithInvoice" name="expenses_with_invoice" required>
                </div>
            </div>
      
            

            <div class="card">
                <div class="section-header">
                    <h4>Coût Total</h4>
                </div>
                <div class="form-group">
                    <label for="totalCost">Coût Total (TND)</label>
                    <input type="text" class="form-control" id="totalCost" name="total_cost" readonly>
                </div>
            </div>
        </div>



        <div class="submit-container">
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Soumettre la Demande</button>
        </div>
    </form>
</div>
<script>
function calculateTotalCost() {
    const distance = parseFloat(document.getElementById('distanceTraveled').value) || 0;
    const fuelCost = (distance / 100) * 2.525;
    document.getElementById('fuelCost').value = fuelCost.toFixed(2);

    const tollExpenses = parseFloat(document.getElementById('tollExpenses').value) || 0;
    const indemnity = parseFloat(document.getElementById('indemnity').value) || 0;
    const expensesWithInvoice = parseFloat(document.getElementById('expensesWithInvoice').value) || 0; // Nouveaux frais avec facture

    const hotelCost = 0; // Le coût de l'hôtel est toujours 0

    // Calcul du coût total
    const totalCost = fuelCost + tollExpenses + indemnity + expensesWithInvoice + hotelCost;
    document.getElementById('totalCost').value = totalCost.toFixed(2);
}

// Ajouter des écouteurs d'événements pour recalculer le coût total
document.getElementById('distanceTraveled').addEventListener('input', calculateTotalCost);
document.getElementById('tollExpenses').addEventListener('input', calculateTotalCost);
document.getElementById('indemnity').addEventListener('input', calculateTotalCost);
document.getElementById('expensesWithInvoice').addEventListener('input', calculateTotalCost); // Ajout de l'écouteur pour les dépenses avec facture
document.getElementById('hotel').addEventListener('change', calculateTotalCost);

 </script>

 </body>
 </html>

 @endsection

