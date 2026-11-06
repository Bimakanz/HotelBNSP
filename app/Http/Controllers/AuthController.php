<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Controller AuthController
 * 
 * Deskripsi: Menangani proses autentikasi (login, register akun tamu, dan logout) untuk sistem hotel.
 * Initial State: Pengguna belum terautentikasi atau ingin mengakhiri sesi.
 * Final State: Pengguna terautentikasi dengan sesi aktif sesuai role masing-masing atau diarahkan keluar sistem.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class AuthController extends Controller
{
    /**
     * Deskripsi: Menampilkan formulir masuk (login) sistem hotel dengan antarmuka editorial luxury.
     * Initial State: Pengguna membuka halaman login.
     * Final State: View formulir login ditampilkan ke layar pengguna.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Deskripsi: Memproses kredensial login pengguna (Admin atau Guest).
     * Initial State: Data request email dan password dikirimkan melalui form POST.
     * Final State: Sesi autentikasi terbentuk dan pengguna diarahkan ke dashboard (Admin) atau halaman utama/pesanan (Guest).
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi input formulir login
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // 2. Verifikasi kredensial ke database
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Arahkan admin ke dashboard admin, tamu ke halaman reservasi/beranda
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali di Dashboard Pengelola, ' . Auth::user()->name);
            }

            return redirect()->intended(route('guest.my-bookings'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name);
        }

        // 3. Tangani kegagalan otentikasi
        return back()->withErrors([
            'email' => 'Kombinasi email dan kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Deskripsi: Menampilkan halaman formulir pendaftaran akun tamu (Guest registration).
     * Initial State: Pengunjung membuka tautan registrasi akun.
     * Final State: View pendaftaran akun ditampilkan.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Deskripsi: Mendaftarkan akun tamu baru ke database sistem.
     * Initial State: Data nama, email, nomor telepon, dan kata sandi dikirim dari formulir.
     * Final State: Akun user baru dengan role 'guest' tersimpan di database dan langsung login.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function register(Request $request): RedirectResponse
    {
        // 1. Validasi input registrasi
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.unique'       => 'Alamat email ini sudah terdaftar.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. Simpan akun tamu ke tabel users
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'role'     => 'guest',
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Autologin dan arahkan ke halaman utama
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('booking.form')
            ->with('success', 'Akun Anda berhasil didaftarkan. Selamat datang di The Serenity Palace.');
    }

    /**
     * Deskripsi: Mengakhiri sesi pengguna saat ini (logout).
     * Initial State: Pengguna dalam status login aktif.
     * Final State: Sesi dihapus, token CSRF di-regenerate, dan pengguna dialihkan ke beranda.
     * Author: Bima Garda Nusantara (BNSP Asesi)
     * Version / Date: 1.0.0 / 02 November 2026
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}

