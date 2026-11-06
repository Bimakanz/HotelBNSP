<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware RoleMiddleware
 * 
 * Deskripsi: Memeriksa dan memvalidasi hak akses (otorisasi role) pengguna sebelum mengakses rute tertentu.
 * Initial State: Request masuk membawa sesi autentikasi pengguna.
 * Final State: Mengizinkan request melanjutkan ke controller jika role sesuai, atau menolak dengan pesan otorisasi 403 / redirect.
 * Author: Bima Garda Nusantara (BNSP Asesi)
 * Version / Date: 1.0.0 / 02 November 2026
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles Daftar role yang diizinkan (misal: 'admin', 'guest')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Periksa apakah user telah melakukan login autentikasi
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        // 2. Periksa apakah role user terdaftar dalam parameter role yang diizinkan
        $userRole = auth()->user()->role;
        if (!in_array($userRole, $roles, true)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses area ini.');
        }

        return $next($request);
    }
}

