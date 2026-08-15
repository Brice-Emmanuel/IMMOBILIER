<!DOCTYPE html>
<html lang="fr" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Gestion Immobilière') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#E3E8EC] font-sans text-slate-800 antialiased min-h-screen flex flex-col md:flex-row">

    @auth
    <!-- Overlay Mobile quand la Sidebar est ouverte -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black/50 md:hidden"></div>

    <!-- Header Mobile (Bouton Burger + Logo) -->
    <header class="bg-[#0A2E38] text-white p-4 flex justify-between items-center md:hidden sticky top-0 z-30 shadow-md">
        <div class="flex items-center space-x-3">
            <span class="bg-[#C6E900] text-[#0A2E38] font-black text-lg px-2 py-0.5 rounded">GI</span>
            <span class="font-bold text-base tracking-wide uppercase">ImmoGestion</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-white p-2 rounded-lg focus:outline-none hover:bg-[#061e25]">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </header>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A2E38] text-white flex flex-col justify-between transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:min-h-screen shadow-xl">
        
        <div>
            <!-- Branding -->
            <div class="p-5 flex items-center justify-between border-b border-gray-700/60">
                <div class="flex items-center space-x-3">
                    <span class="bg-[#C6E900] text-[#0A2E38] font-black text-xl px-2.5 py-1 rounded">GI</span>
                    <a href="{{ route('dashboard') }}" class="font-bold text-lg tracking-wide uppercase">ImmoGestion</a>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Profil connecté -->
            <div class="px-5 py-4 border-b border-gray-700/40 bg-[#061e25]/50 flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-[#C6E900] text-[#0A2E38] font-bold flex items-center justify-center text-sm uppercase">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs text-gray-400">Espace d'administration</p>
                    <p class="text-sm font-bold truncate text-white">Gestionnaire</p>
                </div>
            </div>

            <!-- Menu de Navigation avec icônes -->
            <nav class="p-4 space-y-1 text-xs font-semibold uppercase tracking-wider">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-[#C6E900] text-[#0A2E38] font-bold shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('batiments.index') }}" 
                   class="flex items-center space-x-3 px-3 py-3 rounded-xl transition {{ request()->routeIs('batiments.*') ? 'bg-[#C6E900] text-[#0A2E38] font-bold shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-city text-base w-5 text-center"></i>
                    <span>Bâtiments</span>
                </a>

                <a href="{{ route('logements.index') }}" 
                   class="flex items-center space-x-3 px-3 py-3 rounded-xl transition {{ request()->routeIs('logements.*') ? 'bg-[#C6E900] text-[#0A2E38] font-bold shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-door-open text-base w-5 text-center"></i>
                    <span>Logements</span>
                </a>

                <a href="{{ route('locataires.index') }}" 
                   class="flex items-center space-x-3 px-3 py-3 rounded-xl transition {{ request()->routeIs('locataires.*') ? 'bg-[#C6E900] text-[#0A2E38] font-bold shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-users text-base w-5 text-center"></i>
                    <span>Locataires</span>
                </a>

                <a href="{{ route('paiements.index') }}" 
                   class="flex items-center space-x-3 px-3 py-3 rounded-xl transition {{ request()->routeIs('paiements.*') ? 'bg-[#C6E900] text-[#0A2E38] font-bold shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-wallet text-base w-5 text-center"></i>
                    <span>Paiements</span>
                </a>

                <a href="{{ route('depenses.index') }}" 
                   class="flex items-center space-x-3 px-3 py-3 rounded-xl transition {{ request()->routeIs('depenses.*') ? 'bg-[#C6E900] text-[#0A2E38] font-bold shadow-md' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-receipt text-base w-5 text-center"></i>
                    <span>Dépenses</span>
                </a>
            </nav>
        </div>

        <!-- Déconnexion -->
        <div class="p-4 border-t border-gray-700/60">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white px-4 py-2.5 rounded-xl text-xs font-bold transition uppercase">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <main class="flex-grow p-4 md:p-8 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="bg-emerald-500 text-white font-medium p-4 rounded-xl shadow-md mb-6 flex items-center justify-between">
                    <span><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer / Signature -->
        <footer class="mt-auto py-5 px-4 border-t border-gray-300/40">
            <div class="max-w-7xl mx-auto text-center text-xs text-gray-500 font-normal">
                Créé et développé par <span class="font-bold text-sm text-[#0A2E38] ml-1">Emmanuel NYAMSI</span>
            </div>
        </footer>
    </div>

</body>
</html>