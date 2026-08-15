@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
    <!-- En-tête -->
    <div class="bg-[#0A2E38] text-white p-5 flex items-center justify-between">
        <h1 class="font-bold uppercase text-xs tracking-wider flex items-center">
            <i class="fa-solid fa-pen-to-square mr-2 text-[#C6E900]"></i> Modifier le Paiement
        </h1>
        <a href="{{ route('paiements.index') }}" class="text-gray-300 hover:text-white text-xs transition">
            <i class="fa-solid fa-xmark text-base"></i>
        </a>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('paiements.update', $paiement) }}" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <!-- Locataire -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Locataire <span class="text-red-500">*</span>
            </label>
            <select name="locataire_id" required 
                    class="w-full border @error('locataire_id') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                @foreach($locataires as $loc)
                    <option value="{{ $loc->id }}" {{ old('locataire_id', $paiement->locataire_id) == $loc->id ? 'selected' : '' }}>
                        {{ $loc->nom }} {{ $loc->prenom }} ({{ $loc->logement->batiment->name ?? 'Sans bâtiment' }} - Appt {{ $loc->logement->numero ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('locataire_id') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Montant & Date de Paiement -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Montant Payé (FCFA) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number" step="0.01" name="montant_paiement" value="{{ old('montant_paiement', $paiement->montant_paiement) }}" required 
                           placeholder="Ex: 85000" 
                           class="w-full border @error('montant_paiement') border-red-500 @else border-gray-300 @enderror rounded-xl pl-3.5 pr-12 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                    <span class="absolute right-2.5 top-2 text-xs font-bold text-gray-400 pointer-events-none">FCFA</span>
                </div>
                @error('montant_paiement') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Date du Paiement <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date_paiement" value="{{ old('date_paiement', $paiement->date_paiement) }}" required 
                       class="w-full border @error('date_paiement') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                @error('date_paiement') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <!-- Période Couverte -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Début Période <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date_debut_conso" value="{{ old('date_debut_conso', $paiement->date_debut_conso) }}" required 
                       class="w-full border @error('date_debut_conso') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                @error('date_debut_conso') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Fin Période <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date_fin_conso" value="{{ old('date_fin_conso', $paiement->date_fin_conso) }}" required 
                       class="w-full border @error('date_fin_conso') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                @error('date_fin_conso') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('paiements.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold uppercase rounded-xl transition">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs font-bold uppercase rounded-xl transition shadow-sm">
                <i class="fa-solid fa-rotate mr-1 text-[#C6E900]"></i> Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection