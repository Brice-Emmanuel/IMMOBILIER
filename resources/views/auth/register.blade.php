@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-8 bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
    <!-- En-tête -->
    <div class="bg-[#0A2E38] text-white text-center py-6 px-4">
        <h1 class="text-xl font-bold uppercase tracking-wider flex items-center justify-center">
            <i class="fa-solid fa-user-plus mr-2 text-[#C6E900]"></i> Créer un compte
        </h1>
        <p class="text-xs text-gray-300 mt-1">Inscrivez-vous en tant que bailleur</p>
    </div>

    <!-- Formulaire -->
    <form method="POST" action="{{ route('register') }}" class="p-6 space-y-4">
        @csrf

        <!-- Nom complet -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                   placeholder="Ex: Jean claude" 
                   class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('name') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Téléphone -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Téléphone <span class="text-red-500">*</span>
            </label>
            <input type="text" name="phone" value="{{ old('phone') }}" required 
                   placeholder="Ex: 699001122" 
                   class="w-full border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('phone') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">Adresse Email (Optionnel)</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   placeholder="Ex: bailleur@exemple.com" 
                   class="w-full border @error('email') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('email') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Mot de passe -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Mot de passe <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password" required 
                   placeholder="••••••••" 
                   class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
            @error('password') 
                <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
            @enderror
        </div>

        <!-- Confirmation Mot de passe -->
        <div>
            <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                Confirmer le mot de passe <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password_confirmation" required 
                   placeholder="••••••••" 
                   class="w-full border border-gray-300 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition">
        </div>

        <!-- Bouton Soumettre -->
        <button type="submit" class="w-full bg-[#0A2E38] hover:bg-[#061e25] text-white font-bold py-2.5 rounded-xl transition shadow-sm uppercase text-xs tracking-wider flex items-center justify-center">
            <i class="fa-solid fa-check mr-2 text-[#C6E900]"></i> S'inscrire
        </button>

        <p class="text-xs text-center text-gray-600 mt-4">
            Déjà un compte ? <a href="{{ route('login') }}" class="text-[#0A2E38] font-bold underline hover:text-[#061e25]">Se connecter</a>
        </p>
    </form>
</div>
@endsection