<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Deskripsi: Menjalankan migrasi pembuatan tabel reservasi pemesanan kamar hotel (reservations).
     * Initial State: Tabel reservations belum ada dalam skema database.
     * Final State: Tabel reservations berhasil dibuat dengan relasi foreign key ke tabel users dan rooms.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 30)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_name', 150);
            $table->string('gender', 20); // Laki-laki / Perempuan
            $table->string('identity_number', 16); // Wajib tepat 16 digit
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('room_type_name', 100);
            $table->decimal('room_price', 12, 2);
            $table->date('booking_date');
            $table->integer('stay_duration'); // Durasi menginap dalam satuan hari
            $table->boolean('includes_breakfast')->default(false);
            $table->decimal('breakfast_fee', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_percent', 5, 2)->default(0); // 10 atau 0
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_payment', 12, 2);
            $table->string('status', 30)->default('confirmed'); // pending, confirmed, checked_in, completed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Deskripsi: Menghapus tabel reservations saat rollback migrasi.
     * Initial State: Tabel reservations ada di database.
     * Final State: Tabel reservations terhapus dari skema database.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

