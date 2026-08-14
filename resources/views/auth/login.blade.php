@extends('layouts.app')

@section('content')
<style>
    /* Intégration avec la charte du Dashboard Immobilière */
    :root {
        --immo-primary: #0f172a;
        --immo-dark-accent: #1e293b;
        --immo-accent: #10b981;
        --immo-accent-hover: #059669;
        --immo-pill-bg: #f1f5f9;
        --immo-pill-focus: #e2e8f0;
    }

    .auth-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 900px;
        border: none;
    }

    .auth-side-panel {
        background: linear-gradient(135deg, var(--immo-primary) 0%, var(--immo-dark-accent) 100%);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        text-align: center;
        position: relative;
        border-top-right-radius: 120px;
        border-bottom-right-radius: 120px;
    }

    .auth-logo-circle {
        width: 70px;
        height: 70px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .auth-logo-circle i {
        font-size: 32px;
        color: var(--immo-primary);
    }

    .pill-input {
        background-color: var(--immo-pill-bg);
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 12px 24px;
        color: #334155;
        font-weight: 500;
    }

    .pill-input:focus {
        background-color: #ffffff;
        border-color: var(--immo-accent);
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.2);
        color: #0f172a;
    }

    .pill-input::placeholder {
        color: #94a3b8;
    }

    .btn-green-pill {
        background-color: var(--immo-accent);
        color: #ffffff;
        border-radius: 50px;
        padding: 10px 40px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-green-pill:hover {
        background-color: var(--immo-accent-hover);
        color: #ffffff;
    }

    .btn-outline-pill {
        border: 1.5px solid rgba(255, 255, 255, 0.8);
        color: #ffffff;
        border-radius: 50px;
        padding: 8px 36px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-outline-pill:hover {
        background-color: #ffffff;
        color: var(--immo-primary);
    }

    .text-green-dark {
        color: var(--immo-primary);
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="row g-0">
            <!-- Panneau Gauche : Bienvenue / Inscription -->
            <div class="col-md-5 auth-side-panel d-none d-md-flex">
                <div class="auth-logo-circle">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <h2 class="fw-bold mb-3">Bienvenue !</h2>
                <p class="text-white-50 mb-4 fs-6">
                    Pour accéder à la gestion de vos bâtiments et logements, veuillez vous connecter.
                </p>
                <a href="{{ route('register') }}" class="btn-outline-pill">S'INSCRIRE</a>
            </div>

            <!-- Panneau Droit : Formulaire de Connexion -->
            <div class="col-md-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                <div class="text-center text-md-start mb-4">
                    <h2 class="fw-bold text-green-dark m-0">Connexion</h2>
                    <small class="text-muted">Connectez-vous à votre espace gestionnaire</small>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control pill-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Adresse Email..." required>
                        @error('email')
                            <div class="invalid-feedback ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <input type="password" name="password" class="form-control pill-input @error('password') is-invalid @enderror" placeholder="Mot de passe..." required>
                        @error('password')
                            <div class="invalid-feedback ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label text-muted small" for="remember">Se souvenir de moi</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none">Mot de passe oublié ?</a>
                        @endif
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-green-pill w-50">SE CONNECTER</button>
                    </div>

                    <div class="text-center d-md-none mt-3">
                        <span class="text-muted small">Pas encore de compte ?</span>
                        <a href="{{ route('register') }}" class="text-success fw-bold small text-decoration-none ms-1">S'inscrire</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection