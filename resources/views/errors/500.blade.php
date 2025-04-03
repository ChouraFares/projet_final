<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur système - BK Food</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --olive: #887630;
            --federal-blue: #00004F;
            --navy-blue: #000080;
            --dark-blue: #000022;
            --dashboard-bg: #2A4B67;
            --primary: #F4A261;
            --secondary: #E76F51;
            --text-light: #F4F4F9;
            --text-dark: #1E3D58;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--dashboard-bg);
            margin: 0;
            padding: 0;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .error-container {
            max-width: 700px;
            margin: 5vh auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-out;
        }

        .error-header {
            background: var(--federal-blue);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 4px solid var(--primary);
        }

        .error-header h1 {
            margin: 0;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .error-content {
            padding: 2.5rem;
        }

        .error-icon {
            font-size: 5rem;
            color: var(--secondary);
            text-align: center;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        .error-message {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .error-details {
            background: var(--text-light);
            padding: 1.25rem;
            border-radius: 8px;
            margin: 2rem 0;
            border-left: 4px solid var(--secondary);
        }

        .contact-card {
            background: var(--dark-blue);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 2.5rem 0;
        }

        .contact-card h3 {
            color: var(--primary);
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-methods {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .contact-link {
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-link:hover {
            color: var(--primary);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.9rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--text-dark);
            border: 2px solid var(--primary);
        }

        .btn-primary:hover {
            background: transparent;
            color: var(--primary);
        }

        .btn-secondary {
            background: var(--secondary);
            color: white;
            border: 2px solid var(--secondary);
        }

        .btn-secondary:hover {
            background: transparent;
            color: var(--secondary);
        }

        .error-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .error-container {
                margin: 2vh auto;
                border-radius: 0;
            }
            
            .error-content {
                padding: 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-header">
            <h1>
                <i class="fas fa-exclamation-triangle"></i>
                ERREUR SYSTÈME
            </h1>
        </div>
        
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-bug"></i>
            </div>
            
            <div class="error-message">
                <p>Une erreur critique est survenue dans le système.</p>
            </div>
            
            <div class="error-details">
                <p><i class="fas fa-barcode"></i> <strong>Référence :</strong> ERR-{{ substr(md5(uniqid()), 0, 8) }}</p>
                <p><i class="fas fa-calendar-day"></i> <strong>Date/heure :</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
            
            <div class="contact-card">
                <h3><i class="fas fa-headset"></i> Support technique</h3>
                <div class="contact-methods">
                    <a href="mailto:Fares.Choura@bkfood.com.tn" class="contact-link">
                        <i class="fas fa-envelope"></i> Fares.Choura@bkfood.com.tn
                    </a>
                    <div class="contact-link">
                        <i class="fas fa-phone"></i> +216 99 997 496
                    </div>
                    <div class="contact-link">
                        <i class="fas fa-clock"></i> Disponible 8h-17h (Lundi-Vendredi)
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button onclick="window.history.back()" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Page précédente
                </button>
                <a href="/" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Page d'accueil
                </a>
            </div>
        </div>
    </div>
    
    <div class="error-footer">
        &copy; {{ date('Y') }} BK Food - Tous droits réservés
    </div>

    <script>
        // Enregistrement de l'erreur dans la console
        console.error("Erreur système détectée. Code: ERR-{{ substr(md5(uniqid()), 0, 8) }}");
        
        // Tentative de récupération du chemin erroné
        const errorPath = window.location.pathname;
        if(errorPath) {
            console.log("Chemin demandé:", errorPath);
        }
    </script>
</body>
</html>