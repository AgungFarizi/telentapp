@extends('layouts.auth')
@section('title', 'Verifikasi Email — TELENT')
@section('content')
<div class="text-center">
    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Verifikasi Email Anda</h1>
    <p class="text-slate-500 text-sm mb-6 leading-relaxed">
        Kami telah mengirimkan link verifikasi ke email Anda.<br>
        Silakan cek inbox (atau folder spam) dan klik link tersebut untuk mengaktifkan akun Anda.
    </p>
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-left mb-6">
        <p class="text-sm text-amber-800 font-semibold mb-1">📌 Belum menerima email?</p>
        <p class="text-xs text-amber-700">Pastikan email benar, cek folder spam, atau minta kirim ulang di bawah ini.</p>
    </div>
    <form method="POST" action="{{ route('auth.kirim-ulang-verifikasi') }}" class="space-y-3">
        @csrf
        <input type="email" name="email" placeholder="Masukkan email Anda" required
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-xl text-sm transition-colors">
            Kirim Ulang Email Verifikasi
        </button>
    </form>
    <a href="{{ route('auth.login') }}" class="block mt-4 text-sm text-slate-500 hover:text-blue-700">← Kembali ke halaman login</a>
</div>
@endsection
