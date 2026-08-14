@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('batiments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4>{{ $batiment->name }}</h4>
        <p class="mb-1"><strong>Ville :</strong> {{ $batiment->ville }}</p>
        <p class="mb-0"><strong>Adresse :</strong> {{ $batiment->adresse ?? 'Non spécifiée' }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Logements associés</div>
            <ul class="list-group list-group-flush">
                @forelse($batiment->logements as $l)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ ucfirst($l->categorie) }}</span>
                        <strong>{{ number_format($l->loyer_mensuel, 2, ',', ' ') }} FCFA</strong>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aucun logement enregistré.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">Dépenses liées</div>
            <ul class="list-group list-group-flush">
                @forelse($batiment->depenses as $d)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $d->motif }}</span>
                        <strong>{{ number_format($d->montant_depenses, 2, ',', ' ') }} FCFA</strong>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aucune dépense.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection