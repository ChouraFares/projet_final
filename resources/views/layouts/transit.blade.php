<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Transit Achat  - BK FOOD</title>
=======
    <title>Transit - BK FOOD</title>
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
    <link rel="stylesheet" href="{{ asset('css/transit.css') }}">
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <style>
<<<<<<< HEAD
        /* Fixer le zoom à 75% avec transform */
        body {
            transform: scale(0.75); /* Zoom augmenté de 50% à 75% */
            transform-origin: top left; /* Point de départ du zoom */
            width: 133.33%; /* Compensé pour le zoom (100 / 0.75 = 133.33%) */
            height: 133.33%; /* Compensé pour le zoom (100 / 0.75 = 133.33%) */
=======
        /* Fixer le zoom à 50% avec transform */
        body {
            transform: scale(0.5);
            transform-origin: top left; /* Point de départ du zoom */
            width: 200%; /* Compensé pour éviter le rétrécissement */
            height: 200%; /* Compensé pour éviter le rétrécissement */
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
            overflow: auto; /* Permettre le défilement si nécessaire */
        }

        /* Ajuster le conteneur principal pour occuper tout l’espace */
        html {
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        /* Style des alertes */
        .alert-container {
            position: fixed;
            top: 20px;
            left: 50%;
<<<<<<< HEAD
            transform: translateX(-50%) scale(1.3333); /* Contrebalancer le zoom du body (1 / 0.75 = 1.3333) */
=======
            transform: translateX(-50%) scale(2); /* Contrebalancer le zoom du body */
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
            width: 80%;
            max-width: 600px;
            z-index: 1000;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        .alert-success {
            background-color: #28a745;
            color: white;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
        .alert i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/bk-food.png') }}" alt="Logo BK Food" style="width: 150px; height: auto;">
    </header>

    <div class="alert-container">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 73aa7d46b21da869958b907c679599bfb3cef23a
