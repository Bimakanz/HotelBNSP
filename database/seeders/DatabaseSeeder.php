<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Services\RoomPricingService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder DatabaseSeeder
 *
 * Deskripsi: Inisialisasi data awal aplikasi sistem hotel, meliputi akun Admin, Guest contoh,
 *            3 data master tipe kamar (Standar, Deluxe, Family) dengan media visual lengkap,
 *            serta data sampel reservasi awal.
 * Initial State: Tabel users, rooms, dan reservations dalam keadaan kosong.
 * Final State: Database terisi data user kredensial, katalog 3 tipe kamar, dan transaksi contoh.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Deskripsi: Menjalankan eksekusi seeding ke database.
     * Initial State: Tabel-tabel kosong.
     * Final State: Data terpopulasi dan terhubung secara relasional.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function run(): void
    {
        // 1. Buat Akun Admin / Resepsionis Siap Pakai
        $admin = User::firstOrCreate(
            ['email' => 'admin@hotelbnsp.test'],
            [
                'name' => 'Administrator Resepsionis',
                'role' => 'admin',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Buat Akun Tamu / Guest Contoh
        $guest = User::firstOrCreate(
            ['email' => 'guest@hotelbnsp.test'],
            [
                'name' => 'Andri Santosa',
                'role' => 'guest',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Buat 3 Master Kamar Sesuai Skenario Soal BNSP
        // Kamar Standar: Rp 500.000
        /** @var Room $standar */
        $standar = Room::updateOrCreate(
            ['code' => 'STD-01'],
            [
                'name' => 'Standar',
                'tagline' => 'Garden Pavilion Sanctuary',
                'price' => 500000,
                'capacity' => 2,
                'bed_type' => '1 Queen Bed',
                'size' => '32 m²',
                'description' => 'Kamar bertema minimalis tropis dengan jendela panorama menghadap ke taman asri hotel. Didesain dengan material kayu jati hangat, seprai katun Mesir organik, serta pencahayaan hangat untuk kenyamanan istirahat maksimal.',
                'facilities' => [
                    'Wi-Fi Kecepatan Tinggi (100 Mbps)',
                    'Smart TV 43 Inci Full HD',
                    'Rain Shower Panas & Dingin',
                    'AC Inverter Hemat Energi',
                    'Amenitas Mandi Herbal Organik',
                    'Complimentary Artisan Tea & Coffee',
                    'Safe Deposit Box Digital',
                ],
                'image_url' => '/assets/rooms/standar.jpg',
                'gallery' => [
                    '/assets/rooms/standar.jpg',
                    '/assets/rooms/deluxe.jpg',
                ],
                'video_url' => '/assets/rooms/preview_standar.mp4',
                'is_active' => true,
            ]
        );

        // Kamar Deluxe: Rp 750.000
        /** @var Room $deluxe */
        $deluxe = Room::updateOrCreate(
            ['code' => 'DLX-02'],
            [
                'name' => 'Deluxe',
                'tagline' => 'Premier Ocean Horizon Suite',
                'price' => 750000,
                'capacity' => 2,
                'bed_type' => '1 King Bed',
                'size' => '48 m²',
                'description' => 'Suite elegan dengan balkon privat luas menghadap langsung ke laut dan lanskap kolam renang. Menawarkan bathtub marmer mewah, area lounge santai terpisah, dan soundbar bluetooth berkualitas studio.',
                'facilities' => [
                    'Balkon Privat dengan Pemandangan Laut',
                    'Bathtub Marmer Mewah & Jacuzzi Jet',
                    'Wi-Fi Cepat 150 Mbps',
                    'Smart TV 55 Inci 4K UHD',
                    'Mesin Kopi Kapsul Nespresso',
                    'Marshall Bluetooth Speaker',
                    'Layanan Setrika & Laundry Express',
                ],
                'image_url' => '/assets/rooms/deluxe.jpg',
                'gallery' => [
                    '/assets/rooms/deluxe.jpg',
                    '/assets/rooms/standar.jpg',
                ],
                'video_url' => '/assets/rooms/preview_deluxe.mp4',
                'is_active' => true,
            ]
        );

        // Kamar Family / Executive: Rp 1.000.000
        /** @var Room $family */
        $family = Room::updateOrCreate(
            ['code' => 'FML-03'],
            [
                'name' => 'Family',
                'tagline' => 'Royal Heritage Family Residence',
                'price' => 1000000,
                'capacity' => 4,
                'bed_type' => '2 King Beds & Living Lounge',
                'size' => '78 m²',
                'description' => 'Kamar keluarga prestisius dengan dua ranjang utama King-Size, ruang tamu luas untuk berkumpul, dapur mini fungsional, dan dua kamar mandi lengkap. Pilihan sempurna untuk liburan keluarga atau eksekutif.',
                'facilities' => [
                    '2 Ranjang King Bed Luas',
                    'Ruang Tamu & Meja Makan Terpisah',
                    'Pantry Mini & Microwave',
                    '2 Kamar Mandi dengan Bathtub Terpisah',
                    'Smart TV 65 Inci Bioskop Mini',
                    'Area Bermain Ramah Anak',
                    'Layanan Butler Pribadi Panggilan',
                ],
                'image_url' => '/assets/rooms/family.jpg',
                'gallery' => [
                    '/assets/rooms/family.jpg',
                    '/assets/rooms/deluxe.jpg',
                ],
                'video_url' => '/assets/rooms/preview_family.mp4',
                'is_active' => true,
            ]
        );

        // 4. Buat Contoh Reservasi Awal (Sesuai Contoh Uji Asesmen BNSP)
        $pricingService = new RoomPricingService;
        $calc1 = $pricingService->calculateBooking((float) $standar->price, 3, true);

        Reservation::firstOrCreate(
            ['booking_code' => 'RSV-20261102-0001'],
            [
                'user_id' => $guest->id,
                'customer_name' => 'Andri Santosa',
                'gender' => 'Laki-laki',
                'identity_number' => '3275091210770004',
                'room_id' => $standar->id,
                'room_type_name' => $standar->name,
                'room_price' => $standar->price,
                'booking_date' => Carbon::now()->format('Y-m-d'),
                'stay_duration' => 3,
                'includes_breakfast' => true,
                'breakfast_fee' => $calc1['breakfast_fee'],
                'subtotal' => $calc1['subtotal'],
                'discount_percent' => $calc1['discount_percent'],
                'discount_amount' => $calc1['discount_amount'],
                'total_payment' => $calc1['total_payment'],
                'status' => 'confirmed',
                'notes' => 'Pemesanan awal contoh evaluasi demonstrasi BNSP.',
            ]
        );

        // Reservasi contoh 2: Durasi 4 hari (Diskon 10%)
        $calc2 = $pricingService->calculateBooking((float) $deluxe->price, 4, true);
        Reservation::firstOrCreate(
            ['booking_code' => 'RSV-20261102-0002'],
            [
                'user_id' => null,
                'customer_name' => 'Siti Rahmawati',
                'gender' => 'Perempuan',
                'identity_number' => '3578014508920001',
                'room_id' => $deluxe->id,
                'room_type_name' => $deluxe->name,
                'room_price' => $deluxe->price,
                'booking_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'stay_duration' => 4,
                'includes_breakfast' => true,
                'breakfast_fee' => $calc2['breakfast_fee'],
                'subtotal' => $calc2['subtotal'],
                'discount_percent' => $calc2['discount_percent'],
                'discount_amount' => $calc2['discount_amount'],
                'total_payment' => $calc2['total_payment'],
                'status' => 'confirmed',
                'notes' => 'Contoh pemesanan dengan diskon 10% (durasi > 3 hari).',
            ]
        );
    }
}
