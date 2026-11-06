<?php

namespace Tests\Unit;

use App\Services\RoomPricingService;
use PHPUnit\Framework\TestCase;

/**
 * Unit Test RoomPricingServiceTest
 * 
 * Deskripsi: Menguji validitas logika matematis perhitungan tarif sewa kamar, diskon durasi,
 *            biaya tambahan breakfast, serta algoritma manual pengurutan array (Bubble Sort).
 * Initial State: Service RoomPricingService diinisialisasi.
 * Final State: Seluruh skenario rumus perhitungan dan pengurutan array terverifikasi akurat.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class RoomPricingServiceTest extends TestCase
{
    private RoomPricingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RoomPricingService();
    }

    /**
     * Uji pemesanan 3 hari tanpa diskon (durasi <= 3 tidak dapat diskon).
     */
    public function test_booking_three_days_has_no_discount(): void
    {
        // Standar Rp 500.000, 3 hari, dengan breakfast (80.000 x 3 = 240.000)
        $result = $this->service->calculateBooking(500000, 3, true);

        $this->assertEquals(1500000, $result['subtotal']);
        $this->assertEquals(0, $result['discount_percent']);
        $this->assertEquals(0, $result['discount_amount']);
        $this->assertEquals(240000, $result['breakfast_fee']);
        $this->assertEquals(1740000, $result['total_payment']);
    }

    /**
     * Uji pemesanan lebih dari 3 hari (misal 4 hari) mendapatkan diskon 10%.
     */
    public function test_booking_more_than_three_days_gets_ten_percent_discount(): void
    {
        // Deluxe Rp 750.000, 4 hari, dengan breakfast
        // Subtotal = 750.000 * 4 = 3.000.000
        // Diskon 10% = 300.000
        // Breakfast = 80.000 * 4 = 320.000
        // Total = 3.000.000 - 300.000 + 320.000 = 3.020.000
        $result = $this->service->calculateBooking(750000, 4, true);

        $this->assertEquals(3000000, $result['subtotal']);
        $this->assertEquals(10, $result['discount_percent']);
        $this->assertEquals(300000, $result['discount_amount']);
        $this->assertEquals(320000, $result['breakfast_fee']);
        $this->assertEquals(3020000, $result['total_payment']);
    }

    /**
     * Uji pemesanan tanpa sarapan (breakfast = false).
     */
    public function test_booking_without_breakfast(): void
    {
        $result = $this->service->calculateBooking(1000000, 2, false);

        $this->assertEquals(2000000, $result['subtotal']);
        $this->assertEquals(0, $result['breakfast_fee']);
        $this->assertEquals(2000000, $result['total_payment']);
    }

    /**
     * Uji fungsi algoritma pengurutan array (Bubble Sort) secara ascending dan descending.
     */
    public function test_bubble_sort_rooms_by_price(): void
    {
        $rooms = [
            ['name' => 'Family', 'price' => 1000000],
            ['name' => 'Standar', 'price' => 500000],
            ['name' => 'Deluxe', 'price' => 750000],
        ];

        // Uji Ascending (Termurah ke termahal)
        $sortedAsc = $this->service->sortRoomsByPriceBubble($rooms, 'asc');
        $this->assertEquals(500000, $sortedAsc[0]['price']);
        $this->assertEquals(750000, $sortedAsc[1]['price']);
        $this->assertEquals(1000000, $sortedAsc[2]['price']);

        // Uji Descending (Termahal ke termurah)
        $sortedDesc = $this->service->sortRoomsByPriceBubble($rooms, 'desc');
        $this->assertEquals(1000000, $sortedDesc[0]['price']);
        $this->assertEquals(750000, $sortedDesc[1]['price']);
        $this->assertEquals(500000, $sortedDesc[2]['price']);
    }
}

