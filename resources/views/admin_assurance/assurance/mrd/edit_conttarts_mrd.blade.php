@extends('layouts.app')

@section('title', 'Modifier un Contrat MRD')

@section('content')

<style>
body {
    background-color: #f8f9fa; /* Fond neutre */
    }

    .container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
    }

    .form-label {
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
    }

    .form-control {
    width: 100%;
    border-radius: 5px;
    padding: 8px;
    font-size: 14px;
    }

    .form-control:focus {
    border-color: #666;
    box-shadow: none;
    outline: none;
    }

    .alert {
    text-align: center;
    }
</style>

<div class="container">
    <h2>Modifier un Contrat MRD</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.mrd.contrats.update', $contrat->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="compagnie_assurance" class="form-label">Compagnie d'Assurance</label>
        <input type="text" name="compagnie_assurance" id="compagnie_assurance" class="form-control" value="{{ $contrat->compagnie_assurance }}" required>
    </div>

    <div class="mb-3">
        <label for="ref_contrat" class="form-label">Référence du Contrat</label>
        <input type="text" name="ref_contrat" id="ref_contrat" class="form-control" value="{{ $contrat->ref_contrat }}" required>
    </div>

    <div class="mb-3">
        <label for="date_effet" class="form-label">Date d'Effet</label>
        <input type="date" name="date_effet" id="date_effet" class="form-control" value="{{ $contrat->date_effet }}" required>
    </div>

    <div class="mb-3">
        <label for="echeance" class="form-label">Échéance</label>
        <input type="date" name="echeance" id="echeance" class="form-control" value="{{ $contrat->echeance }}" required>
    </div>

    <div class="mb-3">
        <label for="condition_renouvellement" class="form-label">Condition de Renouvellement</label>
        <input type="text" name="condition_renouvellement" id="condition_renouvellement" class="form-control" value="{{ $contrat->condition_renouvellement }}">
    </div>

    <div class="mb-3">
        <label for="avenant" class="form-label">Avenant</label>
        <input type="text" name="avenant" id="avenant" class="form-control" value="{{ $contrat->avenant }}">
    </div>

    <div class="mb-3">
        <label for="objet_avenant" class="form-label">Objet Avenant</label>
        <input type="text" name="objet_avenant" id="objet_avenant" class="form-control" value="{{ $contrat->objet_avenant }}">
    </div>

    <div class="mb-3">
        <label for="attachement_contrat" class="form-label">Attachement Contrat (PDF)</label>
        <input type="file" name="attachement_contrat" id="attachement_contrat" class="form-control" accept=".pdf">
        @if($contrat->attachement_contrat)
        <p><a href="{{ asset('storage/'.$contrat->attachement_contrat) }}" target="_blank" style="color: yellow;">Voir le fichier actuel</a></p>
        @endif
    </div>

    <div class="mb-3">
        <label for="attachement_avenant" class="form-label">Attachement Avenant (PDF)</label>
        <input type="file" name="attachement_avenant" id="attachement_avenant" class="form-control" accept=".pdf">
        @if($contrat->attachement_avenant)
        <p><a href="{{ asset('storage/'.$contrat->attachement_avenant) }}" target="_blank" style="color: yellow;">Voir le fichier actuel</a></p>
        @endif
    </div>

    <button type="submit" class="btn">Mettre à jour</button>
    </form>
</div>

@endsection
