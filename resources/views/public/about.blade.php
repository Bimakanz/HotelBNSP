@extends('layouts.app')

@section('title', 'Tentang Kami — The Serenity Palace')

@section('content')
<!-- Header Halaman Tentang Kami -->
<section class="border-b border-[#E7E1D4] bg-[#F5F1E9] py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="max-w-3xl space-y-4">
            <div class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">
                <span>Menu Resmi BNSP</span>
                <span>&bull;</span>
                <span>Profil & Kontak Resmi</span>
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl text-[#1C1B18] font-normal tracking-tight">
                Tentang The Serenity Palace
            </h1>
            <p class="text-sm text-[#6E6A5F] leading-relaxed">
                Mengenal lebih dekat dedikasi kami dalam menghadirkan keanggunan peristirahatan bernuansa alam, keramahan layanan personal, serta informasi kontak resmi hotel.
            </p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-16 space-y-20">

    <!-- Cerita & Profil Singkat Hotel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 space-y-6">
            <span class="text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">Dedikasi Keramahan</span>
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1C1B18] leading-tight">
                Harmoni Tradisi Luhur & Kemewahan Tropis Kontemporer
            </h2>
            <div class="w-12 h-[1px] bg-[#9E7B56]"></div>
            <p class="text-sm text-[#6E6A5F] leading-relaxed">
                Berdiri megah di punggung bukit yang tenang, <strong>The Serenity Palace</strong> didirikan dengan visi menciptakan suaka pelarian dari hiruk-pikuk ritme urban. Terinspirasi oleh konsep ketenangan spiritual Aman Resorts dan kesederhanaan bersahaja Hoshinoya, kami mengutamakan privasi, kenyamanan alami, dan keselarasan ekologis.
            </p>
            <p class="text-sm text-[#6E6A5F] leading-relaxed">
                Kami menyediakan tiga kurasi kamar utama: <em>Standar</em> untuk pelancong pencari ketenangan, <em>Deluxe</em> dengan panorama samudera dan lembah, serta <em>Family Residence</em> untuk kebersamaan keluarga dalam kemewahan ruang yang lapang.
            </p>
        </div>

        <div class="lg:col-span-6">
            <div class="border border-[#E7E1D4] p-3 bg-white">
                <img src="{{ asset('assets/rooms/hotel_about.jpg') }}" 
                     alt="The Serenity Palace Resort" 
                     class="w-full aspect-[4/3] object-cover">
                <div class="p-3 text-center text-xs text-[#6E6A5F] font-serif italic">
                    Paviliun utama The Serenity Palace saat matahari terbit di perbukitan.
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kontak Resmi & Alamat (Wajib Persis Sesuai Skenario BNSP) -->
    <div class="border border-[#E7E1D4] bg-[#F5F1E9] p-8 sm:p-12">
        <div class="max-w-3xl mb-8">
            <span class="text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">Informasi Resmi Perusahaan</span>
            <h3 class="font-serif text-3xl text-[#1C1B18] mt-1">Alamat & Saluran Komunikasi</h3>
            <p class="text-xs text-[#6E6A5F] mt-2">
                Hubungi staf reservasi dan layanan resepsionis kami 24 jam untuk bantuan pemesanan atau pertanyaan fasilitas.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Alamat Lengkap Hotel -->
            <div class="bg-white p-6 border border-[#E7E1D4] space-y-3">
                <div class="w-10 h-10 border border-[#E7E1D4] flex items-center justify-center text-[#9E7B56]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h4 class="font-serif text-lg text-[#1C1B18]">Alamat Lengkap</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    Jl. Nirwana Highland No. 88, Resort Valley, Ciumbuleuit Atas, Bandung, Jawa Barat 40391, Indonesia
                </p>
            </div>

            <!-- Nomor Telepon Resmi -->
            <div class="bg-white p-6 border border-[#E7E1D4] space-y-3">
                <div class="w-10 h-10 border border-[#E7E1D4] flex items-center justify-center text-[#9E7B56]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h4 class="font-serif text-lg text-[#1C1B18]">Nomor Telepon</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    <strong>Hotline Resepsionis:</strong><br>
                    +62 (022) 8765-4321<br>
                    <strong>WhatsApp Layanan Tamu:</strong><br>
                    +62 812-3456-7890
                </p>
            </div>

            <!-- Alamat Email Resmi -->
            <div class="bg-white p-6 border border-[#E7E1D4] space-y-3">
                <div class="w-10 h-10 border border-[#E7E1D4] flex items-center justify-center text-[#9E7B56]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="font-serif text-lg text-[#1C1B18]">Alamat Email</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    <strong>Pemesanan & Reservasi:</strong><br>
                    reservations@serenitypalace.test<br>
                    <strong>Layanan Concierge:</strong><br>
                    concierge@serenitypalace.test
                </p>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-[#E7E1D4] flex flex-col sm:flex-row items-center justify-between text-xs text-[#6E6A5F]">
            <span>Operasional Check-In: 14:00 WIB &bull; Check-Out: 12:00 WIB</span>
            <a href="{{ route('booking.form') }}" class="btn-luxury text-xs py-2.5 px-6 mt-4 sm:mt-0">
                Pesan Kamar Sekarang
            </a>
        </div>
    </div>

</div>
@endsection

