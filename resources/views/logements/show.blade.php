@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('logements.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <span>Logement #{{ $logement->id }}</span>
        <span class="badge {{ $logement->statut ? 'bg-success' : 'bg-danger' }}">
            {{ $logement->statut ? 'Disponible' : 'Occupé' }}
        </span>
    </div>
    <div class="card-body">
        <h5>{{ ucfirst($logement->categorie) }}</h5>
        <p><strong>Bâtiment :</strong> {{ $logement->batiment->name ?? 'N/A' }}</p>
        <p><strong>Loyer mensuel :</strong> {{ number_format($logement->loyer_mensuel, 2, ',', ' ') }} FCFA</p>
        <p><strong>Description :</strong> {{ $logement->description ?? 'Aucune description' }}</p>
    </div>
</div>
@endsection