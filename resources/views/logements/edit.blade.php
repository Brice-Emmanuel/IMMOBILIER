@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
    <!-- En-tête -->
    <div class="bg-[#0A2E38] text-white p-5 flex items-center justify-between">
        <h1 class="font-bold uppercase text-xs tracking-wider flex items-center">
            <i class="fa-solid fa-pen-to-square mr-2 text-[#C6E900]"></i> Modifier le Logement
        </h1>
        <a href="{{ route('logements.index') }}" class="text-gray-300 hover:text-white text-xs transition">
            <i class="fa-solid fa-xmark text-base"></i>
        </a>
    </div>

    <!-- Formulaire -->
    <form method="POST" action="{{ route('logements.update', $logement) }}" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <!-- Bâtiment -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Bâtiment <span class="text-red-500">*</span>
            </label>
            <select name="batiment_id" required 
                    class="w-full border @error('batiment_id') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                @foreach($batiments as $b)
                    <option value="{{ $b->id }}" {{ old('batiment_id', $logement->batiment_id) == $b->id ? 'selected' : '' }}>
                        {{ $b->name }} ({{ $b->ville }})
                    </option>
                @endforeach
            </select>
            @error('batiment_id') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Numéro / Porte & Catégorie -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Numéro / Porte</label>
                <input type="text" name="numero" value="{{ old('numero', $logement->numero) }}" 
                       placeholder="Ex: Appt 102, Porte B3..." 
                       class="w-full border @error('numero') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                @error('numero') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Catégorie <span class="text-red-500">*</span>
                </label>
                <select name="categorie" required 
                        class="w-full border @error('categorie') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                    <option value="appartement" {{ old('categorie', $logement->categorie) == 'appartement' ? 'selected' : '' }}>Appartement</option>
                    <option value="studio" {{ old('categorie', $logement->categorie) == 'studio' ? 'selected' : '' }}>Studio</option>
                    <option value="maison" {{ old('categorie', $logement->categorie) == 'maison' ? 'selected' : '' }}>Maison</option>
                    <option value="boutique" {{ old('categorie', $logement->categorie) == 'boutique' ? 'selected' : '' }}>Boutique</option>
                    <option value="bureau" {{ old('categorie', $logement->categorie) == 'bureau' ? 'selected' : '' }}>Bureau</option>
                </select>
                @error('categorie') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <!-- Loyer Mensuel & Statut -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Loyer Mensuel (FCFA) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number" name="loyer_mensuel" value="{{ old('loyer_mensuel', $logement->loyer_mensuel) }}" required 
                           placeholder="Ex: 75000" 
                           class="w-full border @error('loyer_mensuel') border-red-500 @else border-gray-300 @enderror rounded-xl pl-3.5 pr-14 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
                    <span class="absolute right-3 top-2 text-xs font-bold text-gray-400 pointer-events-none">FCFA</span>
                </div>
                @error('loyer_mensuel') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>

            <!-- Interrupteur Statut (Occupé / Libre) -->
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Statut de disponibilité</label>
                
                <input type="hidden" name="statut" id="statutInput" value="{{ old('statut', $logement->statut) }}">

                <div class="flex items-center justify-between border border-gray-200 rounded-xl p-2.5 bg-gray-50">
                    <span id="statutLabel" class="text-xs font-bold {{ old('statut', $logement->statut) == 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ old('statut', $logement->statut) == 0 ? 'Occupé' : 'Libre' }}
                    </span>

                    <button type="button" 
                            id="toggleStatutBtn" 
                            onclick="toggleStatut()" 
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ old('statut', $logement->statut) == 0 ? 'bg-red-500' : 'bg-emerald-500' }}">
                        <span id="toggleCircle" 
                              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ old('statut', $logement->statut) == 0 ? 'translate-x-5' : 'translate-x-0' }}">
                        </span>
                    </button>
                </div>
                @error('statut') 
                    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Description (Optionnelle)</label>
            <textarea name="description" rows="3" 
                      placeholder="Ex: 2 chambres, 1 salon, compteur prépayé, balcon..." 
                      class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">{{ old('description', $logement->description) }}</textarea>
            @error('description') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('logements.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold uppercase rounded-xl transition">
                Annuler
            </a>
            <button type="submit" class="px-5 py-2.5 bg-[#0A2E38] hover:bg-[#061e25] text-white text-xs font-bold uppercase rounded-xl transition shadow-sm">
                <i class="fa-solid fa-check mr-1 text-[#C6E900]"></i> Enregistrer
            </button>
        </div>
    </form>
</div>

<script>
    function toggleStatut() {
        const input = document.getElementById('statutInput');
        const label = document.getElementById('statutLabel');
        const btn = document.getElementById('toggleStatutBtn');
        const circle = document.getElementById('toggleCircle');

        if (input.value == "1") {
            input.value = "0";
            label.textContent = "Occupé";
            label.className = "text-xs font-bold text-red-600";
            btn.className = "relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-red-500";
            circle.className = "pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5";
        } else {
            input.value = "1";
            label.textContent = "Libre";
            label.className = "text-xs font-bold text-emerald-600";
            btn.className = "relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-emerald-500";
            circle.className = "pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-0";
        }
    }
</script>
@endsection