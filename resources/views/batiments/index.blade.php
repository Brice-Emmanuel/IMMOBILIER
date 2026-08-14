@extends('layouts.app')

@section('content')
<style>
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .custom-input, .custom-select {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
    }
    .kpi-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 16px;
        border: 1px solid #93c5fd;
    }
    .badge-logements {
        background-color: #e0e7ff;
        color: #3730a3;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 8px;
    }
</style>

<div class="container-fluid py-3">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-building me-2 text-primary"></i>Gestion des Bâtiments</h3>
            <p class="text-muted mb-0 fs-7">Gérez vos immeubles, résidences et complexes immobiliers</p>
        </div>
        <a href="{{ route('batiments.create') }}" class="btn btn-primary rounded-3 px-4 py-2 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Bâtiment
        </a>
    </div>

    <!-- Carte de Récapitulatif -->
    <div class="card kpi-card mb-4 p-3 border-0 shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white p-3 rounded-3">
                    <i class="bi bi-houses-fill fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold">Total de vos bâtiments</span>
                    <h3 class="fw-bold text-primary mb-0">{{ $batiments->total() }} Immeuble(s)</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulaire de Filtrage -->
    <div class="card card-custom mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('batiments.index') }}" method="GET" class="row g-3">
                
                <!-- Recherche Textuelle -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Recherche rapide</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control custom-input border-start-0 rounded-end-3" 
                               placeholder="Nom du bâtiment, adresse..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filtre par Ville -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Ville</label>
                    <select name="ville" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Toutes les villes</option>
                        @foreach($villes as $v)
                            <option value="{{ $v }}" {{ request('ville') === $v ? 'selected' : '' }}>
                                {{ $v }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Boutons Filtrer / Effacer -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary custom-select w-100 fw-semibold">
                        <i class="bi bi-funnel me-1"></i> Filtrer
                    </button>
                    @if(request()->has('search') || request()->has('ville'))
                        <a href="{{ route('batiments.index') }}" class="btn btn-light custom-select text-danger fw-semibold" title="Réinitialiser">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tableau des Bâtiments -->
    <div class="card card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold">#</th>
                        <th class="py-3 text-muted fw-bold">Nom du Bâtiment</th>
                        <th class="py-3 text-muted fw-bold">Ville</th>
                        <th class="py-3 text-muted fw-bold">Adresse</th>
                        <th class="py-3 text-muted fw-bold">Capacité</th>
                        <th class="pe-4 py-3 text-end text-muted fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batiments as $b)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $b->id }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $b->name }}</div>
                                @if($b->description)
                                    <small class="text-muted">{{ Str::limit($b->description, 40) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    <i class="bi bi-geo-alt me-1 text-danger"></i>{{ $b->ville ?? 'Non renseignée' }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $b->adresse ?? '-' }}</td>
                            <td>
                                <span class="badge-logements">
                                    <i class="bi bi-door-closed me-1"></i>{{ $b->logements_count ?? 0 }} Logement(s)
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('batiments.show', $b) }}" class="btn btn-sm btn-light text-primary rounded-2" title="Voir les détails"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('batiments.edit', $b) }}" class="btn btn-sm btn-light text-warning rounded-2" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('batiments.destroy', $b) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-2" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-building-exclamation fs-1 d-block mb-2 text-secondary"></i>
                                Aucun bâtiment trouvé avec ces critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $batiments->links() }}
    </div>

</div>
@endsection