@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête de page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-[#0A2E38] uppercase tracking-wide">Gestion des Locataires</h1>
            <p class="text-xs text-gray-500 mt-1">Gérez l'ensemble de vos locataires et suivez leurs logements attribués.</p>
        </div>
        <a href="{{ route('locataires.create') }}" class="inline-flex items-center justify-center bg-[#0A2E38] hover:bg-[#061e25] text-white px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow">
            <i class="fa-solid fa-user-plus mr-2 text-[#C6E900]"></i> Nouveau Locataire
        </a>
    </div>

    <!-- Barre de Filtres et Recherche -->
    <form method="GET" action="{{ route('locataires.index') }}" class="bg-[#0A2E38] p-5 rounded-2xl shadow-md text-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Recherche par Nom, Prénom, Téléphone -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Recherche</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, prénom, téléphone..." class="w-full pl-9 pr-3 py-2 bg-white/10 text-white placeholder-gray-400 border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                </div>
            </div>

            <!-- Filtre Bâtiment -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Bâtiment</label>
                <select name="batiment_id" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Tous les bâtiments</option>
                    @foreach($batiments as $batiment)
                        <option value="{{ $batiment->id }}" {{ request('batiment_id') == $batiment->id ? 'selected' : '' }}>
                            {{ $batiment->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre Statut d'attribution du logement -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Statut Logement</label>
                <select name="statut_logement" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Tous les états</option>
                    <option value="avec_logement" {{ request('statut_logement') == 'avec_logement' ? 'selected' : '' }}>Avec logement</option>
                    <option value="sans_logement" {{ request('statut_logement') == 'sans_logement' ? 'selected' : '' }}>Sans logement</option>
                </select>
            </div>

            <!-- Boutons d'Action -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-[#C6E900] hover:bg-[#b0d000] text-[#0A2E38] font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition">
                    Filtrer
                </button>
                @if(request()->hasAny(['search', 'batiment_id', 'statut_logement']))
                    <a href="{{ route('locataires.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-3 rounded-xl text-xs uppercase transition flex items-center justify-center" title="Réinitialiser">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Cartes des Locataires -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($locataires as $loc)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                <div class="p-5">
                    <!-- Nom et Badge Statut -->
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <h3 class="font-bold text-lg text-[#0A2E38] line-clamp-1">{{ $loc->nom }} {{ $loc->prenom }}</h3>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">
                                <i class="fa-solid fa-phone mr-1 text-gray-400"></i>{{ $loc->phone }}
                            </p>
                        </div>
                        
                        @if($loc->logement)
                            <span class="inline-flex items-center bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap border border-emerald-200">
                                <i class="fa-solid fa-house-user mr-1 text-xs"></i> Occupe
                            </span>
                        @else
                            <span class="inline-flex items-center bg-gray-100 text-gray-600 text-[11px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap">
                                Sans logement
                            </span>
                        @endif
                    </div>

                    <!-- Détails du logement et Loyer -->
                    <div class="mt-4 space-y-2 text-xs border-t border-gray-100 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 flex items-center">
                                <i class="fa-solid fa-building mr-1.5 text-[#0A2E38]"></i> Logement :
                            </span>
                            <span class="font-bold text-gray-700">
                                @if($loc->logement)
                                    {{ $loc->logement->batiment->name ?? 'Bâtiment' }} - Porte {{ $loc->logement->numero ?? 'N/A' }}
                                @else
                                    <span class="text-gray-400 italic">Aucun attribué</span>
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 flex items-center">
                                <i class="fa-solid fa-money-bill-wave mr-1.5 text-[#0A2E38]"></i> Loyer convenu :
                            </span>
                            <span class="font-bold text-emerald-600 text-sm">
                                {{ number_format($loc->loyer, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer d'Actions -->
                <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold">
                    <span class="text-gray-400 text-[11px]">
                        @if($loc->email)
                            <i class="fa-solid fa-envelope mr-1"></i> {{ Str::limit($loc->email, 18) }}
                        @endif
                    </span>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('locataires.edit', $loc) }}" class="text-blue-600 hover:text-blue-800 transition flex items-center">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Éditer
                        </a>

                        <form method="POST" action="{{ route('locataires.destroy', $loc) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce locataire et libérer son logement ?')" class="inline">
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
                    <i class="fa-solid fa-users-slash text-xl"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-700 uppercase">Aucun locataire trouvé</h3>
                <p class="text-xs text-gray-500 mt-1">Essayez d'ajuster vos filtres de recherche ou enregistrez un nouveau locataire.</p>
                <a href="{{ route('locataires.create') }}" class="inline-block mt-4 bg-[#0A2E38] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                    Créer un locataire
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($locataires, 'links'))
        <div>
            {{ $locataires->links() }}
        </div>
    @endif
</div>
@endsection