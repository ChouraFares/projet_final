@extends('layouts.app')

@section('title', 'Modifier Sinistre Bris de Machine')

@section('content')
<style>


    /* Style pour le conteneur principal */
.container {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

/* Style pour le titre */
h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2rem;
}

/* Style pour les messages d'alerte */





/* Style pour le formulaire */
form {
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Style pour les étiquettes des champs */
.form-label {
    font-weight: bold;
    margin-bottom: 5px;
}

/* Style pour les champs de formulaire */
.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    font-size: 1rem;
    margin-bottom: 15px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
}

/* Style pour les boutons */
.btn {
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    cursor: pointer;
}









/* Style pour les boutons dans le formulaire */

</style>
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Modifier le Sinistre Bris de Machine</h2>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire d'édition d'un sinistre -->
    <form action="{{ route('bris_de_machine.update', $sinistre->id) }}" method="POST" class="shadow-lg p-4 rounded bg-light border border-primary">
        @csrf
        @method('PUT') <!-- Indique que la méthode HTTP est PUT pour la mise à jour -->

     

        <div class="mb-3">
            <label for="assureur" class="form-label">Compagnie Assurance</label>
            <input type="text" class="form-control" id="assureur" name="assureur" value="{{ old('assureur', $sinistre->assureur) }}" required>
        </div>

        <div class="mb-3">
            <label for="nature_sinistre" class="form-label">Nature du Sinistre</label>
            <input type="text" class="form-control" id="nature_sinistre" name="nature_sinistre" value="{{ old('nature_sinistre', $sinistre->nature_sinistre) }}" required>
        </div>

        <div class="mb-3">
            <label for="lieu_sinistre" class="form-label">Lieu du Sinistre</label>
            <input type="text" class="form-control" id="lieu_sinistre" name="lieu_sinistre" value="{{ old('lieu_sinistre', $sinistre->lieu_sinistre) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_sinistre" class="form-label">Date du Sinistre</label>
            <input type="date" class="form-control" id="date_sinistre" name="date_sinistre"
            value="{{ old('date_sinistre', \Carbon\Carbon::parse($sinistre->date_sinistre)->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="degats" class="form-label">Dégâts</label>
            <textarea class="form-control" id="degats" name="degats" required>{{ old('degats', $sinistre->degats) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="charge" class="form-label">Chargé</label>
            <input type="text" class="form-control" id="charge" name="charge" value="{{ old('charge', $sinistre->charge) }}" required>
        </div>

        <div class="mb-3">
            <label for="perte" class="form-label">Perte</label>
            <input type="number" class="form-control" id="perte" name="perte" value="{{ old('perte', $sinistre->perte) }}" required>
        </div>

        <div class="mb-3">
            <label for="responsable" class="form-label">Responsable</label>
            <input type="text" class="form-control" id="responsable" name="responsable" value="{{ old('responsable', $sinistre->responsable) }}" required>
        </div>

        <div class="form-group">
            <label for="statu_du_dossier">Status</label>
            <select class="form-control" id="statu_du_dossier" name="statu_du_dossier" required>
            <option value="">Sélectionner un statut</option>
            <option value="Avant Constat" {{ old('statu_du_dossier', $sinistre->statu_du_dossier) == 'Avant Constat' ? 'selected' : '' }}>Avant Constat</option>
            <option value="Constat Déposé" {{ old('statu_du_dossier', $sinistre->statu_du_dossier) == 'Constat Déposé' ? 'selected' : '' }}>Constat Déposé</option>
            <option value="Expert" {{ old('statu_du_dossier', $sinistre->statu_du_dossier) == 'Expert' ? 'selected' : '' }}>Expert</option>
            <option value="En attente du remboursement" {{ old('statu_du_dossier', $sinistre->statu_du_dossier) == 'En attente du remboursement' ? 'selected' : '' }}>En attente du remboursement</option>
            </select>
        </div>


        <div class="form-group">
            <label for="expert">Expert</label>
            <input type="text" class="form-control" id="expert" name="expert" value="{{ old('expert', $sinistre->expert) }}" >
        </div>


        <div class="mb-3">
            <label for="commentaires" class="form-label">Commentaires</label>
            <textarea class="form-control" id="commentaires" name="commentaires">{{ old('commentaires', $sinistre->commentaires) }}</textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success">Sauvegarder les modifications</button>
        </div>
    </form>
</div>
@endsection
