@extends('layouts.app')

@section('title', 'Formulir Pemesanan Kamar — The Serenity Palace')

@section('content')
<!-- Header Halaman Form Pemesanan -->
<section class="border-b border-[#E7E1D4] bg-[#F5F1E9] py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="max-w-3xl space-y-3">
            <div class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">
                <span>Dokumen Reservasi Resmi</span>
                <span>&bull;</span>
                <span>BNSP LSP Informatika</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl text-[#1C1B18] font-normal tracking-tight">
                Pemesanan Kamar & Reservasi
            </h1>
            <p class="text-xs sm:text-sm text-[#6E6A5F] leading-relaxed">
                Silakan lengkapi formulir di bawah ini dengan data yang akurat. Gunakan tombol <strong>Hitung Total Bayar</strong> untuk melihat kalkulasi biaya secara langsung sebelum menyimpan data reservasi Anda.
            </p>
        </div>
    </div>
</section>

<!-- Kontainer Utama: 2 Kolom (Formulir di Kiri & Rincian Estimasi Biaya di Kanan) -->
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- KOLOM KIRI: FORMULIR PEMESANAN (COL-SPAN-7) -->
        <div class="lg:col-span-7 border border-[#E7E1D4] bg-white p-8 sm:p-10 shadow-sm relative">
            
            <div class="border-b border-[#E7E1D4] pb-5 mb-8 flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-2xl text-[#1C1B18]">Form Pemesanan</h2>
                </div>
            </div>

            <!-- Formulir Pemesanan Kamar Hotel -->
            <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" novalidate onsubmit="return validateAndSubmitForm(event)">
                @csrf

                <!-- Notifikasi Error Validasi Server (jika ada) -->
                @if ($errors->any())
                    <div id="serverErrorBox" class="border border-rose-300 bg-rose-50 p-4 mb-6 text-xs text-rose-800">
                        <p class="font-semibold uppercase tracking-wider mb-1">Periksa Kesalahan Isian Data:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-8">

                    <!-- SEKSI 1: IDENTITAS PEMESAN -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 border-b border-[#F5F1E9] pb-2">
                            <span class="text-xs uppercase tracking-wider font-bold text-[#9E7B56]">A.</span>
                            <h3 class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">Identitas Tamu Pemesan</h3>
                        </div>

                        <!-- 1. Nama Pemesan -->
                        <div class="space-y-1.5">
                            <label for="customer_name" class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                Nama Pemesan <span class="text-rose-600">*</span>
                            </label>
                            <input type="text" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name', auth()->check() ? auth()->user()->name : '') }}" 
                                   required
                                   placeholder="Contoh: Andri Santosa"
                                   oninput="updateReceiptCustomerName()"
                                   class="input-editorial @error('customer_name') border-rose-500 @enderror">
                            @error('customer_name')
                                <p class="text-xs text-rose-600 mt-1 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 2. Jenis Kelamin (Radio Button: Laki-laki / Perempuan) -->
                        <div class="space-y-1.5 pt-2">
                            <label class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                Jenis Kelamin <span class="text-rose-600">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="border border-[#E7E1D4] p-3 flex items-center space-x-3 cursor-pointer hover:border-[#9E7B56] transition-colors bg-[#FBF9F5]">
                                    <input type="radio" 
                                           name="gender" 
                                           value="Laki-laki" 
                                           {{ old('gender', 'Laki-laki') === 'Laki-laki' ? 'checked' : '' }}
                                           onchange="updateReceiptCustomerName()"
                                           class="text-[#9E7B56] focus:ring-[#9E7B56] h-4 w-4">
                                    <span class="text-xs font-medium text-[#1C1B18]">Laki-laki</span>
                                </label>
                                <label class="border border-[#E7E1D4] p-3 flex items-center space-x-3 cursor-pointer hover:border-[#9E7B56] transition-colors bg-[#FBF9F5]">
                                    <input type="radio" 
                                           name="gender" 
                                           value="Perempuan" 
                                           {{ old('gender') === 'Perempuan' ? 'checked' : '' }}
                                           onchange="updateReceiptCustomerName()"
                                           class="text-[#9E7B56] focus:ring-[#9E7B56] h-4 w-4">
                                    <span class="text-xs font-medium text-[#1C1B18]">Perempuan</span>
                                </label>
                            </div>
                            @error('gender')
                                <p class="text-xs text-rose-600 block mt-1 font-light">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 3. Nomor Identitas (Wajib tepat 16 digit angka) -->
                        <div class="space-y-1.5 pt-2">
                            <div class="flex items-center justify-between">
                                <label for="identity_number" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                    Nomor Identitas (NIK) <span class="text-rose-600">*</span>
                                </label>
                                <span class="text-[10px] text-[#6E6A5F] font-mono"><span id="idCharCount">{{ strlen(old('identity_number', '')) }}</span> / 16 Digit</span>
                            </div>
                            <input type="text" 
                                   id="identity_number" 
                                   name="identity_number" 
                                   maxlength="16"
                                   value="{{ old('identity_number', '') }}" 
                                   required
                                   placeholder="Contoh: 3275091210770004"
                                   oninput="validateIdentityNumber(true)"
                                   class="input-editorial font-mono tracking-wider @error('identity_number') border-rose-500 @enderror">
                            
                            <!-- Pesan Error Wajib Persis Skenario BNSP: "isian salah..data harus 16 digit" -->
                            <div id="identityError" class="text-xs text-rose-600 mt-1 font-medium {{ $errors->has('identity_number') ? '' : 'hidden' }}">
                                {{ $errors->first('identity_number') ?: 'isian salah..data harus 16 digit' }}
                            </div>
                            <p class="text-[11px] text-[#6E6A5F] mt-1 font-light">Wajib tepat 16 digit angka sesuai identitas KTP / NIK resmi.</p>
                        </div>
                    </div>

                    <!-- SEKSI 2: KONFIGURASI KAMAR & MASA INAP -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-2 border-b border-[#F5F1E9] pb-2">
                            <span class="text-xs uppercase tracking-wider font-bold text-[#9E7B56]">B.</span>
                            <h3 class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">Pilihan Tipe Kamar & Durasi</h3>
                        </div>

                        <!-- Baris 1: Tipe Kamar & Durasi Menginap (2 Grid) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- 4. Tipe Kamar (Dropdown Pilihan Kamar Sesuai Aturan BNSP) -->
                            <div class="space-y-1.5">
                                <label for="room_id" class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                    Tipe Kamar <span class="text-rose-600">*</span>
                                </label>
                                <div class="relative flex items-center group">
                                    <div class="absolute left-3.5 pointer-events-none text-[#9E7B56] transition-colors group-focus-within:text-[#1C1B18]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7v11m0-4h18m0-7v11M3 10h18M7 10V7a1 1 0 011-1h8a1 1 0 011 1v3"/>
                                        </svg>
                                    </div>
                                    <select id="room_id" 
                                            name="room_id" 
                                            required
                                            onchange="updateRoomPrice();"
                                            class="w-full bg-white border border-[#E7E1D4] pl-10 pr-10 py-3 text-sm font-semibold text-[#1C1B18] appearance-none cursor-pointer focus:outline-none focus:border-[#9E7B56] hover:border-[#9E7B56] transition-all shadow-sm">
                                        @foreach($rooms as $r)
                                            <option value="{{ $r->id }}" 
                                                    data-price="{{ $r->price }}"
                                                    data-name="{{ $r->name }}"
                                                    data-image="{{ asset($r->image_url) }}"
                                                    data-tagline="{{ $r->tagline }}"
                                                    data-capacity="{{ $r->capacity }}"
                                                    data-bed="{{ $r->bed_type }}"
                                                    class="py-2 font-normal text-[#1C1B18] bg-white"
                                                    {{ (old('room_id', $selectedRoom->id ?? '') == $r->id) ? 'selected' : '' }}>
                                                Kamar {{ $r->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-3.5 pointer-events-none text-[#9E7B56] transition-transform group-focus-within:rotate-180">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('room_id')
                                    <p class="text-xs text-rose-600 mt-1 font-light">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- 5. Durasi Menginap (Input jumlah hari) -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label for="stay_duration" class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                        Durasi Menginap <span class="text-rose-600">*</span>
                                    </label>
                                    <span id="discountTagBadge" class="hidden text-[10px] px-2 py-0.5 bg-amber-100 text-amber-900 border border-amber-300 font-semibold tracking-wide">
                                        Diskon 10% (> 3 hari)
                                    </span>
                                </div>
                                <div class="flex items-center border border-[#E7E1D4] bg-white overflow-hidden focus-within:border-[#9E7B56] transition-colors">
                                    <input type="text" 
                                           id="stay_duration" 
                                           name="stay_duration" 
                                           value="{{ old('stay_duration', '') }}" 
                                           required
                                           oninput="handleDurationInput()"
                                           placeholder="Contoh: 3"
                                           class="w-full bg-transparent px-3.5 py-3 font-mono tabular-nums text-[#1C1B18] font-semibold text-sm focus:outline-none @error('stay_duration') border-rose-500 @enderror">
                                    <span class="px-3.5 py-3 text-xs font-semibold text-[#6E6A5F] border-l border-[#E7E1D4] bg-[#F5F1E9] select-none uppercase tracking-wider">
                                        Hari
                                    </span>
                                </div>
                                <!-- Pesan Error Wajib Persis Skenario BNSP: "harus isi angka" -->
                                <div id="durationError" class="text-xs text-rose-600 mt-1 font-medium {{ $errors->has('stay_duration') ? '' : 'hidden' }}">
                                    {{ $errors->first('stay_duration') ?: 'harus isi angka' }}
                                </div>
                            </div>
                        </div>

                        <!-- Baris 2: Harga & Tanggal Pesan (2 Grid) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <!-- 6. Harga (Readonly, terisi otomatis saat dropdown tipe kamar berubah) -->
                            <div class="space-y-1.5">
                                <label for="price_display" class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                    Harga Kamar 
                                </label>
                                <div class="flex items-center border border-[#E7E1D4] bg-[#F5F1E9] overflow-hidden">
                                    <span class="px-3.5 py-3 text-xs font-semibold text-[#6E6A5F] border-r border-[#E7E1D4] bg-[#EFECE4] select-none">
                                        Rp
                                    </span>
                                    <input type="text" 
                                           id="price_display" 
                                           readonly 
                                           value="500.000"
                                           class="w-full bg-transparent px-3.5 py-3 font-mono tabular-nums text-[#1C1B18] font-bold text-sm focus:outline-none cursor-not-allowed">
                                    <input type="hidden" id="raw_room_price" value="500000">
                                </div>
                            </div>

                            <!-- 7. Tanggal Pesan (Format dd/mm/yyyy) -->
                            <div class="space-y-1.5">
                                <label for="booking_date" class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                    Tanggal Pesan <span class="text-rose-600">*</span>
                                </label>
                                <input type="date" 
                                       id="booking_date" 
                                       name="booking_date" 
                                       value="{{ old('booking_date', date('Y-m-d')) }}" 
                                       required
                                       onchange="updateReceiptCustomerName()"
                                       class="input-editorial">
                            </div>
                        </div>
                    </div>

                    <!-- SEKSI 3: LAYANAN SARAPAN & ESTIMASI BIAYA -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-2 border-b border-[#F5F1E9] pb-2">
                            <span class="text-xs uppercase tracking-wider font-bold text-[#9E7B56]">C.</span>
                            <h3 class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">Layanan Tambahan & Total Bayar</h3>
                        </div>

                        <!-- 8. Termasuk Breakfast (Checkbox "Ya") Dikalikan Durasi -->
                        <div class="border border-[#E7E1D4] bg-[#FBF9F5] p-4">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" 
                                       id="includes_breakfast" 
                                       name="includes_breakfast" 
                                       value="1"
                                       {{ old('includes_breakfast', '1') ? 'checked' : '' }}
                                       onchange="calculateTotalBayar(false)"
                                       class="text-[#9E7B56] focus:ring-[#9E7B56] h-5 w-5 mt-0.5">
                                <div class="space-y-0.5">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">Termasuk Breakfast:</span>
                                        <span class="text-xs font-bold text-[#9E7B56]">Ya</span>
                                    </div>
                                    <p class="text-[11px] text-[#6E6A5F] leading-relaxed">
                                        Tambahan sarapan buffet segar Rp 80.000 per hari (<span id="breakfastMultiNote" class="font-medium text-[#1C1B18]">Rp 80.000 &times; durasi</span>).
                                    </p>
                                </div>
                            </label>
                        </div>

                        <!-- 9. Total Bayar (Readonly, kalkulasi otomatis realtime) -->
                        <div class="space-y-2 pt-2">
                            <label for="total_bayar_display" class="block text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                                Total Bayar (Readonly)
                            </label>
                            <div class="flex items-center border border-[#9E7B56] bg-[#F5F1E9] overflow-hidden">
                                <span class="px-4 py-3.5 text-sm font-bold text-[#1C1B18] border-r border-[#9E7B56]/30 bg-[#EFECE4] select-none">
                                    Rp
                                </span>
                                <input type="text" 
                                       id="total_bayar_display" 
                                       readonly 
                                       value="{{ old('stay_duration') ? '1.740.000' : '0' }}"
                                       class="w-full bg-transparent px-4 py-3.5 font-mono tabular-nums text-[#1C1B18] font-bold text-xl focus:outline-none cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TOMBOL AKSI FORMULIR (Simpan Data & Cancel) -->
                <div class="pt-8 border-t border-[#E7E1D4] mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                    
                    <!-- Tombol Cancel -->
                    <button type="button" 
                            id="btnCancel"
                            onclick="resetBookingForm()" 
                            class="btn-push-3d btn-cancel text-xs py-3.5 px-7 order-2 sm:order-1 text-center">
                        Cancel
                    </button>

                    <!-- Tombol Simpan -->
                    <button type="submit" 
                            id="btnSave"
                            class="btn-push-3d text-xs py-3.5 px-8 order-1 sm:order-2 text-center">
                        Simpan Data
                    </button>

                </div>

            </form>

        </div>

        <!-- KOLOM KANAN: STICKY LIVE SUMMARY & RINCIAN BILL ESTIMATION (COL-SPAN-5) -->
        <div class="lg:col-span-5 sticky top-28 space-y-6">
            
            <div class="border border-[#E7E1D4] bg-white p-6 shadow-sm space-y-6">
                
                <!-- Preview Foto & Tipe Kamar Terpilih -->
                <div class="space-y-3">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#9E7B56] font-semibold block">Pratinjau Kamar Dipilih</span>
                    <div class="relative aspect-video overflow-hidden border border-[#E7E1D4] bg-[#F5F1E9]">
                        <img id="receiptRoomImage" 
                             src="{{ asset($selectedRoom->image_url ?? '/assets/rooms/standar.jpg') }}" 
                             alt="Room Preview" 
                             class="w-full h-full object-cover transition-all duration-500">
                        <span id="receiptRoomTag" class="absolute top-2 left-2 bg-[#1C1B18]/85 text-white text-[10px] uppercase tracking-wider px-2.5 py-0.5 font-medium">
                            {{ $selectedRoom->name ?? 'Standar' }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between pt-1">
                        <div>
                            <h4 id="receiptRoomName" class="font-serif text-xl text-[#1C1B18] font-normal">Kamar {{ $selectedRoom->name ?? 'Standar' }}</h4>
                            <p id="receiptRoomTagline" class="text-[11px] text-[#6E6A5F]">{{ $selectedRoom->tagline ?? '' }}</p>
                        </div>
                        <div class="text-right">
                            <span id="receiptRoomPrice" class="font-serif text-lg font-bold text-[#9E7B56] tabular-nums">
                                Rp {{ number_format($selectedRoom->price ?? 500000, 0, ',', '.') }}
                            </span>
                            <span class="text-[10px] text-[#6E6A5F] block">/ malam</span>
                        </div>
                    </div>
                </div>

                <!-- Rincian Breakdown Faktur Live -->
                <div class="border-t border-[#E7E1D4] pt-4 space-y-3 text-xs">
                    <span class="text-[10px] uppercase tracking-wider font-semibold text-[#1C1B18] block">Rincian Perhitungan Tagihan:</span>
                    
                    <!-- Subtotal Kamar -->
                    <div class="flex justify-between items-center text-[#6E6A5F]">
                        <span>Subtotal Kamar (<span id="billDuration">{{ old('stay_duration', 0) }}</span> malam):</span>
                        <span id="billSubtotal" class="font-mono text-[#1C1B18] font-medium">Rp 0</span>
                    </div>

                    <!-- Diskon 10% jika > 3 hari -->
                    <div id="billDiscountRow" class="hidden flex justify-between items-center text-emerald-700 bg-emerald-50 p-2 border border-emerald-200">
                        <span>Diskon Menginap 10% (> 3 Hari):</span>
                        <span id="billDiscountAmount" class="font-mono font-bold">- Rp 0</span>
                    </div>

                    <!-- Biaya Breakfast (Rp 80.000 x Hari) -->
                    <div id="billBreakfastRow" class="hidden flex justify-between items-center text-[#6E6A5F]">
                        <span>Sarapan Buffet (Rp 80.000 &times; <span id="billBreakfastDays">0</span> hari):</span>
                        <span id="billBreakfastAmount" class="font-mono text-[#1C1B18] font-medium">+ Rp 0</span>
                    </div>

                    <!-- Total Estimasi Akhir -->
                    <div class="border-t border-[#E7E1D4] pt-3 flex justify-between items-baseline">
                        <span class="text-xs uppercase tracking-wider font-bold text-[#1C1B18]">Estimasi Total Bayar:</span>
                        <span id="billTotal" class="font-serif text-2xl font-bold text-[#1C1B18] tabular-nums">
                            Rp 0
                        </span>
                    </div>
                </div>

                <!-- Jaminan Keamanan & Validasi BNSP -->
                <div class="border-t border-[#E7E1D4] pt-4 text-[11px] text-[#6E6A5F] space-y-2">
                    <div class="flex items-center space-x-2 text-emerald-800">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Kalkulasi akurat sesuai durasi sarapan & masa menginap</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Deskripsi: Memperbarui tampilan harga kamar, foto pratinjau, dan rincian pada kartu receipt
     *            saat dropdown Tipe Kamar berubah nilainya.
     * Initial State: Dropdown Tipe Kamar dipilih oleh pengguna.
     * Final State: Kolom harga readonly terisi nominal kamar dan preview kartu terupdate.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     */
    function updateRoomPrice() {
        const roomSelect = document.getElementById('room_id');
        const selectedOption = roomSelect.options[roomSelect.selectedIndex];
        
        if (!selectedOption) return;

        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const name = selectedOption.getAttribute('data-name') || '';
        const image = selectedOption.getAttribute('data-image') || '';
        const tagline = selectedOption.getAttribute('data-tagline') || '';

        // Perbarui input tersembunyi dan readonly harga kamar
        document.getElementById('raw_room_price').value = price;
        document.getElementById('price_display').value = formatRibuan(price);

        // Perbarui pratinjau visual pada kartu kanan
        if (image) document.getElementById('receiptRoomImage').src = image;
        document.getElementById('receiptRoomTag').textContent = name;
        document.getElementById('receiptRoomName').textContent = 'Kamar ' + name;
        document.getElementById('receiptRoomTagline').textContent = tagline;
        document.getElementById('receiptRoomPrice').textContent = 'Rp ' + formatRibuan(price);

        // Hitung ulang kalkulasi total
        calculateTotalBayar(false);
    }

    /**
     * Deskripsi: Memvalidasi isian Nomor Identitas harus tepat 16 digit angka.
     *            Jika tidak valid, memunculkan pesan error persis: "isian salah..data harus 16 digit".
     * Initial State: Nilai teks pada input Nomor Identitas diubah oleh pengguna.
     * Final State: Menampilkan atau menyembunyikan pesan kesalahan dan mengembalikan status boolean.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     * 
     * @param {boolean} showErrorIfEmpty Apakah menampilkan pesan error jika input kosong
     * @returns {boolean} True jika tepat 16 digit angka, false jika tidak.
     */
    function validateIdentityNumber(showErrorIfEmpty = true) {
        const input = document.getElementById('identity_number');
        const errorElem = document.getElementById('identityError');
        const charCount = document.getElementById('idCharCount');
        const value = input.value.trim();

        if (charCount) charCount.textContent = value.length;

        // Jika input masih kosong
        if (value.length === 0) {
            if (showErrorIfEmpty) {
                errorElem.textContent = "isian salah..data harus 16 digit";
                errorElem.classList.remove('hidden');
                input.classList.add('border-rose-500');
            } else {
                errorElem.classList.add('hidden');
                input.classList.remove('border-rose-500');
            }
            return false;
        }

        // Pola regex: tepat 16 karakter angka saja (0-9)
        const regex16Digits = /^[0-9]{16}$/;

        if (!regex16Digits.test(value)) {
            errorElem.textContent = "isian salah..data harus 16 digit";
            errorElem.classList.remove('hidden');
            input.classList.add('border-rose-500');
            return false;
        } else {
            errorElem.classList.add('hidden');
            input.classList.remove('border-rose-500');
            return true;
        }
    }

    /**
     * Deskripsi: Memvalidasi isian Durasi Menginap harus berupa angka bulat positif.
     *            Jika tidak valid, memunculkan pesan error persis: "harus isi angka".
     * Initial State: Nilai input durasi diubah oleh pengguna.
     * Final State: Menampilkan pesan error "harus isi angka" jika bukan numerik positif.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     * 
     * @param {boolean} showErrorIfEmpty Apakah menampilkan pesan error jika input kosong
     * @returns {boolean} True jika angka valid, false jika tidak.
     */
    function validateDuration(showErrorIfEmpty = true) {
        const input = document.getElementById('stay_duration');
        const errorElem = document.getElementById('durationError');
        const value = input.value.trim();

        if (value.length === 0) {
            if (showErrorIfEmpty) {
                errorElem.textContent = "harus isi angka";
                errorElem.classList.remove('hidden');
                input.classList.add('border-rose-500');
            } else {
                errorElem.classList.add('hidden');
                input.classList.remove('border-rose-500');
            }
            return false;
        }

        // Validasi numerik: hanya angka bulat positif (1 atau lebih)
        const isNumeric = /^[1-9][0-9]*$/.test(value);

        if (!isNumeric) {
            errorElem.textContent = "harus isi angka";
            errorElem.classList.remove('hidden');
            input.classList.add('border-rose-500');
            return false;
        } else {
            errorElem.classList.add('hidden');
            input.classList.remove('border-rose-500');
            return true;
        }
    }

    /**
     * Handler realtime saat durasi menginap diketik oleh pengguna
     */
    function handleDurationInput() {
        const input = document.getElementById('stay_duration');
        const value = input.value.trim();
        
        if (value.length === 0) {
            validateDuration(false);
            calculateTotalBayar(false);
            return;
        }

        validateDuration(true);
        calculateTotalBayar(false);
    }

    /**
     * Deskripsi: Melakukan kalkulasi Total Bayar secara otomatis dan akurat:
     *            - Subtotal = Harga Kamar x Durasi Menginap
     *            - Diskon = Jika Durasi > 3 hari, diskon 10% dari subtotal
     *            - Breakfast = Jika dicentang Ya, tambahan Rp 80.000 x Durasi Menginap
     *            - Total Bayar = Subtotal - Diskon + Breakfast
     * Initial State: Parameter harga kamar, durasi, dan sarapan berubah.
     * Final State: Input readonly Total Bayar dan kartu rincian tagihan terisi akurat.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     * 
     * @param {boolean} showToast Tampilkan notifikasi visual saat status berubah
     */
    function calculateTotalBayar(showToast = false) {
        const isDurationValid = validateDuration(false);
        const totalDisplay = document.getElementById('total_bayar_display');
        const billDuration = document.getElementById('billDuration');
        const billSubtotal = document.getElementById('billSubtotal');
        const billTotal = document.getElementById('billTotal');
        const breakfastMultiNote = document.getElementById('breakfastMultiNote');
        const billBreakfastRow = document.getElementById('billBreakfastRow');
        const discountTagBadge = document.getElementById('discountTagBadge');
        const billDiscountRow = document.getElementById('billDiscountRow');

        if (!isDurationValid) {
            if (totalDisplay) totalDisplay.value = '0';
            if (billDuration) billDuration.textContent = '0';
            if (billSubtotal) billSubtotal.textContent = 'Rp 0';
            if (billTotal) billTotal.textContent = 'Rp 0';
            if (breakfastMultiNote) breakfastMultiNote.textContent = 'Rp 80.000 × durasi';
            if (billBreakfastRow) billBreakfastRow.classList.add('hidden');
            if (discountTagBadge) discountTagBadge.classList.add('hidden');
            if (billDiscountRow) billDiscountRow.classList.add('hidden');
            return;
        }

        const roomPrice = parseFloat(document.getElementById('raw_room_price').value) || 0;
        const duration = parseInt(document.getElementById('stay_duration').value, 10) || 0;
        const includesBreakfast = document.getElementById('includes_breakfast').checked;

        // 1. Subtotal kamar: Harga Kamar x Durasi
        const subtotal = roomPrice * duration;

        // 2. Diskon: Jika durasi menginap > 3 hari, diskon 10% dari subtotal kamar
        let discountPercent = 0;
        let discountAmount = 0;

        if (duration > 3) {
            discountPercent = 10;
            discountAmount = subtotal * 0.10;
            if (discountTagBadge) discountTagBadge.classList.remove('hidden');
            if (billDiscountRow) {
                billDiscountRow.classList.remove('hidden');
                document.getElementById('billDiscountAmount').textContent = '- Rp ' + formatRibuan(discountAmount);
            }
        } else {
            if (discountTagBadge) discountTagBadge.classList.add('hidden');
            if (billDiscountRow) billDiscountRow.classList.add('hidden');
        }

        // 3. Tambahan sarapan: Rp 80.000 x Durasi Menginap (jika dicentang)
        const breakfastFeePerDay = 80000;
        const breakfastFee = includesBreakfast ? (breakfastFeePerDay * duration) : 0;

        // Perbarui teks keterangan sarapan di form
        if (breakfastMultiNote) {
            breakfastMultiNote.textContent = includesBreakfast 
                ? `Rp 80.000 × ${duration} hari = Rp ${formatRibuan(breakfastFee)}`
                : `Tidak diaktifkan`;
        }

        if (billBreakfastRow) {
            if (includesBreakfast) {
                billBreakfastRow.classList.remove('hidden');
                document.getElementById('billBreakfastDays').textContent = duration;
                document.getElementById('billBreakfastAmount').textContent = '+ Rp ' + formatRibuan(breakfastFee);
            } else {
                billBreakfastRow.classList.add('hidden');
            }
        }

        // 4. Total Bayar: Subtotal - Diskon + Sarapan
        const totalBayar = subtotal - discountAmount + breakfastFee;

        // Tampilkan hasil ke input readonly Total Bayar dengan format pemisah ribuan titik
        if (totalDisplay) totalDisplay.value = formatRibuan(totalBayar);

        // Perbarui rincian kalkulasi di kartu kanan (receipt)
        if (billDuration) billDuration.textContent = duration;
        if (billSubtotal) billSubtotal.textContent = 'Rp ' + formatRibuan(subtotal);
        if (billTotal) billTotal.textContent = 'Rp ' + formatRibuan(totalBayar);

        if (showToast) {
            const badge = document.getElementById('formStatusBadge');
            if (badge) {
                badge.innerHTML = `<span class="w-2 h-2 rounded-full bg-emerald-500"></span><span>Kalkulasi Otomatis (Total Rp ${formatRibuan(totalBayar)})</span>`;
                badge.className = 'text-emerald-700 font-semibold flex items-center space-x-1.5 justify-end';
            }
        }
    }

    /**
     * Deskripsi: Memvalidasi seluruh field formulir sebelum disubmit ke server.
     * Initial State: Tombol Simpan diklik oleh pengguna.
     * Final State: Form dikirim jika valid, atau ditahan dan difokuskan ke field bermasalah.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     */
    function validateAndSubmitForm(event) {
        const customerName = document.getElementById('customer_name').value.trim();
        if (!customerName) {
            alert('Nama Pemesan wajib diisi.');
            document.getElementById('customer_name').focus();
            event.preventDefault();
            return false;
        }

        const isIdValid = validateIdentityNumber(true);
        if (!isIdValid) {
            alert('isian salah..data harus 16 digit');
            document.getElementById('identity_number').focus();
            event.preventDefault();
            return false;
        }

        const isDurationValid = validateDuration(true);
        if (!isDurationValid) {
            alert('harus isi angka');
            document.getElementById('stay_duration').focus();
            event.preventDefault();
            return false;
        }

        // Jalankan kalkulasi final sebelum data dikirim ke MySQL
        calculateTotalBayar(false);
        return true;
    }

    /**
     * Deskripsi: Mereset seluruh nilai formulir pemesanan ke kondisi awal (Action Cancel).
     * Initial State: Formulir terisi nilai input sebelumnya.
     * Final State: Formulir dibersihkan dan diatur ke nilai default standar.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     */
    function resetBookingForm() {
        if (confirm('Apakah Anda yakin ingin membatalkan dan mereset isian formulir pemesanan ini?')) {
            const form = document.getElementById('bookingForm');
            form.reset();

            // Kosongkan isian
            const idInput = document.getElementById('identity_number');
            const durInput = document.getElementById('stay_duration');
            if (idInput) idInput.value = '';
            if (durInput) durInput.value = '';
            const charCount = document.getElementById('idCharCount');
            if (charCount) charCount.textContent = '0';

            // Sembunyikan pesan kesalahan
            document.getElementById('identityError').classList.add('hidden');
            document.getElementById('durationError').classList.add('hidden');
            if (idInput) idInput.classList.remove('border-rose-500');
            if (durInput) durInput.classList.remove('border-rose-500');

            // Reset harga dan kalkulasi
            updateRoomPrice();
            calculateTotalBayar(false);
            
            const badge = document.getElementById('formStatusBadge');
            if (badge) {
                badge.innerHTML = `<span class="w-2 h-2 rounded-full bg-gray-400"></span><span>Formulir Direset</span>`;
                badge.className = 'text-[#6E6A5F] font-normal flex items-center space-x-1.5 justify-end';
            }
        }
    }

    /**
     * Utilitas memperbarui nama dan detail tamu saat diketik
     */
    function updateReceiptCustomerName() {
        // Reserved for dynamic client updates
    }

    /**
     * Deskripsi: Utilitas pemformat angka ribuan dengan pemisah titik (contoh: 1740000 -> 1.740.000).
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 03 November 2026
     */
    function formatRibuan(num) {
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Inisialisasi awal saat dokumen siap
    document.addEventListener('DOMContentLoaded', function() {
        updateRoomPrice();
        validateIdentityNumber(false);
        validateDuration(false);
        calculateTotalBayar(false);
    });
</script>
@endpush
