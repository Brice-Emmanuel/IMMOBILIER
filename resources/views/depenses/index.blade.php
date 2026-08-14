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
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border-radius: 16px;
        border: 1px solid #fca5a5;
    }
</style>

<div class="container-fluid py-3">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-wallet2 me-2 text-danger"></i>Gestion des Dépenses</h3>
            <p class="text-muted mb-0 fs-7">Suivez et filtrez toutes les dépenses liées à vos bâtiments</p>
        </div>
        <a href="{{ route('depenses.create') }}" class="btn btn-danger rounded-3 px-4 py-2 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Nouvelle Dépense
        </a>
    </div>

    <!-- Carte de Récapitulatif / Total -->
    <div class="card kpi-card mb-4 p-3 border-0 shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-danger text-white p-3 rounded-3">
                    <i class="bi bi-calculator fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold">Total des dépenses (Sélection)</span>
                    <h3 class="fw-bold text-danger mb-0">{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
            <span class="badge bg-white text-danger border border-danger rounded-pill px-3 py-2 fw-semibold">
                {{ $depenses->total() }} Dépense(s)
            </span>
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
            <form action="{{ route('depenses.index') }}" method="GET" class="row g-3">
                
                <!-- Recherche par Motif -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Motif / Libellé</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control custom-input border-start-0 rounded-end-3" 
                               placeholder="Ex: Travaux, Electricité..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filtre par Bâtiment -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Bâtiment</label>
                    <select name="batiment_id" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Tous les bâtiments</option>
                        @foreach($batiments as $b)
                            <option value="{{ $b->id }}" {{ request('batiment_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Début -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Du</label>
                    <input type="date" name="date_debut" class="form-control custom-input" value="{{ request('date_debut') }}">
                </div>

                <!-- Date Fin -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Au</label>
                    <input type="date" name="date_fin" class="form-control custom-input" value="{{ request('date_fin') }}">
                </div>

                <!-- Boutons Filtrer / Effacer -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-danger custom-select w-100 fw-semibold">
                        <i class="bi bi-funnel me-1"></i> Filtrer
                    </button>
                    @if(request()->has('search') || request()->has('batiment_id') || request()->has('date_debut') || request()->has('date_fin'))
                        <a href="{{ route('depenses.index') }}" class="btn btn-light custom-select text-danger fw-semibold" title="Réinitialiser">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tableau des Dépenses -->
    <div class="card card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold">#</th>
                        <th class="py-3 text-muted fw-bold">Date</th>
                        <th class="py-3 text-muted fw-bold">Bâtiment</th>
                        <th class="py-3 text-muted fw-bold">Motif</th>
                        <th class="py-3 text-muted fw-bold">Montant</th>
                        <th class="pe-4 py-3 text-end text-muted fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($depenses as $d)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $d->id }}</td>
                            <td class="text-muted small">
                                <i class="bi bi-calendar-event me-1"></i>{{ $d->created_at->format('d/m/Y') }}
                            </td>
                            <td class="fw-bold text-dark">{{ $d->batiment->name ?? 'N/A' }}</td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $d->motif }}</span>
                            </td>
                            <td class="fw-bold text-danger">
                                - {{ number_format($d->montant_depenses, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('depenses.show', $d) }}" class="btn btn-sm btn-light text-primary rounded-2" title="Voir les détails"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('depenses.edit', $d) }}" class="btn btn-sm btn-light text-warning rounded-2" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('depenses.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-2" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-receipt-cutoff fs-1 d-block mb-2 text-secondary"></i>
                                Aucune dépense trouvée avec ces critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $depenses->links() }}
    </div>

</div>
@endsection