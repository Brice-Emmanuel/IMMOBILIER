@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête de page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-[#0A2E38] uppercase tracking-wide">Gestion des Bâtiments</h1>
            <p class="text-xs text-gray-500 mt-1">Gérez l'ensemble de vos biens immobiliers et consultez leurs logements affiliés.</p>
        </div>
        <a href="{{ route('batiments.create') }}" class="inline-flex items-center justify-center bg-[#0A2E38] hover:bg-[#061e25] text-white px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow">
            <i class="fa-solid fa-plus mr-2 text-[#C6E900]"></i> Ajouter un Bâtiment
        </a>
    </div>

    <!-- Barre de Filtres et Recherche -->
    <form method="GET" action="{{ route('batiments.index') }}" class="bg-[#0A2E38] p-5 rounded-2xl shadow-md text-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Recherche</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, adresse..." class="w-full pl-9 pr-3 py-2 bg-white/10 text-white placeholder-gray-400 border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Ville</label>
                <select name="ville" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Toutes les villes</option>
                    @foreach($villes as $ville)
                        <option value="{{ $ville }}" {{ request('ville') == $ville ? 'selected' : '' }}>{{ $ville }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Trier par</label>
                <select name="sort" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Plus récents d'abord</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Plus anciens d'abord</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-[#C6E900] hover:bg-[#b0d000] text-[#0A2E38] font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition">
                    Filtrer
                </button>
                @if(request()->hasAny(['search', 'ville', 'sort']))
                    <a href="{{ route('batiments.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-3 rounded-xl text-xs uppercase transition" title="Réinitialiser">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Cartes des Bâtiments -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($batiments as $b)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                <div class="p-5">
                    <div class="flex justify-between items-start gap-2">
                        <h3 class="font-bold text-lg text-[#0A2E38] line-clamp-1">{{ $b->name }}</h3>
                        <span class="inline-flex items-center bg-[#0A2E38]/10 text-[#0A2E38] text-[11px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap">
                            <i class="fa-solid fa-door-open mr-1 text-xs"></i> {{ $b->logements_count }}
                        </span>
                    </div>

                    <p class="text-xs text-gray-500 mt-3 flex items-start">
                        <i class="fa-solid fa-location-dot mt-0.5 mr-2 text-[#0A2E38] shrink-0"></i>
                        <span>{{ $b->adresse ? $b->adresse . ', ' : '' }}<strong class="text-gray-700">{{ $b->ville }}</strong></span>
                    </p>
                </div>

                <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                    <a href="{{ route('batiments.show', $b) }}" class="text-[#0A2E38] hover:text-[#061e25] transition flex items-center">
                        <i class="fa-solid fa-eye mr-1.5"></i> Détails
                    </a>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('batiments.edit', $b) }}" class="text-blue-600 hover:text-blue-800 transition flex items-center">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Éditer
                        </a>

                        <form method="POST" action="{{ route('batiments.destroy', $b) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')" class="inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition flex items-center">
                                <i class="fa-solid fa-trash mr-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                    <i class="fa-solid fa-building-circle-xmark text-xl"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-700 uppercase">Aucun bâtiment trouvé</h3>
                <p class="text-xs text-gray-500 mt-1">Essayer d'ajuster vos filtres de recherche ou créez votre premier bâtiment.</p>
                <a href="{{ route('batiments.create') }}" class="inline-block mt-4 bg-[#0A2E38] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                    Créer un bâtiment
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $batiments->links() }}
    </div>
</div>
@endsection