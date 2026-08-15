@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
    <!-- En-tête -->
    <div class="bg-[#0A2E38] text-white p-5 flex items-center justify-between">
        <h1 class="font-bold uppercase text-xs tracking-wider flex items-center">
            <i class="fa-solid fa-pen-to-square mr-2 text-[#C6E900]"></i> Modifier la Dépense
        </h1>
        <a href="{{ route('depenses.index') }}" class="text-gray-300 hover:text-white text-xs transition">
            <i class="fa-solid fa-xmark text-base"></i>
        </a>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('depenses.update', $depense) }}" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <!-- Bâtiment -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Bâtiment Concerné <span class="text-red-500">*</span>
            </label>
            <select name="batiment_id" required 
                    class="w-full border @error('batiment_id') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                <option value="" disabled>-- Choisir un bâtiment dans la liste --</option>
                @foreach($batiments as $batiment)
                    <option value="{{ $batiment->id }}" {{ old('batiment_id', $depense->batiment_id) == $batiment->id ? 'selected' : '' }}>
                        {{ $batiment->name }} ({{ $batiment->ville }})
                    </option>
                @endforeach
            </select>
            @error('batiment_id') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Motif -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Motif de la Dépense <span class="text-red-500">*</span>
            </label>
            <input type="text" name="motif" value="{{ old('motif', $depense->motif) }}" required 
                   placeholder="Ex: Réparation fuite d'eau, Achat d'ampoules LED, Entretien peinture..." 
                   class="w-full border @error('motif') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('motif') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Montant -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Montant (FCFA) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input type="number" step="0.01" name="montant_depenses" value="{{ old('montant_depenses', $depense->montant_depenses) }}" required 
                       placeholder="Ex: 25000" 
                       class="w-full border @error('montant_depenses') border-red-500 @else border-gray-300 @enderror rounded-xl pl-3.5 pr-14 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                <span class="absolute right-3 top-2 text-xs font-bold text-gray-400 pointer-events-none">FCFA</span>
            </div>
            @error('montant_depenses') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('depenses.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold uppercase rounded-xl transition">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs font-bold uppercase rounded-xl transition shadow-sm">
                <i class="fa-solid fa-rotate mr-1 text-[#C6E900]"></i> Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection