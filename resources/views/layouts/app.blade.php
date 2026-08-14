<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Immobilière</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --immo-dark: #19323c;
            --immo-dark-accent: #112229;
            --immo-accent: #c4d600;
            --immo-bg: #eaf0f2;
        }

        body {
            background-color: var(--immo-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2b2b2b;
        }

        /* Navbar Style */
        .navbar-custom {
            background-color: var(--immo-dark-accent);
            padding: 12px 0;
        }
        .navbar-custom .nav-link {
            color: #ffffff;
            font-weight: 500;
            font-size: 0.95rem;
            margin-right: 15px;
        }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active {
            color: var(--immo-accent);
        }
        .btn-accent {
            background-color: var(--immo-accent);
            color: #112229;
            font-weight: 700;
            border: none;
        }
        .btn-accent:hover {
            background-color: #b0c200;
            color: #112229;
        }

        /* En-tête / Slogan Box */
        .hero-banner {
            background-color: var(--immo-dark);
            color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .hero-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 4px solid var(--immo-accent);
            padding: 20px;
            border-radius: 4px;
        }

        /* Cartes d'affichage des biens / stats */
        .property-card {
            background: #ffffff;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            transition: transform 0.2s, shadow 0.2s;
        }
        .property-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .price-tag {
            color: #19323c;
            font-size: 1.25rem;
            font-weight: 800;
        }
        .badge-status {
            background-color: var(--immo-accent);
            color: #112229;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    @auth
    <!-- Barre de Navigation Sombre -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase d-flex align-items-center" href="{{ route('dashboard') }}">
                <span class="btn-accent px-2 py-1 rounded me-2 fs-6">IMMO</span> APP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('batiments.index') }}">Bâtiments</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logements.index') }}">Logements</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('locataires.index') }}">Locataires</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('depenses.index') }}">Dépenses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('paiements.index') }}">Paiements</a></li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm fw-bold">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>