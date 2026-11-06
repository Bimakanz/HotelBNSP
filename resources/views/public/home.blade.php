@extends('layouts.app')

@section('title', 'The Serenity Palace — Editorial Luxury Boutique Hotel')

@section('content')
<!-- Hero Section Editorial -->
<section class="relative bg-[#1C1B18] text-[#FBF9F5] overflow-hidden min-h-[85vh] flex items-center">
    <!-- Gambar Latar Hero Asli -->
    <div class="absolute inset-0 z-0 opacity-40">
        <img src="{{ asset('assets/rooms/hotel_hero.jpg') }}" 
             alt="The Serenity Palace Architecture" 
             class="w-full h-full object-cover object-center scale-105 transition-transform duration-1000 ease-out">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 py-24 w-full">
        <div class="max-w-3xl space-y-8">
            
            <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-[550] leading-[1.08] tracking-tight" style="font-weight: 550;">
                Keheningan Abadi di Atas Hamparan Perbukitan.
            </h1>

            <p class="text-sm sm:text-base text-[#D8D0C0] font-light leading-relaxed max-w-xl">
                Didesain dengan pendekatan arsitektur tropis minimalis, menghadirkan harmoni sempurna antara kemewahan yang tenang, panorama alam tak berbatas, dan sentuhan budaya Nusantara.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center space-y-4 sm:space-y-0 sm:space-x-5">
                <a href="{{ route('booking.form') }}" class="btn-push-3d text-center">
                    Mulai Reservasi Kamar
                </a>
                <a href="{{ route('public.rooms') }}" class="btn-swipe-fill text-center">
                    <span>Jelajahi 3 Tipe Kamar</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filosofi & Narasi Editorial -->
<section class="py-24 max-w-7xl mx-auto px-6 lg:px-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-5 space-y-6">
            <span class="text-xs uppercase tracking-[0.25em] text-[#6E6A5F] block font-medium">Suaka Relaksasi</span>
            <h2 class="font-serif text-3xl sm:text-4xl text-[#1C1B18] leading-tight font-normal">
                Kenyamanan Tanpa Kompromi, Kemewahan yang Teduh.
            </h2>
            <div class="w-12 h-[1px] bg-[#9E7B56]"></div>
            <p class="text-sm text-[#6E6A5F] leading-relaxed">
                Di The Serenity Palace, setiap sudut dirancang untuk meredakan kepenatan jiwa. Kami menghadirkan tiga kurasi tipe kamar eksklusif dengan kelengkapan fasilitas mutakhir, pemandangan alami yang lapang, serta pengalaman menginap berkesan.
            </p>
            <div class="pt-2">
                <a href="{{ route('public.about') }}" class="text-xs uppercase tracking-widest font-semibold text-[#1C1B18] hover:text-[#9E7B56] inline-flex items-center space-x-2 transition-colors">
                    <span>Pelajari Lebih Lanjut Profil Hotel</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="border border-[#E7E1D4] p-8 bg-[#F5F1E9] space-y-4">
                <span class="font-serif text-3xl text-[#9E7B56]">01.</span>
                <h4 class="font-serif text-xl text-[#1C1B18]">Pemandangan Tropis Alami</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    Setiap kamar memiliki orientasi jendela ke lanskap taman hijau dan cakrawala lembah berkabut.
                </p>
            </div>
            <div class="border border-[#E7E1D4] p-8 bg-white space-y-4">
                <span class="font-serif text-3xl text-[#9E7B56]">02.</span>
                <h4 class="font-serif text-xl text-[#1C1B18]">Pratinjau Video Sinematik</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    Saksikan video tur kamar beresolusi tinggi sebelum Anda menentukan pilihan terbaik untuk istirahat Anda.
                </p>
            </div>
            <div class="border border-[#E7E1D4] p-8 bg-white space-y-4">
                <span class="font-serif text-3xl text-[#9E7B56]">03.</span>
                <h4 class="font-serif text-xl text-[#1C1B18]">Diskon Masa Inap Panjang</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    Nikmati diskon istimewa sebesar 10% untuk masa menginap lebih dari 3 hari secara otomatis saat reservasi.
                </p>
            </div>
            <div class="border border-[#E7E1D4] p-8 bg-[#F5F1E9] space-y-4">
                <span class="font-serif text-3xl text-[#9E7B56]">04.</span>
                <h4 class="font-serif text-xl text-[#1C1B18]">Layanan Sarapan Pilihan</h4>
                <p class="text-xs text-[#6E6A5F] leading-relaxed">
                    Pilihan sarapan organik segar disajikan hangat setiap pagi dengan penambahan flat Rp 80.000.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Produk Kamar Unggulan (3 Tipe Kamar Skenario BNSP) -->
