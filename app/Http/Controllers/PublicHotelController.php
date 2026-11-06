<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Services\RoomPricingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controller PublicHotelController
 * 
 * Deskripsi: Mengelola seluruh antarmuka publik hotel yang mencakup:
 *            1. Halaman Beranda & Produk Kamar (3 jenis kamar beserta foto dan video preview)
 *            2. Daftar Harga dengan implementasi sorting array terstruktur (Bubble Sort)
 *            3. Profil Tentang Kami (alamat, kontak, email)
 *            4. Form Pemesanan Kamar interaktif beserta validasi spesifik BNSP
 *            5. Tampilan Ringkasan/Invoice Hasil Simpan Pemesanan
 *            6. Riwayat Pemesanan untuk Guest yang sedang login
 * Initial State: Pengguna mengakses rute publik aplikasi reservasi hotel.
 * Final State: Data kamar/reservasi diproses dan dirender ke view berestetika Editorial Luxury.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class PublicHotelController extends Controller
{
    /**
     * Layanan perhitungan tarif kamar dan algoritma array sorting.
     */
    protected RoomPricingService $pricingService;

    /**
     * Inisialisasi dependensi service.
     */
    public function __construct(RoomPricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    /**
     * Deskripsi: Menampilkan halaman utama (Landing Page) hotel bergaya Editorial Boutique.
     * Initial State: Tamu membuka website pada root URL (/).
     * Final State: Menampilkan banner visual, narasi hotel, preview 3 tipe kamar, dan tautan reservasi.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function index(): View
    {
        $rooms = Room::where('is_active', true)->orderBy('price', 'asc')->get();
        return view('public.home', compact('rooms'));
    }

    /**
     * Deskripsi: Menampilkan Menu Produk Kamar yang menyajikan 3 jenis kamar (Standar, Deluxe, Family)
     *            lengkap dengan galeri foto beresolusi tinggi dan video preview interaktif untuk tiap kamar.
     * Initial State: Pengguna mengklik menu "Produk Kamar".
     * Final State: View katalog kamar lengkap dengan galeri dan video player HTML5 ditampilkan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function rooms(): View
    {
        $rooms = Room::where('is_active', true)->orderBy('price', 'asc')->get();
        return view('public.rooms', compact('rooms'));
    }

    /**
     * Deskripsi: Menampilkan Menu Daftar Harga kamar hotel dalam format tabel perbandingan bersih.
     *            Mengimplementasikan fungsi pemanfaatan array dan pengurutan (sorting) terstruktur
     *            menggunakan algoritma Bubble Sort pada Service untuk memenuhi rubrik penilaian BNSP.
     * Initial State: Pengguna membuka menu "Daftar Harga" dengan parameter sorting opsional (?sort=asc/desc).
     * Final State: Data kamar dikonversi ke array, diurutkan secara terstruktur, dan dirender ke tabel perbandingan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function pricing(Request $request): View
    {
        // Ambil data kamar aktif dari database
        $roomsCollection = Room::where('is_active', true)->get();

        // Konversi ke format array murni untuk mempraktikkan manipulasi array terstruktur
        $roomsArray = $roomsCollection->toArray();

        // Parameter arah sorting (default: asc / termurah ke termahal)
        $sortOrder = $request->query('sort', 'asc');
        if (!in_array($sortOrder, ['asc', 'desc'], true)) {
            $sortOrder = 'asc';
        }

        // Panggil fungsi pengurutan array (Bubble Sort) yang terdokumentasi di RoomPricingService
        $sortedRooms = $this->pricingService->sortRoomsByPriceBubble($roomsArray, $sortOrder);

        return view('public.pricing', [
            'rooms'        => $sortedRooms,
            'currentSort'  => $sortOrder,
            'arrayLength'  => count($sortedRooms),
        ]);
    }

    /**
     * Deskripsi: Menampilkan Menu Tentang Kami yang berisi narasi profil hotel, alamat lengkap,
     *            nomor telepon, alamat email resmi, serta kartu fasilitas hotel.
     * Initial State: Pengguna membuka menu "Tentang Kami".
     * Final State: View profil hotel ditampilkan secara komprehensif.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function about(): View
    {
        return view('public.about');
    }

    /**
     * Deskripsi: Menampilkan formulir pemesanan kamar hotel (Menu Pesan Kamar) yang interaktif.
     * Initial State: Pengguna membuka menu pemesanan kamar atau memilih kamar dari katalog.
     * Final State: View formulir pemesanan siap menerima input dengan data harga kamar otomatis.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function bookingForm(Request $request): View
    {
        $rooms = Room::where('is_active', true)->orderBy('price', 'asc')->get();

        // Tangkap parameter kamar yang dipilih sebelumnya jika ada (misal dari tombol "Pesan Kamar Ini")
        $selectedRoomId = $request->query('room_id', $rooms->first()->id ?? null);
        $selectedRoom = $rooms->firstWhere('id', $selectedRoomId) ?? $rooms->first();

        return view('public.booking-form', compact('rooms', 'selectedRoom'));
    }

    /**
     * Deskripsi: Endpoint AJAX/JSON untuk menghitung Total Bayar tanpa reload halaman.
     * Initial State: Request membawa data room_id, stay_duration, dan includes_breakfast.
     * Final State: Mengembalikan respons JSON berisi rincian kalkulasi subtotal, diskon, dan total bayar.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function calculate(Request $request): JsonResponse
    {
        $roomId = $request->input('room_id');
        $room = Room::find($roomId);

        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Kamar tidak ditemukan'], 404);
        }

        $duration = max(1, (int) $request->input('stay_duration', 1));
        $includesBreakfast = $request->boolean('includes_breakfast');

        $calculation = $this->pricingService->calculateBooking($room->price, $duration, $includesBreakfast);

        return response()->json([
            'success'     => true,
            'calculation' => $calculation,
        ]);
    }

    /**
     * Deskripsi: Memvalidasi dan menyimpan data pemesanan kamar hotel ke database sesuai standar BNSP.
     *            Menerapkan validasi persis:
     *            - Nomor Identitas harus 16 digit: "isian salah..data harus 16 digit"
     *            - Durasi Menginap harus angka: "harus isi angka"
     * Initial State: Form pemesanan dikirim melalui metode POST.
     * Final State: Data transaksi pemesanan tersimpan di database dan pengguna diarahkan ke kartu invoice/ringkasan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function storeBooking(Request $request): RedirectResponse
    {
        // 1. Validasi Input Form dengan pesan error persis sesuai panduan soal BNSP
        $validated = $request->validate([
            'customer_name'      => ['required', 'string', 'max:150'],
            'gender'             => ['required', 'in:Laki-laki,Perempuan'],
            'identity_number'    => ['required', 'regex:/^[0-9]{16}$/'],
            'room_id'            => ['required', 'exists:rooms,id'],
            'booking_date'       => ['required', 'date'],
            'stay_duration'      => ['required', 'integer', 'min:1'],
            'includes_breakfast' => ['nullable'],
        ], [
            'customer_name.required'   => 'Nama pemesan wajib diisi.',
            'gender.required'          => 'Silakan pilih jenis kelamin.',
            'gender.in'                => 'Pilihan jenis kelamin tidak valid.',
            // Pesan error wajib persis sesuai dokumen uji BNSP:
            'identity_number.required' => 'isian salah..data harus 16 digit',
            'identity_number.regex'    => 'isian salah..data harus 16 digit',
            'room_id.required'         => 'Silakan tentukan tipe kamar.',
            'booking_date.required'    => 'Tanggal pesan wajib diisi.',
            // Pesan error wajib persis sesuai dokumen uji BNSP:
            'stay_duration.required'   => 'harus isi angka',
            'stay_duration.integer'    => 'harus isi angka',
            'stay_duration.min'        => 'harus isi angka',
        ]);

        // 2. Ambil data master kamar terpilih
        $room = Room::findOrFail($validated['room_id']);

        // 3. Jalankan kalkulasi tarif melalui RoomPricingService
        $duration = (int) $validated['stay_duration'];
        $includesBreakfast = $request->boolean('includes_breakfast');
        $calc = $this->pricingService->calculateBooking($room->price, $duration, $includesBreakfast);

        // 4. Generate kode booking unik (contoh: RSV-20261102-ABCD)
        $bookingCode = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 5. Simpan transaksi pemesanan ke tabel reservations
        $reservation = Reservation::create([
            'booking_code'       => $bookingCode,
            'user_id'            => Auth::id(), // null jika tamu belum mendaftar/login
            'customer_name'      => $validated['customer_name'],
            'gender'             => $validated['gender'],
            'identity_number'    => $validated['identity_number'],
            'room_id'            => $room->id,
            'room_type_name'     => $room->name,
            'room_price'         => $room->price,
            'booking_date'       => $validated['booking_date'],
            'stay_duration'      => $duration,
            'includes_breakfast' => $includesBreakfast,
            'breakfast_fee'      => $calc['breakfast_fee'],
            'subtotal'           => $calc['subtotal'],
            'discount_percent'   => $calc['discount_percent'],
            'discount_amount'    => $calc['discount_amount'],
            'total_payment'      => $calc['total_payment'],
            'status'             => 'confirmed',
            'notes'              => $request->input('notes'),
        ]);

        // 6. Redirect ke halaman kartu ringkasan hasil simpan data (Invoice Card)
        return redirect()->route('booking.summary', $reservation->id)
            ->with('success', 'Reservasi kamar berhasil disimpan ke dalam sistem database.');
    }

    /**
     * Deskripsi: Menampilkan kartu ringkasan hasil pemesanan (Invoice / Reservation Summary)
     *            yang memuat persis data sesuai format visual standar asesmen BNSP:
     *            - Nama Pemesan
     *            - Nomor Identitas
     *            - Jenis Kelamin
     *            - Tipe Kamar
     *            - Durasi Penginapan (format: 3 Hari)
     *            - Discount (format: 10% atau 0%)
     *            - Total Bayar (format: 1.590.000 dengan pemisah ribuan titik)
     * Initial State: Reservasi telah tersimpan di tabel database.
     * Final State: View ringkasan faktur pemesanan ditampilkan dengan desain editorial luxury.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function bookingSummary(Reservation $reservation): View
    {
        return view('public.booking-summary', compact('reservation'));
    }

    /**
     * Deskripsi: Menampilkan daftar riwayat reservasi milik tamu yang sedang login.
     * Initial State: Pengguna dengan role 'guest' mengakses menu pesanan saya.
     * Final State: Daftar pemesanan milik tamu ditampilkan dengan status dan aksi detail.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function myBookings(): View
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guest.my-bookings', compact('reservations'));
    }
}

