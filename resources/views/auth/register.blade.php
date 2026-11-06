@extends('layouts.app')

@section('title', 'Pendaftaran Akun Tamu — The Serenity Palace')

@section('content')
<div class="max-w-md mx-auto px-6 py-16">
    <div class="border border-[#E7E1D4] bg-white p-8 sm:p-10 shadow-sm space-y-8">
        
        <div class="text-center space-y-2">
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#9E7B56] font-semibold">Role 1: Tamu / Pengunjung</span>
            <h1 class="font-serif text-3xl text-[#1C1B18]">Daftar Akun Baru</h1>
            <p class="text-xs text-[#6E6A5F]">
                Daftarkan akun untuk mempermudah reservasi dan memantau riwayat pesanan kamar hotel Anda.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div class="space-y-1">
                <label for="name" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Nama Lengkap <span class="text-rose-600">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="Masukkan nama lengkap Anda"
                       class="input-editorial @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1">
                <label for="email" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Alamat Email <span class="text-rose-600">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       placeholder="nama@domain.com"
                       class="input-editorial @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telepon -->
            <div class="space-y-1">
                <label for="phone" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Nomor WhatsApp / Telepon
                </label>
                <input type="text" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone') }}" 
                       placeholder="08123456789"
                       class="input-editorial @error('phone') border-rose-500 @enderror">
                @error('phone')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Kata Sandi <span class="text-rose-600">*</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="Minimal 6 karakter"
                       class="input-editorial @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="space-y-1">
                <label for="password_confirmation" class="text-xs uppercase tracking-wider font-semibold text-[#1C1B18]">
                    Ulangi Kata Sandi <span class="text-rose-600">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required 
                       placeholder="Masukkan ulang kata sandi"
                       class="input-editorial">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full btn-luxury text-xs py-3.5">
                    Daftar Akun Tamu &rarr;
                </button>
            </div>
        </form>

        <div class="text-center text-xs text-[#6E6A5F]">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-[#9E7B56] hover:underline font-semibold">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection

