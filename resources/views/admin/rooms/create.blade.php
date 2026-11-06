@extends('layouts.admin')

@section('title', 'Tambah Master Kamar')
@section('header-title', 'Tambah Tipe Kamar Baru')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="border border-[#E7E1D4] bg-white p-8">
        <div class="border-b border-[#E7E1D4] pb-4 mb-6">
            <h3 class="font-serif text-2xl text-[#1C1B18]">Informasi Master Kamar</h3>
            <p class="text-xs text-[#6E6A5F]">Isi detail tipe kamar, tarif, kapasitas, foto, dan preview video.</p>
        </div>

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kode Kamar -->
                <div class="space-y-1">
                    <label for="code" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Kode Kamar <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required placeholder="Contoh: EXE-04" class="input-editorial font-mono">
                </div>

                <!-- Nama Kamar -->
                <div class="space-y-1">
                    <label for="name" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Nama Tipe Kamar <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Presidential Suite" class="input-editorial">
                </div>
            </div>

            <!-- Tagline -->
            <div class="space-y-1">
                <label for="tagline" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Tagline / Subjudul Kamar
                </label>
                <input type="text" id="tagline" name="tagline" value="{{ old('tagline') }}" placeholder="Contoh: Panoramic Valley & Private Jacuzzi" class="input-editorial">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Harga -->
                <div class="space-y-1">
                    <label for="price" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Harga per Malam (Rp) <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price', 500000) }}" required min="0" step="1000" class="input-editorial font-mono">
                </div>

                <!-- Kapasitas -->
                <div class="space-y-1">
                    <label for="capacity" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Kapasitas Tamu <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', 2) }}" required min="1" class="input-editorial">
                </div>

                <!-- Ukuran -->
                <div class="space-y-1">
                    <label for="size" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Ukuran Kamar <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="size" name="size" value="{{ old('size', '45 m²') }}" required class="input-editorial">
                </div>
            </div>

            <!-- Tipe Ranjang -->
            <div class="space-y-1">
                <label for="bed_type" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Tipe Ranjang <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="bed_type" name="bed_type" value="{{ old('bed_type', '1 King Bed') }}" required class="input-editorial">
            </div>

            <!-- Deskripsi -->
            <div class="space-y-1">
                <label for="description" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Deskripsi Lengkap Kamar <span class="text-rose-600">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required class="input-editorial">{{ old('description') }}</textarea>
            </div>

            <!-- Fasilitas -->
            <div class="space-y-1">
                <label for="facilities" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Daftar Fasilitas (Pisahkan dengan baris baru atau koma)
                </label>
                <textarea id="facilities" name="facilities" rows="3" placeholder="Wi-Fi Cepat, Smart TV 55 inci, Bathtub Marmer, Safe Box" class="input-editorial">{{ old('facilities') }}</textarea>
            </div>

            <!-- Media: Foto & Video Preview -->
            <div class="border-t border-[#E7E1D4] pt-6 space-y-4">
                <h4 class="text-xs uppercase tracking-wider font-semibold text-[#9E7B56]">Media Promosi Kamar (Foto & Video)</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- URL Foto -->
                    <div class="space-y-1">
                        <label for="image_url" class="text-xs text-[#1C1B18]">URL atau Path Foto</label>
                        <input type="text" id="image_url" name="image_url" value="{{ old('image_url', '/assets/rooms/standar.jpg') }}" class="input-editorial text-xs font-mono">
                    </div>

                    <!-- Upload Foto -->
                    <div class="space-y-1">
                        <label for="image_file" class="text-xs text-[#1C1B18]">Atau Unggah File Foto</label>
                        <input type="file" id="image_file" name="image_file" accept="image/*" class="input-editorial text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- URL Video Preview -->
                    <div class="space-y-1">
                        <label for="video_url" class="text-xs text-[#1C1B18]">URL atau Path Video Preview MP4</label>
                        <input type="text" id="video_url" name="video_url" value="{{ old('video_url', '/assets/rooms/preview_standar.mp4') }}" class="input-editorial text-xs font-mono">
                    </div>

                    <!-- Upload Video -->
                    <div class="space-y-1">
                        <label for="video_file" class="text-xs text-[#1C1B18]">Atau Unggah File Video MP4</label>
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm" class="input-editorial text-xs">
                    </div>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="pt-2">
                <label class="inline-flex items-center space-x-2 text-xs text-[#1C1B18] cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="text-[#9E7B56] focus:ring-[#9E7B56]">
                    <span>Aktifkan dan tampilkan di katalog publik</span>
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div class="border-t border-[#E7E1D4] pt-6 flex items-center space-x-4">
                <button type="submit" class="btn-luxury text-xs py-3 px-8">
                    Simpan Master Kamar
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-luxury-outline text-xs py-3 px-6">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

