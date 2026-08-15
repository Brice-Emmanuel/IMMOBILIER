@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête de page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-[#0A2E38] uppercase tracking-wide">Gestion des Logements</h1>
            <p class="text-xs text-gray-500 mt-1">Gérez l'ensemble de vos appartements, studios, boutiques et locaux.</p>
        </div>
        <a href="{{ route('logements.create') }}" class="inline-flex items-center justify-center bg-[#0A2E38] hover:bg-[#061e25] text-white px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow">
            <i class="fa-solid fa-plus mr-2 text-[#C6E900]"></i> Nouveau Logement
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-bold flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check mr-2 text-sm"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Barre de Filtres et Recherche -->
    <form method="GET" action="{{ route('logements.index') }}" class="bg-[#0A2E38] p-5 rounded-2xl shadow-md text-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Recherche par Numéro / Porte -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Recherche</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Numéro, porte..." class="w-full pl-9 pr-3 py-2 bg-white/10 text-white placeholder-gray-400 border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                </div>
            </div>

            <!-- Filtre Bâtiment -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Bâtiment</label>
                <select name="batiment_id" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Tous les bâtiments</option>
                    @foreach($batiments as $b)
                        <option value="{{ $b->id }}" {{ request('batiment_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre Catégorie -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Catégorie</label>
                <select name="categorie" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Toutes catégories</option>
                    <option value="appartement" {{ request('categorie') == 'appartement' ? 'selected' : '' }}>Appartement</option>
                    <option value="studio" {{ request('categorie') == 'studio' ? 'selected' : '' }}>Studio</option>
                    <option value="maison" {{ request('categorie') == 'maison' ? 'selected' : '' }}>Maison</option>
                    <option value="boutique" {{ request('categorie') == 'boutique' ? 'selected' : '' }}>Boutique</option>
                    <option value="bureau" {{ request('categorie') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                </select>
            </div>

            <!-- Filtre Statut -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Statut</label>
                <select name="statut" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Tous les statuts</option>
                    <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Libre</option>
                    <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Occupé</option>
                </select>
            </div>

            <!-- Boutons d'Action -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-[#C6E900] hover:bg-[#b0d000] text-[#0A2E38] font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition">
                    Filtrer
                </button>
                @if(request()->hasAny(['search', 'batiment_id', 'categorie', 'statut']))
                    <a href="{{ route('logements.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-3 rounded-xl text-xs uppercase transition flex items-center justify-center" title="Réinitialiser">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Cartes des Logements -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($logements as $logement)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                <div class="p-5">
                    <!-- Titre / Porte & Badge Statut -->
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <h3 class="font-bold text-lg text-[#0A2E38] line-clamp-1">
                                Porte {{ $logement->numero ?? 'N/A' }}
                            </h3>
                            <p class="text-xs text-gray-500 font-medium mt-0.5 capitalize">
                                <i class="fa-solid fa-tag mr-1 text-gray-400"></i>{{ $logement->categorie }}
                            </p>
                        </div>
                        
                        @if($logement->statut == 1)
                            <span class="inline-flex items-center bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Libre
                            </span>
                        @else
                            <span class="inline-flex items-center bg-red-50 text-red-700 text-[11px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Occupé
                            </span>
                        @endif
                    </div>

                    <!-- Détails Bâtiment et Loyer -->
                    <div class="mt-4 space-y-2 text-xs border-t border-gray-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 flex items-center">
                                <i class="fa-solid fa-building mr-1.5 text-[#0A2E38]"></i> Bâtiment :
                            </span>
                            <span class="font-bold text-gray-700">
                                {{ $logement->batiment->name ?? 'Non assigné' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 flex items-center">
                                <i class="fa-solid fa-money-bill-wave mr-1.5 text-[#0A2E38]"></i> Loyer mensuel :
                            </span>
                            <span class="font-bold text-emerald-600 text-sm">
                                {{ number_format($logement->loyer_mensuel, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer d'Actions -->
                <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                    <span class="text-gray-400 text-[11px] truncate max-w-[150px]" title="{{ $logement->description }}">
                        @if($logement->description)
                            <i class="fa-solid fa-circle-info mr-1"></i> {{ $logement->description }}
                        @else
                            <span class="italic text-gray-300">Sans description</span>
                        @endif
                    </span>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('logements.edit', $logement) }}" class="text-blue-600 hover:text-blue-800 transition flex items-center">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Éditer
                        </a>

                        <form method="POST" action="{{ route('logements.destroy', $logement) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce logement ?');" class="inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition flex items-center">
                                <i class="fa-solid fa-trash mr-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                    <i class="fa-solid fa-door-closed text-xl"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-700 uppercase">Aucun logement trouvé</h3>
                <p class="text-xs text-gray-500 mt-1">Essayez d'ajuster vos filtres de recherche ou enregistrez un nouveau logement.</p>
                <a href="{{ route('logements.create') }}" class="inline-block mt-4 bg-[#0A2E38] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                    Créer un logement
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($logements, 'links'))
        <div>
            {{ $logements->links() }}
        </div>
    @endif
</div>
@endsection