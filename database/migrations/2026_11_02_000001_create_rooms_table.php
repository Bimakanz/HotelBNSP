<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Deskripsi: Menjalankan migrasi untuk membuat tabel master data kamar (rooms).
     * Initial State: Tabel rooms belum ada dalam skema database.
     * Final State: Tabel rooms berhasil dibuat dengan atribut lengkap (kode, nama, harga, deskripsi, fasilitas, foto, video).
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 100); // Standar, Deluxe, Family
            $table->string('tagline', 150)->nullable();
            $table->decimal('price', 12, 2); // 500000, 750000, 1000000
            $table->integer('capacity')->default(2);
            $table->string('bed_type', 100)->default('1 Queen Bed');
            $table->string('size', 50)->default('32 m²');
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->string('image_url')->nullable();
            $table->json('gallery')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Deskripsi: Membatalkan migrasi dan menghapus tabel rooms.
     * Initial State: Tabel rooms ada di database.
     * Final State: Tabel rooms dihapus dari database.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

