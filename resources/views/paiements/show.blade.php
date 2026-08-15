@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Détail du Paiement N° #{{ $paiement->id }}</h2>
    <div class="space-y-3 text-sm">
        <p><strong>Locataire :</strong> {{ $paiement->locataire->nom ?? '' }} {{ $paiement->locataire->prenom ?? '' }}</p>
        <p><strong>Montant :</strong> {{ number_format($paiement->montant_paiement, 0, ',', ' ') }} FCFA</p>
        <p><strong>Date de paiement :</strong> {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</p>
        <p><strong>Période :</strong> Du {{ \Carbon\Carbon::parse($paiement->date_debut_conso)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($paiement->date_fin_conso)->format('d/m/Y') }}</p>
    </div>
    <div class="mt-6 flex gap-2">
        <a href="{{ route('paiements.showRecu', $paiement->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded">Voir le Reçu</a>
        <a href="{{ route('paiements.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection