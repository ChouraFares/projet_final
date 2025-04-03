<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - BK Food</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicon HD (pour les écrans retina) -->
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/bk-food-hd.png') }}">

<!-- Favicon standard -->
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/bk-food-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/bk-food-16x16.png') }}">

<!-- Pour Safari/iOS -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/bk-food-180x180.png') }}">


    <style>
        :root {
            --olive: #887630;
            --federal-blue: #2A4B67;
            --navy-blue: #2A4B67;
            --dark-blue: #000022;
            --light-beige: #F5F5DC;
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
            background: rgba(0, 0, 79, 0.3);
        }
        
        .login-form-container {
            flex: 1;
            background-color: white;
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
        
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
        }
        
        .form-control:focus {
            border-color: var(--olive);
            box-shadow: 0 0 0 0.25rem rgba(136, 118, 48, 0.25);
        }
        
        .btn-login {
            background-color: var(--navy-blue);
            color: white;
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
        
        .login-title {
            color: var(--navy-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .form-label {
            color: var(--federal-blue);
            font-weight: 500;
        }
        
        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .footer-links a {
            color: var(--olive);
            text-decoration: none;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
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
        <!-- Image Section (Outside login container) -->
        <div class="login-image"></div>
        
        <!-- Login Form Section -->
        <div class="login-form-container">
            <div class="login-form">
                <div class="logo-container">
                    <img src="/images/bk-food.png" alt="BK Food Logo">
                </div>
                
                <h3 class="login-title">Connexion à votre espace</h3>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Adresse Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg" required autofocus />
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-primary">Mot de passe oublié?</a>
                    
                    
                    </div>
                    
                    <button type="submit" class="btn btn-login mb-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                    </button>
                    
                    <div class="footer-links">
                        <a href="#">Conditions d'utilisation</a>
                        <a href="#">Politique de confidentialité</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>