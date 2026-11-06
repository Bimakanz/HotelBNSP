<?php

namespace App\Services;

/**
 * Service RoomPricingService
 *
 * Deskripsi: Layanan perhitungan tarif reservasi, diskon durasi menginap, kalkulasi sarapan,
 *            serta algoritma manipulasi dan pengurutan (sorting) array harga kamar sesuai standar BNSP.
 * Initial State: Parameter input belum divalidasi dan dihitung.
 * Final State: Menghasilkan rincian kalkulasi keuangan pemesanan kamar dan koleksi array terurut.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class RoomPricingService
{
    /**
     * Biaya tambahan sarapan (breakfast) per reservasi sesuai instruksi skenario soal.
     */
    public const BREAKFAST_FLAT_FEE = 80000;

    /**
     * Ambang batas hari minimal untuk mendapatkan diskon (menginap lebih dari 3 hari).
     */
    public const DISCOUNT_MIN_DAYS = 3;

    /**
     * Persentase diskon untuk menginap lebih dari 3 hari.
     */
    public const DISCOUNT_PERCENT = 10;

    /**
     * Deskripsi: Menghitung rincian total bayar berdasarkan harga kamar, durasi, dan opsi breakfast.
     * Initial State: Nilai harga kamar (float/int), durasi menginap (int), dan status sarapan (bool).
     * Final State: Array asosiatif berisi subtotal, diskon persentase, nominal diskon, biaya sarapan, dan total bayar.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function calculateBooking(float|int|string $roomPrice, int $stayDuration, bool $includesBreakfast): array
    {
        $roomPrice = (float) $roomPrice;

        // 1. Hitung subtotal kamar: Harga Kamar x Durasi Menginap
        $subtotal = $roomPrice * $stayDuration;

        // 2. Evaluasi diskon: Jika durasi > 3 hari, diskon 10% dari subtotal
        $discountPercent = 0.0;
        $discountAmount = 0.0;

        if ($stayDuration > self::DISCOUNT_MIN_DAYS) {
            $discountPercent = (float) self::DISCOUNT_PERCENT;
            $discountAmount = ($subtotal * $discountPercent) / 100.0;
        }

        // 3. Tambahan biaya sarapan (breakfast) Rp 80.000 x Durasi Menginap jika dicentang
        $breakfastFee = $includesBreakfast ? ((float) self::BREAKFAST_FLAT_FEE * $stayDuration) : 0.0;

        // 4. Kalkulasi Total Bayar: Subtotal - Diskon + Biaya Breakfast
        $totalPayment = $subtotal - $discountAmount + $breakfastFee;

        return [
            'room_price' => $roomPrice,
            'stay_duration' => $stayDuration,
            'includes_breakfast' => $includesBreakfast,
            'subtotal' => $subtotal,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'breakfast_fee' => $breakfastFee,
            'total_payment' => $totalPayment,
            'formatted_subtotal' => number_format($subtotal, 0, ',', '.'),
            'formatted_discount' => intval($discountPercent).'%',
            'formatted_total' => number_format($totalPayment, 0, ',', '.'),
        ];
    }

    /**
     * Deskripsi: Melakukan pengurutan (sorting) data array kamar berdasarkan harga secara terstruktur
     *            menggunakan algoritma Bubble Sort manual untuk membuktikan penguasaan algoritma array BNSP.
     * Initial State: Array 2-dimensi daftar kamar dengan panjang n yang urutannya acak atau belum berurutan.
     * Final State: Array 2-dimensi terurut berdasarkan harga kamar (ascending atau descending).
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     *
     * @param  array  $roomsArray  Array daftar kamar
     * @param  string  $order  Arah pengurutan ('asc' atau 'desc')
     * @return array Array terurut
     */
    public function sortRoomsByPriceBubble(array $roomsArray, string $order = 'asc'): array
    {
        // Panjang array kamar (n)
        $n = count($roomsArray);

        // Algoritma Bubble Sort Pemrograman Terstruktur
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                $priceA = (float) ($roomsArray[$j]['price'] ?? 0);
                $priceB = (float) ($roomsArray[$j + 1]['price'] ?? 0);

                $condition = ($order === 'desc') ? ($priceA < $priceB) : ($priceA > $priceB);

                // Pertukaran elemen (swap) jika urutan belum sesuai kriteria
                if ($condition) {
                    $temp = $roomsArray[$j];
                    $roomsArray[$j] = $roomsArray[$j + 1];
                    $roomsArray[$j + 1] = $temp;
                }
            }
        }

        return $roomsArray;
    }
}
