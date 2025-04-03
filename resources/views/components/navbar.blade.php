<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #23435f;">
    <div class="container-fluid">
        <!-- Navbar Brand -->
        <div class="navbar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" class="logo">
            </a>
            <span class="navbar-title">Portail</span>
        </div>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <!-- Menu Items -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link d-flex flex-column text-center">
                        <i class="fas fa-home fa-lg my-1"></i>
                        <span class="small">Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link d-flex flex-column text-center">
                        <i class="fas fa-user-edit fa-lg my-1"></i>
                        <span class="small">Modifier profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('change-password') }}" class="nav-link d-flex flex-column text-center">
                        <i class="fas fa-key fa-lg my-1"></i>
                        <span class="small">Mot de passe</span>
                    </a>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" 
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Photo de profil" class="profile-photo">
                        @else
                            <div class="user-icon-container">
                                <i class="fas fa-user-circle user-icon"></i>
                            </div>
                        @endif
                        <span class="username ms-2">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mon profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('change-password') }}">Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item btn-logout">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.navbar {
    background-color: #23435f;
    padding: 15px 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 20px;
}

.navbar-brand .logo {
    height: 60px;
    transition: transform 0.3s;
}

.navbar-brand .logo:hover {
    transform: scale(1.05);
}

.navbar-title {
    color: #887630;
    font-weight: bold;
    font-size: 1.4rem;
    letter-spacing: 1px;
}

.navbar-toggler {
    border: none;
    color: #887630;
}

.navbar-toggler i {
    font-size: 24px;
    color: #887630;
}

.navbar-nav .nav-link {
    color: white;
    padding: 10px 15px;
    transition: all 0.3s;
}

.navbar-nav .nav-link:hover {
    color: #887630;
    background-color: rgba(0, 0, 128, 0.2);
}

.navbar-nav .nav-link i {
    font-size: 18px;
}

.navbar-nav .nav-link .small {
    font-size: 0.85rem;
}

.profile-photo {
    width: 80px; /* Taille augmentée pour le dashboard */
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #887630;
    box-shadow: 0 0 8px rgba(136, 118, 48, 0.6);
    transition: transform 0.3s, box-shadow 0.3s;
}

.profile-photo:hover {
    transform: scale(1.1);
    box-shadow: 0 0 12px rgba(136, 118, 48, 0.8);
}

.user-icon-container {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(136, 118, 48, 0.15);
    border-radius: 50%;
    border: 2px solid #887630;
}

.user-icon {
    font-size: 50px; /* Taille augmentée pour correspondre à la photo */
    color: #887630;
}

.username {
    font-weight: 600;
    font-size: 1.1rem;
    color: white;
}

.dropdown-menu {
    background-color: #23435f;
    border: 1px solid #887630;
    color: white;
}

.dropdown-item {
    color: white;
    padding: 8px 15px;
    transition: all 0.3s;
}

.dropdown-item:hover {
    background-color: #000080;
    color: #887630;
}

.btn-logout {
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    color: white;
    font-size: 1rem;
}

.btn-logout:hover {
    color: #887630;
    background-color: rgba(0, 0, 128, 0.2);
}

.dropdown-divider {
    border-color: rgba(136, 118, 48, 0.3);
}

@media (max-width: 991px) {
    .navbar-nav {
        padding-top: 15px;
        text-align: center;
    }
    
    .profile-photo, .user-icon-container {
        width: 60px; /* Réduction pour mobile */
        height: 60px;
    }
    
    .user-icon {
        font-size: 40px;
    }
    
    .navbar-brand .logo {
        height: 50px;
    }
    
    .navbar-title {
        font-size: 1.2rem;
    }
}
</style>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>