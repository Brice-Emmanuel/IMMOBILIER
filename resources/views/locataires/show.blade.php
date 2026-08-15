@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">{{ $locataire->nom }} {{ $locataire->prenom }}</h2>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <p><strong>Téléphone :</strong> {{ $locataire->phone }}</p>
        <p><strong>Urgence :</strong> {{ $locataire->phone_urgence ?? 'N/A' }}</p>
        <p><strong>Email :</strong> {{ $locataire->email ?? 'N/A' }}</p>
        <p><strong>Loyer mensuel :</strong> {{ number_format($locataire->loyer, 0, ',', ' ') }} FCFA</p>
        <p class="col-span-2"><strong>Logement actuel :</strong> 
            {{ $locataire->logement ? ($locataire->logement->batiment->name . ' - N° ' . $locataire->logement->numero) : 'Non attribué' }}
        </p>
    </div>
    <div class="mt-6 flex justify-end">
        <a href="{{ route('locataires.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection