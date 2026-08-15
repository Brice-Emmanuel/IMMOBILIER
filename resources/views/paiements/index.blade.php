@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- En-tête de page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-[#0A2E38] uppercase tracking-wide">Historique des Paiements</h1>
            <p class="text-xs text-gray-500 mt-1">Consultez, filtrez et téléchargez les reçus de vos règlements.</p>
        </div>
        <a href="{{ route('paiements.create') }}" class="inline-flex items-center justify-center bg-[#0A2E38] hover:bg-[#061e25] text-white px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm hover:shadow">
            <i class="fa-solid fa-plus mr-2 text-[#C6E900]"></i> Nouveau Paiement
        </a>
    </div>

    <!-- Barre de Filtres et Recherche -->
    <form method="GET" action="{{ route('paiements.index') }}" class="bg-[#0A2E38] p-5 rounded-2xl shadow-md text-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Recherche par Nom du locataire -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Recherche</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom du locataire..." class="w-full pl-9 pr-3 py-2 bg-white/10 text-white placeholder-gray-400 border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                </div>
            </div>

            <!-- Filtre Locataire -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Locataire</label>
                <select name="locataire_id" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="">Tous les locataires</option>
                    @foreach($locataires as $loc)
                        <option value="{{ $loc->id }}" {{ request('locataire_id') == $loc->id ? 'selected' : '' }}>
                            {{ $loc->nom }} {{ $loc->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre Mois / Année -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Mois de règlement</label>
                <input type="month" name="mois" value="{{ request('mois') }}" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
            </div>

            <!-- Tri par date -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-300 mb-1.5">Trier par</label>
                <select name="sort" onchange="this.form.submit()" class="w-full px-3 py-2 bg-[#0A2E38] text-white border border-gray-600 focus:border-[#C6E900] focus:ring-1 focus:ring-[#C6E900] rounded-xl text-xs transition">
                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Plus récents d'abord</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Plus anciens d'abord</option>
                </select>
            </div>

            <!-- Boutons d'Action -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-[#C6E900] hover:bg-[#b0d000] text-[#0A2E38] font-bold py-2 px-4 rounded-xl text-xs uppercase tracking-wider transition">
                    Filtrer
                </button>
                @if(request()->hasAny(['search', 'locataire_id', 'mois', 'sort']))
                    <a href="{{ route('paiements.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-3 rounded-xl text-xs uppercase transition flex items-center justify-center" title="Réinitialiser">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>

    <!-- Affichage Mobile (Cartes) -->
    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($paiements as $p)
            <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-[#0A2E38] text-base">{{ $p->locataire->nom ?? '' }} {{ $p->locataire->prenom ?? '' }}</h3>
                        <p class="text-xs text-gray-500 font-medium">
                            <i class="fa-solid fa-[#0A2E38] fa-building mr-1 text-[#0A2E38]"></i>
                            {{ $p->locataire->logement->batiment->name ?? 'Bâtiment' }} - Porte {{ $p->locataire->logement->numero ?? 'N/A' }}
                        </p>
                    </div>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                        {{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-2 flex justify-between items-center text-xs">
                    <span class="text-gray-500">Période :</span>
                    <span class="font-bold text-gray-700">
                        {{ \Carbon\Carbon::parse($p->date_debut_conso)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($p->date_fin_conso)->format('d/m/Y') }}
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-3 flex justify-between items-center">
                    <span class="font-black text-emerald-600 text-base">+ {{ number_format($p->montant_paiement, 0, ',', ' ') }} FCFA</span>
                    <a href="{{ route('paiements.showRecu', $p) }}" class="bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs px-3 py-1.5 rounded-xl font-bold uppercase transition flex items-center">
                        <i class="fa-solid fa-file-invoice mr-1.5 text-[#C6E900]"></i> Reçu
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-300">
                <p class="text-xs text-gray-500 italic">Aucun paiement trouvé.</p>
            </div>
        @endforelse
    </div>

    <!-- Affichage Desktop (Tableau) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#0A2E38] text-white text-xs uppercase tracking-wider">
                    <th class="p-4">Date Paiement</th>
                    <th class="p-4">Locataire</th>
                    <th class="p-4">Logement</th>
                    <th class="p-4">Période Couverte</th>
                    <th class="p-4">Montant</th>
                    <th class="p-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($paiements as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}
                        </td>
                        <td class="p-4 font-bold text-[#0A2E38]">
                            {{ $p->locataire->nom ?? '' }} {{ $p->locataire->prenom ?? '' }}
                        </td>
                        <td class="p-4 text-xs text-gray-600">
                            {{ $p->locataire->logement->batiment->name ?? '-' }} (Porte {{ $p->locataire->logement->numero ?? 'N/A' }})
                        </td>
                        <td class="p-4 text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($p->date_debut_conso)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($p->date_fin_conso)->format('d/m/Y') }}
                        </td>
                        <td class="p-4 font-black text-emerald-600">
                            + {{ number_format($p->montant_paiement, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('paiements.showRecu', $p) }}" class="inline-flex items-center bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs px-3 py-1.5 rounded-xl font-bold uppercase transition">
                                <i class="fa-solid fa-file-invoice mr-1.5 text-[#C6E900]"></i> Voir Reçu
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center border-dashed">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <i class="fa-solid fa-receipt text-xl"></i>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700 uppercase">Aucun paiement trouvé</h3>
                            <p class="text-xs text-gray-500 mt-1">Essayez d'ajuster vos filtres ou enregistrez un nouveau paiement.</p>
                            <a href="{{ route('paiements.create') }}" class="inline-block mt-4 bg-[#0A2E38] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider">
                                Enregistrer un paiement
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($paiements, 'links'))
        <div>
            {{ $paiements->links() }}
        </div>
    @endif
</div>
@endsection