<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\View\View;

/**
 * Controller AdminDashboardController
 * 
 * Deskripsi: Menyajikan ringkasan analitik dan metrik kinerja operasional hotel untuk Role Admin/Resepsionis,
 *            meliputi total omset/pendapatan, jumlah reservasi, rasio pemesanan per tipe kamar, serta daftar booking terbaru.
 * Initial State: Administrator membuka panel dashboard.
 * Final State: Data statistik teragregasi dirender dalam antarmuka editorial luxury yang profesional.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class AdminDashboardController extends Controller
{
    /**
     * Deskripsi: Menampilkan metrik statistik utama dan daftar transaksi masuk terbaru.
     * Initial State: Admin mengakses rute /admin/dashboard.
     * Final State: View dashboard dengan kartu metrik finansial dan tabel reservasi termutakhir.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function index(): View
    {
        // 1. Agregasi total pendapatan hotel dari seluruh transaksi reservasi
        $totalRevenue = Reservation::where('status', '!=', 'cancelled')->sum('total_payment');

        // 2. Total seluruh transaksi pemesanan
        $totalBookings = Reservation::count();

        // 3. Jumlah kamar aktif yang dikelola
        $totalRooms = Room::count();

        // 4. Hitung reservasi aktif hari ini
        $confirmedBookings = Reservation::where('status', 'confirmed')->count();

        // 5. Distribusi pemesanan per tipe kamar
        $roomStats = Room::withCount('reservations')->get();

        // 6. Ambil 5 reservasi terbaru
        $recentReservations = Reservation::with('room', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalRevenue'       => $totalRevenue,
            'totalBookings'      => $totalBookings,
            'totalRooms'         => $totalRooms,
            'confirmedBookings'  => $confirmedBookings,
            'roomStats'          => $roomStats,
            'recentReservations' => $recentReservations,
        ]);
    }
}

