@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête & Bouton Ajouter -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Logements</h1>
            <p class="text-sm text-gray-500">Gérez l'ensemble de vos appartements, studios, boutiques et locaux.</p>
        </div>
        <a href="{{ route('logements.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs font-bold uppercase rounded-xl transition shadow-sm">
            <i class="fa-solid fa-plus mr-2 text-[#C6E900]"></i> Ajouter un logement
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Barres de recherche et Filtres -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('logements.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            <!-- Recherche par numéro / porte -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Numéro / Porte..."
                       class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            </div>

            <!-- Filtre Bâtiment -->
            <div>
                <select name="batiment_id" class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                    <option value="">Tous les bâtiments</option>
                    @foreach($batiments as $b)
                        <option value="{{ $b->id }}" {{ request('batiment_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre Catégorie -->
            <div>
                <select name="categorie" class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
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
                <select name="statut" class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                    <option value="">Tous les statuts</option>
                    <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Libre</option>
                    <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Occupé</option>
                </select>
            </div>

            <!-- Bouton Filtrer -->
            <div class="flex space-x-2">
                <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold uppercase rounded-xl transition flex items-center justify-center">
                    <i class="fa-solid fa-filter mr-1.5"></i> Filtrer
                </button>
                @if(request()->anyFilled(['search', 'batiment_id', 'categorie', 'statut']))
                    <a href="{{ route('logements.index') }}" class="px-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition flex items-center justify-center" title="Réinitialiser">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des logements -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Logement</th>
                        <th class="py-3.5 px-4">Bâtiment</th>
                        <th class="py-3.5 px-4">Catégorie</th>
                        <th class="py-3.5 px-4">Loyer Mensuel</th>
                        <th class="py-3.5 px-4">Statut</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($logements as $logement)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3.5 px-4 font-semibold text-gray-800">
                                {{ $logement->numero ?? 'Sans numéro' }}
                            </td>
                            <td class="py-3.5 px-4 text-gray-600">
                                {{ $logement->batiment->name ?? 'N/A' }}
                            </td>
                            <td class="py-3.5 px-4 capitalize text-gray-600">
                                {{ $logement->categorie }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-800">
                                {{ number_format($logement->loyer_mensuel, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="py-3.5 px-4">
                                @if($logement->statut == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Libre
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Occupé
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('logements.edit', $logement) }}" class="p-2 text-gray-400 hover:text-blue-600 transition" title="Modifier">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('logements.destroy', $logement) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce logement ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Supprimer">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 text-sm">
                                Aucun logement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection