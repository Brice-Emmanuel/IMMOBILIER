@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- En-tête de navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('batiments.index') }}" class="inline-flex items-center text-xs font-bold text-gray-600 hover:text-[#0A2E38] transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Retour à la liste
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('batiments.edit', $batiment) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase rounded-xl transition shadow-sm">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Modifier
            </a>
        </div>
    </div>

    <!-- Carte Fiche Bâtiment -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
        <div class="bg-[#0A2E38] text-white p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-[10px] font-bold uppercase text-[#C6E900] tracking-wider">Fiche Bâtiment</span>
                <h2 class="text-2xl font-black uppercase tracking-wide mt-0.5">{{ $batiment->name }}</h2>
                <p class="text-xs text-gray-300 mt-1 flex items-center">
                    <i class="fa-solid fa-location-dot mr-1.5 text-[#C6E900]"></i>{{ $batiment->adresse ? $batiment->adresse . ', ' : '' }}{{ $batiment->ville }}
                </p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 px-5 py-3 rounded-2xl text-center min-w-[120px]">
                <span class="block text-2xl font-black text-[#C6E900]">{{ $batiment->logements_count }}</span>
                <span class="text-[10px] uppercase font-bold tracking-wider text-gray-200">Logement(s)</span>
            </div>
        </div>

        <!-- Détails -->
        <div class="p-6 space-y-4 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <span class="block font-bold text-gray-400 uppercase text-[10px] mb-1">Nom du Bâtiment</span>
                    <span class="font-bold text-[#0A2E38] text-base">{{ $batiment->name }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <span class="block font-bold text-gray-400 uppercase text-[10px] mb-1">Ville</span>
                    <span class="font-bold text-gray-800 text-base">{{ $batiment->ville }}</span>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                <span class="block font-bold text-gray-400 uppercase text-[10px] mb-1">Adresse complète</span>
                <span class="text-gray-700 font-medium">{{ $batiment->adresse ?? 'Aucune adresse renseignée.' }}</span>
            </div>
        </div>
    </div>

    <!-- Liste des logements associés -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-[#0A2E38] text-white px-6 py-4 text-xs font-bold uppercase flex justify-between items-center">
            <span><i class="fa-solid fa-door-open mr-2 text-[#C6E900]"></i> Logements associés</span>
            <span class="text-[10px] bg-white/20 px-2.5 py-1 rounded-full">{{ $batiment->logements_count }} au total</span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($batiment->logements as $logement)
                <a href="{{ route('logements.show', $logement) }}" class="p-4 sm:px-6 flex items-center justify-between hover:bg-gray-50 transition group block">
                    <div>
                        <div class="font-bold text-[#0A2E38] group-hover:text-blue-600 transition">
                            Logement N° {{ $logement->numero }}
                        </div>
                        <div class="text-xs text-gray-500 mt-0.5">
                            Catégorie : <span class="font-medium text-gray-700 capitalize">{{ $logement->categorie ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-black text-emerald-600">
                            {{ number_format($logement->loyer_mensuel ?? 0, 0, ',', ' ') }} FCFA
                        </div>
                        <span class="inline-block mt-1 px-2.5 py-0.5 text-[10px] font-bold rounded-full {{ $logement->statut ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                            {{ $logement->statut ? 'Libre' : 'Occupé' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-xs text-gray-500">
                    <i class="fa-solid fa-folder-open text-2xl text-gray-300 block mb-2"></i>
                    Aucun logement enregistré pour ce bâtiment.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection