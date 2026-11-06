@extends('layouts.app')

@section('title', 'Ringkasan Reservasi Kamar — The Serenity Palace')

@push('styles')
<style>
@media print {
    /* Sembunyikan elemen non-cetak */
    header,
    footer,
    nav,
    .no-print,
    #videoModal,
    .flash-messages-container {
        display: none !important;
    }

    /* Reset struktur layout agar langsung mencetak kartu voucher di halaman pertama */
    html, body {
        display: block !important;
        background: #ffffff !important;
        color: #000000 !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        min-height: 0 !important;
        overflow: visible !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    main {
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        min-height: 0 !important;
        flex: none !important;
    }

    .print-container {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .print-card {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 20px 24px !important;
        border: 2px solid #000000 !important;
        box-shadow: none !important;
        background: #ffffff !important;
        page-break-before: auto !important;
        break-before: auto !important;
        page-break-inside: auto !important;
        break-inside: auto !important;
    }

    .print-highlight {
        background-color: #f5f1e9 !important;
        border-top: 2px solid #000000 !important;
        border-bottom: 2px solid #000000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .print-only {
        display: block !important;
    }

    @page {
        size: A4 portrait;
        margin: 1cm 1.2cm;
    }
}
</style>
@endpush

@section('content')
<!-- Header Halaman Hasil Simpan Data (Hanya di layar, sembunyi saat dicetak) -->
<section class="border-b border-[#E7E1D4] bg-[#F5F1E9] py-10 no-print">
    <div class="max-w-3xl mx-auto px-6 text-center space-y-2">
        <div class="inline-flex items-center space-x-2 text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">
            <span>Skenario BNSP Butir 2.b</span>
            <span>&bull;</span>
            <span>Hasil Simpan Data MySQL</span>
        </div>
        <h1 class="font-serif text-3xl sm:text-4xl text-[#1C1B18] font-normal">Faktur & Bukti Reservasi</h1>
        <p class="text-xs sm:text-sm text-[#6E6A5F]">
            Data reservasi kamar telah berhasil disimpan ke database. Anda dapat mencetak dokumen bukti reservasi resmi di bawah ini.
        </p>
    </div>
</section>

<div class="max-w-2xl mx-auto px-6 py-10 print-container">
    
    <!-- Tombol Beranda di Atas Kiri di Luar Card (Arrow Left) -->
    <div class="mb-6 no-print">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center space-x-2.5 text-xs uppercase tracking-[0.16em] font-bold text-[#6E6A5F] hover:text-[#1C1B18] transition-all group py-2">
            <svg class="w-4 h-4 text-[#9E7B56] group-hover:text-[#1C1B18] transform group-hover:-translate-x-1 transition-transform" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Beranda</span>
        </a>
    </div>

    <!-- Kartu Hasil Simpan Data Persis Standar Format Asesmen BNSP -->
    <div class="border border-[#1C1B18]/30 bg-white p-8 sm:p-12 shadow-sm relative print-card">
        
        <!-- Header Dokumen Faktur / Voucher -->
        <div class="border-b-2 border-[#1C1B18] pb-6 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[10px] uppercase tracking-[0.25em] text-[#9E7B56] font-semibold block">Official Hotel Reservation Voucher</span>
                <h2 class="font-serif text-2xl sm:text-3xl text-[#1C1B18] font-medium tracking-tight">THE SERENITY PALACE</h2>
                <p class="text-[11px] text-[#6E6A5F]">Jl. Nirwana Highland No. 88, Resort Valley, Bandung &bull; Telp: (022) 8765-4321</p>
            </div>
            <div class="sm:text-right border-l sm:border-l-0 pl-4 sm:pl-0 border-[#E7E1D4]">
                <span class="text-[10px] uppercase tracking-wider text-[#6E6A5F] block font-medium">Nomor / Kode Booking:</span>
                <span class="font-mono text-base font-bold text-[#1C1B18] tracking-wider">{{ $reservation->booking_code }}</span>
            </div>
        </div>

        <!-- Tampilan Persis Field Standar Soal BNSP (Sesuai Dokumen FR.IA.02) -->
        <div class="space-y-4 text-sm text-[#1C1B18]">
            
            <div class="grid grid-cols-12 py-2 border-b border-[#F5F1E9]">
                <div class="col-span-5 sm:col-span-4 text-[#6E6A5F] font-medium">Nama Pemesan</div>
                <div class="col-span-1 text-center font-bold">:</div>
                <div class="col-span-6 sm:col-span-7 font-bold text-[#1C1B18] text-base">{{ $reservation->customer_name }}</div>
            </div>

            <div class="grid grid-cols-12 py-2 border-b border-[#F5F1E9]">
                <div class="col-span-5 sm:col-span-4 text-[#6E6A5F] font-medium">Nomor Identitas</div>
                <div class="col-span-1 text-center font-bold">:</div>
                <div class="col-span-6 sm:col-span-7 font-mono font-semibold tracking-wider">{{ $reservation->identity_number }}</div>
            </div>

            <div class="grid grid-cols-12 py-2 border-b border-[#F5F1E9]">
                <div class="col-span-5 sm:col-span-4 text-[#6E6A5F] font-medium">Jenis Kelamin</div>
                <div class="col-span-1 text-center font-bold">:</div>
                <div class="col-span-6 sm:col-span-7 font-medium">{{ $reservation->gender }}</div>
            </div>

            <div class="grid grid-cols-12 py-2 border-b border-[#F5F1E9]">
                <div class="col-span-5 sm:col-span-4 text-[#6E6A5F] font-medium">Tipe Kamar</div>
                <div class="col-span-1 text-center font-bold">:</div>
                <div class="col-span-6 sm:col-span-7 font-serif text-base font-semibold text-[#1C1B18]">{{ $reservation->room_type_name }}</div>
            </div>

            <div class="grid grid-cols-12 py-2 border-b border-[#F5F1E9]">
                <div class="col-span-5 sm:col-span-4 text-[#6E6A5F] font-medium">Durasi Penginapan</div>
                <div class="col-span-1 text-center font-bold">:</div>
                <div class="col-span-6 sm:col-span-7 font-medium">{{ $reservation->formatted_duration }}</div>
            </div>

            <div class="grid grid-cols-12 py-2 border-b border-[#F5F1E9]">
                <div class="col-span-5 sm:col-span-4 text-[#6E6A5F] font-medium">Discount</div>
                <div class="col-span-1 text-center font-bold">:</div>
                <div class="col-span-6 sm:col-span-7 font-medium {{ $reservation->discount_percent > 0 ? 'text-[#9E7B56] font-semibold' : '' }}">
                    {{ $reservation->formatted_discount }}
                </div>
            </div>

            <!-- Total Bayar Sesuai Format Persis BNSP (Contoh: 1.590.000) -->
            <div class="grid grid-cols-12 py-4 bg-[#F5F1E9] px-4 border-t-2 border-b-2 border-[#1C1B18] items-center print-highlight">
                <div class="col-span-5 sm:col-span-4 font-bold text-[#1C1B18] uppercase tracking-wider text-xs">
                    Total Bayar
                </div>
                <div class="col-span-1 text-center font-bold text-lg">:</div>
                <div class="col-span-6 sm:col-span-7 font-serif text-2xl sm:text-3xl font-bold text-[#1C1B18] tabular-nums">
                    {{ $reservation->formatted_total_payment }}
                </div>
            </div>

        </div>

        <!-- Catatan Layanan Tambahan -->
        <div class="mt-8 pt-6 border-t border-[#E7E1D4] text-xs text-[#6E6A5F] space-y-1.5">
            <p><strong>Layanan Breakfast:</strong> {{ $reservation->includes_breakfast ? 'Termasuk sarapan harian (Rp 80.000 x ' . $reservation->stay_duration . ' hari = Rp ' . number_format($reservation->breakfast_fee, 0, ',', '.') . ')' : 'Tidak termasuk sarapan' }}</p>
            <p><strong>Tanggal Check-in:</strong> {{ $reservation->booking_date->format('d/m/Y') }} (Pukul 14.00 WIB)</p>
            <p class="text-[11px] text-[#8C877D] pt-1">Dokumen ini merupakan bukti sah transaksi reservasi akomodasi The Serenity Palace yang telah tercatat resmi pada database.</p>
        </div>

        <!-- Kolom Tanda Tangan Khusus Cetak (Hanya Tampil Saat Print) -->
        <div class="mt-12 pt-6 border-t border-[#1C1B18]/20 print-only">
            <div class="grid grid-cols-2 text-center text-xs text-[#1C1B18]">
                <div>
                    <p class="text-[#6E6A5F]">Tamu Pemesan,</p>
                    <div class="h-20"></div>
                    <p class="font-bold border-t border-[#1C1B18] inline-block px-8 pt-1">{{ $reservation->customer_name }}</p>
                </div>
                <div>
                    <p class="text-[#6E6A5F]">Front Office Officer,</p>
                    <div class="h-20"></div>
                    <p class="font-bold border-t border-[#1C1B18] inline-block px-8 pt-1">The Serenity Palace</p>
                </div>
            </div>
            <p class="text-center text-[10px] text-[#8C877D] mt-6">
                Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB &bull; Sistem Reservasi Terakreditasi BNSP
            </p>
        </div>

        <!-- Tombol Aksi Cetak Bukti Reservasi (Disembunyikan Saat Print) -->
        <div class="mt-8 pt-6 border-t border-[#E7E1D4] flex items-center justify-end no-print">
            <button type="button" 
                    onclick="window.print()" 
                    class="btn-push-3d text-xs py-3.5 px-8 w-full sm:w-auto flex items-center justify-center space-x-2.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Bukti Reservasi</span>
            </button>
        </div>

    </div>

</div>
@endsection
