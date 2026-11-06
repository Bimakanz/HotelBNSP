<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Room
 *
 * Deskripsi: Model entitas kamar hotel untuk mengelola data master kamar, fasilitas, galeri foto, dan video preview.
 * Initial State: Data kamar belum dimuat dari database.
 * Final State: Menyediakan atribut master kamar serta relasi ke daftar reservasi kamar terkait.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $tagline
 * @property float|string $price
 * @property int $capacity
 * @property string $bed_type
 * @property string $size
 * @property string $description
 * @property array $facilities
 * @property string $image_url
 * @property array $gallery
 * @property string $video_url
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Room extends Model
{
    use HasFactory;

    /**
     * Atribut mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'tagline',
        'price',
        'capacity',
        'bed_type',
        'size',
        'description',
        'facilities',
        'image_url',
        'gallery',
        'video_url',
        'is_active',
    ];

    /**
     * Tipe casting atribut database.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'facilities' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Deskripsi: Relasi has-many ke data reservasi kamar ini.
     * Initial State: Relasi belum dievaluasi.
     * Final State: Menghasilkan relasi HasMany ke entitas Reservation.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Deskripsi: Mendapatkan format harga kamar dalam standar mata uang Rupiah tanpa desimal (cth: Rp 500.000).
     * Initial State: Nilai numerik harga kamar mentah (misal: 500000.00).
     * Final State: String representasi mata uang Rupiah terformat rapi.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }
}
