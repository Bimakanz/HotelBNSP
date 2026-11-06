@extends('layouts.app')

@section('title', 'Masuk ke Sistem — The Serenity Palace')

@section('content')
<div class="max-w-md mx-auto px-6 py-16">
    <div class="border border-[#E7E1D4] bg-white p-8 sm:p-10 shadow-sm space-y-8">
        
        <div class="text-center space-y-2">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">Portal Autentikasi 2 Role</span>
            <h1 class="font-serif text-3xl text-[#1C1B18]">Masuk Sesi</h1>
            <p class="text-xs text-[#6E6A5F]">
                Silakan masuk untuk mengakses panel administrasi atau melihat riwayat reservasi Anda.
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Alamat Email
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', 'admin@hotelbnsp.test') }}" 
                       required 
                       autocomplete="email"
                       placeholder="nama@domain.com"
                       class="input-editorial @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                        Kata Sandi
                    </label>
                </div>
                <input type="password" 
                       id="password" 
                       name="password" 
                       value="password"
                       required 
                       class="input-editorial @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="inline-flex items-center space-x-2 text-[#6E6A5F] cursor-pointer">
                    <input type="checkbox" name="remember" class="text-[#9E7B56] focus:ring-[#9E7B56]">
                    <span>Ingat sesi masuk</span>
                </label>
            </div>

            <button type="submit" class="w-full btn-luxury text-xs py-3.5">
                Masuk ke Sistem &rarr;
            </button>
        </form>

        <!-- Quick Fill Helper untuk Asesor BNSP -->
        <div class="pt-6 border-t border-[#E7E1D4] space-y-3 bg-[#F5F1E9] p-4 text-xs">
            <span class="text-[10px] uppercase tracking-wider text-[#9E7B56] font-semibold block">Akses Cepat Pengujian Asesor:</span>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" 
                        onclick="fillAdminCredentials()" 
                        class="text-left p-2 bg-white border border-[#E7E1D4] hover:border-[#9E7B56] transition-colors">
                    <strong class="block text-[#1C1B18]">Role 2: Admin</strong>
                    <span class="text-[10px] text-[#6E6A5F]">admin@hotelbnsp.test</span>
                </button>
                <button type="button" 
                        onclick="fillGuestCredentials()" 
                        class="text-left p-2 bg-white border border-[#E7E1D4] hover:border-[#9E7B56] transition-colors">
                    <strong class="block text-[#1C1B18]">Role 1: Guest</strong>
                    <span class="text-[10px] text-[#6E6A5F]">guest@hotelbnsp.test</span>
                </button>
            </div>
            <p class="text-[10px] text-[#8C877D] italic">Sandi default: <code>password</code></p>
        </div>

        <div class="text-center text-xs text-[#6E6A5F]">
            Belum memiliki akun tamu? 
            <a href="{{ route('register') }}" class="text-[#9E7B56] hover:underline font-semibold">Daftar sekarang</a>
        </div>

    </div>
</div>

<script>
    function fillAdminCredentials() {
        document.getElementById('email').value = 'admin@hotelbnsp.test';
        document.getElementById('password').value = 'password';
    }

    function fillGuestCredentials() {
        document.getElementById('email').value = 'guest@hotelbnsp.test';
        document.getElementById('password').value = 'password';
    }
</script>
@endsection

