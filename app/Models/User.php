<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User
 * 
 * Deskripsi: Model entitas pengguna sistem dengan dukungan otorisasi multi-role (Admin dan Guest).
 * Initial State: Objek user belum diinisialisasi atau belum diambil dari database.
 * Final State: Menyediakan atribut pengguna, relasi ke riwayat reservasi, dan metode pengecekan role.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Deskripsi: Memeriksa apakah user saat ini memiliki role sebagai Administrator.
     * Initial State: Nilai string role user pada database ('admin' atau 'guest').
     * Final State: Menghasilkan nilai boolean true jika role adalah admin, false jika bukan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Deskripsi: Memeriksa apakah user saat ini memiliki role sebagai Guest (tamu).
     * Initial State: Nilai string role user pada database.
     * Final State: Menghasilkan boolean true jika role guest atau non-admin.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    /**
     * Deskripsi: Mendapatkan daftar seluruh reservasi yang dimiliki oleh user ini.
     * Initial State: User belum memuat relasi ke tabel reservations.
     * Final State: Menghasilkan relasi HasMany ke model Reservation.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
