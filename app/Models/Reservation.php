<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Reservation
 * 
 * Deskripsi: Model entitas reservasi kamar hotel untuk menyimpan data pemesanan, snapshot harga, perhitungan diskon, dan status.
 * Initial State: Objek pemesanan belum tersedia di memori.
 * Final State: Menyediakan atribut pemesanan, relasi ke user dan kamar, serta atribut formatting persis standar BNSP.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * Atribut mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'user_id',
        'customer_name',
        'gender',
        'identity_number',
        'room_id',
        'room_type_name',
        'room_price',
        'booking_date',
        'stay_duration',
        'includes_breakfast',
        'breakfast_fee',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'total_payment',
        'status',
        'notes',
    ];

    /**
     * Tipe casting atribut database.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'room_price' => 'decimal:2',
        'breakfast_fee' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'includes_breakfast' => 'boolean',
        'stay_duration' => 'integer',
    ];

    /**
     * Deskripsi: Relasi ke pengguna yang melakukan pemesanan (opsional jika tamu anonim/guest).
     * Initial State: Relasi user belum dimuat.
     * Final State: Mengembalikan objek BelongsTo relasi user.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Deskripsi: Relasi ke data master kamar yang dipesan.
     * Initial State: Relasi room belum dimuat.
     * Final State: Mengembalikan objek BelongsTo relasi room.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Deskripsi: Format teks durasi penginapan sesuai format standar asesmen BNSP (contoh: "3 Hari").
     * Initial State: Integer durasi (misal: 3).
     * Final State: String dengan akhiran " Hari".
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function getFormattedDurationAttribute(): string
    {
        return $this->stay_duration . ' Hari';
    }

    /**
     * Deskripsi: Format persentase diskon sesuai format standar asesmen BNSP (contoh: "10%" atau "0%").
     * Initial State: Nilai float/desimal discount_percent.
     * Final State: String persentase terformat rapi bulat (contoh: "10%").
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function getFormattedDiscountAttribute(): string
    {
        return intval($this->discount_percent) . '%';
    }

    /**
     * Deskripsi: Format nominal total bayar dengan pemisah ribuan titik persis sesuai contoh BNSP (contoh: "1.590.000").
     * Initial State: Desimal nilai total_payment di database.
     * Final State: String angka dengan separator titik tanpa desimal tambahan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function getFormattedTotalPaymentAttribute(): string
    {
        return number_format($this->total_payment, 0, ',', '.');
    }
}

