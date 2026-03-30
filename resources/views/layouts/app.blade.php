<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amicale Chikory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
      body {
        background-image: url('{{ asset('images/livre-savoir.png') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
      }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 1px;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff !important;
            transform: translateY(-2px);
        }
        
        .navbar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: #fff !important;
            font-weight: 600;
        }
        
        .navbar-nav .nav-link i {
            margin-right: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover i {
            transform: rotate(360deg);
        }
        
        /* Effet de soulignement animé */
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #fff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar-nav .nav-link:hover::after {
            width: 40%;
        }
        
        .navbar-nav .nav-link.active::after {
            width: 40%;
        }
        
        /* Style du bouton toggler pour mobile */
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler:hover {
            border-color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Animation du menu mobile */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 1rem;
                border-radius: 10px;
                margin-top: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }
            
            .navbar-nav .nav-link {
                text-align: center;
                margin: 0.2rem 0;
            }
            
            .navbar-nav .nav-link::after {
                bottom: 0;
            }
        }
        
        /* Animation d'entrée des liens */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .navbar-nav .nav-item {
            animation: slideIn 0.5s ease forwards;
            opacity: 0;
        }
        
        .navbar-nav .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .navbar-nav .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .navbar-nav .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .navbar-nav .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .navbar-nav .nav-item:nth-child(5) { animation-delay: 0.5s; }
        .navbar-nav .nav-item:nth-child(6) { animation-delay: 0.6s; }
        .navbar-nav .nav-item:nth-child(7) { animation-delay: 0.7s; }
        .navbar-nav .nav-item:nth-child(8) { animation-delay: 0.8s; }
        
        /* Badge de notification (optionnel) */
        .badge-notification {
            position: absolute;
            top: 0;
            right: 0;
            background: #ff4757;
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
            border-radius: 10px;
            transform: translate(25%, -25%);
        }

          /* Cartes et badges spécifiques aux loyers */
          .loyer-card {
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 0;
          }

          .loyer-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
          }

          .loyer-card-header h1,
          .loyer-card-header h5,
          .loyer-card-header p {
            color: #ffffff;
          }

          .loyer-badge-paye {
            background: linear-gradient(135deg, #38c172 0%, #51d88a 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(56, 193, 114, 0.4);
          }

          .loyer-badge-non-paye {
            background: rgba(255, 193, 7, 0.15);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.6);
          }

          .loyer-btn-light {
            background: #ffffff;
            color: #4a4a4a;
            border-radius: 50px;
            border: none;
            padding-inline: 1.25rem;
          }

          .loyer-btn-light:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #333333;
          }

          .loyer-empty {
            border-radius: 12px;
            background: rgba(102, 126, 234, 0.05);
            border: 1px dashed rgba(102, 126, 234, 0.4);
          }
    </style>
</head>
<body>

@auth
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <!-- Logo avec image -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/livre-savoir.jpeg') }}" alt="Logo Amicale Chikory" class="me-2" style="height:32px; width:auto;">
        Amicale Chikory
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('etudiants.*') ? 'active' : '' }}" href="{{ route('etudiants.index') }}">
            <i class="fas fa-users"></i>
            Étudiants
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('cotisations.*') ? 'active' : '' }}" href="{{ route('cotisations.index') }}">
            <i class="fas fa-coins"></i>
            Cotisations
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('depenses.*') ? 'active' : '' }}" href="{{ route('depenses.index') }}">
            <i class="fas fa-receipt"></i>
            Dépenses
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('evenements.*') ? 'active' : '' }}" href="{{ route('evenements.index') }}">
            <i class="fas fa-calendar-alt"></i>
            Événements
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('loyers.*') ? 'active' : '' }}" href="{{ route('loyers.index') }}">
            <i class="fas fa-house-user"></i>
            Loyers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('subventions.*') ? 'active' : '' }}" href="{{ route('subventions.index') }}">
            <i class="fas fa-hand-holding-heart"></i>
            Subventions
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('amicales.*') ? 'active' : '' }}" href="{{ route('amicales.index') }}">
            <i class="fas fa-building"></i>
            Maisons
          </a>
        </li>
        @auth
        <li class="nav-item ms-2">
          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="nav-link btn btn-link p-0" style="color: rgba(255,255,255,0.9);">
              <i class="fas fa-sign-out-alt"></i>
              Déconnexion
            </button>
          </form>
        </li>
        @endauth
      </ul>
      
      <!-- Barre de recherche optionnelle -->
      <!-- <form class="d-flex ms-3" role="search">
        <div class="input-group">
          <input class="form-control form-control-sm bg-light bg-opacity-25 border-0 text-white" 
                 type="search" 
                 placeholder="Rechercher..." 
                 aria-label="Search"
                 style="background: rgba(255,255,255,0.2) !important;">
          <button class="btn btn-sm btn-outline-light" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </form> -->
    </div>
  </div>
</nav>
@endauth

<main class="py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    // Activation de l'état actif au scroll (optionnel)
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');
        
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - sectionHeight / 3) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active');
                }
            });
        });
    });
</script>
</body>
</html>