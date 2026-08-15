@extends('layouts.app')

@section('content')
<div class="px-4 py-4 sm:py-8">
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- En-tête -->
        <div class="bg-[#0A2E38] text-white text-center py-6 px-4">
            <h1 class="text-lg sm:text-xl font-bold uppercase tracking-wider flex items-center justify-center">
                <i class="fa-solid fa-right-to-bracket mr-2 text-[#C6E900]"></i> Connexion
            </h1>
            <p class="text-xs text-gray-300 mt-1">Accédez à votre espace gestionnaire</p>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}" class="p-5 sm:p-6 space-y-5">
            @csrf

            <!-- Email ou Téléphone -->
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Email ou Téléphone <span class="text-red-500">*</span>
                </label>
                <input type="text" name="login" value="{{ old('login') }}" required autofocus 
                       placeholder="Ex: 699001122 ou exemple@mail.com" 
                       class="w-full border @error('login') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-3 text-base sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition shadow-sm">
                @error('login') 
                    <span class="text-red-500 text-xs mt-1.5 block flex items-center"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>

            <!-- Mot de passe -->
            <div>
                <label class="block text-xs font-bold uppercase text-gray-700 mb-1.5">
                    Mot de passe <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" required 
                       placeholder="••••••••" 
                       class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-xl px-4 py-3 text-base sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#0A2E38] transition shadow-sm">
                @error('password') 
                    <span class="text-red-500 text-xs mt-1.5 block flex items-center"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>

            <!-- Se souvenir de moi -->
            <div class="flex items-center justify-between py-1">
                <label class="flex items-center cursor-pointer select-none py-1">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-[#0A2E38] focus:ring-[#0A2E38]">
                    <span class="ml-2.5 text-xs sm:text-sm text-gray-600 font-medium">Se souvenir de moi</span>
                </label>
            </div>

            <!-- Bouton Validation Tactile -->
            <button type="submit" class="w-full active:scale-[0.98] bg-[#0A2E38] hover:bg-[#061e25] text-white font-bold py-3.5 rounded-xl transition shadow-md uppercase text-xs tracking-wider flex items-center justify-center">
                <i class="fa-solid fa-arrow-right-to-bracket mr-2 text-[#C6E900]"></i> Se Connecter
            </button>

            <!-- Lien d'inscription -->
            <div class="pt-2 text-center border-t border-gray-100">
                <p class="text-xs sm:text-sm text-gray-600">
                    Pas encore de compte ? 
                    <a href="{{ route('register') }}" class="text-[#0A2E38] font-bold underline hover:text-[#061e25] inline-block py-1">S'inscrire</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection