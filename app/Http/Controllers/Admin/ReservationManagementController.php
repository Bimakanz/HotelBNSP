<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller ReservationManagementController
 * 
 * Deskripsi: Mengelola pengawasan seluruh transaksi pemesanan tamu (reservasi),
 *            pencarian data pemesan, pembaruan status check-in/selesai, serta pembatalan booking.
 * Initial State: Administrator membuka modul data reservasi hotel.
 * Final State: Data transaksi terawasi dan status pemesanan terkelola secara akurat.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class ReservationManagementController extends Controller
{
    /**
     * Deskripsi: Menampilkan daftar seluruh reservasi masuk dengan filter status dan kata kunci pencarian.
     * Initial State: Admin mengakses rute /admin/reservations.
     * Final State: View tabel reservasi terpaginasi ditampilkan lengkap dengan ringkasan status.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function index(Request $request): View
    {
        $query = Reservation::with('room', 'user');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Pencarian nama, nomor identitas, atau kode booking
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%")
                  ->orWhere('booking_code', 'like', "%{$search}%");
            });
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Deskripsi: Menampilkan detail spesifik satu transaksi reservasi.
     * Initial State: Admin mengklik detail reservasi.
     * Final State: View detail pemesanan lengkap ditampilkan ke layar.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function show(Reservation $reservation): View
    {
        $reservation->load('room', 'user');
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Deskripsi: Memperbarui status reservasi tamu (confirmed, checked_in, completed, cancelled).
     * Initial State: Admin memilih status baru dari dropdown aksi status.
     * Final State: Kolom status diperbarui di database dan notifikasi sukses ditampilkan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function updateStatus(Request $request, Reservation $reservation): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,checked_in,completed,cancelled'],
        ]);

        $reservation->update(['status' => $validated['status']]);

        return back()->with('success', 'Status reservasi #' . $reservation->booking_code . ' berhasil diubah menjadi: ' . ucfirst(str_replace('_', ' ', $validated['status'])));
    }

    /**
     * Deskripsi: Menghapus data reservasi dari database.
     * Initial State: Reservasi tersimpan di tabel reservations.
     * Final State: Record reservasi dihapus permanen dari sistem.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        $code = $reservation->booking_code;
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Data reservasi ' . $code . ' berhasil dihapus.');
    }
}

