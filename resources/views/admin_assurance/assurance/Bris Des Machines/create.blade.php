@extends('layouts.app')
@section('title', 'Ajouter Un Bris De Machine')
@section('content')
    <div class="container">
        <h2>Créer un Contrat d'Assurance Bris de Machine</h2>

        <!-- Affichage des messages de succès ou d'erreur -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('BrisDeMachineStore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="compagnie_assurance">Compagnie d'Assurance</label>
                <input type="text" class="form-control" id="compagnie_assurance" name="compagnie_assurance" required>
            </div>

            <div class="form-group">
                <label for="ref_contrat">Référence du Contrat</label>
                <input type="text" class="form-control" id="ref_contrat" name="ref_contrat" required>
            </div>

            <div class="form-group">
                <label for="date_effet">Date d'Effet</label>
                <input type="date" class="form-control" id="date_effet" name="date_effet" required>
            </div>

            <div class="form-group">
                <label for="echeance">Echéance</label>
                <input type="date" class="form-control" id="echeance" name="echeance" required>
            </div>

            <div class="form-group">
                <label for="condition_renouvellement">Condition de Renouvellement</label>
                <input type="text" class="form-control" id="condition_renouvellement" name="condition_renouvellement">
            </div>

            <div class="form-group">
                <label for="avenant">Avenant</label>
                <select class="form-control" id="avenant" name="avenant" required style="width: 50%;">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="objet_avenant">Objet Avenant</label>
                <input type="text" class="objet_avenant" id="objet_avenant" name="objet_avenant">
            </div>


            <div class="form-group">
                <label for="attachement_contrat">Attachement du Contrat</label>
                <input type="file" class="form-control" id="attachement_contrat" name="attachement_contrat">
            </div>

            <div class="form-group">
                <label for="attachement_avenant">Attachement de l'Avenant</label>
                <input type="file" class="form-control" id="attachement_avenant" name="attachement_avenant">
            </div>

            <button type="submit" class="btn btn-primary">Créer Contrat</button>
        </form>
    </div>
@endsection
