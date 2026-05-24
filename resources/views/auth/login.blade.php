@extends('layouts.auth')

@section('title', 'Masuk — Portal Resmi Magang PT. Tanjungenim Lestari')

@section('content')

{{-- ── Logo + Heading ── --}}
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <img
            src="{{ asset('images/logo-telentapp.png') }}"
            alt="TELENT Logo"
            class="h-12 w-12 object-contain flex-shrink-0"
        >
        <div>
            <div class="text-xl font-extrabold text-gray-900 tracking-wide leading-none">TELENT</div>
            <div class="text-green-700 text-xs font-semibold tracking-widest mt-0.5">Intership Management</div>
        </div>
    </div>
    <h1 class="text-[1.85rem] font-extrabold text-gray-900 tracking-tight leading-tight">
        Selamat Datang
    </h1>
    <p class="text-gray-500 text-sm mt-1">Portal resmi magang PT. Tanjungenim Lestari</p>
</div>

{{-- ── Success alert ── --}}
@if(session('success'))
<div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
</div>
@endif

{{-- ── Error alert ── --}}
@if($errors->any())
<div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
    @foreach($errors->all() as $error)
    <p class="text-sm text-red-700">{{ $error }}</p>
    @endforeach
</div>
@endif

{{-- ── FORM ── --}}
<form method="POST" action="{{ route('auth.login.post') }}" class="space-y-5">
    @csrf

    {{-- Email --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0
                             002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </span>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   placeholder="nama@perusahaan.com"
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white
                          text-gray-900 placeholder-gray-300 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          transition-all">
        </div>
    </div>

    {{-- Password --}}
    <div x-data="{ show: false }">
        <div class="flex items-center justify-between mb-1.5">
            <label class="text-sm font-semibold text-gray-700">Kata Sandi</label>
            <a href="#" class="text-sm font-semibold text-red-500 hover:text-red-600 transition-colors">
                Lupa kata sandi?
            </a>
        </div>
        <div class="relative">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2
                             0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </span>
            <input :type="show ? 'text' : 'password'"
                   name="password"
                   required
                   placeholder="••••••••"
                   class="w-full pl-10 pr-12 py-3 rounded-xl border border-gray-200 bg-white
                          text-gray-900 placeholder-gray-300 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          transition-all">
            <button type="button" @click="show = !show"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400
                           hover:text-gray-600 transition-colors">
                <svg x-show="!show" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                             9.542 7-1.274 4.057-5.064 7-9.542 7-4.477
                             0-8.268-2.943-9.542-7z"/>
                </svg>
                <svg x-show="show" x-cloak class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
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

    {{-- Remember me --}}
    <label class="flex items-center gap-2.5 cursor-pointer select-none">
        <input type="checkbox" name="ingat_saya"
               class="w-4 h-4 rounded border-gray-300 accent-green-800 cursor-pointer">
        <span class="text-sm text-gray-600">Ingat saya di perangkat ini</span>
    </label>

    {{-- Submit --}}
    <button type="submit"
            class="w-full flex items-center justify-center gap-2 py-3.5 px-6
                   bg-green-800 hover:bg-green-900 active:scale-[.99]
                   text-white font-bold text-base rounded-xl
                   transition-all shadow-sm shadow-green-900/20">
        Masuk
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </button>
</form>

{{-- ── Social login ── --}}
<div class="grid grid-cols-2 gap-3 mt-4">
    <a href="#"
       class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-gray-200
              bg-white hover:bg-gray-50 text-sm font-semibold text-gray-700 transition-colors">
        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Google
    </a>
    <a href="#"
       class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-gray-200
              bg-white hover:bg-gray-50 text-sm font-semibold text-gray-700 transition-colors">
        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        SSO
    </a>
</div>

{{-- ── Divider ── --}}
<div class="flex items-center gap-3 my-5">
    <div class="flex-1 h-px bg-gray-200"></div>
    <span class="text-xs text-gray-400 font-medium">Atau Daftar Baru</span>
    <div class="flex-1 h-px bg-gray-200"></div>
</div>

{{-- ── Register buttons ── --}}
<div class="grid grid-cols-2 gap-3">
    <a href="{{ route('auth.register') }}"
       class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl
              border-2 border-green-800 bg-white hover:bg-green-50
              text-sm font-bold text-green-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 14l6.16-3.422A12.083 12.083 0 0121 12c0 5-3.5 9.268-9
                     10-5.5-.732-9-5-9-10a12.083 12.083 0 012.84-1.422L12 14z"/>
        </svg>
        Mahasiswa
    </a>
    <a href="{{ route('auth.register-admin') }}"
       class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl
              border-2 border-orange-500 bg-white hover:bg-orange-50
              text-sm font-bold text-orange-500 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1
                     1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
        Admin Token
    </a>
</div>

{{-- ── Info verifikasi ── --}}
<div class="mt-5 p-4 bg-amber-50 border border-amber-200 rounded-xl">
    <p class="text-xs text-amber-700 text-center">
        <strong>Info:</strong> Jika belum menerima email verifikasi,
        <a href="#"
           class="underline font-semibold"
           onclick="event.preventDefault(); document.getElementById('modal-kirim-ulang').style.display='flex'">
            klik di sini untuk kirim ulang
        </a>
    </p>
</div>

{{-- ── Footer links ── --}}
<div class="mt-7 space-y-2">
    <div class="flex flex-wrap justify-center gap-x-5 gap-y-1">
        <a href="#" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Tentang Kami</a>
        <a href="#" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Kebijakan Privasi</a>
        <a href="#" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Syarat &amp; Ketentuan</a>
        <a href="#" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">Kontak</a>
    </div>
    <p class="text-center text-xs text-gray-400">
        © 2026 TELENT (PT. Tanjungenim Lestari Pulp and Paper). Seluruh hak cipta dilindungi.
    </p>
</div>

{{-- ═══════════════════════════════════════════
     MODAL — Kirim Ulang Verifikasi
════════════════════════════════════════════ --}}
<div id="modal-kirim-ulang"
     style="display:none;"
     class="fixed inset-0 z-50 items-center justify-center bg-black/50 px-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
        <h3 class="font-bold text-gray-900 mb-1">Kirim Ulang Verifikasi</h3>
        <p class="text-sm text-gray-500 mb-4">Masukkan email Anda untuk mendapatkan link verifikasi baru.</p>
        <form method="POST" action="{{ route('auth.kirim-ulang-verifikasi') }}">
            @csrf
            <input type="email" name="email" placeholder="Email Anda" required
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-700/30 focus:border-green-700
                          mb-3">
            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('modal-kirim-ulang').style.display='none'"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm
                               text-gray-600 hover:bg-gray-50 cursor-pointer transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-green-800 hover:bg-green-900
                               text-white text-sm font-bold cursor-pointer transition-colors">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

@endsection