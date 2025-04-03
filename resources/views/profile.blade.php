@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-photo-container">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo de profil" class="profile-photo-large">
            @else
                <div class="profile-photo-default">
                    <i class="fas fa-user-circle"></i>
                </div>
            @endif
        </div>
        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            <p class="profile-role">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-edit">
                <i class="fas fa-edit"></i> Modifier le profil
            </a>
        </div>
    </div>
</div>

<style>
.profile-container {
    background-color: #2A4B67;
    color: white;
    padding: 30px;
    border-radius: 10px;
    max-width: 1000px;
    margin: 30px auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 40px;
}

.profile-photo-container {
    flex-shrink: 0;
}

.profile-photo-large {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #887630;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.profile-photo-default {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1E3D58;
    border: 5px solid #887630;
}

.profile-photo-default i {
    font-size: 120px;
    color: #887630;
}

.profile-info {
    flex-grow: 1;
}

.profile-info h1 {
    color: white;
    font-size: 2.2rem;
    margin-bottom: 10px;
}

.profile-email {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 15px;
}

.profile-role {
    display: inline-block;
    background-color: #00004F;
    color: #887630;
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

.btn-edit {
    background-color: #887630;
    color: white;
    padding: 12px 25px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
    transition: all 0.3s;
}

.btn-edit:hover {
    background-color: #6b5c2a;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .profile-photo-large, .profile-photo-default {
        width: 150px;
        height: 150px;
    }
}
</style>
@endsection