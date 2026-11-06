<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature Test HotelBookingTest
 * 
 * Deskripsi: Menguji alur fitur pemesanan kamar hotel dari halaman publik,
 *            validasi form persis standar BNSP, dan penyimpanan ke tabel database.
 * Initial State: Database di-refresh dan diisi master kamar.
 * Final State: Seluruh endpoint publik dan alur transaksi berhasil diuji.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class HotelBookingTest extends TestCase
{
    use RefreshDatabase;

    protected Room $room;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->room = Room::create([
            'code'        => 'STD-01',
            'name'        => 'Standar',
            'tagline'     => 'Garden Sanctuary',
            'price'       => 500000,
            'capacity'    => 2,
            'bed_type'    => '1 Queen Bed',
            'size'        => '32 m²',
            'description' => 'Kamar standar tropis asri.',
            'facilities'  => ['Wi-Fi', 'Smart TV'],
            'image_url'   => '/assets/rooms/standar.jpg',
            'video_url'   => '/assets/rooms/preview_standar.mp4',
            'is_active'   => true,
        ]);
    }

    /**
     * Memastikan halaman-halaman publik utama dapat diakses dengan respons 200 OK.
     */
    public function test_public_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/rooms')->assertStatus(200);
        $this->get('/about')->assertStatus(200);
        $this->get('/booking')->assertStatus(200);
    }

    /**
     * Memastikan validasi nomor identitas kurang dari atau lebih dari 16 digit menghasilkan pesan error persis.
     */
    public function test_identity_number_must_be_exact_16_digits(): void
    {
        $response = $this->post('/booking', [
            'customer_name'   => 'Andri Santosa',
            'gender'          => 'Laki-laki',
            'identity_number' => '12345', // Kurang dari 16 digit
            'room_id'         => $this->room->id,
            'booking_date'    => '2026-11-05',
            'stay_duration'   => 3,
        ]);

        $response->assertSessionHasErrors([
            'identity_number' => 'isian salah..data harus 16 digit',
        ]);
    }

    /**
     * Memastikan validasi durasi menginap bukan angka menghasilkan pesan error persis.
     */
    public function test_stay_duration_must_be_numeric(): void
    {
        $response = $this->post('/booking', [
            'customer_name'   => 'Andri Santosa',
            'gender'          => 'Laki-laki',
            'identity_number' => '3275091210770004',
            'room_id'         => $this->room->id,
            'booking_date'    => '2026-11-05',
            'stay_duration'   => 'tiga_hari', // Bukan angka
        ]);

        $response->assertSessionHasErrors([
            'stay_duration' => 'harus isi angka',
        ]);
    }

    /**
     * Memastikan data reservasi yang valid berhasil disimpan dan dialihkan ke kartu ringkasan.
     */
    public function test_valid_booking_stores_data_and_redirects_to_summary(): void
    {
        $payload = [
            'customer_name'      => 'Andri Santosa',
            'gender'             => 'Laki-laki',
            'identity_number'    => '3275091210770004',
            'room_id'            => $this->room->id,
            'booking_date'       => '2026-11-10',
            'stay_duration'      => 4,
            'includes_breakfast' => '1',
        ];

        $response = $this->post('/booking', $payload);

        $this->assertDatabaseHas('reservations', [
            'customer_name'   => 'Andri Santosa',
            'identity_number' => '3275091210770004',
            'room_type_name'  => 'Standar',
            'stay_duration'   => 4,
            'breakfast_fee'   => 320000,
            'discount_percent'=> 10,
            'total_payment'   => 2120000,
        ]);

        $reservation = Reservation::where('identity_number', '3275091210770004')->first();
        $this->assertNotNull($reservation);

        $response->assertRedirect(route('booking.summary', $reservation->id));

        // Kunjungi halaman ringkasan dan periksa elemen tampilan invoice
        $summaryPage = $this->get(route('booking.summary', $reservation->id));
        $summaryPage->assertStatus(200);
        $summaryPage->assertSee('Andri Santosa');
        $summaryPage->assertSee('3275091210770004');
        $summaryPage->assertSee('Standar');
        $summaryPage->assertSee('4 Hari');
        $summaryPage->assertSee('10%');
    }
}

