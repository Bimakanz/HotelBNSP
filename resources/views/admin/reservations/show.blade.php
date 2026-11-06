@extends('layouts.admin')

@section('title', 'Detail Reservasi #' . $reservation->booking_code)
@section('header-title', 'Rincian Transaksi: ' . $reservation->booking_code)

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.reservations.index') }}" class="text-xs uppercase tracking-wider text-[#6E6A5F] hover:text-[#1C1B18] inline-flex items-center space-x-1">
            <span>&larr;</span>
            <span>Kembali ke Daftar Reservasi</span>
        </a>
        <a href="{{ route('booking.summary', $reservation->id) }}" target="_blank" class="btn-luxury-outline text-xs py-2 px-4">
            Lihat Format Cetak Faktur (BNSP) &rarr;
        </a>
    </div>

    <div class="border border-[#E7E1D4] bg-white p-8">
        <div class="border-b border-[#E7E1D4] pb-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-[10px] uppercase tracking-[0.2em] text-[#9E7B56] font-semibold">Voucher Reservasi</span>
                <h3 class="font-serif text-3xl text-[#1C1B18]">Kode #{{ $reservation->booking_code }}</h3>
                <span class="text-xs text-[#6E6A5F]">Tercatat pada {{ $reservation->created_at->format('d F Y, H:i:s') }} WIB</span>
            </div>

            <!-- Form Ubah Status Cepat -->
            <form action="{{ route('admin.reservations.status', $reservation->id) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                @method('PATCH')
                <label for="status" class="text-xs text-[#6E6A5F] uppercase tracking-wider font-semibold">Ubah Status:</label>
                <select id="status" name="status" onchange="this.form.submit()" class="input-editorial text-xs py-1.5 px-3 bg-[#F5F1E9]">
                    <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ $reservation->status === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="completed" {{ $reservation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>

        <!-- Rincian Data Tamu & Kamar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8 border-b border-[#E7E1D4]">
            
            <div class="space-y-4">
                <h4 class="text-xs uppercase tracking-wider font-semibold text-[#9E7B56]">Data Pemesan (Tamu)</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Nama Lengkap:</span>
                        <span class="font-medium text-[#1C1B18]">{{ $reservation->customer_name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Nomor Identitas (NIK):</span>
                        <span class="font-mono text-[#1C1B18]">{{ $reservation->identity_number }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Jenis Kelamin:</span>
                        <span class="text-[#1C1B18]">{{ $reservation->gender }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Akun Pengguna:</span>
                        <span class="text-[#1C1B18]">{{ $reservation->user ? $reservation->user->email : 'Pemesanan Tamu Publik (Guest)' }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h4 class="text-xs uppercase tracking-wider font-semibold text-[#9E7B56]">Data Kamar & Jadwal</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Tipe Kamar:</span>
                        <span class="font-serif text-sm font-medium text-[#1C1B18]">{{ $reservation->room_type_name }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Tarif per Malam:</span>
                        <span class="font-mono text-[#1C1B18]">Rp {{ number_format($reservation->room_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Tanggal Check-In:</span>
                        <span class="text-[#1C1B18]">{{ $reservation->booking_date->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Durasi Menginap:</span>
                        <span class="font-medium text-[#1C1B18]">{{ $reservation->formatted_duration }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#F5F1E9]">
                        <span class="text-[#6E6A5F]">Layanan Breakfast:</span>
                        <span class="text-[#1C1B18]">{{ $reservation->includes_breakfast ? 'Ya (+Rp 80.000)' : 'Tidak' }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Breakdown Kalkulasi Keuangan (Sesuai Rumus BNSP) -->
        <div class="pt-6 space-y-4">
            <h4 class="text-xs uppercase tracking-wider font-semibold text-[#9E7B56]">Rincian Perhitungan Tagihan</h4>
            
            <div class="bg-[#F5F1E9] p-6 border border-[#E7E1D4] space-y-3 text-xs">
                <div class="flex justify-between">
                    <span class="text-[#6E6A5F]">Subtotal Kamar ({{ $reservation->room_price }} &times; {{ $reservation->stay_duration }} Hari):</span>
                    <span class="font-mono text-[#1C1B18]">Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between {{ $reservation->discount_amount > 0 ? 'text-[#9E7B56]' : 'text-[#6E6A5F]' }}">
                    <span>Potongan Diskon ({{ $reservation->formatted_discount }}):</span>
                    <span class="font-mono">- Rp {{ number_format($reservation->discount_amount, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between text-[#6E6A5F]">
                    <span>Biaya Tambahan Sarapan:</span>
                    <span class="font-mono">+ Rp {{ number_format($reservation->breakfast_fee, 0, ',', '.') }}</span>
                </div>

                <div class="pt-3 border-t border-[#E7E1D4] flex justify-between items-baseline text-sm">
                    <span class="font-bold text-[#1C1B18] uppercase tracking-wider">Total Tagihan Bayar:</span>
                    <span class="font-serif text-2xl font-bold text-[#1C1B18] tabular-nums">
                        Rp {{ $reservation->formatted_total_payment }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

