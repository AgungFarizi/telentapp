@extends('layouts.app')

@section('title', 'Dashboard Pembimbing')
@section('page-title', 'Dashboard Pembimbing')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->nama_lengkap . ' · ' . auth()->user()->divisi)

@section('sidebar-menu')
@php $route = request()->route()->getName(); @endphp

<a href="{{ route('pembimbing.dashboard') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ $route === 'pembimbing.dashboard' ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    <span>Dashboard</span>
</a>
<div class="px-3 pt-4 pb-1"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</p></div>
<a href="{{ route('pembimbing.mahasiswa.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'pembimbing.mahasiswa') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    <span>Mahasiswa Bimbingan</span>
</a>
<div class="px-3 pt-4 pb-1"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Verifikasi</p></div>
<a href="{{ route('pembimbing.kehadiran.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'pembimbing.kehadiran') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
    <span>Verifikasi Kehadiran</span>
    @if($kehadiranMenunggu > 0)
    <span class="ml-auto bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $kehadiranMenunggu }}</span>
    @endif
</a>
<a href="{{ route('pembimbing.log-harian.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'pembimbing.log-harian') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
    <span>Verifikasi Log Harian</span>
    @if($logMenunggu > 0)
    <span class="ml-auto bg-amber-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $logMenunggu }}</span>
    @endif
</a>
<div class="px-3 pt-4 pb-1"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan</p></div>
<a href="{{ route('pembimbing.laporan') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ $route === 'pembimbing.laporan' ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    <span>Laporan Kehadiran</span>
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $mahasiswaBimbingan->count() }}</p>
            <p class="text-sm text-slate-500 mt-1">Mahasiswa Bimbingan</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $kehadiranMenunggu }}</p>
            <p class="text-sm text-slate-500 mt-1">Absen Menunggu</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $logMenunggu }}</p>
            <p class="text-sm text-slate-500 mt-1">Log Menunggu</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $kehadiranHariIni->count() }}</p>
            <p class="text-sm text-slate-500 mt-1">Hadir Hari Ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Daftar Mahasiswa Bimbingan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Mahasiswa Bimbingan</h3>
                <a href="{{ route('pembimbing.mahasiswa.index') }}" class="text-sm text-blue-600 font-medium">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($mahasiswaBimbingan->take(5) as $mhs)
                <a href="{{ route('pembimbing.mahasiswa.detail', $mhs->id) }}"
                   class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50 transition-colors">
                    <img src="{{ $mhs->foto_profil_url }}" class="w-9 h-9 rounded-full object-cover" alt="{{ $mhs->nama_lengkap }}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $mhs->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">{{ $mhs->nim }} · {{ $mhs->universitas }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-sm text-slate-400">Belum ada mahasiswa yang dibimbing</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Kehadiran Hari Ini --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Kehadiran Hari Ini</h3>
                <span class="text-xs text-slate-500">{{ now()->isoFormat('D MMM Y') }}</span>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($kehadiranHariIni as $k)
                <div class="flex items-center gap-4 px-6 py-3.5">
                    <img src="{{ $k->mahasiswa->foto_profil_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $k->mahasiswa->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">
                            Masuk: {{ $k->jam_masuk ?? '-' }}
                            @if($k->jam_keluar) · Keluar: {{ $k->jam_keluar }} @endif
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full font-medium {{ $k->status_verifikasi === 'disetujui' ? 'bg-green-100 text-green-700' : ($k->status_verifikasi === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                        {{ ucfirst($k->status_verifikasi) }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-sm text-slate-400">Belum ada yang absen hari ini</p>
                </div>
                @endforelse
            </div>
            @if($kehadiranMenunggu > 0)
            <div class="px-6 py-4 border-t border-slate-100">
                <a href="{{ route('pembimbing.kehadiran.index', ['status_verifikasi' => 'menunggu']) }}"
                   class="w-full flex items-center justify-center gap-2 py-2.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-700 text-sm font-semibold hover:bg-amber-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Verifikasi {{ $kehadiranMenunggu }} Kehadiran
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
