@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('locataires.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h4>{{ $locataire->nom }} {{ $locataire->prenom }}</h4>
        <p><strong>Téléphone :</strong> {{ $locataire->phone }} | <strong>Urgence :</strong> {{ $locataire->phone_urgence }}</p>
        <p><strong>Email :</strong> {{ $locataire->email ?? 'N/A' }}</p>
        <p><strong>Loyer mensuel :</strong> {{ number_format($locataire->loyer, 2, ',', ' ') }} FCFA</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">Historique des Paiements</div>
    <ul class="list-group list-group-flush">
        @forelse($locataire->paiements as $p)
            <li class="list-group-item d-flex justify-content-between">
                <span>Paiement du {{ $p->date_paiement }} (Conso: {{ $p->date_debut_conso }} au {{ $p->date_fin_conso }})</span>
                <strong class="text-success">{{ number_format($p->montant_paiement, 2, ',', ' ') }} FCFA</strong>
            </li>
        @empty
            <li class="list-group-item text-muted">Aucun paiement répertorié.</li>
        @endforelse
    </ul>
</div>
@endsection