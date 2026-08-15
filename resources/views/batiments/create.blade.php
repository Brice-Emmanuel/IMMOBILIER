@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
    <div class="bg-[#0A2E38] text-white p-5 flex items-center justify-between">
        <h1 class="font-bold uppercase text-xs tracking-wider flex items-center">
            <i class="fa-solid fa-building mr-2 text-[#C6E900]"></i> Ajouter un Bâtiment
        </h1>
        <a href="{{ route('batiments.index') }}" class="text-gray-300 hover:text-white text-xs transition">
            <i class="fa-solid fa-xmark text-base"></i>
        </a>
    </div>

    <form method="POST" action="{{ route('batiments.store') }}" class="p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Nom du Bâtiment <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                   placeholder="Ex: Immeuble Krystal, Résidence La Paix..." 
                   class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('name') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Ville <span class="text-red-500">*</span></label>
            <input type="text" name="ville" value="{{ old('ville') }}" required 
                   placeholder="Ex: Douala, Yaoundé, Bafoussam..." 
                   class="w-full border @error('ville') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('ville') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Adresse (Optionnelle)</label>
            <textarea name="adresse" rows="3" 
                      placeholder="Ex: Akwa, Rue Deido, à 100m du carrefour Total..." 
                      class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">{{ old('adresse') }}</textarea>
            @error('adresse') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('batiments.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold uppercase rounded-xl transition">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs font-bold uppercase rounded-xl transition shadow-sm">
                <i class="fa-solid fa-check mr-1 text-[#C6E900]"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection