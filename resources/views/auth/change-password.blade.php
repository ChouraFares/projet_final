@extends('layouts.app')
@section('content')
<head>
    <title>Changer le mot de passe - BK FOOD</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h2>Changer le mot de passe</h2>

            <form method="POST" action="{{ route('change-password.update') }}">
                @csrf
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn">Changer le mot de passe</button>
            </form>

            <p><a href="{{ route('login') }}">Retour a la page de login</a></p>
        </div>
    </div>
</body>
</html>

@endsection