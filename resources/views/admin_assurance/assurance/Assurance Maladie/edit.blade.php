@extends('layouts.app')

@section('title', 'Modifier une Assurance Maladie')

@section('content')
<div class="dashboard">
    <div class="header">
        <div>
            <h2><i class="fas fa-file-medical me-2"></i>Modifier une Assurance Maladie</h2>
        </div>
    </div>

    <div class="form-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('AssuranceMaladieUpdate', $assurance->id) }}" method="POST" id="editAssuranceMaladieForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Première colonne -->
                <div class="card">
                    <!-- Date d'Envoi -->
                    <div class="form-group">
                        <label for="date_envoi" class="form-label">
                            <i class="fas fa-calendar-alt me-1"></i>Date d'Envoi
                        </label>
                        <input type="date" class="form-control @error('date_envoi') is-invalid @enderror" 
                               id="date_envoi" name="date_envoi" 
                               value="{{ old('date_envoi', $assurance->date_envoi) }}" required>
                        @error('date_envoi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Numéro Bulletin -->
                    <div class="form-group">
                        <label for="bulletin_numero" class="form-label">
                            <i class="fas fa-file-alt me-1"></i>Numéro Bulletin
                        </label>
                        <input type="text" class="form-control @error('bulletin_numero') is-invalid @enderror" 
                               id="bulletin_numero" name="bulletin_numero" 
                               value="{{ old('bulletin_numero', $assurance->bulletin_numero) }}" required>
                        @error('bulletin_numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nom Adhérent -->
                    <div class="form-group">
                        <label for="nom_adherent" class="form-label">
                            <i class="fas fa-user me-1"></i>Nom Adhérent
                        </label>
                        <input type="text" class="form-control @error('nom_adherent') is-invalid @enderror" 
                               id="nom_adherent" name="nom_adherent" 
                               value="{{ old('nom_adherent', $assurance->nom_adherent) }}" required>
                        @error('nom_adherent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième colonne -->
                <div class="card">
                    <!-- Date de Soin -->
                    <div class="form-group">
                        <label for="date_de_soin" class="form-label">
                            <i class="fas fa-calendar-check me-1"></i>Date de Soin
                        </label>
                        <input type="date" class="form-control @error('date_de_soin') is-invalid @enderror" 
                               id="date_de_soin" name="date_de_soin" 
                               value="{{ old('date_de_soin', $assurance->date_de_soin) }}" required>
                        @error('date_de_soin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="form-group">
                        <label for="status" class="form-label">
                            <i class="fas fa-info-circle me-1"></i>Statut
                        </label>
                        <select class="department-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="Remis" {{ old('status', $assurance->status) == 'Remis' ? 'selected' : '' }}>Remis</option>
                            <option value="Non Remis" {{ old('status', $assurance->status) == 'Non Remis' ? 'selected' : '' }}>Non Remis</option>
                            <option value="Cloturé" {{ old('status', $assurance->status) == 'Cloturé' ? 'selected' : '' }}>Clôturé</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Réclamations -->
                    <div class="form-group">
                        <label for="reclamation" class="form-label">
                            <i class="fas fa-comment-dots me-1"></i>Réclamations
                        </label>
                        <textarea class="form-control @error('reclamation') is-invalid @enderror" 
                                  id="reclamation" name="reclamation" 
                                  rows="4">{{ old('reclamation', $assurance->reclamation) }}</textarea>
                        @error('reclamation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="btn-group" style="margin-top: 30px; justify-content: center;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Modifier
                </button>
            </div>
        </form>
    </div>
</div>

@endsection