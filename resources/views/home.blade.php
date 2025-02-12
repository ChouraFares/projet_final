
@section('title', 'Bienvenue sur le Portail BK Food')

<style>
    :root {
        --olive: #887630;
        --federal-blue: #00004F;
        --navy-blue: #000080;
        --white: #ffffff;
        --light-gray: #f8f9fa;
    }

    .homepage-container {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
    }

    /* Vidéo en arrière-plan */
    .background-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* S'assure que la vidéo remplit l'espace */
        z-index: -1; /* Place la vidéo derrière le contenu */
        opacity: 0.7; /* Légère transparence pour le contenu au-dessus */
    }

    /* Header */
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px 20px;
        background: rgba(43, 39, 39, 0.7);
        backdrop-filter: blur(5px);
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    header a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    header img {
        height: 50px;
        margin-right: 20px;
        transition: transform 0.3s ease;
    }

    header img:hover {
        transform: scale(1.1);
    }

    header h1 {
        font-size: 1.8rem;
        color: var(--white);
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    /* Hero Section */
    .hero {
        position: relative;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 0 20px;
        z-index: 2;
        color: var(--white);
        background: linear-gradient(135deg, rgba(0, 0, 79, 0.9), rgba(0, 0, 128, 0.8));
    }

    .hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset('images/télécharger__3_-removebg-preview.png') }}') no-repeat center center;
        background-size: contain;
        opacity: 0.15;
        z-index: -1;
        animation: zoomInOut 10s ease-in-out infinite;
    }

    .hero h1 {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 2rem;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);
        animation: fadeInDown 1s ease-out;
    }

    .hero p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        color: #ddd;
        animation: fadeInUp 1s ease-out 0.5s both;
    }

    .hero .btn {
        display: inline-block;
        padding: 12px 40px;
        margin: 10px;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        text-decoration: none;
        animation: fadeInUp 1s ease-out 0.3s both;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .hero .btn:first-of-type {
        background-color: var(--olive);
        color: var(--white);
        border: 2px solid var(--olive);
    }

    .hero .btn:last-of-type {
        background-color: transparent;
        color: var(--white);
        border: 2px solid var(--white);
    }

    .hero .btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }

    .hero .btn:first-of-type:hover {
        background-color: transparent;
        color: var(--white);
        border-color: var(--white);
    }

    .hero .btn:last-of-type:hover {
        background-color: var(--olive);
        border-color: var(--olive);
    }

    /* Footer */
    footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.8);
        padding: 1rem;
        text-align: center;
        font-size: 0.9rem;
        color: #ddd;
        z-index: 3;
    }

    footer a {
        color: var(--olive);
        text-decoration: none;
        margin: 0 5px;
    }

    footer a:hover {
        color: var(--white);
        text-decoration: underline;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes zoomInOut {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-15px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            padding: 10px;
        }

        header img {
            height: 40px;
            margin-right: 0;
            margin-bottom: 10px;
        }

        header h1 {
            font-size: 1.2rem;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .hero .btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="homepage-container">
    <!-- Vidéo en arrière-plan -->
    <video class="background-video" autoplay muted loop playsinline>
        <source src="{{ asset('videos/2fd67280-45cf-4863-a17d-f6328ddc48f6.mp4') }}" type="video/mp4">
        Votre navigateur ne supporte pas la balise vidéo.
    </video>

    <!-- Header Section -->
    <header>
        <a href="/">
            <img src="{{ asset('images/bk-food.png') }}" alt="BK Food Logo">
            <h1>Portail BK Food</h1>
        </a>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1 class="floating">Bienvenue sur le Portail BK Food</h1>
        <p>Simplifiez votre gestion avec notre plateforme intuitive et moderne</p>
        <div>
            <a href="{{ route('login') }}" class="btn">Se connecter</a>
            <a href="{{ route('register') }}" class="btn">Créer un compte</a>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>© {{ date('Y') }} BK Food. Tous droits réservés.</p>
        <div>
            <a href="#">Conditions d'utilisation</a> | 
            <a href="#">Politique de confidentialité</a>
        </div>
    </footer>
</div>

<script>
    // Ajout d'un effet de parallaxe subtil
    document.addEventListener('mousemove', function(e) {
        const hero = document.querySelector('.hero');
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        hero.style.backgroundPosition = `${x * 30}px ${y * 30}px`;
    });

    // Animation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach((btn, index) => {
            btn.style.animationDelay = `${index * 0.1 + 0.3}s`;
        });
    });
</script>
