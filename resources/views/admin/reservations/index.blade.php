@extends('layouts.admin')

@section('title', 'Data Reservasi Masuk')
@section('header-title', 'Daftar Reservasi Tamu Hotel')

@section('content')
<div class="space-y-6">
    
    <!-- Filter & Pencarian -->
    <div class="bg-white border border-[#E7E1D4] p-6">
        <form method="GET" action="{{ route('admin.reservations.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            
            <div class="sm:col-span-6 space-y-1">
                <label for="search" class="text-xs uppercase tracking-wider text-[#6E6A5F] font-semibold">
                    Cari Nama Pemesan, NIK (16 Digit), atau Kode Booking
                </label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci pencarian..." class="input-editorial text-xs">
            </div>

            <div class="sm:col-span-3 space-y-1">
                <label for="status" class="text-xs uppercase tracking-wider text-[#6E6A5F] font-semibold">
                    Filter Status
                </label>
                <select id="status" name="status" class="input-editorial text-xs bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="sm:col-span-3 flex items-center space-x-2">
                <button type="submit" class="btn-luxury text-xs py-2.5 px-5 flex-1">
                    Terapkan
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.reservations.index') }}" class="btn-luxury-outline text-xs py-2.5 px-3">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Tabel Data Reservasi Masuk -->
    <div class="bg-white border border-[#E7E1D4] overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="bg-[#F5F1E9] border-b border-[#E7E1D4] text-[#1C1B18] uppercase tracking-wider text-[11px]">
                    <th class="p-4 font-semibold">Kode & Tanggal</th>
                    <th class="p-4 font-semibold">Nama Pemesan & NIK</th>
                    <th class="p-4 font-semibold">Tipe Kamar</th>
                    <th class="p-4 font-semibold">Durasi</th>
                    <th class="p-4 font-semibold">Diskon & Sarapan</th>
                    <th class="p-4 font-semibold">Total Bayar</th>
                    <th class="p-4 font-semibold">Status Reservasi</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E7E1D4]">
                @forelse($reservations as $r)
                    <tr class="hover:bg-[#FBF9F5] transition-colors">
                        <td class="p-4">
                            <span class="font-mono text-xs font-bold text-[#1C1B18] block">{{ $r->booking_code }}</span>
                            <span class="text-[11px] text-[#6E6A5F]">{{ $r->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-[#1C1B18]">{{ $r->customer_name }}</div>
                            <span class="font-mono text-[11px] text-[#6E6A5F] block">{{ $r->identity_number }} ({{ $r->gender }})</span>
                        </td>
                        <td class="p-4 font-serif text-base text-[#1C1B18]">
                            {{ $r->room_type_name }}
                        </td>
                        <td class="p-4 text-xs text-[#6E6A5F]">
                            {{ $r->formatted_duration }}
                        </td>
                        <td class="p-4 text-xs text-[#6E6A5F]">
                            <div>Diskon: <strong class="{{ $r->discount_percent > 0 ? 'text-[#9E7B56]' : '' }}">{{ $r->formatted_discount }}</strong></div>
                            <div>Sarapan: {{ $r->includes_breakfast ? 'Ya' : 'Tidak' }}</div>
                        </td>
                        <td class="p-4 font-serif text-base font-bold text-[#1C1B18] tabular-nums">
                            Rp {{ $r->formatted_total_payment }}
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.reservations.status', $r->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-[11px] uppercase tracking-wider font-semibold py-1 px-2 border cursor-pointer
                                    {{ $r->status === 'confirmed' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : '' }}
                                    {{ $r->status === 'checked_in' ? 'bg-blue-50 text-blue-800 border-blue-300' : '' }}
                                    {{ $r->status === 'completed' ? 'bg-gray-100 text-gray-800 border-gray-300' : '' }}
                                    {{ $r->status === 'pending' ? 'bg-amber-50 text-amber-800 border-amber-300' : '' }}
                                    {{ $r->status === 'cancelled' ? 'bg-rose-50 text-rose-800 border-rose-300' : '' }}">
                                    <option value="pending" {{ $r->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $r->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="checked_in" {{ $r->status === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                    <option value="completed" {{ $r->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $r->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.reservations.show', $r->id) }}" class="btn-luxury-outline text-[11px] py-1.5 px-3">
                                Rincian
                            </a>
                            <form action="{{ route('admin.reservations.destroy', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus transaksi reservasi {{ $r->booking_code }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-[11px] uppercase tracking-wider font-semibold py-1.5 px-2">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-[#6E6A5F]">
                            Tidak ada data reservasi yang sesuai dengan kriteria pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reservations->links() }}
    </div>

</div>
@endsection

