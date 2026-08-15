@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Logement N° {{ $logement->numero }}</h2>
    <div class="space-y-2 text-sm">
        <p><strong>Bâtiment :</strong> {{ $logement->batiment->name ?? 'N/A' }}</p>
        <p><strong>Catégorie :</strong> {{ ucfirst($logement->categorie) }}</p>
        <p><strong>Loyer Mensuel :</strong> {{ number_format($logement->loyer_mensuel, 0, ',', ' ') }} FCFA</p>
        <p><strong>Statut :</strong> 
            <span class="px-2 py-1 text-xs rounded-full {{ $logement->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $logement->statut ? 'Libre' : 'Occupé' }}
            </span>
        </p>
        <p><strong>Description :</strong> {{ $logement->description ?? 'Aucune description' }}</p>
    </div>
    <div class="mt-6">
        <a href="{{ route('logements.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Retour</a>
    </div>
</div>
@endsection