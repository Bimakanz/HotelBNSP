@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya — The Serenity Palace')

@section('content')
<!-- Header Halaman Riwayat Tamu -->
<section class="border-b border-[#E7E1D4] bg-[#F5F1E9] py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-xs uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">Portal Tamu Hotel</span>
                <h1 class="font-serif text-3xl sm:text-4xl text-[#1C1B18] font-normal">Riwayat Reservasi Saya</h1>
                <p class="text-xs text-[#6E6A5F]">
                    Daftar seluruh transaksi pemesanan kamar atas nama <strong>{{ auth()->user()->name }}</strong>.
                </p>
            </div>
            <div>
                <a href="{{ route('booking.form') }}" class="btn-luxury text-xs py-3 px-6">
                    + Pesan Kamar Baru
                </a>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
    @if($reservations->isEmpty())
        <div class="border border-[#E7E1D4] bg-white p-12 text-center space-y-4">
            <span class="font-serif text-2xl text-[#1C1B18] block">Belum Ada Riwayat Reservasi</span>
            <p class="text-xs text-[#6E6A5F] max-w-md mx-auto">
                Anda belum melakukan pemesanan kamar saat ini. Mulai pengalaman liburan mewah Anda bersama The Serenity Palace sekarang.
            </p>
            <div class="pt-2">
                <a href="{{ route('booking.form') }}" class="btn-luxury text-xs py-3 px-8">
                    Buat Reservasi Pertama &rarr;
                </a>
            </div>
        </div>
    @else
        <div class="border border-[#E7E1D4] bg-white overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-[#F5F1E9] border-b border-[#E7E1D4] text-[#1C1B18] uppercase tracking-wider text-[11px]">
                        <th class="p-4 font-semibold">Kode Reservasi</th>
                        <th class="p-4 font-semibold">Tipe Kamar</th>
                        <th class="p-4 font-semibold">Tanggal Check-In</th>
                        <th class="p-4 font-semibold">Durasi</th>
                        <th class="p-4 font-semibold">Sarapan</th>
                        <th class="p-4 font-semibold">Diskon</th>
                        <th class="p-4 font-semibold">Total Bayar</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E7E1D4]">
                    @foreach($reservations as $r)
                        <tr class="hover:bg-[#FBF9F5] transition-colors">
                            <td class="p-4 font-mono font-bold text-[#1C1B18] text-xs">
                                {{ $r->booking_code }}
                            </td>
                            <td class="p-4 font-serif text-base text-[#1C1B18]">
                                {{ $r->room_type_name }}
                            </td>
                            <td class="p-4 text-[#6E6A5F] tabular-nums">
                                {{ $r->booking_date->format('d/m/Y') }}
                            </td>
                            <td class="p-4 text-[#6E6A5F]">
                                {{ $r->formatted_duration }}
                            </td>
                            <td class="p-4 text-[#6E6A5F]">
                                {{ $r->includes_breakfast ? 'Ya (+Rp 80.000)' : 'Tidak' }}
                            </td>
                            <td class="p-4 text-[#6E6A5F]">
                                {{ $r->formatted_discount }}
                            </td>
                            <td class="p-4 font-serif text-base font-bold text-[#1C1B18] tabular-nums">
                                Rp {{ $r->formatted_total_payment }}
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-[10px] uppercase tracking-wider font-semibold 
                                    {{ $r->status === 'confirmed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : '' }}
                                    {{ $r->status === 'checked_in' ? 'bg-blue-50 text-blue-800 border border-blue-200' : '' }}
                                    {{ $r->status === 'completed' ? 'bg-gray-100 text-gray-800 border border-gray-300' : '' }}
                                    {{ $r->status === 'cancelled' ? 'bg-rose-50 text-rose-800 border border-rose-200' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $r->status)) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('booking.summary', $r->id) }}" 
                                   class="btn-luxury-outline text-[11px] py-1.5 px-3">
                                    Lihat Ringkasan &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reservations->links() }}
        </div>
    @endif
</div>
@endsection

