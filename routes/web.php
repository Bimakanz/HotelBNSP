<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ReservationManagementController;
use App\Http\Controllers\Admin\RoomManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicHotelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Reservasi Hotel BNSP (Editorial Luxury Architecture)
|--------------------------------------------------------------------------
|
| Author: Bima Garda Nusantara (BNSP Asesi)
| Version / Date: 1.0.0 / 02 November 2026
|
*/

// ==========================================
// 1. RUTE PUBLIK & MENU RESMI HOTEL (BNSP)
// ==========================================

// Beranda Utama Hotel
Route::get('/', [PublicHotelController::class, 'index'])->name('home');

// Menu Produk Kamar: Katalog 3 tipe kamar (Standar, Deluxe, Family) + Foto & Video Preview
Route::get('/rooms', [PublicHotelController::class, 'rooms'])->name('public.rooms');

// Menu Tentang Kami: Profil hotel, alamat resmi, no telepon, email, peta lokasi
Route::get('/about', [PublicHotelController::class, 'about'])->name('public.about');

// Menu Pesan Kamar: Form interaktif kalkulasi real-time
Route::get('/booking', [PublicHotelController::class, 'bookingForm'])->name('booking.form');
Route::post('/booking/calculate', [PublicHotelController::class, 'calculate'])->name('booking.calculate');
Route::post('/booking', [PublicHotelController::class, 'storeBooking'])->name('booking.store');

// Hasil Simpan Data: Kartu Faktur/Ringkasan Reservasi Persis Format Standar BNSP
Route::get('/booking/{reservation}/summary', [PublicHotelController::class, 'bookingSummary'])->name('booking.summary');


// ==========================================
// 2. RUTE AUTENTIKASI PENGGUNA
// ==========================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ==========================================
// 3. RUTE ROLE 1: GUEST (TAMU TERDAFTAR)
// ==========================================

Route::middleware(['auth', 'role:guest,admin'])->group(function () {
    Route::get('/my-bookings', [PublicHotelController::class, 'myBookings'])->name('guest.my-bookings');
});


// ==========================================
// 4. RUTE ROLE 2: ADMIN / RESEPSIONIS
// ==========================================

// Akses rute langsung /admin (mengarahkan ke login jika belum login, atau ke dashboard jika sudah login sebagai admin)
Route::get('/admin', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('guest.my-bookings');
    }
    return redirect()->route('login');
})->name('admin.entry');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Ringkasan Statistik Pendapatan & Reservasi
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Master Data Kamar (CRUD, Foto & Video Preview)
    Route::resource('rooms', RoomManagementController::class);

    // Pengawasan & Pengelolaan Reservasi Tamu
    Route::resource('reservations', ReservationManagementController::class)->only(['index', 'show', 'destroy']);
    Route::patch('/reservations/{reservation}/status', [ReservationManagementController::class, 'updateStatus'])->name('reservations.status');
});
