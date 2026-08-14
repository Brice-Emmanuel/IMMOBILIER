@extends('layouts.app')

@section('content')
<style>
    /* Harmonisation avec les couleurs sombres & vertes du dashboard */
    :root {
        --immo-primary: #0f172a;
        --immo-dark-accent: #1e293b;
        --immo-accent: #10b981;
    }

    .register-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--immo-primary) 0%, var(--immo-dark-accent) 60%, #0d9488 100%);
        border-radius: 24px;
        padding: 30px 15px;
        position: relative;
        overflow: hidden;
    }

    /* Carte effet verre dépoli ajustée pour la charte */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 28px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 920px;
        padding: 45px 35px;
    }

    /* Titre principal */
    .register-title {
        color: var(--immo-primary);
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 25px;
    }

    /* Champs en forme de pilules */
    .pill-input-white {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 12px 22px;
        color: #1e293b;
        font-size: 0.95rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .pill-input-white:focus {
        background-color: #ffffff;
        border-color: var(--immo-accent);
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.2);
        color: #0f172a;
    }

    .pill-input-white::placeholder {
        color: #94a3b8;
    }

    /* Boutons personnalisés */
    .btn-dark-pill {
        background-color: var(--immo-primary);
        color: #ffffff;
        border-radius: 50px;
        padding: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        border: none;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.25);
        transition: all 0.3s ease;
    }

    .btn-dark-pill:hover {
        background-color: var(--immo-dark-accent);
        color: #ffffff;
        transform: translateY(-2px);
    }

    .btn-social-pill {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 10px 20px;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s ease;
    }

    .btn-social-pill:hover {
        background-color: #f1f5f9;
        color: var(--immo-primary);
    }

    .text-dark-blue {
        color: #334155;
    }

    .divider-text {
        position: relative;
        text-align: center;
        margin: 20px 0;
    }

    .divider-text::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #cbd5e1;
        z-index: 1;
    }

    .divider-text span {
        position: relative;
        background: #ffffff;
        padding: 0 12px;
        border-radius: 10px;
        z-index: 2;
        font-size: 0.85rem;
        color: #64748b;
    }
</style>

<div class="register-wrapper">
    <div class="glass-card">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="row g-4 align-items-center">
                
                <!-- Colonne Gauche : Formulaire de Saisie -->
                <div class="col-lg-7">
                    <h2 class="register-title">Inscription</h2>

                    <!-- Nom Complet -->
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control pill-input-white @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nom complet" required>
                        @error('name')
                            <div class="invalid-feedback ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control pill-input-white @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Téléphone" required>
                        @error('phone')
                            <div class="invalid-feedback ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Adresse Email -->
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control pill-input-white @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Adresse Email" required>
                        @error('email')
                            <div class="invalid-feedback ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control pill-input-white @error('password') is-invalid @enderror" placeholder="Mot de passe" required>
                        @error('password')
                            <div class="invalid-feedback ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation Mot de passe -->
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control pill-input-white" placeholder="Confirmer le mot de passe" required>
                    </div>
                </div>

                <!-- Colonne Droite : Action & Connexion -->
                <div class="col-lg-5 ps-lg-4 text-center">
                    
                    <!-- Bouton de Soumission Principal -->
                    <div class="mb-4">
                        <button type="submit" class="btn btn-dark-pill w-100">
                            S'INSCRIRE
                        </button>
                    </div>

                    <!-- Lien vers Connexion -->
                    <p class="text-dark-blue small mb-4">
                        Déjà un compte ? 
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-underline ms-1" style="color: var(--immo-accent);">Se connecter</a>
                    </p>

                    <!-- Séparateur -->
                    <div class="divider-text">
                        <span>Ou s'inscrire avec</span>
                    </div>

                    <!-- Options Réseaux -->
                    <div class="d-flex flex-column gap-2 mt-3">
                        <a href="#" class="btn btn-social-pill">
                            <i class="bi bi-google text-danger"></i> Google
                        </a>
                        <a href="#" class="btn btn-social-pill">
                            <i class="bi bi-facebook text-primary"></i> Facebook
                        </a>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
@endsection