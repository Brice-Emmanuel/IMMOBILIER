@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('paiements.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">Reçu de Paiement #{{ $paiement->id }}</div>
    <div class="card-body">
        <h5>Locataire : {{ $paiement->locataire->nom ?? 'N/A' }} {{ $paiement->locataire->prenom ?? '' }}</h5>
        <p><strong>Montant payé :</strong> {{ number_format($paiement->montant_paiement, 2, ',', ' ') }} FCFA</p>
        <p><strong>Date d'effet :</strong> {{ $paiement->date_paiement }}</p>
        <p><strong>Période couverte :</strong> du {{ $paiement->date_debut_conso }} au {{ $paiement->date_fin_conso }}</p>
    </div>
</div>
@endsection