@extends('layouts.app')

@section('title', 'Modifier un Sinistre')

@section('content')
<div class="container">
    <h2>Modifier un Sinistre</h2>

    <!-- Formulaire de modification du sinistre -->
    <form action="{{ route('admin.mrd.sinistres.update', $sinistre->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Pour indiquer que c'est une mise à jour -->

        <div class="row">
            <div class="col-md-6">
                <!-- Type Assurance -->


                <!-- Assureur -->
                <div class="form-group">
                    <label for="compagnie_assurance"> Compagnie Assurance</label>
                    <input type="text" id="compagnie_assurance" name="compagnie_assurance" class="form-control @error('compagnie_assurance') is-invalid @enderror" value="{{ old('compagnie_assurance', $sinistre->compagnie_assurance) }}" required>
                    @error('compagnie_assurance')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nature du Sinistre -->
                <div class="form-group">
                    <label for="nature_sinistre">Nature du Sinistre</label>
                    <input type="text" id="nature_sinistre" name="nature_sinistre" class="form-control @error('nature_sinistre') is-invalid @enderror" value="{{ old('nature_sinistre', $sinistre->nature_sinistre) }}" required>
                    @error('nature_sinistre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lieu du Sinistre -->
                <div class="form-group">
                    <label for="lieu_sinistre">Lieu du Sinistre</label>
                    <input type="text" id="lieu_sinistre" name="lieu_sinistre" class="form-control @error('lieu_sinistre') is-invalid @enderror" value="{{ old('lieu_sinistre', $sinistre->lieu_sinistre) }}" required>
                    @error('lieu_sinistre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date du Sinistre -->
                <div class="form-group">
                    <label for="date_sinistre">Date du Sinistre</label>
                    <input type="date" id="date_sinistre" name="date_sinistre" class="form-control @error('date_sinistre') is-invalid @enderror" value="{{ old('date_sinistre', $sinistre->date_sinistre) }}" required>
                    @error('date_sinistre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Degâts -->
                <div class="form-group">
                    <label for="degats">Dégâts</label>
                    <textarea id="degats" name="degats" class="form-control @error('degats') is-invalid @enderror" rows="3" required>{{ old('degats', $sinistre->degats) }}</textarea>
                    @error('degats')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Charge -->
                <div class="form-group">
                    <label for="charge">Charge</label>
                    <input type="number" id="charge" name="charge" class="form-control @error('charge') is-invalid @enderror" value="{{ old('charge', $sinistre->charge) }}" >
                    @error('charge')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <!-- Perte -->
                <div class="form-group">
                    <label for="perte">Perte</label>
                    <input type="number" id="perte" name="perte" class="form-control @error('perte') is-invalid @enderror" value="{{ old('perte', $sinistre->perte) }}" >
                    @error('perte')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Responsable -->
                <div class="form-group">
                    <label for="responsable">Responsable</label>
                    <input type="text" id="responsable" name="responsable" class="form-control @error('responsable') is-invalid @enderror" value="{{ old('responsable', $sinistre->responsable) }}" >
                    @error('responsable')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Commentaires -->
                <div class="form-group">
                    <label for="commentaires">Commentaires</label>
                    <textarea id="commentaires" name="commentaires" class="form-control @error('commentaires') is-invalid @enderror" rows="3">{{ old('commentaires', $sinistre->commentaires) }}</textarea>
                    @error('commentaires')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
<!-- Status -->
<div class="form-group">
    <label for="statut">Status</label>
    <select id="statut" name="statut" class="form-control @error('statut') is-invalid @enderror" required>
        <option value="Avant Constat" {{ old('statut', $sinistre->statut) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
        <option value="Constat Deposé" {{ old('statut', $sinistre->statut) == 'Constat Deposé' ? 'selected' : '' }}>Constat Deposé</option>
        <option value="Expert" {{ old('statut', $sinistre->statut) == 'Expert' ? 'selected' : '' }}>Expert</option>
        <option value="En attente du remboursement" {{ old('statut', $sinistre->statut) == 'En attente du remboursement' ? 'selected' : '' }}>En attente du remboursement</option>
    </select>
    @error('statut')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-warning mt-3">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>
@endsection
