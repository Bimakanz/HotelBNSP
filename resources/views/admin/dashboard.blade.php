@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard Pengelola')
@section('header-title', 'Pusat Analitik & Operasional Hotel')

@section('content')
<div class="space-y-8">
    
    <!-- Kartu Metrik Keuangan & Reservasi (Editorial Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Pendapatan -->
        <div class="bg-white p-6 border border-[#E7E1D4]">
            <span class="text-[10px] uppercase tracking-[0.2em] text-[#6E6A5F] block font-medium">Total Akumulasi Pendapatan</span>
            <div class="mt-2 font-serif text-3xl font-medium text-[#1C1B18] tabular-nums">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-emerald-700 block mt-2">Dari seluruh reservasi aktif</span>
        </div>

        <!-- Total Reservasi -->
        <div class="bg-white p-6 border border-[#E7E1D4]">
            <span class="text-[10px] uppercase tracking-[0.2em] text-[#6E6A5F] block font-medium">Total Transaksi Booking</span>
            <div class="mt-2 font-serif text-3xl font-medium text-[#1C1B18] tabular-nums">
                {{ $totalBookings }} <span class="text-sm font-sans font-normal text-[#6E6A5F]">Pesanan</span>
            </div>
            <span class="text-[11px] text-[#6E6A5F] block mt-2">Tercatat di tabel MySQL</span>
        </div>

        <!-- Kamar Dikelola -->
        <div class="bg-white p-6 border border-[#E7E1D4]">
            <span class="text-[10px] uppercase tracking-[0.2em] text-[#6E6A5F] block font-medium">Tipe Kamar Aktif</span>
            <div class="mt-2 font-serif text-3xl font-medium text-[#1C1B18] tabular-nums">
                {{ $totalRooms }} <span class="text-sm font-sans font-normal text-[#6E6A5F]">Tipe Master</span>
            </div>
            <span class="text-[11px] text-[#9E7B56] block mt-2">Standar, Deluxe, Family</span>
        </div>

        <!-- Booking Terkonfirmasi -->
        <div class="bg-white p-6 border border-[#E7E1D4]">
            <span class="text-[10px] uppercase tracking-[0.2em] text-[#6E6A5F] block font-medium">Reservasi Siap Check-In</span>
            <div class="mt-2 font-serif text-3xl font-medium text-[#1C1B18] tabular-nums">
                {{ $confirmedBookings }} <span class="text-sm font-sans font-normal text-[#6E6A5F]">Tamu</span>
            </div>
            <span class="text-[11px] text-blue-700 block mt-2">Status: Confirmed</span>
        </div>

    </div>

    <!-- Distribusi Pemesanan per Tipe Kamar -->
    <div class="bg-white border border-[#E7E1D4] p-6">
        <h3 class="font-serif text-xl text-[#1C1B18] mb-4">Statistik Pemesanan per Tipe Kamar</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($roomStats as $rs)
                <div class="p-4 border border-[#E7E1D4] bg-[#F5F1E9] space-y-2">
                    <div class="flex justify-between items-baseline">
                        <span class="font-serif text-lg font-medium text-[#1C1B18]">{{ $rs->name }}</span>
                        <span class="text-xs font-mono text-[#9E7B56] font-semibold">{{ $rs->formatted_price }}</span>
                    </div>
                    <div class="text-xs text-[#6E6A5F]">
                        Jumlah Reservasi: <strong>{{ $rs->reservations_count }} kali</strong>
                    </div>
                    <div class="w-full bg-[#E7E1D4] h-1.5 overflow-hidden">
                        <div class="bg-[#9E7B56] h-full" style="width: {{ $totalBookings > 0 ? ($rs->reservations_count / $totalBookings) * 100 : 0 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tabel 5 Reservasi Terbaru Masuk -->
    <div class="bg-white border border-[#E7E1D4] p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-serif text-xl text-[#1C1B18]">Reservasi Terbaru Masuk</h3>
                <p class="text-xs text-[#6E6A5F]">Daftar transaksi reservasi teranyar dari tamu publik.</p>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="btn-luxury-outline text-xs py-2 px-4">
                Lihat Seluruh Data &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F5F1E9] border-b border-[#E7E1D4] text-[#1C1B18] uppercase tracking-wider text-[11px]">
                        <th class="p-3 font-semibold">Kode Reservasi</th>
                        <th class="p-3 font-semibold">Nama Pemesan</th>
                        <th class="p-3 font-semibold">Tipe Kamar</th>
                        <th class="p-3 font-semibold">Durasi</th>
                        <th class="p-3 font-semibold">Total Bayar</th>
                        <th class="p-3 font-semibold">Status</th>
                        <th class="p-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E7E1D4]">
                    @forelse($recentReservations as $res)
                        <tr class="hover:bg-[#FBF9F5]">
                            <td class="p-3 font-mono font-bold text-[#1C1B18]">{{ $res->booking_code }}</td>
                            <td class="p-3 font-medium text-[#1C1B18]">{{ $res->customer_name }}</td>
                            <td class="p-3 font-serif text-sm">{{ $res->room_type_name }}</td>
                            <td class="p-3 text-[#6E6A5F]">{{ $res->formatted_duration }}</td>
                            <td class="p-3 font-serif font-bold text-[#1C1B18] tabular-nums">Rp {{ $res->formatted_total_payment }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 text-[10px] uppercase tracking-wider font-semibold 
                                    {{ $res->status === 'confirmed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : '' }}
                                    {{ $res->status === 'checked_in' ? 'bg-blue-50 text-blue-800 border border-blue-200' : '' }}
                                    {{ $res->status === 'completed' ? 'bg-gray-100 text-gray-800 border border-gray-300' : '' }}
                                    {{ $res->status === 'cancelled' ? 'bg-rose-50 text-rose-800 border border-rose-200' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $res->status)) }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                <a href="{{ route('admin.reservations.show', $res->id) }}" class="text-[#9E7B56] hover:underline font-medium">
                                    Detail &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-[#6E6A5F]">Belum ada data reservasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

