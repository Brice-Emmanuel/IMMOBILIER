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
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-radius: 16px;
        border: 1px solid #86efac;
    }
    .badge-conso {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 6px;
    }
</style>

<div class="container-fluid py-3">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-cash-stack me-2 text-success"></i>Gestion des Paiements</h3>
            <p class="text-muted mb-0 fs-7">Historique des reçus de loyers et encaissements</p>
        </div>
        <a href="{{ route('paiements.create') }}" class="btn btn-success rounded-3 px-4 py-2 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Paiement
        </a>
    </div>

    <!-- Carte de Récapitulatif / Total -->
    <div class="card kpi-card mb-4 p-3 border-0 shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success text-white p-3 rounded-3">
                    <i class="bi bi-currency-exchange fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold">Total Encaissement (Sélection)</span>
                    <h3 class="fw-bold text-success mb-0">+ {{ number_format($totalPaiements, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
            <span class="badge bg-white text-success border border-success rounded-pill px-3 py-2 fw-semibold">
                {{ $paiements->total() }} Règlement(s)
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
            <form action="{{ route('paiements.index') }}" method="GET" class="row g-3">
                
                <!-- Filtre par Locataire -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Locataire</label>
                    <select name="locataire_id" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Tous les locataires</option>
                        @foreach($locataires as $loc)
                            <option value="{{ $loc->id }}" {{ request('locataire_id') == $loc->id ? 'selected' : '' }}>
                                {{ $loc->nom }} {{ $loc->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Recherche par Note/Motif -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Motif / Observation</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control custom-input border-start-0 rounded-end-3" 
                               placeholder="Ex: Loyer Août, Avance..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Date Début -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Payé du</label>
                    <input type="date" name="date_debut" class="form-control custom-input" value="{{ request('date_debut') }}">
                </div>

                <!-- Date Fin -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted small">Au</label>
                    <input type="date" name="date_fin" class="form-control custom-input" value="{{ request('date_fin') }}">
                </div>

                <!-- Boutons Filtrer / Effacer -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-success custom-select w-100 fw-semibold">
                        <i class="bi bi-funnel me-1"></i> Filtrer
                    </button>
                    @if(request()->has('locataire_id') || request()->has('search') || request()->has('date_debut') || request()->has('date_fin'))
                        <a href="{{ route('paiements.index') }}" class="btn btn-light custom-select text-danger fw-semibold" title="Réinitialiser">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tableau des Paiements -->
    <div class="card card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold">#</th>
                        <th class="py-3 text-muted fw-bold">Locataire</th>
                        <th class="py-3 text-muted fw-bold">Montant</th>
                        <th class="py-3 text-muted fw-bold">Date Règlement</th>
                        <th class="py-3 text-muted fw-bold">Période Couverte</th>
                        <th class="pe-4 py-3 text-end text-muted fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paiements as $p)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $p->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->locataire->nom ?? 'Inconnu' }} {{ $p->locataire->prenom ?? '' }}</div>
                                @if(isset($p->locataire->phone))
                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $p->locataire->phone }}</small>
                                @endif
                            </td>
                            <td class="fw-bold text-success">
                                + {{ number_format($p->montant_paiement, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                            </td>
                            <td class="text-dark fw-semibold">
                                <i class="bi bi-calendar-check me-1 text-primary"></i>
                                {{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="badge-conso">
                                    <i class="bi bi-clock-history me-1"></i>
                                    {{ \Carbon\Carbon::parse($p->date_debut_conso)->format('d/m/Y') }} 
                                    <i class="bi bi-arrow-right mx-1"></i> 
                                    {{ \Carbon\Carbon::parse($p->date_fin_conso)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('paiements.show', $p) }}" class="btn btn-sm btn-light text-primary rounded-2" title="Voir les détails"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('paiements.edit', $p) }}" class="btn btn-sm btn-light text-warning rounded-2" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('paiements.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-2" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-cash-coin fs-1 d-block mb-2 text-secondary"></i>
                                Aucun paiement trouvé avec ces critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $paiements->links() }}
    </div>

</div>
@endsection