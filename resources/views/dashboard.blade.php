@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-[#0A2E38] tracking-tight uppercase">Tableau de Bord</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">Aperçu en temps réel de votre parc immobilier et état financier</p>
        </div>
    </div>

    <!-- Grille Principale des Indicateurs (KPIs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Bâtiments -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Bâtiments</p>
                <p class="text-2xl sm:text-3xl font-black text-[#0A2E38] mt-1">{{ number_format($totalBatiments, 0, ',', ' ') }}</p>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Immeubles gérés</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#0A2E38]/5 text-[#0A2E38] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m0 0v-5a1 1 0 011-1h1a1 1 0 011 1v5m-7 0V9a1 1 0 011-1h2a1 1 0 011 1v12"/>
                </svg>
            </div>
        </div>

        <!-- Logements -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Logements</p>
                <p class="text-2xl sm:text-3xl font-black text-[#0A2E38] mt-1">{{ number_format($totalLogements, 0, ',', ' ') }}</p>
                <div class="flex items-center gap-2 mt-1 text-[11px] font-semibold">
                    <span class="text-emerald-600">{{ $logementsDisponibles }} libres</span>
                    <span class="text-gray-300">•</span>
                    <span class="text-rose-500">{{ $logementsOccupes }} occupés</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#0A2E38]/5 text-[#0A2E38] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
        </div>

        <!-- Locataires -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Locataires</p>
                <p class="text-2xl sm:text-3xl font-black text-[#0A2E38] mt-1">{{ number_format($totalLocataires, 0, ',', ' ') }}</p>
                <p class="text-[11px] text-gray-400 mt-1 font-medium">Contrats actifs</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#0A2E38]/5 text-[#0A2E38] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5 5 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Revenus Totaux -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Revenus Totaux</p>
                <p class="text-xl sm:text-2xl font-black text-emerald-600 mt-1">{{ number_format($totalRevenus, 0, ',', ' ') }} <span class="text-xs font-bold">FCFA</span></p>
                <p class="text-[11px] text-emerald-600/80 mt-1 font-medium">Loyers encaissés</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Bilan financier : Dépenses & Solde Net -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- Dépenses Totales -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dépenses Totales</p>
                    <p class="text-xl font-black text-rose-600 mt-0.5">- {{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
            <a href="{{ route('depenses.index') }}" class="text-xs font-bold text-[#0A2E38] hover:text-[#C6E900] transition-colors">Détails →</a>
        </div>

        <!-- Solde Net -->
        <div class="bg-[#0A2E38] text-white rounded-2xl p-5 shadow-lg flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/10 text-[#C6E900] flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-300 uppercase tracking-wider">Solde Net Global</p>
                    <p class="text-xl font-black {{ $soldeNet >= 0 ? 'text-[#C6E900]' : 'text-rose-400' }} mt-0.5">
                        {{ number_format($soldeNet, 0, ',', ' ') }} FCFA
                    </p>
                </div>
            </div>
            <span class="text-[10px] font-extrabold uppercase bg-white/10 text-white px-3 py-1 rounded-full border border-white/10">
                {{ $soldeNet >= 0 ? 'Bénéficiaire' : 'Déficitaire' }}
            </span>
        </div>

    </div>

    <!-- Activités Récentes (Tables Modifiées) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Derniers Paiements -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <h2 class="font-black text-xs text-[#0A2E38] uppercase tracking-wider">Derniers Paiements</h2>
                    </div>
                    <a href="{{ route('paiements.index') }}" class="text-xs font-bold text-[#0A2E38] hover:underline">Tout voir</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($derniersPaiements as $p)
                        <div class="px-6 py-3.5 flex justify-between items-center hover:bg-gray-50/80 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($p->locataire->nom ?? 'N', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-[#0A2E38]">{{ $p->locataire->nom ?? 'N/A' }} {{ $p->locataire->prenom ?? '' }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <span class="font-extrabold text-xs text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                + {{ number_format($p->montant_paiement, 0, ',', ' ') }} F
                            </span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-gray-400 italic">Aucun paiement enregistré pour le moment.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Dernières Dépenses -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                        <h2 class="font-black text-xs text-[#0A2E38] uppercase tracking-wider">Dernières Dépenses</h2>
                    </div>
                    <a href="{{ route('depenses.index') }}" class="text-xs font-bold text-[#0A2E38] hover:underline">Tout voir</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($dernieresDepenses as $d)
                        <div class="px-6 py-3.5 flex justify-between items-center hover:bg-gray-50/80 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    D
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-[#0A2E38]">{{ $d->motif }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $d->batiment->name ?? 'Dépense Générale' }}</p>
                                </div>
                            </div>
                            <span class="font-extrabold text-xs text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg">
                                - {{ number_format($d->montant_depenses, 0, ',', ' ') }} F
                            </span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-gray-400 italic">Aucune dépense enregistrée pour le moment.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection