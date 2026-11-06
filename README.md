# SISTEM RESERVASI HOTEL THE SERENITY PALACE
### Uji Kompetensi BNSP LSP Informatika — Skema Junior Web Developer (FR.SKEMA-02-07 / FR.IA.02)

Aplikasi Web Pemesanan Kamar Hotel dirancang dengan standar profesional industri dan kepatuhan penuh terhadap seluruh instrumen asesmen demonstrasi **BNSP (Badan Nasional Sertifikasi Profesi) LSP Informatika**. Mengusung konsep **Editorial Luxury Boutique Hotel** (anti-AI slop), arsitektur 2 Role terautentikasi (Guest & Admin), algoritma pemrograman terstruktur (Array Sorting), serta validasi client/server yang presisi.

---

## DAFTAR ISI
1. [Identitas Asesmen & Standar Kompetensi](#1-identitas-asesmen--standar-kompetensi)
2. [Arahan Desain UI/UX (Anti-AI Slop & Editorial Luxury)](#2-arahan-desain-uiux-anti-ai-slop--editorial-luxury)
3. [Arsitektur 2 Role & Kredensial Akun](#3-arsitektur-2-role--kredensial-akun)
4. [Fitur Wajib Skenario BNSP](#4-fitur-wajib-skenario-bnsp)
5. [Spesifikasi Form Pemesanan & Rumus Perhitungan](#5-spesifikasi-form-pemesanan--rumus-perhitungan)
6. [Implementasi Pemrograman Terstruktur (Array Sorting)](#6-implementasi-pemrograman-terstruktur-array-sorting)
7. [Struktur & Hirarki Folder Proyek](#7-struktur--hirarki-folder-proyek)
8. [Skema Basis Data (Data Dictionary)](#8-skema-basis-data-data-dictionary)
9. [Daftar Library & Teknologi](#9-daftar-library--teknologi)
10. [Panduan Instalasi & Menjalankan Aplikasi](#10-panduan-instalasi--menjalankan-aplikasi)

---

## 1. IDENTITAS ASESMEN & STANDAR KOMPETENSI

- **Judul Skema Sertifikasi:** Junior Web Developer
- **Nomor Skema:** FR.SKEMA-02-07
- **Kode Dokumen Asesmen:** FR.IA.02 Tugas Praktik Demonstrasi (Versi 20211011)
- **TUK:** Tempat Uji Kompetensi Mandiri / Sewaktu
- **Nama Asesi:** Bima Garda Nusantara
- **Waktu Pengerjaan:** 180 Menit
- **Unit Kompetensi yang Dipenuhi:**
  1. *Mengimplementasikan User Interface* (J.620100.017.02)
  2. *Menerapkan Perintah Eksekusi Bahasa Pemrograman Berbasis Teks, Grafik, dan Multimedia* (J.620100.016.01)
  3. *Menyusun Fungsi, File atau Sumber Daya Pemrograman yang Lain dalam Organisasi yang Rapi* (J.620100.018.02)
  4. *Menulis Kode dengan Prinsip Sesuai Guidelines dan Best Practices* (J.620100.019.02)
  5. *Mengimplementasikan Pemrograman Terstruktur* (J.620100.023.02)
  6. *Menggunakan Library atau Komponen Pre-Existing* (J.620100.025.02)

---

## 2. ARAHAN DESAIN UI/UX (ANTI-AI SLOP & EDITORIAL LUXURY)

Aplikasi ini menolak pendekatan template generik (*AI Slop*): tidak menggunakan gradasi neon ungu/biru murahan, tidak menggunakan drop-shadow tebal berlebih, dan tidak menggunakan tata letak klise.

### Karakteristik Visual Editorial Boutique Hotel:
- **Palet Warna Alami & Bersahaja:**
  - *Warm Alabaster* (`#FBF9F5`) sebagai latar belakang utama yang sejuk di mata.
  - *Deep Charcoal* (`#1C1B18`) untuk teks hierarki tinggi dan kontras tegas.
  - *Muted Taupe / Olive* (`#6E6A5F`) untuk teks deskripsi dan label sekunder.
  - *Aged Gold / Warm Terracotta* (`#9E7B56`) sebagai aksen premium dan status interaktif.
  - *Surface Linen* (`#F5F1E9`) untuk kartu dan pembatas halus.
- **Tipografi Bersih & Modern (Clean Sans-Serif):**
  - **Font Utama & Judul:** `Poppins` untuk seluruh judul utama (*hero*, nama kamar, tajuk faktur, menu navigasi) yang bersih, geometris, modern, dan bebas liukan serif.
  - **Teks Antarmuka & Numerik:** `Plus Jakarta Sans` & `Poppins` dengan penataan angka rapi vertikal (`tabular-nums`).
- **Detail Mikro:**
  - Garis pembatas tipis 1px solid (`border-[#E7E1D4]`).
  - *Whitespace* yang lega memberi ruang bernafas pada setiap elemen.
  - Modal video tour sinematik responsif untuk memutar pratinjau kamar.

---

## 3. ARSITEKTUR 2 ROLE & KREDENSIAL AKUN

Sistem dilengkapi mekanisme autentikasi dan otorisasi sesi berbasis role dengan *middleware* `RoleMiddleware`:

### Role 1: Tamu / Pengunjung (Guest)
- Menjelajahi menu publik: Katalog Produk Kamar, Daftar Harga, Tentang Kami.
- Mengisi formulir pemesanan kamar dengan kalkulasi harga instan tanpa reload.
- Menerima bukti reservasi (kartu invoice) sesuai format standar BNSP.
- Melakukan registrasi akun tamu dan melihat riwayat pemesanan miliknya di menu **Pesanan Saya**.

### Role 2: Resepsionis / Pengelola (Admin)
- Memiliki dashboard operasional eksklusif di rute `/admin/dashboard`.
- **Ringkasan Finansial:** Total omset pendapatan akumulatif, rasio pemesanan per tipe kamar, dan daftar transaksi terbaru.
- **Master Data Kamar (CRUD):** Tambah kamar baru, edit harga, kapasitas, deskripsi, fasilitas, unggah foto dan tautan video preview.
- **Pengawasan Reservasi:** Filter dan pencarian booking tamu (berdasarkan nama, NIK 16 digit, atau kode booking), ubah status booking (*Pending, Confirmed, Checked In, Completed, Cancelled*), dan hapus data.

### Kredensial Bawaan Database Seeder:
| Role | Email | Password | Kegunaan |
|---|---|---|---|
| **Admin** | `admin@hotelbnsp.test` | `password` | Akses Dashboard Pengelola & CRUD Kamar |
| **Guest** | `guest@hotelbnsp.test` | `password` | Pengujian Akun Tamu & Riwayat Reservasi |

*(Pada halaman login, disediakan tombol **Akses Cepat Pengujian Asesor** untuk pengisian kredensial 1-klik).*

---

## 4. FITUR WAJIB SKENARIO BNSP

Sesuai butir instruksi soal demonstrasi:

1. **Menu Produk Kamar (`/rooms`):**
   - Menampilkan 3 jenis kamar: **Standar** (Rp 500.000), **Deluxe** (Rp 750.000), dan **Family** (Rp 1.000.000).
   - Dilengkapi galeri foto interaktif untuk masing-masing tipe kamar.
   - Dilengkapi pemutar **Video Preview** sinematik HTML5 untuk setiap tipe kamar.
2. **Menu Daftar Harga (`/pricing`):**
   - Tabel perbandingan fasilitas (kapasitas, ukuran ruang, sarapan opsional, diskon).
   - Terintegrasi dengan algoritma pengurutan array manual (*Bubble Sort*).
3. **Menu Tentang Kami (`/about`):**
   - Uraian profil hotel, alamat lengkap: `Jl. Nirwana Highland No. 88, Resort Valley, Bandung, Jawa Barat`.
   - Nomor telepon resmi: `+62 (022) 8765-4321` / `+62 812-3456-7890`.
   - Alamat email resmi: `reservations@serenitypalace.test`.
4. **Menu Pesan Kamar (`/booking`):**
   - Form pemesanan interaktif dengan validasi ganda (JS & Laravel Request).
   - Output hasil simpan invoice card persis standar asesmen.

---

## 5. SPESIFIKASI FORM PEMESANAN & RUMUS PERHITUNGAN

### Aturan Validasi Input:
1. **Nama Pemesan:** Teks wajib diisi.
2. **Jenis Kelamin:** Radio button pilihan *Laki-laki* atau *Perempuan*.
3. **Nomor Identitas:** Wajib tepat 16 digit angka. Jika tidak 16 digit angka, tampilkan pesan error persis:  
   `"isian salah..data harus 16 digit"`
4. **Tipe Kamar:** Dropdown pilihan kamar (Standar, Deluxe, Family).
5. **Harga:** Input *readonly* yang terisi otomatis saat dropdown tipe kamar berubah:
   - Standar: `500.000`
   - Deluxe: `750.000`
   - Family: `1.000.000`
6. **Tanggal Pesan:** Kalender format tampilan `dd/mm/yyyy`.
7. **Durasi Menginap:** Input jumlah hari. Jika diisi bukan angka positif, tampilkan pesan error persis:  
   `"harus isi angka"`
8. **Termasuk Breakfast:** Checkbox dengan label *"Ya (Tambahan biaya Rp 80.000)"*.
9. **Total Bayar:** Input *readonly* yang terisi otomatis saat tombol **Hitung Total Bayar** diklik.

### Rumus Perhitungan Total Bayar:
$$\text{Subtotal Kamar} = \text{Harga Kamar} \times \text{Durasi Menginap}$$
$$\text{Diskon} = \begin{cases} 10\% \times \text{Subtotal Kamar}, & \text{jika Durasi Menginap} > 3 \text{ hari} \\ 0, & \text{jika Durasi Menginap} \le 3 \text{ hari} \end{cases}$$
$$\text{Biaya Sarapan} = \begin{cases} \text{Rp } 80.000, & \text{jika checkbox Termasuk Breakfast dicentang} \\ 0, & \text{jika tidak dicentang} \end{cases}$$
$$\text{Total Bayar} = \text{Subtotal Kamar} - \text{Diskon} + \text{Biaya Sarapan}$$

### Tiga Tombol Aksi:
- **[Hitung Total Bayar]:** Menjalankan kalkulasi secara instan di sisi klien tanpa *reload* halaman.
- **[Simpan]:** Memvalidasi form dan menyimpan transaksi ke tabel basis data.
- **[Cancel]:** Menyetel ulang (*reset*) formulir ke kondisi default.

### Format Tampilan Hasil Simpan (Kartu Faktur):
Persis sesuai *screenshot* acuan BNSP:
```
Nama Pemesan      : Andri Santosa
Nomor Identitas   : 3275091210770004
Jenis Kelamin     : Laki-laki
Tipe Kamar        : Standar
Durasi Penginapan : 3 Hari
Discount          : 10% (atau 0%)
Total Bayar       : 1.590.000 (atau 1.580.000)
```

---

## 6. IMPLEMENTASI PEMROGRAMAN TERSTRUKTUR (ARRAY SORTING)

Memenuhi **Unit Kompetensi 5 (Mengimplementasikan Pemrograman Terstruktur)**, khususnya Elemen 4: *Membuat program menggunakan array*:
- **Menentukan Dimensi Array:** Array 2 dimensi koleksi kamar hotel `array<int, array<string, mixed>>`.
- **Menentukan Tipe Data & Panjang:** Penggunaan tipe data terstruktur dan penentuan panjang array melalui fungsi `count($roomsArray)`.
- **Pengurutan Array Manual (Bubble Sort):**  
  Diimplementasikan pada `app/Services/RoomPricingService.php` metode `sortRoomsByPriceBubble()` yang dilengkapi DocBlock standar BNSP. Dapat diuji langsung oleh asesor pada menu **Daftar Harga** melalui tombol:
  - *&uarr; Termurah (Ascending)*
  - *&darr; Termahal (Descending)*

---

## 7. STRUKTUR & HIRARKI FOLDER PROYEK

```
HotelBNSP/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php       # Analitik pendapatan & statistik booking
│   │   │   │   ├── ReservationManagementController.php# Pengawasan reservasi & perubahan status
│   │   │   │   └── RoomManagementController.php       # CRUD master data tipe kamar
│   │   │   ├── AuthController.php                     # Sesi Login, Register, Logout
│   │   │   └── PublicHotelController.php              # Rute publik (Rooms, Pricing, About, Booking)
│   │   └── Middleware/
│   │       └── RoleMiddleware.php                     # Otorisasi role 'admin' & 'guest'
│   ├── Models/
│   │   ├── Reservation.php                            # Entitas reservasi & formatting BNSP
│   │   ├── Room.php                                   # Entitas master tipe kamar
│   │   └── User.php                                   # Entitas pengguna (Role admin & guest)
│   └── Services/
│       └── RoomPricingService.php                     # Logika kalkulasi tarif & algoritma Bubble Sort
├── bootstrap/
│   └── app.php                                        # Konfigurasi routing & alias middleware
├── config/                                            # File konfigurasi bawaan Laravel
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php   # Migrasi tabel pengguna + role
│   │   ├── 2026_11_02_000001_create_rooms_table.php   # Migrasi tabel master kamar
│   │   └── 2026_11_02_000002_create_reservations_table.php # Migrasi tabel reservasi pemesanan
│   ├── seeders/
│   │   └── DatabaseSeeder.php                         # Seeder akun admin, guest, 3 kamar, & sampel booking
│   ├── database.sqlite                                # Database SQLite lokal siap uji
│   └── hotel_bnsp_mysql.sql                           # Dump SQL mandiri untuk XAMPP MySQL/phpMyAdmin
├── public/
│   ├── assets/
│   │   └── rooms/                                     # Asset foto resolusi tinggi & video preview MP4
│   │       ├── standar.jpg
│   │       ├── deluxe.jpg
│   │       ├── family.jpg
│   │       ├── hotel_hero.jpg
│   │       ├── hotel_about.jpg
│   │       ├── preview_standar.mp4
│   │       ├── preview_deluxe.mp4
│   │       └── preview_family.mp4
│   ├── css/
│   │   └── editorial.css                              # Design system CSS mandiri Editorial Luxury
│   └── index.php                                      # Front controller publik
├── resources/
│   ├── css/
│   │   └── app.css                                    # Tailwind CSS token & tipografi
│   └── views/
│       ├── admin/
│       │   ├── reservations/
│       │   │   ├── index.blade.php                    # Tabel pengawasan data reservasi
│       │   │   └── show.blade.php                     # Rincian transaksi & cetak
│       │   ├── rooms/
│       │   │   ├── create.blade.php                   # Form tambah kamar
│       │   │   ├── edit.blade.php                     # Form edit kamar
│       │   │   └── index.blade.php                    # Tabel master kamar
│       │   └── dashboard.blade.php                    # Panel analitik pendapatan
│       ├── auth/
│       │   ├── login.blade.php                        # Form login dengan 1-click credential filler
│       │   └── register.blade.php                     # Form pendaftaran akun tamu
│       ├── guest/
│       │   └── my-bookings.blade.php                  # Riwayat reservasi tamu yang login
│       ├── layouts/
│       │   ├── admin.blade.php                        # Layout sidebar panel pengelola
│       │   └── app.blade.php                          # Layout navigasi editorial & video modal
│       └── public/
│           ├── about.blade.php                        # Menu Tentang Kami (profil, kontak, alamat)
│           ├── booking-form.blade.php                 # Menu Pesan Kamar (form interaktif)
│           ├── booking-summary.blade.php              # Hasil Simpan Data (Kartu Faktur BNSP)
│           ├── home.blade.php                         # Beranda Hotel
│           ├── pricing.blade.php                      # Menu Daftar Harga (+ Array Sorting)
│           └── rooms.blade.php                        # Menu Produk Kamar (Foto & Video Preview)
├── routes/
│   └── web.php                                        # Pemetaan seluruh rute aplikasi
├── tests/
│   ├── Feature/
│   │   ├── AdminAccessTest.php                        # Pengujian hak akses & CRUD admin
│   │   ├── ExampleTest.php                            # Pengujian respons root
│   │   └── HotelBookingTest.php                       # Pengujian form pemesanan & validasi BNSP
│   └── Unit/
│       └── RoomPricingServiceTest.php                 # Pengujian matematis diskon, breakfast, & bubble sort
├── composer.json                                      # Konfigurasi dependensi PHP
├── package.json                                       # Konfigurasi dependensi Node.js / Vite
└── README.md                                          # Dokumentasi komprehensif proyek
```

---

## 8. SKEMA BASIS DATA (DATA DICTIONARY)

### Tabel `users`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK, AI) | Identitas unik pengguna |
| `name` | VARCHAR(150) | Nama lengkap pengguna |
| `email` | VARCHAR(255) (UNIQUE) | Alamat email untuk login |
| `role` | VARCHAR(20) | Hak akses: `'admin'` atau `'guest'` |
| `phone` | VARCHAR(30) NULL | Nomor kontak telepon / WhatsApp |
| `password` | VARCHAR(255) | Hash kata sandi (*Bcrypt*) |
| `created_at` / `updated_at` | TIMESTAMP | Waktu pembuatan & perubahan |

### Tabel `rooms`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK, AI) | Identitas kamar |
| `code` | VARCHAR(20) (UNIQUE) | Kode kamar (*STD-01, DLX-02, FML-03*) |
| `name` | VARCHAR(100) | Nama tipe kamar (*Standar, Deluxe, Family*) |
| `tagline` | VARCHAR(150) NULL | Subjudul kamar |
| `price` | DECIMAL(12,2) | Tarif sewa per malam (Rp) |
| `capacity` | INT | Kapasitas tamu (orang dewasa) |
| `bed_type` | VARCHAR(100) | Tipe kasur (*1 Queen Bed, 1 King Bed, 2 King Beds*) |
| `size` | VARCHAR(50) | Luas ruangan (*32 m², 48 m², 78 m²*) |
| `description` | TEXT | Narasi fasilitas dan kenyamanan kamar |
| `facilities` | JSON NULL | Array daftar fasilitas kamar |
| `image_url` | VARCHAR(255) | Path gambar foto kamar |
| `gallery` | JSON NULL | Array galeri foto tambahan |
| `video_url` | VARCHAR(255) | Path file video preview MP4 |
| `is_active` | BOOLEAN | Status tayang kamar |

### Tabel `reservations`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED (PK, AI) | Identitas reservasi |
| `booking_code` | VARCHAR(30) (UNIQUE) | Kode referensi pemesanan unik |
| `user_id` | BIGINT UNSIGNED NULL (FK) | Relasi ke tabel `users` (opsional untuk guest anonim) |
| `customer_name` | VARCHAR(150) | **Nama Pemesan** |
| `gender` | VARCHAR(20) | **Jenis Kelamin** (*Laki-laki / Perempuan*) |
| `identity_number`| VARCHAR(16) | **Nomor Identitas** (*Tepat 16 digit*) |
| `room_id` | BIGINT UNSIGNED (FK) | Relasi ke master `rooms` |
| `room_type_name` | VARCHAR(100) | Snapshot nama tipe kamar saat dipesan |
| `room_price` | DECIMAL(12,2) | Snapshot tarif kamar saat dipesan |
| `booking_date` | DATE | **Tanggal Pesan** |
| `stay_duration` | INT | **Durasi Menginap** (satuan hari) |
| `includes_breakfast` | BOOLEAN | **Termasuk Breakfast** (*1 = Ya, 0 = Tidak*) |
| `breakfast_fee` | DECIMAL(12,2) | Biaya sarapan (Rp 80.000 jika Ya) |
| `subtotal` | DECIMAL(12,2) | Hasil $\text{Harga Kamar} \times \text{Durasi}$ |
| `discount_percent`| DECIMAL(5,2) | Persentase diskon (10% jika durasi > 3 hari, else 0%) |
| `discount_amount` | DECIMAL(12,2) | Nominal potongan diskon (Rp) |
| `total_payment` | DECIMAL(12,2) | **Total Bayar** akhir yang harus dibayarkan |
| `status` | VARCHAR(30) | Status booking (*confirmed, checked_in, completed, cancelled*) |

---

## 9. DAFTAR LIBRARY & TEKNOLOGI

1. **Framework Utama:**
   - **PHP 8.3+** (Standard Environment)
   - **Laravel Framework 11+** (MVC Architecture, Eloquent ORM, Blade Templating)
2. **Antarmuka & Styling:**
   - **Tailwind CSS v4** (Utility-first Modern CSS)
   - **Google Fonts:** *Cormorant Garamond* (Serif Editorial) & *Plus Jakarta Sans* (Sans-Serif Tabular)
   - **HTML5 Native Video & Media API** untuk video tour preview
3. **Build Tool & Asset Bundler:**
   - **Vite 8** & `@tailwindcss/vite`
4. **Pengujian Kualitas Kode (Testing):**
   - **PHPUnit 12** (14 automated feature & unit tests, 100% passed)
5. **Database:**
   - **SQLite** (Bawaan siap pakai tanpa konfigurasi server)
   - **MySQL / MariaDB** (Dukungan penuh via `.env` dan dump SQL `database/hotel_bnsp_mysql.sql`)

---

## 10. PANDUAN INSTALASI & MENJALANKAN APLIKASI

### Opsi A: Menjalankan Langsung via PHP Artisan (Direkomendasikan)
Aplikasi telah terkonfigurasi dengan database SQLite dan file media lokal. Anda dapat langsung menjalankannya:

1. **Buka Terminal / Command Prompt** pada folder proyek:
   ```bash
   cd c:\Users\bimag\Documents\SEKOLAH\HotelBNSP
   ```
2. **Jalankan Server Lokal Laravel:**
   ```bash
   php artisan serve
   ```
3. **Buka Peramban (Browser):**
   Akses alamat: **`http://127.0.0.1:8000`**

### Opsi B: Menggunakan XAMPP (Apache & MySQL)
Jika penguji/asesor ingin menguji menggunakan phpMyAdmin / MySQL di XAMPP:

1. Buka **XAMPP Control Panel**, nyalakan modul **Apache** dan **MySQL**.
2. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
3. Buat database baru bernama `hotel_bnsp`.
4. Klik tab **Import**, pilih file:  
   `database/hotel_bnsp_mysql.sql`  
   lalu klik **Go** / **Kirim**.
5. Salin dan sesuaikan konfigurasi pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hotel_bnsp
   DB_USERNAME=root
   DB_PASSWORD=
   ```
6. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```

### Menjalankan Unit & Feature Test:
Seluruh 14 test skenario perhitungan dan otorisasi dapat diuji dengan perintah:
```bash
php artisan test
```

---
*Dokumentasi ini disusun secara formal sesuai Standar Uji Kompetensi Demonstrasi LSP Informatika BNSP Tahun 2026.*
