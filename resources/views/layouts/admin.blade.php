<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — The Serenity Palace</title>

    <!-- Google Fonts: Poppins (Clean Modern Sans) & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/editorial.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#FBF9F5] text-[#1C1B18] font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar Admin Editorial Luxury -->
    <aside class="w-full md:w-64 bg-[#1C1B18] text-[#FBF9F5] shrink-0 border-r border-[#2C2B27] flex flex-col justify-between">
        <div>
            <!-- Header Brand -->
            <div class="p-6 border-b border-[#2C2B27]">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#9E7B56] block font-medium">Panel Pengelola</span>
                    <span class="font-serif text-xl tracking-wide text-white block mt-1">THE SERENITY PALACE</span>
                </a>
                <div class="mt-3 flex items-center space-x-2 text-xs text-[#8C877D]">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Resepsionis Aktif</span>
                </div>
            </div>

            <!-- Navigasi Menu Admin -->
            <nav class="p-4 space-y-1 text-xs tracking-wider uppercase font-medium">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-none transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#9E7B56] text-white' : 'text-[#A09B90] hover:bg-[#282723] hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Ringkasan Statistik</span>
                </a>

                <a href="{{ route('admin.rooms.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-none transition-colors {{ request()->routeIs('admin.rooms.*') ? 'bg-[#9E7B56] text-white' : 'text-[#A09B90] hover:bg-[#282723] hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Master Kamar (CRUD)</span>
                </a>

                <a href="{{ route('admin.reservations.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-none transition-colors {{ request()->routeIs('admin.reservations.*') ? 'bg-[#9E7B56] text-white' : 'text-[#A09B90] hover:bg-[#282723] hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Data Reservasi</span>
                </a>

                <div class="pt-4 border-t border-[#2C2B27] mt-4">
                    <span class="px-4 text-[10px] uppercase tracking-[0.2em] text-[#6E6A5F] block mb-2">Tautan Eksternal</span>
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center space-x-3 px-4 py-2.5 text-[#A09B90] hover:text-white hover:bg-[#282723] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Halaman Publik Hotel &rarr;</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Footer Sidebar Pengguna -->
        <div class="p-6 border-t border-[#2C2B27]">
            <div class="text-xs text-[#A09B90] mb-3">
                <span class="text-[10px] uppercase text-[#6E6A5F] block">Login sebagai:</span>
                <span class="font-medium text-white">{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full text-center text-xs uppercase tracking-wider py-2 px-3 border border-[#3C3B37] text-[#A09B90] hover:text-white hover:border-[#9E7B56] transition-colors">
                    Keluar Sesi
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama Admin -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Topbar Admin -->
        <header class="h-20 bg-white border-b border-[#E7E1D4] px-8 flex items-center justify-between">
            <h1 class="font-serif text-2xl text-[#1C1B18]">@yield('header-title', 'Dashboard Resepsionis')</h1>
            <div class="flex items-center space-x-4">
                <span class="text-xs text-[#6E6A5F] tabular-nums hidden sm:inline">{{ now()->translatedFormat('l, d F Y') }}</span>
                <a href="{{ route('admin.rooms.create') }}" class="btn-luxury text-xs py-2 px-4">
                    + Tambah Kamar
                </a>
            </div>
        </header>

        <!-- Area Pesan Flash -->
        <div class="px-8 pt-6">
            @if(session('success'))
                <div class="border border-[#9E7B56]/50 bg-[#F5F1E9] text-[#1C1B18] p-4 text-sm flex items-start space-x-3 mb-6">
                    <svg class="w-5 h-5 text-[#9E7B56] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <div class="flex-1 font-light">{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="border border-rose-300 bg-rose-50/70 text-[#1C1B18] p-4 text-sm mb-6">
                    <p class="font-medium text-rose-800 text-xs uppercase tracking-wider mb-2">Terjadi Kesalahan Validasi:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Body Dashboard -->
        <main class="flex-1 px-8 pb-12">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

