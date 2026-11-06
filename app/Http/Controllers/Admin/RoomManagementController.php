<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controller RoomManagementController
 * 
 * Deskripsi: Mengelola operasi CRUD (Create, Read, Update, Delete) data master kamar,
 *            termasuk pengaturan harga, kapasitas, fasilitas, foto galeri, dan video preview.
 * Initial State: Pengguna dengan role Admin mengakses modul manajemen kamar.
 * Final State: Data master kamar diperbarui dan tersinkronisasi di database.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class RoomManagementController extends Controller
{
    /**
     * Deskripsi: Menampilkan daftar seluruh master tipe kamar yang terdaftar di hotel.
     * Initial State: Rute /admin/rooms diakses.
     * Final State: View tabel kamar ditampilkan lengkap dengan status dan tombol aksi.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function index(): View
    {
        $rooms = Room::withCount('reservations')->orderBy('price', 'asc')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Deskripsi: Menampilkan formulir penambahan kamar baru.
     * Initial State: Admin mengklik tombol "Tambah Kamar".
     * Final State: Formulir input kamar baru dirender ke layar.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function create(): View
    {
        return view('admin.rooms.create');
    }

    /**
     * Deskripsi: Memvalidasi dan menyimpan data tipe kamar baru ke dalam database.
     * Initial State: Data kamar dikirim melalui metode POST.
     * Final State: Record kamar baru tersimpan dan admin dialihkan kembali ke daftar kamar.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code'        => ['required', 'string', 'max:20', 'unique:rooms,code'],
            'name'        => ['required', 'string', 'max:100'],
            'tagline'     => ['nullable', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'bed_type'    => ['required', 'string', 'max:100'],
            'size'        => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'facilities'  => ['nullable', 'string'], // Dipisahkan koma atau baris baru
            'image_url'   => ['nullable', 'string'],
            'image_file'  => ['nullable', 'image', 'max:4096'],
            'video_url'   => ['nullable', 'string'],
            'video_file'  => ['nullable', 'mimes:mp4,mov,ogg,webm', 'max:20480'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // Tangani unggahan foto utama
        $imageUrl = $validated['image_url'] ?? '/assets/rooms/standar.jpg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'room_' . time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/rooms'), $fileName);
            $imageUrl = '/assets/rooms/' . $fileName;
        }

        // Tangani unggahan file video preview
        $videoUrl = $validated['video_url'] ?? '/assets/rooms/preview_standar.mp4';
        if ($request->hasFile('video_file')) {
            $vFile = $request->file('video_file');
            $vFileName = 'video_' . time() . '_' . Str::slug($validated['name']) . '.' . $vFile->getClientOriginalExtension();
            $vFile->move(public_path('assets/rooms'), $vFileName);
            $videoUrl = '/assets/rooms/' . $vFileName;
        }

        // Olah fasilitas dari input teks menjadi array JSON
        $facilitiesArray = [];
        if (!empty($validated['facilities'])) {
            $lines = preg_split('/[\r\n,]+/', $validated['facilities']);
            $facilitiesArray = array_values(array_filter(array_map('trim', $lines)));
        }

        Room::create([
            'code'        => strtoupper($validated['code']),
            'name'        => $validated['name'],
            'tagline'     => $validated['tagline'],
            'price'       => $validated['price'],
            'capacity'    => $validated['capacity'],
            'bed_type'    => $validated['bed_type'],
            'size'        => $validated['size'],
            'description' => $validated['description'],
            'facilities'  => $facilitiesArray,
            'image_url'   => $imageUrl,
            'gallery'     => [$imageUrl],
            'video_url'   => $videoUrl,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Master tipe kamar baru berhasil ditambahkan.');
    }

    /**
     * Deskripsi: Menampilkan form edit data master kamar.
     * Initial State: Admin memilih kamar yang ingin diubah.
     * Final State: View form edit dirender dengan data kamar saat ini.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function edit(Room $room): View
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Deskripsi: Menyimpan pembaruan data master kamar ke database.
     * Initial State: Form edit dikirim melalui metode PUT.
     * Final State: Data kamar terupdate di tabel rooms.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'code'        => ['required', 'string', 'max:20', 'unique:rooms,code,' . $room->id],
            'name'        => ['required', 'string', 'max:100'],
            'tagline'     => ['nullable', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'bed_type'    => ['required', 'string', 'max:100'],
            'size'        => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'facilities'  => ['nullable', 'string'],
            'image_url'   => ['nullable', 'string'],
            'image_file'  => ['nullable', 'image', 'max:4096'],
            'video_url'   => ['nullable', 'string'],
            'video_file'  => ['nullable', 'mimes:mp4,mov,ogg,webm', 'max:20480'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $imageUrl = $validated['image_url'] ?? $room->image_url;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'room_' . time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/rooms'), $fileName);
            $imageUrl = '/assets/rooms/' . $fileName;
        }

        $videoUrl = $validated['video_url'] ?? $room->video_url;
        if ($request->hasFile('video_file')) {
            $vFile = $request->file('video_file');
            $vFileName = 'video_' . time() . '_' . Str::slug($validated['name']) . '.' . $vFile->getClientOriginalExtension();
            $vFile->move(public_path('assets/rooms'), $vFileName);
            $videoUrl = '/assets/rooms/' . $vFileName;
        }

        $facilitiesArray = [];
        if (!empty($validated['facilities'])) {
            $lines = preg_split('/[\r\n,]+/', $validated['facilities']);
            $facilitiesArray = array_values(array_filter(array_map('trim', $lines)));
        }

        $room->update([
            'code'        => strtoupper($validated['code']),
            'name'        => $validated['name'],
            'tagline'     => $validated['tagline'],
            'price'       => $validated['price'],
            'capacity'    => $validated['capacity'],
            'bed_type'    => $validated['bed_type'],
            'size'        => $validated['size'],
            'description' => $validated['description'],
            'facilities'  => $facilitiesArray,
            'image_url'   => $imageUrl,
            'video_url'   => $videoUrl,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Data tipe kamar ' . $room->name . ' berhasil diperbarui.');
    }

    /**
     * Deskripsi: Menghapus data master kamar dari database.
     * Initial State: Kamar ada di database.
     * Final State: Record kamar terhapus dari tabel rooms.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function destroy(Room $room): RedirectResponse
    {
        $name = $room->name;
        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Tipe kamar ' . $name . ' berhasil dihapus.');
    }
}

