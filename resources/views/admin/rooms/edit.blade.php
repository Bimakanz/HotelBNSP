@extends('layouts.admin')

@section('title', 'Ubah Master Kamar')
@section('header-title', 'Perbarui Data Tipe Kamar: ' . $room->name)

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="border border-[#E7E1D4] bg-white p-8">
        <div class="border-b border-[#E7E1D4] pb-4 mb-6 flex justify-between items-center">
            <div>
                <h3 class="font-serif text-2xl text-[#1C1B18]">Ubah Master Kamar</h3>
                <p class="text-xs text-[#6E6A5F]">Perbarui parameter tarif, kapasitas, media promosi, dan deskripsi.</p>
            </div>
            <span class="font-mono text-xs px-2 py-1 bg-[#F5F1E9] border border-[#E7E1D4] text-[#1C1B18]">
                ID #{{ $room->id }}
            </span>
        </div>

        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kode Kamar -->
                <div class="space-y-1">
                    <label for="code" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Kode Kamar <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="code" name="code" value="{{ old('code', $room->code) }}" required class="input-editorial font-mono">
                </div>

                <!-- Nama Kamar -->
                <div class="space-y-1">
                    <label for="name" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Nama Tipe Kamar <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $room->name) }}" required class="input-editorial">
                </div>
            </div>

            <!-- Tagline -->
            <div class="space-y-1">
                <label for="tagline" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Tagline / Subjudul Kamar
                </label>
                <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $room->tagline) }}" class="input-editorial">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Harga -->
                <div class="space-y-1">
                    <label for="price" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Harga per Malam (Rp) <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price', (int)$room->price) }}" required min="0" step="1000" class="input-editorial font-mono">
                </div>

                <!-- Kapasitas -->
                <div class="space-y-1">
                    <label for="capacity" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Kapasitas Tamu <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" required min="1" class="input-editorial">
                </div>

                <!-- Ukuran -->
                <div class="space-y-1">
                    <label for="size" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Ukuran Kamar <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="size" name="size" value="{{ old('size', $room->size) }}" required class="input-editorial">
                </div>
            </div>

            <!-- Tipe Ranjang -->
            <div class="space-y-1">
                <label for="bed_type" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Tipe Ranjang <span class="text-rose-600">*</span>
                </label>
                <input type="text" id="bed_type" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}" required class="input-editorial">
            </div>

            <!-- Deskripsi -->
            <div class="space-y-1">
                <label for="description" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Deskripsi Lengkap Kamar <span class="text-rose-600">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required class="input-editorial">{{ old('description', $room->description) }}</textarea>
            </div>

            <!-- Fasilitas -->
            <div class="space-y-1">
                <label for="facilities" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Daftar Fasilitas (Pisahkan dengan baris baru atau koma)
                </label>
                <textarea id="facilities" name="facilities" rows="3" class="input-editorial">{{ old('facilities', is_array($room->facilities) ? implode("\n", $room->facilities) : $room->facilities) }}</textarea>
            </div>

            <!-- Media: Foto & Video Preview -->
            <div class="border-t border-[#E7E1D4] pt-6 space-y-4">
                <h4 class="text-xs uppercase tracking-wider font-semibold text-[#9E7B56]">Media Promosi Kamar (Foto & Video)</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- URL Foto -->
                    <div class="space-y-1">
                        <label for="image_url" class="text-xs text-[#1C1B18]">URL atau Path Foto</label>
                        <input type="text" id="image_url" name="image_url" value="{{ old('image_url', $room->image_url) }}" class="input-editorial text-xs font-mono">
                    </div>

                    <!-- Upload Foto -->
                    <div class="space-y-1">
                        <label for="image_file" class="text-xs text-[#1C1B18]">Ganti File Foto (Opsional)</label>
                        <input type="file" id="image_file" name="image_file" accept="image/*" class="input-editorial text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- URL Video Preview -->
                    <div class="space-y-1">
                        <label for="video_url" class="text-xs text-[#1C1B18]">URL atau Path Video Preview MP4</label>
                        <input type="text" id="video_url" name="video_url" value="{{ old('video_url', $room->video_url) }}" class="input-editorial text-xs font-mono">
                    </div>

                    <!-- Upload Video -->
                    <div class="space-y-1">
                        <label for="video_file" class="text-xs text-[#1C1B18]">Ganti File Video MP4 (Opsional)</label>
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm" class="input-editorial text-xs">
                    </div>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="pt-2">
                <label class="inline-flex items-center space-x-2 text-xs text-[#1C1B18] cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }} class="text-[#9E7B56] focus:ring-[#9E7B56]">
                    <span>Kamar Aktif (Dapat dipilih tamu pada formulir reservasi)</span>
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div class="border-t border-[#E7E1D4] pt-6 flex items-center space-x-4">
                <button type="submit" class="btn-luxury text-xs py-3 px-8">
                    Perbarui Data Kamar
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="btn-luxury-outline text-xs py-3 px-6">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

