@extends('layouts.app')

@section('title', 'Modifier mon Profil')

@section('content')
<div class="edit-profile-container">
    <h1><i class="fas fa-user-edit"></i> Modifier mon Profil</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="profile_photo">Photo de profil</label>
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
            @if($user->profile_photo)
                <div class="current-photo">
                    <span>Photo actuelle :</span>
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo actuelle" width="120">
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-save">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <a href="{{ route('profile') }}" class="btn btn-cancel">
                Annuler
            </a>
        </div>
    </form>
</div>

<style>
.edit-profile-container {
    background-color: #2A4B67;
    color: white;
    padding: 30px;
    border-radius: 10px;
    max-width: 800px;
    margin: 30px auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.edit-profile-container h1 {
    color: #887630;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: white;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="file"] {
    width: 100%;
    padding: 12px;
    border: 2px solid #00004F;
    border-radius: 5px;
    background-color: #1E3D58;
    color: white;
}

.current-photo {
    margin-top: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.current-photo img {
    border-radius: 5px;
    border: 2px solid #887630;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
}

.btn {
    padding: 12px 25px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-save {
    background-color: #887630;
    color: white;
    border: none;
}

.btn-save:hover {
    background-color: #6b5c2a;
}

.btn-cancel {
    background-color: transparent;
    color: white;
    border: 2px solid #000080;
}

.btn-cancel:hover {
    background-color: #000080;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endsection