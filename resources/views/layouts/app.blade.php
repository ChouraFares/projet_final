<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Favicon (Logo in the browser tab) -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}">
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
</head>
<body style="transform: scale(0.8); transform-origin: 0 0; width: 125%; height: 125%;">
    <header>
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" style="height: 50px; margin-right: 20px;">
        </a>
        <h1>Portail - BK FOOD</h1>
    </header>

    <!-- Section pour afficher les messages d'alerte -->
    <div class="alert-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <!-- Icône de succès -->
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <!-- Icône d'erreur -->
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script>
        // Faire disparaître les messages après 5 secondes
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    <style>
        /* Style de la section des alertes */
        .alert-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 600px;
            z-index: 1000;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert i {
            font-size: 20px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
<script>
    console.log('Script chargé');
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('notificationModal');
        const openBtn = document.getElementById('notificationBtn');
        const closeBtn = document.getElementById('closeModal');

        if (openBtn) {
            openBtn.addEventListener('click', function() {
                console.log('Bouton cliqué');
                if (modal) {
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden'; // Empêche le défilement
                } else {
                    console.error('Modal non trouvé');
                }
            });
        } else {
            console.error('Bouton non trouvé');
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                console.log('Fermeture cliquée');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto'; // Restaure le défilement
                }
            });
        } else {
            console.error('Bouton de fermeture non trouvé');
        }

        // Fermer le modal en cliquant à l'extérieur
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                console.log('Clic à l’extérieur');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
</body>
</html>