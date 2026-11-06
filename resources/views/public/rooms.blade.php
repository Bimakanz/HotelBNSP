@extends('layouts.app')

@section('title', 'Katalog Produk Kamar — The Serenity Palace')

@section('content')
<!-- Header Halaman Produk Kamar -->
<section class="border-b border-[#E7E1D4] bg-[#F5F1E9] py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="max-w-2xl space-y-4">
            <h1 class="font-serif text-4xl sm:text-5xl text-[#1C1B18] font-normal tracking-tight">
                Koleksi Kamar & Suaka Privasi
            </h1>
            <p class="text-sm text-[#6E6A5F] leading-relaxed">
                Tersedia 3 pilihan tipe kamar yang dirancang secara cermat: Standar, Deluxe, dan Family. Setiap tipe kamar dilengkapi dengan galeri foto mendetail serta video preview sinematik.
            </p>
        </div>
    </div>
</section>

<!-- Konten Utama: 3 Tipe Kamar dengan Galeri Foto & Video Preview -->
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-16 space-y-24">
    @foreach($rooms as $index => $room)
        <article class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center {{ $index % 2 === 1 ? 'lg:flex-row-reverse' : '' }}">
            
            <!-- Kolom Visual (Foto & Video Preview Player) -->
            <div class="lg:col-span-7 space-y-4 {{ $index % 2 === 1 ? 'lg:order-2' : '' }}">
                <!-- Foto Utama -->
                <div class="relative overflow-hidden aspect-[16/10] bg-[#E7E1D4] border border-[#E7E1D4] group">
                    <img src="{{ asset($room->image_url) }}" 
                         alt="{{ $room->name }}" 
                         id="main-img-{{ $room->id }}"
                         class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                    
                    <div class="absolute top-4 left-4 bg-[#1C1B18]/90 text-white text-xs uppercase tracking-widest px-3 py-1 font-medium">
                        Tipe: {{ $room->name }}
                    </div>

                    <!-- Overlay Tombol Putar Video Preview -->
                    <button type="button" 
                            onclick="openVideoModal('{{ asset($room->video_url) }}', '{{ $room->name }}')"
                            class="absolute inset-0 flex items-center justify-center bg-black/25 hover:bg-black/40 transition-colors group-hover:scale-100">
                        <div class="w-16 h-16 rounded-full bg-white/90 text-[#1C1B18] flex items-center justify-center shadow-lg transition-transform hover:scale-110">
                            <svg class="w-6 h-6 text-[#9E7B56] ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </div>
                    </button>
                </div>

                <!-- Galeri Foto Tambahan & Pemutar Video Inline Cepat -->
                <div class="grid grid-cols-4 gap-3">
                    @if(!empty($room->gallery) && is_array($room->gallery))
                        @foreach($room->gallery as $galleryImg)
                            <div class="cursor-pointer border border-[#E7E1D4] aspect-video overflow-hidden hover:border-[#9E7B56]"
                                 onclick="document.getElementById('main-img-{{ $room->id }}').src = '{{ asset($galleryImg) }}'">
                                <img src="{{ asset($galleryImg) }}" alt="{{ $room->name }} angle" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    @endif
                    
                    <!-- Thumbnail Video Preview Langsung -->
                    <div class="cursor-pointer border border-[#9E7B56] bg-[#1C1B18] aspect-video flex flex-col items-center justify-center text-center p-2 text-white hover:bg-[#9E7B56] transition-colors"
                         onclick="openVideoModal('{{ asset($room->video_url) }}', '{{ $room->name }}')">
                        <svg class="w-5 h-5 text-amber-300 mb-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                        <span class="text-[9px] uppercase tracking-wider font-semibold">Video Tour</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Deskripsi & Spesifikasi Kamar -->
            <div class="lg:col-span-5 space-y-6 {{ $index % 2 === 1 ? 'lg:order-1' : '' }}">
                <div class="space-y-2">
                    <span class="text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">{{ $room->tagline }}</span>
                    <h2 class="font-serif text-3xl sm:text-4xl text-[#1C1B18] font-normal">{{ $room->name }}</h2>
                </div>

                <!-- Nominal Tarif Kamar -->
                <div class="border-y border-[#E7E1D4] py-4 flex items-baseline justify-between">
                    <span class="text-xs uppercase tracking-wider text-[#6E6A5F]">Tarif Dasar per Malam:</span>
                    <div class="text-right">
                        <span class="font-serif text-2xl sm:text-3xl font-medium text-[#1C1B18] tabular-nums">{{ $room->formatted_price }}</span>
                        <span class="text-xs text-[#6E6A5F] block">Termasuk PPN & Biaya Layanan</span>
                    </div>
                </div>

                <p class="text-sm text-[#6E6A5F] leading-relaxed">
                    {{ $room->description }}
                </p>

                <!-- Spesifikasi Teknis -->
                <div class="grid grid-cols-2 gap-4 text-xs bg-[#F5F1E9] p-4 border border-[#E7E1D4]">
                    <div>
                        <span class="text-[#6E6A5F] block">Kapasitas Tamu</span>
                        <span class="font-medium text-[#1C1B18] text-sm">{{ $room->capacity }} Orang Dewasa</span>
                    </div>
                    <div>
                        <span class="text-[#6E6A5F] block">Ukuran Ruangan</span>
                        <span class="font-medium text-[#1C1B18] text-sm">{{ $room->size }}</span>
                    </div>
                    <div class="col-span-2 pt-2 border-t border-[#E7E1D4]">
                        <span class="text-[#6E6A5F] block">Tipe Ranjang</span>
                        <span class="font-medium text-[#1C1B18] text-sm">{{ $room->bed_type }}</span>
                    </div>
                </div>

                <!-- Fasilitas Utama Kamar -->
                @if(!empty($room->facilities) && is_array($room->facilities))
                    <div class="space-y-2">
                        <h4 class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">Fasilitas Termasuk:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-[#6E6A5F]">
                            @foreach($room->facilities as $fac)
                                <div class="flex items-center space-x-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#9E7B56]"></span>
                                    <span>{{ $fac }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Aksi Reservasi & Video -->
                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('booking.form', ['room_id' => $room->id]) }}" 
                       class="btn-luxury text-xs py-3.5 px-8 text-center">
                        Pesan Kamar {{ $room->name }}
                    </a>
                    <button type="button" 
                            onclick="openVideoModal('{{ asset($room->video_url) }}', '{{ $room->name }}')"
                            class="btn-swipe-fill-dark text-xs py-3.5 px-6 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-[#9E7B56]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                        <span>Putar Video Tour</span>
                    </button>
                </div>

            </div>
        </article>
    @endforeach
</div>
@endsection

