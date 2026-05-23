@extends('layouts.auth')

@section('title', 'Daftar Mahasiswa — TELENT')

@section('content')

{{-- ── Back link + Heading ── --}}
<div class="mb-7">
    <a href="{{ route('auth.login') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-800 font-medium transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Login
    </a>
    <h1 class="text-[1.75rem] font-extrabold text-gray-900 tracking-tight leading-tight">
        Daftar Mahasiswa
    </h1>
    <p class="text-gray-500 text-sm mt-1">Buat akun untuk mendaftar magang di TELENT</p>
</div>

{{-- ── Error alert ── --}}
@if($errors->any())
<div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
    @foreach($errors->all() as $error)
    <p class="text-sm text-red-700">• {{ $error }}</p>
    @endforeach
</div>
@endif

{{-- ── FORM ── --}}
<form method="POST" action="{{ route('auth.register.post') }}" class="space-y-4">
    @csrf

    {{-- Nama Lengkap --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
               placeholder="Nama sesuai KTP/KTM"
               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                      placeholder-gray-300 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                      transition-all">
    </div>

    {{-- Email + NIM --}}
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Email <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   placeholder="email@kampus.ac.id"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                          placeholder-gray-300 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          transition-all">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                NIM <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nim" value="{{ old('nim') }}" required
                   placeholder="Nomor Induk Mahasiswa"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                          placeholder-gray-300 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          transition-all">
        </div>
    </div>

    {{-- Universitas --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Universitas <span class="text-red-500">*</span>
        </label>
        <input type="text" name="universitas" value="{{ old('universitas') }}" required
               placeholder="Nama Universitas"
               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                      placeholder-gray-300 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                      transition-all">
    </div>

    {{-- Jurusan + Semester --}}
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Jurusan <span class="text-red-500">*</span>
            </label>
            <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                   placeholder="Program Studi"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                          placeholder-gray-300 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          transition-all">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                Semester <span class="text-red-500">*</span>
            </label>
            <select name="semester" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                           text-sm
                           focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                           transition-all appearance-none"
                    style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 1rem center;">
                <option value="">Pilih Semester</option>
                @for($i = 1; $i <= 14; $i++)
                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    {{-- No. HP --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            No. HP <span class="text-red-500">*</span>
        </label>
        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
               placeholder="08xxxxxxxxxx"
               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                      placeholder-gray-300 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                      transition-all">
    </div>

    {{-- Password --}}
    <div x-data="{ show: false }">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Password <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input :type="show ? 'text' : 'password'" name="password" required
                   placeholder="Min. 8 karakter, huruf &amp; angka"
                   class="w-full px-4 py-2.5 pr-11 rounded-xl border border-gray-200 bg-white text-gray-900
                          placeholder-gray-300 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          transition-all">
            <button type="button" @click="show = !show"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                <svg x-show="!show" class="w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                             9.542 7-1.274 4.057-5.064 7-9.542 7-4.477
                             0-8.268-2.943-9.542-7z"/>
                </svg>
                <svg x-show="show" x-cloak class="w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97
                             9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878
                             9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532
                             7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112
                             5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0
                             01-4.132 5.411m0 0L21 21"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Konfirmasi Password --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Konfirmasi Password <span class="text-red-500">*</span>
        </label>
        <input type="password" name="password_confirmation" required
               placeholder="Ulangi password"
               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900
                      placeholder-gray-300 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                      transition-all">
    </div>

    {{-- Submit --}}
    <div class="pt-1">
        <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3.5 px-6
                       bg-green-800 hover:bg-green-900 active:scale-[.99]
                       text-white font-bold text-base rounded-xl
                       transition-all shadow-sm shadow-green-900/20">
            Daftar Sekarang
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </button>
    </div>
</form>

{{-- ── Footer ── --}}
<p class="mt-5 text-center text-sm text-gray-500">
    Sudah punya akun?
    <a href="{{ route('auth.login') }}"
       class="text-red-500 font-bold hover:text-red-900 transition-colors">
        Masuk di sini
    </a>
</p>

@endsection