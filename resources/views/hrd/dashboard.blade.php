@extends('layouts.app')

@section('title', 'Dashboard HRD')
@section('page-title', 'Dashboard HRD')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->nama_lengkap . '. Hari ini ' . \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y'))

@section('sidebar-menu')
@php $route = request()->route()->getName(); @endphp

<a href="{{ route('hrd.dashboard') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.dashboard') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    <span>Dashboard</span>
</a>

<div class="px-3 pt-4 pb-1"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Manajemen Magang</p></div>

<a href="{{ route('hrd.periode.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.periode') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    <span>Periode Magang</span>
</a>

<a href="{{ route('hrd.proposal.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.proposal') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    <span>Proposal</span>
    @php $pending = \App\Models\Proposal::whereIn('status',['diajukan'])->count(); @endphp
    @if($pending > 0)
    <span class="ml-auto bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ $pending }}</span>
    @endif
</a>

<a href="{{ route('hrd.mahasiswa.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.mahasiswa') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    <span>Data Mahasiswa</span>
</a>

<div class="px-3 pt-4 pb-1"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Manajemen Pengguna</p></div>

<a href="{{ route('hrd.pengguna.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.pengguna') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    <span>Kelola Admin</span>
</a>

<a href="{{ route('hrd.token.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.token') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
    <span>Token Registrasi</span>
</a>

<div class="px-3 pt-4 pb-1"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Laporan</p></div>

<a href="{{ route('hrd.laporan') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route, 'hrd.laporan') ? 'active' : '' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    <span>Laporan Magang</span>
</a>
@endsection

@section('content')

