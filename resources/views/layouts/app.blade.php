<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Serenity Palace') — Editorial Luxury Boutique Hotel</title>

    <!-- Google Fonts: Poppins (Clean Modern Sans) & Plus Jakarta Sans (Clean Interface & Tabular Nums) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS & Styling -->
    <link rel="stylesheet" href="{{ asset('css/editorial.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#FBF9F5] text-[#1C1B18] font-sans antialiased selection:bg-[#9E7B56] selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Header & Navigasi Utama -->
    <header class="border-b border-[#E7E1D4] bg-[#FBF9F5]/90 backdrop-blur-md sticky top-0 z-40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex items-center justify-between h-24">
                
                <!-- Logo & Identitas Brand Hotel -->
                <a href="{{ route('home') }}" class="group flex flex-col items-start focus:outline-none">
                    <span class="text-xs uppercase tracking-[0.3em] text-[#6E6A5F] font-medium transition-colors group-hover:text-[#9E7B56]">Boutique Residence</span>
                    <span class="font-serif text-2xl lg:text-3xl tracking-tight text-[#1C1B18] font-normal">THE SERENITY PALACE</span>
                </a>

                <!-- Navigasi Menu Publik (Skenario Wajib BNSP) -->
                <nav class="hidden md:flex items-center space-x-8 text-xs uppercase tracking-[0.18em] font-medium">
                    <a href="{{ route('home') }}" 
                       class="nav-link-animated {{ request()->routeIs('home') ? 'active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('public.rooms') }}" 
                       class="nav-link-animated {{ request()->routeIs('public.rooms') ? 'active' : '' }}">
                        Produk Kamar
                    </a>
                    <a href="{{ route('public.about') }}" 
                       class="nav-link-animated {{ request()->routeIs('public.about') ? 'active' : '' }}">
                        Tentang Kami
                    </a>
                </nav>

                <!-- Aksi Pengguna & Autentikasi -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="text-xs uppercase tracking-wider font-semibold text-[#9E7B56] hover:text-[#826241] px-3 py-1.5 border border-[#9E7B56]/40 transition-colors">
                                Panel Admin
                            </a>
                        @else
                            <a href="{{ route('guest.my-bookings') }}" 
                               class="text-xs uppercase tracking-wider font-medium text-[#1C1B18] hover:text-[#9E7B56] px-3 py-1.5 border border-[#E7E1D4] transition-colors">
                                Pesanan Saya
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-xs uppercase tracking-wider font-medium text-[#6E6A5F] hover:text-[#1C1B18] transition-colors">
                                Keluar
                            </button>
                        </form>
                    @endauth

                    <a href="{{ route('booking.form') }}" 
                       class="btn-luxury text-xs py-3 px-5 transition-all">
                        Pesan Kamar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Notifikasi Flash Messages -->
    <div class="max-w-7xl mx-auto px-6 lg:px-12 w-full pt-6 no-print">
        @if(session('success'))
            <div class="border border-[#9E7B56]/50 bg-[#F5F1E9] text-[#1C1B18] p-4 text-sm flex items-start space-x-3 mb-6 transition-all">
                <svg class="w-5 h-5 text-[#9E7B56] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                </svg>
                <div class="flex-1 font-light">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="border border-amber-300 bg-amber-50 text-[#1C1B18] p-4 text-sm flex items-start space-x-3 mb-6">
                <svg class="w-5 h-5 text-amber-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="flex-1 font-light">{{ session('warning') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="border border-rose-300 bg-rose-50/70 text-[#1C1B18] p-4 text-sm mb-6">
                <p class="font-medium text-rose-800 text-xs uppercase tracking-wider mb-2">Mohon Periksa Isian Anda:</p>
                <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Konten Utama Halaman -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Video Modal Player -->
    <div id="videoModal" class="fixed inset-0 z-50 bg-[#1C1B18]/80 backdrop-blur-md hidden items-center justify-center p-4 no-print">
        <div class="bg-[#FBF9F5] border border-[#E7E1D4] w-full max-w-4xl overflow-hidden shadow-2xl relative">
            <div class="flex items-center justify-between p-4 border-b border-[#E7E1D4] bg-[#F5F1E9]">
                <div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-[#6E6A5F]">Room Preview Tour</span>
                    <h4 id="videoModalTitle" class="font-serif text-xl text-[#1C1B18]">Video Preview Kamar</h4>
                </div>
                <button type="button" onclick="closeVideoModal()" class="text-[#6E6A5F] hover:text-[#1C1B18] text-2xl leading-none p-2 focus:outline-none">
                    &times;
                </button>
            </div>
            <div class="relative bg-black aspect-video flex items-center justify-center">
                <video id="modalVideoPlayer" controls class="w-full h-full object-contain">
                    <source id="modalVideoSource" src="" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video HTML5.
                </video>
            </div>
            <div class="p-4 bg-[#FBF9F5] text-xs text-[#6E6A5F] flex justify-between items-center border-t border-[#E7E1D4]">
                <span>Pratinjau sinematik kamar hotel.</span>
                <button type="button" onclick="closeVideoModal()" class="btn-luxury-outline text-xs py-2 px-4">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Footer Editorial Hotel -->
    <footer class="border-t border-[#E7E1D4] bg-[#F5F1E9] text-[#1C1B18] pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-12 border-b border-[#E7E1D4]">
                
                <!-- Kolom 1: Brand & Slogan -->
                <div class="md:col-span-1 space-y-4">
                    <span class="text-xs uppercase tracking-[0.3em] text-[#6E6A5F]">Boutique Residence</span>
                    <h3 class="font-serif text-2xl text-[#1C1B18]">THE SERENITY PALACE</h3>
                    <p class="text-xs text-[#6E6A5F] leading-relaxed">
                        Suaka ketenangan di dataran tinggi, memadukan keindahan arsitektur tropis kontemporer, keramahan tradisi luhur, dan keteduhan alam semesta.
                    </p>
                </div>

                <!-- Kolom 2: Navigasi Cepat -->
                <div class="space-y-3">
                    <h4 class="text-xs uppercase tracking-[0.2em] font-semibold text-[#1C1B18]">Eksplorasi</h4>
                    <ul class="space-y-2 text-xs text-[#6E6A5F]">
                        <li><a href="{{ route('public.rooms') }}" class="hover:text-[#9E7B56] transition-colors">Produk Kamar (3 Tipe)</a></li>
                        <li><a href="{{ route('public.about') }}" class="hover:text-[#9E7B56] transition-colors">Tentang Profil Hotel</a></li>
                        <li><a href="{{ route('booking.form') }}" class="hover:text-[#9E7B56] transition-colors">Formulir Pesan Kamar</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak & Alamat Resmi (Skenario BNSP) -->
                <div class="space-y-3">
                    <h4 class="text-xs uppercase tracking-[0.2em] font-semibold text-[#1C1B18]">Kontak Resmi</h4>
                    <p class="text-xs text-[#6E6A5F] leading-relaxed">
                        <strong>Alamat:</strong><br>
                        Jl. Nirwana Highland No. 88, Resort Valley, Bandung, Jawa Barat 40391
                    </p>
                    <p class="text-xs text-[#6E6A5F]">
                        <strong>Telepon:</strong><br>
                        +62 (022) 8765-4321 / +62 812-3456-7890
                    </p>
                    <p class="text-xs text-[#6E6A5F]">
                        <strong>Email:</strong><br>
                        reservations@serenitypalace.test
                    </p>
                </div>

            </div>

            <!-- Baris Hak Cipta -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-[#6E6A5F]">
                <div>
                    &copy; {{ date('Y') }} The Serenity Palace Hotel & Resort. Seluruh hak cipta dilindungi.
                </div>
                <div class="mt-4 sm:mt-0 space-x-6 text-[11px]">
                    <span class="tabular-nums">Standards Compliant: BNSP LSP Informatika 2026</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Video Modal Helper Script -->
    <script>
        /**
         * Deskripsi: Menampilkan modal pemutar video preview kamar hotel.
         * Initial State: Modal video tersembunyi.
         * Final State: Modal terbuka dan video memuat file sumber yang diberikan.
         * Author: Bima Garda Nusantara (BNSP Asesi)
         * Version / Date: 1.0.0 / 02 November 2026
         * 
         * @param {string} videoUrl Path file video kamar
         * @param {string} title Nama kamar
         */
        function openVideoModal(videoUrl, title) {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('modalVideoPlayer');
            const source = document.getElementById('modalVideoSource');
            const titleElem = document.getElementById('videoModalTitle');

            titleElem.textContent = 'Preview Video — ' + title;
            source.src = videoUrl;
            video.load();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            video.play().catch(e => console.log('Autoplay prevented by browser:', e));
        }

        /**
         * Deskripsi: Menutup modal pemutar video dan menghentikan pemutaran audio/video.
         * Initial State: Modal video terbuka.
         * Final State: Video dihentikan dan modal disembunyikan.
         * Author: Bima Garda Nusantara (BNSP Asesi)
         * Version / Date: 1.0.0 / 02 November 2026
         */
        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('modalVideoPlayer');

            video.pause();
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Tutup modal jika user menekan tombol Escape di keyboard
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeVideoModal();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

