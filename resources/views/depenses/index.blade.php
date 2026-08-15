@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête de page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-[#0A2E38] uppercase tracking-wide">Gestion des Dépenses</h1>
            <p class="text-xs text-gray-500 mt-1">Suivez, filtrez et gérez les charges liées à vos biens immobiliers.</p>
        </div>
        <a href="{{ route('depenses.create') }}" class="inline-flex items-center justify-center bg-[#0A2E38] hover:bg-[#061e25] text-white px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow">
            <i class="fa-solid fa-plus mr-2 text-[#C6E900]"></i> Saisir une Dépense
        </a>
    </div>

    <!-- Barre de Filtres et Recherche (Fond Sombre #0A2E38) -->
    <form method="GET" action="{{ route('depenses.index') }}" class="bg-[#0A2E38] p-5 rounded-2xl shadow-md text-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Recherche par Motif -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Recherche</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Motif, description..." class="w-full pl-9 pr-3 py-2 bg-white/10 text-white placeholder-gray-400 border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
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

            <!-- Tri -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Trier par</label>
                <select name="sort" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Plus récentes d'abord</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Plus anciennes d'abord</option>
                </select>
            </div>

            <!-- Boutons d'Action -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-[#C6E900] hover:bg-[#b0d000] text-[#0A2E38] font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition">
                    Filtrer
                </button>
                @if(request()->hasAny(['search', 'batiment_id', 'sort']))
                    <a href="{{ route('depenses.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-3 rounded-xl text-xs uppercase transition flex items-center justify-center" title="Réinitialiser">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- Affichage Mobile (Cartes) -->
    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($depenses as $d)
            <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-[#0A2E38] text-base">{{ $d->motif }}</h3>
                        <p class="text-xs text-gray-500 font-medium mt-0.5">
                            <i class="fa-solid fa-building mr-1 text-[#0A2E38]"></i>
                            {{ $d->batiment->name ?? 'Général / Non attribué' }}
                        </p>
                    </div>
                    <span class="text-xs font-semibold text-gray-400">
                        {{ $d->created_at ? $d->created_at->format('d/m/Y') : '' }}
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-3 flex justify-between items-center">
                    <span class="font-black text-red-600 text-base">- {{ number_format($d->montant_depenses, 0, ',', ' ') }} FCFA</span>
                    
                    <form method="POST" action="{{ route('depenses.destroy', $d) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense ?')" class="inline">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition font-bold text-xs flex items-center">
                            <i class="fa-solid fa-trash mr-1"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-300">
                <p class="text-xs text-gray-500 italic">Aucune dépense trouvée.</p>
            </div>
        @endforelse
    </div>

    <!-- Affichage Desktop (Tableau) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#0A2E38] text-white text-xs uppercase tracking-wider">
                    <th class="p-4">Date</th>
                    <th class="p-4">Motif</th>
                    <th class="p-4">Bâtiment Concerné</th>
                    <th class="p-4">Montant</th>
                    <th class="p-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($depenses as $d)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-xs font-medium text-gray-500">
                            {{ $d->created_at ? $d->created_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="p-4 font-bold text-[#0A2E38]">
                            {{ $d->motif }}
                        </td>
                        <td class="p-4 text-xs text-gray-600">
                            {{ $d->batiment->name ?? 'Général' }}
                        </td>
                        <td class="p-4 font-black text-red-600">
                            - {{ number_format($d->montant_depenses, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="p-4 text-right">
                            <form method="POST" action="{{ route('depenses.destroy', $d) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette dépense ?')" class="inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition font-bold text-xs flex items-center justify-end ml-auto">
                                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center border-dashed">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i class="fa-solid fa-receipt text-xl"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700 uppercase">Aucune dépense trouvée</h3>
                            <p class="text-xs text-gray-500 mt-1">Essayez d'ajuster vos filtres de recherche ou saisissez une nouvelle dépense.</p>
                            <a href="{{ route('depenses.create') }}" class="inline-block mt-4 bg-[#0A2E38] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                                Saisir une dépense
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($depenses, 'links'))
        <div>
            {{ $depenses->links() }}
        </div>
    @endif
</div>
@endsection