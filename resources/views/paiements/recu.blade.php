@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow border">
    <div class="text-center border-b pb-4 mb-4">
        <h2 class="text-2xl font-bold uppercase tracking-wide">Reçu de Paiement</h2>
        <p class="text-sm text-gray-500">N° REÇU-{{ $paiement->id }}</p>
    </div>

    <div class="space-y-3 text-sm mb-6">
        <div class="flex justify-between">
            <span class="text-gray-600">Bailleur / Émetteur :</span>
            <span class="font-bold">{{ $paiement->user->name ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Locataire :</span>
            <span class="font-bold">{{ $paiement->locataire->nom }} {{ $paiement->locataire->prenom }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Bâtiment / Logement :</span>
            <span>{{ $paiement->locataire->logement->batiment->name ?? '' }} - N° {{ $paiement->locataire->logement->numero ?? '' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Période couverte :</span>
            <span>{{ \Carbon\Carbon::parse($paiement->date_debut_conso)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($paiement->date_fin_conso)->format('d/m/Y') }}</span>
        </div>
        <div class="flex justify-between border-t pt-3 text-base">
            <span class="font-bold">Montant Reglé :</span>
            <span class="font-bold text-green-600">{{ number_format($paiement->montant_paiement, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="flex justify-between items-center print:hidden">
        <a href="{{ route('paiements.index') }}" class="px-4 py-2 border rounded">Retour</a>
        <div class="space-x-2">
            <button onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white rounded">Imprimer</button>
            <a href="{{ route('paiements.downloadRecu', $paiement->id) }}" class="px-4 py-2 bg-green-600 text-white rounded">Télécharger PDF</a>
        </div>
    </div>
</div>
@endsection