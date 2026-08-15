@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Détails de la Dépense</h2>
    <div class="space-y-2">
        <p><strong>Bâtiment :</strong> {{ $depense->batiment->name ?? '-' }}</p>
        <p><strong>Motif :</strong> {{ $depense->motif }}</p>
        <p><strong>Montant :</strong> {{ number_format($depense->montant_depenses, 0, ',', ' ') }} FCFA</p>
        <p><strong>Date :</strong> {{ $depense->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="mt-6">
        <a href="{{ route('depenses.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Retour</a>
    </div>
</div>
@endsection