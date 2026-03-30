@extends('layouts.app')

@section('content')
<div class="hero-section" style="background-image: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)), url('{{ asset('images/livre-savoir.jpg') }}'); background-size: cover; background-position: center; min-height: 100vh; padding: 60px 0;">
    <div class="container">
        <!-- Titre avec animation -->
        <div class="text-center mb-5 animate__animated animate__fadeInDown">
            <h1 class="display-3 fw-bold text-primary mb-3">Bienvenue sur l'Amicale Chikory De l'UADB</h1>
            <p class="lead text-secondary">Ensemble, construisons une communauté étudiante dynamique et solidaire</p>
            <div class="divider mx-auto"></div>
        </div>

        <!-- Statistiques en cartes colorées -->
        <div class="row g-4 mb-5">
            <div class="col-md-2 col-6">
                <div class="stats-card card border-0 shadow-lg text-center p-4 gradient-card text-white">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-2">{{ $nbEtudiants }}</h3>
                    <p class="mb-0">Étudiants</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stats-card card border-0 shadow-lg text-center p-4 gradient-card text-white">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-coins fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalRecettes, 0, ',', ' ') }} FCFA</h3>
                    <p class="mb-0">Recettes totales</p>
                    <p class="mb-0 small">Cotisations, loyers, subventions</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stats-card card border-0 shadow-lg text-center p-4 gradient-card text-white">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-chart-line fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-2">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</h3>
                    <p class="mb-0">Dépenses</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stats-card card border-0 shadow-lg text-center p-4 gradient-card text-white">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-wallet fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-2">{{ number_format($resteCaisse, 0, ',', ' ') }} FCFA</h3>
                    <p class="mb-0">Reste en caisse</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="stats-card card border-0 shadow-lg text-center p-4 gradient-card text-white">
                    <div class="stats-icon mb-3">
                        <i class="fas fa-calendar-alt fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-2">{{ $nbEvenements }}</h3>
                    <p class="mb-0">Événements</p>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <a href="{{ route('loyers.retards') }}" class="text-decoration-none">
                    <div class="stats-card card border-0 shadow-lg text-center p-4 gradient-card text-white">
                        <div class="stats-icon mb-3">
                            <i class="fas fa-house-user fa-3x"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $nbEtudiantsEnRetardLoyer }}</h3>
                        <p class="mb-0 small">Étudiants en retard de loyer</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Prochains événements avec design amélioré -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-lg p-4 bg-white">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-calendar-check fa-2x text-primary me-3"></i>
                        <h3 class="text-dark mb-0">Prochains événements</h3>
                    </div>
                    
                    @if($prochainsEvenements->count() > 0)
                        <div class="row g-4">
                            @foreach($prochainsEvenements as $evenement)
                            <div class="col-md-4">
                                <div class="event-card card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="event-date text-center me-3 bg-light rounded p-2">
                                                <span class="day d-block fw-bold text-primary">{{ \Carbon\Carbon::parse($evenement->date)->format('d') }}</span>
                                                <span class="month text-muted">{{ \Carbon\Carbon::parse($evenement->date)->format('M') }}</span>
                                            </div>
                                            <div>
                                                <h5 class="text-dark mb-1">{{ $evenement->titre }}</h5>
                                                <p class="text-muted small mb-0">
                                                    <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $evenement->lieu }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-muted small mb-3">
                                            <i class="fas fa-clock me-1 text-warning"></i> {{ \Carbon\Carbon::parse($evenement->date)->format('H:i') }}
                                        </p>
                                        <a href="{{ route('evenements.show', $evenement->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Aucun événement à venir pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-lg p-4 bg-white">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-bolt fa-2x text-warning me-3"></i>
                        <h3 class="text-dark mb-0">Actions rapides</h3>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('etudiants.create') }}" class="quick-action-card text-decoration-none">
                                <div class="card border-0 bg-light text-center p-3">
                                    <i class="fas fa-user-plus fa-2x text-primary mb-2"></i>
                                    <p class="text-dark mb-0 fw-bold">Nouvel étudiant</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('cotisations.create') }}" class="quick-action-card text-decoration-none">
                                <div class="card border-0 bg-light text-center p-3">
                                    <i class="fas fa-hand-holding-usd fa-2x text-success mb-2"></i>
                                    <p class="text-dark mb-0 fw-bold">Nouvelle cotisation</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('depenses.create') }}" class="quick-action-card text-decoration-none">
                                <div class="card border-0 bg-light text-center p-3">
                                    <i class="fas fa-receipt fa-2x text-danger mb-2"></i>
                                    <p class="text-dark mb-0 fw-bold">Nouvelle dépense</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('evenements.create') }}" class="quick-action-card text-decoration-none">
                                <div class="card border-0 bg-light text-center p-3">
                                    <i class="fas fa-plus-circle fa-2x text-info mb-2"></i>
                                    <p class="text-dark mb-0 fw-bold">Nouvel événement</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés -->
<style>
    /* Animation */
    .animate__animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }
    
    .animate__fadeInDown {
        animation-name: fadeInDown;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -30px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    /* Divider */
    .divider {
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0d6efd, transparent);
        margin-top: 20px;
    }

    /* Stats cards */
    .stats-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2) !important;
    }

    .stats-icon {
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1);
    }

    /* Couleur des cartes stats alignée sur le navbar */
    .gradient-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }

    /* Event cards */
    .event-card {
        transition: all 0.3s ease;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .event-date {
        min-width: 60px;
    }

    .event-date .day {
        font-size: 24px;
        line-height: 1;
    }

    .event-date .month {
        font-size: 14px;
        text-transform: uppercase;
    }

    /* Quick action cards */
    .quick-action-card {
        display: block;
        transition: all 0.3s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
    }

    .quick-action-card:hover .card {
        background: #e9ecef !important;
        border-color: #0d6efd !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-section {
            padding: 30px 0;
        }
        
        .display-3 {
            font-size: 2rem;
        }
        
        .stats-card {
            padding: 1rem !important;
        }
        
        .stats-icon i {
            font-size: 2rem;
        }
    }
</style>
@endsection