@extends('layouts.admin')

@section('title', 'Master Data Kamar')
@section('header-title', 'Kelola Master Tipe Kamar Hotel')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl text-[#1C1B18]">Katalog Master Kamar</h2>
            <p class="text-xs text-[#6E6A5F]">Kelola tarif kamar, fasilitas, galeri foto, dan pratinjau video kamar.</p>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn-luxury text-xs py-3 px-6">
            + Tambah Tipe Kamar Baru
        </a>
    </div>

    <div class="bg-white border border-[#E7E1D4] overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="bg-[#F5F1E9] border-b border-[#E7E1D4] text-[#1C1B18] uppercase tracking-wider text-[11px]">
                    <th class="p-4 font-semibold">Foto & Kode</th>
                    <th class="p-4 font-semibold">Nama Kamar</th>
                    <th class="p-4 font-semibold">Tarif / Malam</th>
                    <th class="p-4 font-semibold">Kapasitas & Ukuran</th>
                    <th class="p-4 font-semibold">Video Preview</th>
                    <th class="p-4 font-semibold">Total Booking</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E7E1D4]">
                @foreach($rooms as $room)
                    <tr class="hover:bg-[#FBF9F5] transition-colors">
                        <td class="p-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset($room->image_url) }}" alt="{{ $room->name }}" class="w-16 h-12 object-cover border border-[#E7E1D4]">
                                <div>
                                    <span class="font-mono text-xs font-bold text-[#1C1B18]">{{ $room->code }}</span>
                                    <span class="text-[10px] text-[#6E6A5F] block">{{ $room->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 font-serif text-base text-[#1C1B18]">
                            <div>{{ $room->name }}</div>
                            <span class="text-xs font-sans text-[#6E6A5F] block">{{ $room->tagline }}</span>
                        </td>
                        <td class="p-4 font-serif text-base font-semibold text-[#9E7B56] tabular-nums">
                            {{ $room->formatted_price }}
                        </td>
                        <td class="p-4 text-xs text-[#6E6A5F]">
                            <div>{{ $room->capacity }} Tamu &bull; {{ $room->size }}</div>
                            <span class="text-[11px] text-[#8C877D]">{{ $room->bed_type }}</span>
                        </td>
                        <td class="p-4">
                            @if($room->video_url)
                                <a href="{{ asset($room->video_url) }}" target="_blank" class="inline-flex items-center space-x-1 text-xs text-[#9E7B56] hover:underline font-medium">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                    <span>Lihat Video</span>
                                </a>
                            @else
                                <span class="text-xs text-[#8C877D]">Belum ada video</span>
                            @endif
                        </td>
                        <td class="p-4 text-xs font-medium text-[#1C1B18]">
                            {{ $room->reservations_count }} Reservasi
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn-luxury-outline text-[11px] py-1.5 px-3">
                                Edit
                            </a>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tipe kamar {{ $room->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-[11px] uppercase tracking-wider font-semibold py-1.5 px-2">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