{{-- STATS CARDS --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-5">

    {{-- Total Mahasiswa --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm hover:shadow-md transition-all">
        <p class="text-xs text-slate-500 mb-1">Total Mahasiswa</p>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">{{ $stats['total_mahasiswa'] }}</h2>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Proposal Pending --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm hover:shadow-md transition-all">
        <p class="text-xs text-slate-500 mb-1">Proposal Pending</p>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">{{ $stats['total_proposal_pending'] }}</h2>
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Proposal Disetujui --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm hover:shadow-md transition-all">
        <p class="text-xs text-slate-500 mb-1">Proposal Disetujui</p>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">{{ $stats['total_proposal_disetujui'] }}</h2>
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Pembimbing Aktif --}}
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm hover:shadow-md transition-all">
        <p class="text-xs text-slate-500 mb-1">Pembimbing Aktif</p>
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800">{{ $stats['total_pembimbing'] }}</h2>
            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
    </div>

</div>


{{-- PERIODE AKTIF BANNER --}}
@if($stats['periode_aktif'])
<div class="relative overflow-hidden bg-gradient-to-r from-emerald-800 to-emerald-600 rounded-2xl p-5 mb-5 text-white shadow-lg">

    <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full border-[24px] border-white/10"></div>
    <div class="absolute -bottom-10 -right-4 w-28 h-28 rounded-full border-[16px] border-white/5"></div>

    <div class="relative z-10">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></div>
            <span class="text-xs font-semibold uppercase tracking-widest text-emerald-200">Periode Aktif</span>
        </div>

        <h2 class="text-xl font-bold leading-tight mb-3">
            {{ $stats['periode_aktif']->nama_periode }}
        </h2>

        <div class="flex flex-wrap items-center gap-3">

            {{-- Date badge --}}
            <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg text-sm">
                <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-white/90">
                    {{ $stats['periode_aktif']->tanggal_mulai_pendaftaran->format('d M') }}
                    –
                    {{ $stats['periode_aktif']->tanggal_akhir_pendaftaran->format('d M Y') }}
                </span>
            </div>

            {{-- Kuota stats --}}
            <div class="flex items-center gap-2 ml-auto">
                <div class="text-center bg-white/10 px-3 py-1.5 rounded-lg min-w-[52px]">
                    <p class="text-xs text-white/60 leading-none mb-0.5">Terisi</p>
                    <p class="text-lg font-bold leading-none">{{ $stats['periode_aktif']->kuota_terisi }}</p>
                </div>
                <div class="text-center bg-white/10 px-3 py-1.5 rounded-lg min-w-[52px]">
                    <p class="text-xs text-white/60 leading-none mb-0.5">Total</p>
                    <p class="text-lg font-bold leading-none">{{ $stats['periode_aktif']->kuota_total }}</p>
                </div>
                <div class="text-center bg-white/20 px-3 py-1.5 rounded-lg min-w-[52px]">
                    <p class="text-xs text-white/60 leading-none mb-0.5">Sisa</p>
                    <p class="text-lg font-bold leading-none">{{ $stats['periode_aktif']->sisaKuota() }}</p>
                </div>
            </div>

        </div>
    </div>

</div>
@endif


{{-- MAIN GRID --}}
<div class="grid grid-cols-1 xl:grid-cols-12 gap-5">

    {{-- KIRI: Proposal Terbaru --}}
    <div class="xl:col-span-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Proposal Terbaru</h3>
                <a href="{{ route('hrd.proposal.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua</a>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama Mahasiswa</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Keterangan</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse($proposalTerbaru as $proposal)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar inisial --}}
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-bold text-emerald-700">
                                            {{ strtoupper(substr($proposal->pengaju->nama_lengkap, 0, 2)) }}
                                        </span>
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $proposal->pengaju->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 max-w-[180px] truncate">
                                {{ $proposal->judul_proposal }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="{{ $proposal->status_badge_class }}">
                                    {{ $proposal->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('hrd.proposal.index') }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 hover:bg-emerald-100 text-slate-500 hover:text-emerald-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-400 text-sm">
                                Belum ada proposal
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>


    {{-- KANAN --}}
    <div class="xl:col-span-4 space-y-5">

        {{-- TUGAS TERTUNDA --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-semibold text-slate-800 mb-3">Tugas Tertunda</h3>

            @if($stats['kehadiran_menunggu'] > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-amber-800 text-sm">
                            {{ $stats['kehadiran_menunggu'] }} Kehadiran Menunggu Verifikasi
                        </p>
                        <p class="text-xs text-amber-600 mt-0.5">
                            Harap segera lakukan verifikasi absensi harian mahasiswa.
                        </p>
                    </div>
                </div>
                <a href="{{ route('hrd.mahasiswa.index') }}"
                   class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold py-2 rounded-lg transition">
                    Verifikasi Sekarang
                </a>
            </div>
            @else
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-emerald-700">Semua tugas selesai 🎉</p>
            </div>
            @endif
        </div>


        {{-- AKSES CEPAT --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-semibold text-slate-800 mb-3">Akses Cepat</h3>

            <div class="space-y-2.5">

                <a href="{{ route('hrd.periode.create') }}"
                   class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-emerald-50 hover:border-emerald-200 transition group">
                    <div class="w-9 h-9 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Buka Periode</p>
                        <p class="text-xs text-slate-400">Kelola pendaftaran baru</p>
                    </div>
                </a>

                <a href="{{ route('hrd.token.index') }}"
                   class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-purple-50 hover:border-purple-200 transition group">
                    <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Buat Token</p>
                        <p class="text-xs text-slate-400">Generate akses mahasiswa</p>
                    </div>
                </a>

                <a href="{{ route('hrd.laporan') }}"
                   class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-orange-50 hover:border-orange-200 transition group">
                    <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Lihat Laporan</p>
                        <p class="text-xs text-slate-400">Review progres bulanan</p>
                    </div>
                </a>

            </div>
        </div>


        {{-- PROGRES TOTAL KUOTA --}}
        @if($stats['periode_aktif'])
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <h3 class="font-semibold text-slate-800 mb-4">Progres Total Kuota</h3>

            @php
                $total   = $stats['periode_aktif']->kuota_total ?: 1;
                $terisi  = $stats['periode_aktif']->kuota_terisi;
                $persen  = min(100, round(($terisi / $total) * 100));
            @endphp

            <div class="space-y-3">

                <div>
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>Kuota Terisi</span>
                        <span class="font-semibold text-slate-700">{{ $terisi }} / {{ $total }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5">
                        <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-700"
                             style="width: {{ $persen }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">{{ $persen }}% terisi</p>
                </div>

                <div class="grid grid-cols-3 gap-2 pt-1">
                    <div class="text-center bg-slate-50 rounded-xl p-2.5">
                        <p class="text-xs text-slate-400 mb-0.5">Terisi</p>
                        <p class="text-base font-bold text-slate-700">{{ $terisi }}</p>
                    </div>
                    <div class="text-center bg-slate-50 rounded-xl p-2.5">
                        <p class="text-xs text-slate-400 mb-0.5">Total</p>
                        <p class="text-base font-bold text-slate-700">{{ $total }}</p>
                    </div>
                    <div class="text-center bg-emerald-50 rounded-xl p-2.5">
                        <p class="text-xs text-emerald-500 mb-0.5">Sisa</p>
                        <p class="text-base font-bold text-emerald-600">{{ $stats['periode_aktif']->sisaKuota() }}</p>
                    </div>
                </div>

            </div>
        </div>
        @endif

    </div>

</div>
@endsection
