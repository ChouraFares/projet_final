@extends('layouts.app')

@section('title', 'Modifier une Assurance Maladie')

@section('content')
<style>
    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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

    .btn {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Modifier une Assurance Maladie</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('AssuranceMaladieUpdate', $assurance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date_envoi" class="form-label">Date d'Envoi</label>
            <input type="date" class="form-control" id="date_envoi" name="date_envoi" value="{{ $assurance->date_envoi }}" required>
        </div>

        <div class="mb-3">
            <label for="bulletin_numero" class="form-label"><i class="fas fa-file-alt"></i> Numéro Bulletin</label>
            <input type="text" class="form-control" id="bulletin_numero" name="bulletin_numero" value="{{ $assurance->bulletin_numero }}" required>
        </div>

        <div class="mb-3">
            <label for="nom_adherent" class="form-label"><i class="fas fa-user"></i> Nom Adhérent</label>
            <input type="text" class="form-control" id="nom_adherent" name="nom_adherent" value="{{ $assurance->nom_adherent }}" required>
        </div>

        <div class="mb-3">
            <label for="matricule" class="form-label"><i class="fas fa-id-card"></i> Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" value="{{ $assurance->matricule }}" required>
        </div>

        <div class="mb-3">
            <label for="date_de_soin" class="form-label"><i class="fas fa-calendar-check"></i> Date de Soin</label>
            <input type="date" class="form-control" id="date_de_soin" name="date_de_soin" value="{{ $assurance->date_de_soin }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label"><i class="fas fa-info-circle"></i> Statut</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Remis" {{ $assurance->status == 'Remis' ? 'selected' : '' }}>Remis</option>
                <option value="Non Remis" {{ $assurance->status == 'Non Remis' ? 'selected' : '' }}>Non Remis</option>
                <option value="Cloturé" {{ $assurance->status == 'Cloturé' ? 'selected' : '' }}>Clôturé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="reclamation" class="form-label"><i class="fas fa-comment-dots"></i> Réclamations</label>
            <textarea class="form-control" id="reclamation" name="reclamation" rows="3">{{ $assurance->reclamation }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
@endsection
