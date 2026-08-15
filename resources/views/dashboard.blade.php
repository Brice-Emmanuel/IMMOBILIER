@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header simple sans boutons d'action -->
    <div>
        <h1 class="text-xl md:text-2xl font-black text-[#0A2E38] uppercase tracking-wide">Tableau de Bord</h1>
        <p class="text-xs text-gray-600 mt-1">Aperçu global de votre parc immobilier et état financier</p>
    </div>

    <!-- Banner Stat Bâtiments/Logements (Adapté Mobile) -->
    <div class="bg-[#0A2E38] text-white rounded-2xl shadow-lg p-5 md:p-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="border-r border-gray-700/60 pr-2">
            <p class="text-[10px] sm:text-xs text-gray-300 uppercase font-semibold">Bâtiments</p>
            <p class="text-xl sm:text-2xl font-black text-[#C6E900] mt-1">{{ $totalBatiments }}</p>
        </div>
        <div class="border-r border-gray-700/60 pr-2">
            <p class="text-[10px] sm:text-xs text-gray-300 uppercase font-semibold">Logements</p>
            <p class="text-xl sm:text-2xl font-black text-white mt-1">{{ $totalLogements }}</p>
        </div>
        <div class="border-r border-gray-700/60 pr-2">
            <p class="text-[10px] sm:text-xs text-gray-300 uppercase font-semibold">Disponibles</p>
            <p class="text-xl sm:text-2xl font-black text-[#C6E900] mt-1">{{ $logementsDisponibles }}</p>
        </div>
        <div class="border-r sm:border-r-0 lg:border-r border-gray-700/60 pr-2">
            <p class="text-[10px] sm:text-xs text-gray-300 uppercase font-semibold">Occupés</p>
            <p class="text-2xl font-black text-red-400 mt-1">{{ $logementsOccupes }}</p>
        </div>
        <div class="col-span-2 sm:col-span-1">
            <p class="text-[10px] sm:text-xs text-gray-300 uppercase font-semibold">Locataires</p>
            <p class="text-xl sm:text-2xl font-black text-white mt-1">{{ $totalLocataires }}</p>
        </div>
    </div>

    <!-- Bilan Financier -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100">
            <p class="text-xs font-bold uppercase text-emerald-800">Revenus Totaux</p>
            <p class="text-lg md:text-xl font-black text-emerald-600 mt-1">+ {{ number_format($totalRevenus, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="bg-red-50 p-4 rounded-xl border border-red-100">
            <p class="text-xs font-bold uppercase text-red-800">Dépenses Totales</p>
            <p class="text-lg md:text-xl font-black text-red-600 mt-1">- {{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
            <p class="text-xs font-bold uppercase text-slate-700">Solde Net</p>
            <p class="text-lg md:text-xl font-black {{ $soldeNet >= 0 ? 'text-[#0A2E38]' : 'text-red-600' }} mt-1">
                {{ number_format($soldeNet, 0, ',', ' ') }} FCFA
            </p>
        </div>
    </div>

    <!-- Activités Récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Derniers Paiements -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-[#0A2E38] text-white px-5 py-3 flex justify-between items-center">
                <h3 class="font-bold text-xs sm:text-sm uppercase tracking-wider">Derniers Paiements</h3>
                <a href="{{ route('paiements.index') }}" class="text-xs text-[#C6E900] hover:underline font-semibold">Voir tout</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($derniersPaiements as $p)
                    <div class="p-4 flex justify-between items-center hover:bg-gray-50 text-xs sm:text-sm">
                        <div>
                            <p class="font-bold text-[#0A2E38]">{{ $p->locataire->nom ?? 'N/A' }} {{ $p->locataire->prenom ?? '' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}</p>
                        </div>
                        <span class="font-bold text-emerald-600 text-xs sm:text-sm bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                            + {{ number_format($p->montant_paiement, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                @empty
                    <p class="p-4 text-xs text-gray-500 italic">Aucun paiement enregistré.</p>
                @endforelse
            </div>
        </div>

        <!-- Dernières Dépenses -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-[#0A2E38] text-white px-5 py-3 flex justify-between items-center">
                <h3 class="font-bold text-xs sm:text-sm uppercase tracking-wider">Dernières Dépenses</h3>
                <a href="{{ route('depenses.index') }}" class="text-xs text-[#C6E900] hover:underline font-semibold">Voir tout</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($dernieresDepenses as $d)
                    <div class="p-4 flex justify-between items-center hover:bg-gray-50 text-xs sm:text-sm">
                        <div>
                            <p class="font-bold text-[#0A2E38]">{{ $d->motif }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $d->batiment->name ?? 'Général' }}</p>
                        </div>
                        <span class="font-bold text-red-600 text-xs sm:text-sm bg-red-50 px-2.5 py-1 rounded-lg border border-red-100">
                            - {{ number_format($d->montant_depenses, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                @empty
                    <p class="p-4 text-xs text-gray-500 italic">Aucune dépense enregistrée.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection