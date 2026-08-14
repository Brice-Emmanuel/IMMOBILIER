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
    .badge-assigned {
        background-color: #dbeafe;
        color: #1e40af;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 8px;
    }
    .badge-unassigned {
        background-color: #f3f4f6;
        color: #6b7280;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 8px;
    }
</style>

<div class="container-fluid py-3">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-people me-2 text-primary"></i>Gestion des Locataires</h3>
            <p class="text-muted mb-0 fs-7">Recherchez et filtrez vos locataires enregistrés</p>
        </div>
        <a href="{{ route('locataires.create') }}" class="btn btn-primary rounded-3 px-4 py-2 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Locataire
        </a>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulaire de Filtrage & Recherche -->
    <div class="card card-custom mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('locataires.index') }}" method="GET" class="row g-3">
                
                <!-- Recherche Textuelle -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">Recherche rapide</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control custom-input border-start-0 rounded-end-3" 
                               placeholder="Nom, prénom, téléphone, email..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filtre par Logement -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Logement occupé</label>
                    <select name="logement_id" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Tous les logements</option>
                        @foreach($logements as $log)
                            <option value="{{ $log->id }}" {{ request('logement_id') == $log->id ? 'selected' : '' }}>
                                Logement N° {{ $log->numero ?? $log->id }} ({{ $log->batiment->name ?? 'Bâtiment' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre par Statut d'attribution -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small">Attribution</label>
                    <select name="assignation" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Tous les locataires</option>
                        <option value="assigne" {{ request('assignation') === 'assigne' ? 'selected' : '' }}>Avec logement attribué</option>
                        <option value="non_assigne" {{ request('assignation') === 'non_assigne' ? 'selected' : '' }}>Sans logement attribué</option>
                    </select>
                </div>

                <!-- Boutons Filtrer / Effacer -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary custom-select w-100 fw-semibold">
                        <i class="bi bi-funnel me-1"></i> Filtrer
                    </button>
                    @if(request()->has('search') || request()->has('logement_id') || request()->has('assignation'))
                        <a href="{{ route('locataires.index') }}" class="btn btn-light custom-select text-danger fw-semibold" title="Réinitialiser">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tableau des Locataires -->
    <div class="card card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold">#</th>
                        <th class="py-3 text-muted fw-bold">Nom & Prénom</th>
                        <th class="py-3 text-muted fw-bold">Contact</th>
                        <th class="py-3 text-muted fw-bold">Logement</th>
                        <th class="py-3 text-muted fw-bold">Loyer</th>
                        <th class="pe-4 py-3 text-end text-muted fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locataires as $loc)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $loc->nom }} {{ $loc->prenom }}</div>
                                @if($loc->email)
                                    <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $loc->email }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-dark"><i class="bi bi-telephone me-1 text-primary"></i>{{ $loc->phone }}</span>
                                @if($loc->phone_urgence)
                                    <br><small class="text-muted">Urg: {{ $loc->phone_urgence }}</small>
                                @endif
                            </td>
                            <td>
                                @if($loc->logement)
                                    <span class="badge-assigned">
                                        <i class="bi bi-house-door me-1"></i>
                                        Logement N° {{ $loc->logement->numero ?? $loc->logement->id }} ({{ $loc->logement->batiment->name ?? 'Bâtiment' }})
                                    </span>
                                @else
                                    <span class="badge-unassigned">Non assigné</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">
                                {{ number_format($loc->loyer ?? $loc->logement?->loyer_mensuel ?? $loc->logement?->loyer ?? 0, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('locataires.show', $loc) }}" class="btn btn-sm btn-light text-primary rounded-2" title="Voir les détails"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('locataires.edit', $loc) }}" class="btn btn-sm btn-light text-warning rounded-2" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('locataires.destroy', $loc) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce locataire ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-2" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                Aucun locataire trouvé avec ces critères.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $locataires->links() }}
    </div>

</div>
@endsection