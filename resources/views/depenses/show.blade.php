@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('depenses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-danger text-white">Détails Dépense #{{ $depense->id }}</div>
    <div class="card-body">
        <h5>Motif : {{ $depense->motif }}</h5>
        <p><strong>Bâtiment :</strong> {{ $depense->batiment->name ?? 'N/A' }}</p>
        <p><strong>Montant :</strong> {{ number_format($depense->montant_depenses, 2, ',', ' ') }} FCFA</p>
    </div>
</div>
@endsection