@extends('layouts.app')
@section('title', 'Ajouter Un Contrat Responsabilité Civil')
@section('content')
    <div class="container">
        <h2>Ajouter un Contrat Responsabilité Civile</h2>

        <!-- Afficher les messages de succès -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('ResponsableCivilStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="compagnie_assurance">Compagnie d'Assurance</label>
                <input type="text" name="compagnie_assurance" id="compagnie_assurance" class="form-control" value="{{ old('compagnie_assurance') }}" required>
            </div>

            <div class="form-group">
                <label for="ref_contrat">Référence du Contrat</label>
                <input type="text" name="ref_contrat" id="ref_contrat" class="form-control" value="{{ old('ref_contrat') }}" required>
            </div>

            <div class="form-group">
                <label for="date_effet">Date d'Effet</label>
                <input type="date" name="date_effet" id="date_effet" class="form-control" value="{{ old('date_effet') }}" required>
            </div>

            <div class="form-group">
                <label for="echeance">Échéance</label>
                <input type="date" name="echeance" id="echeance" class="form-control" value="{{ old('echeance') }}" required>
            </div>

            <div class="form-group">
                <label for="condition_renouvellement">Conditions de Renouvellement</label>
                <input type="text" name="condition_renouvellement" id="condition_renouvellement" class="form-control" value="{{ old('condition_renouvellement') }}">
            </div>

            <div class="form-group">
                <label for="avenant">Avenant</label>
                <select name="avenant" id="avenant" class="form-control" required>
                    <option value="oui" {{ old('avenant') == 'oui' ? 'selected' : '' }}>Oui</option>
                    <option value="non" {{ old('avenant') == 'non' ? 'selected' : '' }}>Non</option>
                </select>
            </div>

            <div class="form-group">
                <label for="objet_avenant">Objet Avenant </label>
                <input type="text" name="objet_avenant" id="objet_avenant" class="form-control" value="{{ old('objet_avenant') }}">
            </div>

            <div class="form-group">
                <label for="attachement_contrat">Attachement Contrat (PDF)</label>
                <input type="file" name="attachement_contrat" id="attachement_contrat" class="form-control">
            </div>

            <div class="form-group">
                <label for="attachement_avenant">Attachement Avenant (PDF)</label>
                <input type="file" name="attachement_avenant" id="attachement_avenant" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter le Contrat</button>
        </form>
    </div>
@endsection
