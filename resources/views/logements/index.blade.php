@extends('layouts.app')

@section('content')
<style>
    .card-custom { border: none; border-radius: 16px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .custom-select { border-radius: 10px; padding: 10px 14px; border: 1px solid #cbd5e1; background-color: #f8fafc; }
    .badge-available { background-color: #dcfce7; color: #15803d; font-weight: 600; padding: 6px 12px; border-radius: 20px; }
    .badge-occupied { background-color: #fee2e2; color: #b91c1c; font-weight: 600; padding: 6px 12px; border-radius: 20px; }
    .badge-category { background-color: #e0f2fe; color: #0369a1; font-weight: 600; padding: 5px 10px; border-radius: 8px; }
</style>

<div class="container-fluid py-3">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-house-door me-2 text-primary"></i>Gestion des Logements</h3>
            <p class="text-muted mb-0 fs-7">Consultez et filtrez tous vos biens immobiliers</p>
        </div>
        <a href="{{ route('logements.create') }}" class="btn btn-primary rounded-3 px-4 py-2 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Logement
        </a>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulaire de Filtres (Uniquement Catégorie et Statut) -->
    <div class="card card-custom mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('logements.index') }}" method="GET" class="row g-3">
                
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted small">Catégorie</label>
                    <select name="categorie" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        <option value="maison" {{ request('categorie') == 'maison' ? 'selected' : '' }}>Maison</option>
                        <option value="appartement" {{ request('categorie') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                        <option value="studio" {{ request('categorie') == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="boutique" {{ request('categorie') == 'boutique' ? 'selected' : '' }}>Boutique</option>
                        <option value="bureau" {{ request('categorie') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted small">Statut / Disponibilité</label>
                    <select name="statut" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Occupé</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    @if(request()->has('categorie') || request()->has('statut'))
                        <a href="{{ route('logements.index') }}" class="btn btn-light custom-select w-100 text-center text-danger fw-semibold">
                            <i class="bi bi-x-circle me-1"></i> Effacer
                        </a>
                    @else
                        <button type="submit" class="btn btn-outline-primary custom-select w-100 fw-semibold">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tableau des Logements -->
    <div class="card card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold">#</th>
                        <th class="py-3 text-muted fw-bold">Logement</th>
                        <th class="py-3 text-muted fw-bold">Bâtiment</th>
                        <th class="py-3 text-muted fw-bold">Catégorie</th>
                        <th class="py-3 text-muted fw-bold">Loyer Mensuel</th>
                        <th class="py-3 text-muted fw-bold">Statut</th>
                        <th class="pe-4 py-3 text-end text-muted fw-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logements as $l)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                            
                            <!-- Colonne Logement : Affiche la désignation/numéro du logement -->
                            <td>
                                <span class="fw-bold text-dark">
                                    {{ $l->numero ?? 'Logement #' . $l->id }}
                                </span>
                            </td>

                            <!-- Colonne Bâtiment : Nom du bâtiment rattaché -->
                            <td>
                                <span class="text-muted fw-semibold">
                                    <i class="bi bi-building me-1"></i>{{ $l->batiment?->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-category">
                                    {{ ucfirst($l->categorie) }}
                                </span>
                            </td>

                            <td class="fw-bold text-dark">
                                {{ number_format($l->loyer_mensuel, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                            </td>

                            <td>
                                @if($l->statut)
                                    <span class="badge-available"><i class="bi bi-check-circle me-1"></i>Disponible</span>
                                @else
                                    <span class="badge-occupied"><i class="bi bi-person-fill me-1"></i>Occupé</span>
                                @endif
                            </td>

                            <td class="pe-4 text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('logements.show', $l) }}" class="btn btn-sm btn-light text-primary rounded-2" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('logements.edit', $l) }}" class="btn btn-sm btn-light text-warning rounded-2" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('logements.destroy', $l) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-2" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-house-x fs-1 d-block mb-2 text-secondary"></i>
                                Aucun logement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $logements->links() }}
    </div>

</div>
@endsection