<section class="py-20 bg-[#F5F1E9] border-y border-[#E7E1D4]">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div class="space-y-3">
                <span class="text-xs uppercase tracking-[0.25em] text-[#6E6A5F]">Pilihan Akomodasi</span>
                <h2 class="font-serif text-3xl sm:text-5xl text-[#1C1B18]">3 Tipe Kamar Eksklusif</h2>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('public.rooms') }}" class="btn-luxury-outline text-xs py-3 px-6">
                    Lihat Galeri & Detail Lengkap &rarr;
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($rooms as $room)
                <div class="luxury-card flex flex-col justify-between group">
                    <div>
                        <!-- Foto Kamar -->
                        <div class="relative overflow-hidden aspect-[4/3] bg-[#E7E1D4]">
                            <img src="{{ asset($room->image_url) }}" 
                                 alt="{{ $room->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            <div class="absolute top-4 left-4 bg-[#1C1B18]/85 text-white text-[11px] uppercase tracking-wider px-3 py-1 font-medium">
                                {{ $room->code }}
                            </div>
                        </div>

                        <!-- Konten Kamar -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-baseline justify-between">
                                <h3 class="font-serif text-2xl text-[#1C1B18]">{{ $room->name }}</h3>
                                <div class="text-right">
                                    <span class="text-xs text-[#6E6A5F] block">Mulai dari</span>
                                    <span class="font-serif text-xl font-medium text-[#9E7B56] tabular-nums">{{ $room->formatted_price }}</span>
                                    <span class="text-[10px] text-[#6E6A5F]">/ malam</span>
                                </div>
                            </div>

                            <p class="text-xs text-[#6E6A5F] line-clamp-3 leading-relaxed">
                                {{ $room->description }}
                            </p>

                            <!-- Spesifikasi Singkat -->
                            <div class="pt-3 border-t border-[#E7E1D4] grid grid-cols-2 gap-2 text-xs text-[#6E6A5F]">
                                <div><span class="text-[#1C1B18] font-medium">Kapasitas:</span> {{ $room->capacity }} Tamu</div>
                                <div><span class="text-[#1C1B18] font-medium">Ukuran:</span> {{ $room->size }}</div>
                                <div class="col-span-2"><span class="text-[#1C1B18] font-medium">Ranjang:</span> {{ $room->bed_type }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi: Video & Pesan -->
                    <div class="p-6 pt-0 space-y-2">
                        <button type="button" 
                                onclick="openVideoModal('{{ asset($room->video_url) }}', '{{ $room->name }}')"
                                class="w-full btn-swipe-fill-dark text-xs py-2.5 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4 text-[#9E7B56]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                            <span>Tonton Video Preview</span>
                        </button>

                        <a href="{{ route('booking.form', ['room_id' => $room->id]) }}" 
                           class="w-full btn-luxury text-xs py-2.5 text-center block">
                            Pesan Kamar Ini
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-24 max-w-7xl mx-auto px-6 lg:px-12 text-center">
    <div class="max-w-2xl mx-auto space-y-6">
        <span class="text-xs uppercase tracking-[0.3em] text-[#9E7B56]">Pengalaman Istimewa Menanti Anda</span>
        <h2 class="font-serif text-3xl sm:text-5xl text-[#1C1B18] font-normal leading-tight">
            Rencanakan Waktu Liburan Terbaik Anda Bersama Kami
        </h2>
        <p class="text-sm text-[#6E6A5F] font-light leading-relaxed">
            Pesan kamar sekarang dengan sistem kalkulasi instan. Nikmati diskon otomatis 10% untuk pemesanan menginap lebih dari 3 hari.
        </p>
        <div class="pt-4">
            <a href="{{ route('booking.form') }}" class="btn-luxury text-xs py-4 px-10">
                Buka Formulir Pemesanan Kamar &rarr;
            </a>
        </div>
    </div>
</section>
@endsection

