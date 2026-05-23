@extends('layouts.auth')
@section('title', 'Daftar Admin — TELENT')
@section('content')
<div>
    <div class="mb-6">
        <a href="{{ route('auth.login') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-700 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Login
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Daftar Akun Admin</h1>
        <p class="text-slate-500 mt-1 text-sm">Masukkan token registrasi yang diberikan HRD</p>
    </div>

    <div class="mb-5 p-4 bg-blue-50 border border-blue-200 rounded-xl flex gap-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm text-blue-700">Halaman ini khusus untuk HRD, Manager, dan Pembimbing Lapang. Token diberikan oleh HRD.</p>
    </div>

    @if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-700">• {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('auth.register-admin.post') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Token Registrasi Admin <span class="text-red-500">*</span></label>
            <input type="text" name="token" value="{{ old('token') }}" required
                   placeholder="XXXXXXXX-XXXXXXXX-XXXXXXXX"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white uppercase tracking-widest">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Induk Karyawan <span class="text-red-500">*</span></label>
                <input type="text" name="no_induk_karyawan" value="{{ old('no_induk_karyawan') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Divisi <span class="text-red-500">*</span></label>
                <input type="text" name="divisi" value="{{ old('divisi') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP <span class="text-red-500">*</span></label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
        </div>
        <button type="submit" class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-xl text-sm transition-colors">
            Daftar Sekarang
        </button>
    </form>
    <p class="mt-4 text-center text-sm text-slate-500">
        Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-blue-700 font-semibold">Masuk di sini</a>
    </p>
</div>
@endsection
