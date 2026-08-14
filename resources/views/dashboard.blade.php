@extends('layouts.app')

@section('content')

<!-- Bandeau Supérieur de Bienvenue (Inspiré du Hero de l'image) -->
<div class="hero-banner p-4 p-md-5 mb-4 shadow-sm">
    <div class="row align-items-center">
        <div class="col-md-7">
            <span class="badge badge-status mb-2">Gestion Immobilière</span>
            <h1 class="fw-bold text-white mb-3">Tableau de Bord Général</h1>
            <p class="text-white-50 mb-4">
                Suivez en temps réel l'occupation de vos logements, vos paiements reçus et vos dépenses sur l'ensemble de vos bâtiments.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('paiements.create') }}" class="btn btn-accent px-4 py-2">
                    <i class="bi bi-plus-circle me-1"></i> Nouveau Paiement
                </a>
                <a href="{{ route('logements.index') }}" class="btn btn-outline-light px-4 py-2">
                    <i class="bi bi-house me-1"></i> Voir les Logements
                </a>
            </div>
        </div>
        <div class="col-md-5 mt-4 mt-md-0">
            <div class="hero-card">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-wallet2 fs-2 text-warning me-3"></i>
                    <div>
                        <small class="text-white-50 d-block text-uppercase">Solde Net Actuel</small>
                        <h3 class="fw-bold mb-0 text-white">{{ number_format($soldeNet ?? 0, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Recherche / Filtre (Barre sombre comme sur l'image) -->
<div class="p-3 mb-4 text-white rounded shadow-sm" style="background-color: var(--immo-dark-accent);">
    <div class="row align-items-center g-3">
        <div class="col-md-3">
            <h6 class="m-0 text-uppercase fw-bold text-white-50 fs-7">Résumé des Bâtiments</h6>
            <span class="fs-5 fw-bold">{{ $totalBatiments }} Bâtiment(s)</span>
        </div>
        <div class="col-md-3">
            <h6 class="m-0 text-uppercase fw-bold text-white-50 fs-7">Logements Disponibles</h6>
            <span class="fs-5 fw-bold text-success">{{ $logementsDisponibles }} / {{ $totalLogements }}</span>
        </div>
        <div class="col-md-3">
            <h6 class="m-0 text-uppercase fw-bold text-white-50 fs-7">Logements Occupés</h6>
            <span class="fs-5 fw-bold text-warning">{{ $logementsOccupes }} / {{ $totalLogements }}</span>
        </div>
        <div class="col-md-3">
            <h6 class="m-0 text-uppercase fw-bold text-white-50 fs-7">Total Locataires</h6>
            <span class="fs-5 fw-bold">{{ $totalLocataires }} Active(s)</span>
        </div>
    </div>
</div>

<!-- Cartes Bilan Financier -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="property-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-uppercase text-muted fw-bold">Total Revenus Encaissés</small>
                    <h2 class="price-tag text-success mt-1 mb-0">+{{ number_format($totalRevenus, 0, ',', ' ') }} FCFA</h2>
                </div>
                <div class="rounded-circle p-3" style="background-color: #e8f5e9;">
                    <i class="bi bi-arrow-down-left-circle fs-2 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="property-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-uppercase text-muted fw-bold">Total Dépenses Effectuées</small>
                    <h2 class="price-tag text-danger mt-1 mb-0">-{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</h2>
                </div>
                <div class="rounded-circle p-3" style="background-color: #ffebee;">
                    <i class="bi bi-arrow-up-right-circle fs-2 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activités Récentes sous forme de cartes d'affichage -->
<div class="row g-4">
    <!-- Derniers Paiements -->
    <div class="col-md-6">
        <div class="property-card">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background-color: #f8fafc;">
                <h6 class="fw-bold m-0 text-uppercase" style="color: var(--immo-dark);">
                    <i class="bi bi-receipt me-2 text-success"></i>Derniers Paiements
                </h6>
                <a href="{{ route('paiements.index') }}" class="btn btn-sm btn-link text-decoration-none p-0 fw-bold">Tout voir</a>
            </div>
            <div class="p-3">
                <ul class="list-group list-group-flush">
                    @forelse($derniersPaiements as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                            <div>
                                <strong class="d-block text-dark">{{ $p->locataire->nom ?? 'N/A' }} {{ $p->locataire->prenom ?? '' }}</strong>
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}</small>
                            </div>
                            <span class="badge bg-success fs-6">+{{ number_format($p->montant_paiement, 0, ',', ' ') }} FCFA</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-3 border-0">Aucun paiement enregistré.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Dernières Dépenses -->
    <div class="col-md-6">
        <div class="property-card">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background-color: #f8fafc;">
                <h6 class="fw-bold m-0 text-uppercase" style="color: var(--immo-dark);">
                    <i class="bi bi-tools me-2 text-danger"></i>Dernières Dépenses
                </h6>
                <a href="{{ route('depenses.index') }}" class="btn btn-sm btn-link text-decoration-none p-0 fw-bold">Tout voir</a>
            </div>
            <div class="p-3">
                <ul class="list-group list-group-flush">
                    @forelse($dernieresDepenses as $d)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                            <div>
                                <strong class="d-block text-dark">{{ $d->batiment->name ?? 'N/A' }}</strong>
                                <small class="text-muted">{{ $d->motif }}</small>
                            </div>
                            <span class="badge bg-danger fs-6">-{{ number_format($d->montant_depenses, 0, ',', ' ') }} FCFA</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-3 border-0">Aucune dépense enregistrée.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection