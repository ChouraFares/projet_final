<nav class="navbar">
    <div class="navbar-brand">
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" class="logo">
        </a>
        <span class="navbar-title">Portail</span>
        <!-- Hamburger Menu for Mobile -->
    
    </div>
    
    <div class="navbar-user">
        <i class="fas fa-user-circle user-icon"></i>
        <span class="username">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
    </div>
    
    <ul class="navbar-menu">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('change-password') }}" class="nav-link">
                <i class="fas fa-key"></i> Mot de passe
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-user-cog"></i> Profil
            </a>
        </li>
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </li>
    </ul>
</nav>

<style>
.navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .navbar-brand .logo {
        height: 50px;
        width: auto;
        transition: transform 0.3s;
    }

    .navbar-brand:hover .logo {
        transform: rotate(-5deg) scale(1.05);
    }

    .brand-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .navbar-title {
        color: #FFD700;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .navbar-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        font-weight: 400;
    }

    .navbar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        margin-right: auto;
        margin-left: 30px;
    }

    .user-icon {
        font-size: 24px;
        color: #FFD700;
    }

    .username {
        font-weight: 500;
    }

    .navbar-menu {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 10px;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        color: #fff;
        text-decoration: none;
        font-size: 15px;
        padding: 12px 18px;
        border-radius: 6px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
    }

    .nav-link i {
        margin-right: 8px;
        font-size: 16px;
    }

    .nav-link:hover {
        background: rgba(255, 215, 0, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-logout {
        background: none;
        border: none;
        cursor: pointer;
        color: #fff;
        font-family: inherit;
        font-size: 15px;
        padding: 12px 18px;
        border-radius: 6px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .btn-logout:hover {
        background: rgba(220, 53, 69, 0.8);
        transform: translateY(-2px);
    }

    .nav-item::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        width: 0;
        height: 2px;
        background: #FFD700;
        transition: all 0.3s;
        transform: translateX(-50%);
    }

    .nav-item:hover::after {
        width: 60%;
    }

    @media (max-width: 992px) {
        .navbar {
            padding: 10px 15px;
        }
        
        .navbar-menu {
            gap: 5px;
        }
        
        .nav-link {
            padding: 10px 12px;
            font-size: 14px;
        }
    }

    @media (max-width: 768px) {
        .navbar {
            flex-wrap: wrap;
            padding: 10px;
        }
        
        .navbar-brand {
            order: 1;
            width: 100%;
            justify-content: center;
            margin-bottom: 10px;
        }
        
        .navbar-user {
            order: 2;
            margin: 0 auto 10px;
        }
        
        .navbar-menu {
            order: 3;
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-item {
            margin: 5px;
        }
    }

    @media (max-width: 480px) {
        .navbar-title {
            font-size: 18px;
        }
        
        .navbar-subtitle {
            font-size: 12px;
        }
        
        .navbar-brand .logo {
            height: 40px;
        }
        
        .nav-link {
            padding: 8px 10px;
            font-size: 13px;
        }
    }
</style>