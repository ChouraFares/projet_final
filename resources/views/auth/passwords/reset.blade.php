<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - BK Food</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --olive: #887630;
            --federal-blue: #2A4B67;
            --navy-blue: #2A4B67;
            --dark-blue: #2A4B67;
            --dashboard-bg: #2A4B67;
            --primary: #F4A261;
            --secondary: #E76F51;
            --text-light: #F4F4F9;
            --text-dark: #1E3D58;
        }

        body {
            background: linear-gradient(135deg, var(--federal-blue), var(--navy-blue));
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .login-image {
            flex: 1;
            background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 34, 0.3); /* Utilisation de --dark-blue avec opacité */
        }

        .login-form-container {
            flex: 1;
            background-color: var(--text-light);
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            max-height: 100px;
        }

        .login-title {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-label {
            color: var(--text-dark);
            font-weight: 500;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid var(--dark-blue);
            color: var(--text-dark);
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(244, 162, 97, 0.25); /* Ombre avec --primary */
        }

        .form-control.is-invalid {
            border-color: var(--secondary);
        }

        .invalid-feedback {
            color: var(--secondary);
            font-weight: 500;
        }

        .btn-login {
            background-color: var(--navy-blue);
            color: var(--text-light);
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: var(--federal-blue);
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 600px;
            }

            .login-image {
                min-height: 200px;
            }

            .login-form-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Image Section -->
        <div class="login-image"></div>
        
        <!-- Form Section -->
        <div class="login-form-container">
            <div class="login-form">
                <div class="logo-container">
                    <img src="/images/bk-food.png" alt="BK Food Logo">
                </div>
                
                <h3 class="login-title">Nouveau mot de passe</h3>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autofocus />
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required />
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password-confirm">Confirmer le mot de passe</label>
                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-lg" required />
                    </div>
                    
                    <button type="submit" class="btn btn-login mb-4">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>