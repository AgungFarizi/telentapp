@extends('layouts.app')
@section('title','Dashboard Manager')
@section('page-title','Dashboard Manager')
@section('page-subtitle','Pantau seluruh aktivitas magang — ' . now()->isoFormat('dddd, D MMMM Y'))
@section('sidebar-menu') @include('manager._sidebar') @endsection

@section('content')
<div class="space-y-6">

    {{-- Info Badge Read-Only --}}
    <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        <p class="text-sm text-blue-800 font-medium">Mode Pantau — Anda dapat melihat seluruh data magang. Approval proposal dikelola oleh HRD.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_mahasiswa_aktif'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Mahasiswa Aktif</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_proposal_disetujui'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Proposal Disetujui</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_pembimbing'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Pembimbing Aktif</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_kehadiran_hari_ini'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Absen Hari Ini</p>
        </div>
    </div>

    {{-- Periode Aktif --}}
    @if($stats['periode_aktif'])
    <div class="bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl p-5 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-blue-200 text-xs font-semibold uppercase">Periode Aktif</span>
                </div>
                <h3 class="font-bold text-lg">{{ $stats['periode_aktif']->nama_periode }}</h3>
                <p class="text-blue-200 text-sm mt-1">
                    Magang: {{ $stats['periode_aktif']->tanggal_mulai_magang->format('d M Y') }}
                    – {{ $stats['periode_aktif']->tanggal_akhir_magang->format('d M Y') }}
                </p>
            </div>
            <div class="flex gap-6 text-center">
                <div><p class="text-2xl font-bold">{{ $stats['periode_aktif']->kuota_terisi }}</p><p class="text-blue-200 text-xs">Terisi</p></div>
                <div class="w-px bg-blue-500"></div>
                <div><p class="text-2xl font-bold">{{ $stats['periode_aktif']->kuota_total }}</p><p class="text-blue-200 text-xs">Kuota</p></div>
                <div class="w-px bg-blue-500"></div>
                <div><p class="text-2xl font-bold">{{ $stats['periode_aktif']->sisaKuota() }}</p><p class="text-blue-200 text-xs">Sisa</p></div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Kehadiran Hari Ini --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Absensi Hari Ini</h3>
                <a href="{{ route('manager.kehadiran') }}" class="text-sm text-blue-600 font-medium hover:text-blue-700">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($kehadiranHariIni as $k)
                <div class="flex items-center gap-3 px-6 py-3.5">
                    <img src="{{ $k->mahasiswa->foto_profil_url }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $k->mahasiswa->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">
                            Masuk: {{ $k->jam_masuk ?? '-' }}
                            @if($k->jam_keluar) · Keluar: {{ $k->jam_keluar }} @endif
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full font-medium flex-shrink-0
                        {{ $k->status==='hadir'?'bg-green-100 text-green-700':
                           ($k->status==='terlambat'?'bg-amber-100 text-amber-700':
                           ($k->status==='tidak_hadir'?'bg-red-100 text-red-700':'bg-blue-100 text-blue-700')) }}">
                        {{ $k->status_label }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center"><p class="text-sm text-slate-400">Belum ada absensi hari ini</p></div>
                @endforelse
            </div>
        </div>

        {{-- Mahasiswa Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Mahasiswa Magang</h3>
                <a href="{{ route('manager.mahasiswa.index') }}" class="text-sm text-blue-600 font-medium hover:text-blue-700">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($mahasiswaTerbaru as $mhs)
                <a href="{{ route('manager.mahasiswa.detail', $mhs->id) }}"
                   class="flex items-center gap-3 px-6 py-3.5 hover:bg-slate-50 transition-colors">
                    <img src="{{ $mhs->foto_profil_url }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $mhs->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">{{ $mhs->universitas }} · Pembimbing: {{ $mhs->pembimbing?->nama_lengkap ?? '-' }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @empty
                <div class="px-6 py-8 text-center"><p class="text-sm text-slate-400">Belum ada mahasiswa aktif</p></div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Tren Kehadiran 7 Hari --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-bold text-slate-800 mb-4">Tren Kehadiran 7 Hari Terakhir</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left py-2 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                        <th class="text-center py-2 text-xs font-semibold text-green-600 uppercase">Hadir</th>
                        <th class="text-center py-2 text-xs font-semibold text-amber-600 uppercase">Izin</th>
                        <th class="text-center py-2 text-xs font-semibold text-red-600 uppercase">Tidak Hadir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($kehadiranMingguIni as $hari)
                    <tr>
                        <td class="py-2.5 font-medium text-slate-700">{{ $hari['tanggal'] }}</td>
                        <td class="py-2.5 text-center">
                            <span class="inline-block bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $hari['hadir'] }}</span>
                        </td>
                        <td class="py-2.5 text-center">
                            <span class="inline-block bg-amber-100 text-amber-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $hari['izin'] }}</span>
                        </td>
                        <td class="py-2.5 text-center">
                            <span class="inline-block bg-red-100 text-red-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $hari['tidak_hadir'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
