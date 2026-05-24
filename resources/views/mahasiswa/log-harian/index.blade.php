@extends('layouts.app')

@section('title', 'Log Harian')
@section('page-title', 'Log Harian')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Log Harian</h1>
    <p class="text-sm text-slate-500 mt-1">Catatan kegiatan magang kamu</p>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="mb-6 rounded-md bg-blue-50 p-4 border border-blue-200">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
        </div>
    </div>
@endif

<!-- Main Info Card -->
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden border border-slate-200 mb-6">
    <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="h-12 w-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center ring-1 ring-slate-900/5 shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-slate-900">{{ $proposal->judul_proposal }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-slate-500">Divisi:</span>
                    <span class="text-sm font-medium text-slate-700 bg-slate-100 px-2 py-0.5 rounded">{{ $proposal->divisi_tujuan }}</span>
                </div>
            </div>
        </div>
        
        @if(!$sudahIsiHariIni)
            <a href="{{ route('mahasiswa.log-harian.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Isi Log Hari Ini
            </a>
        @else
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-sm font-medium rounded-full ring-1 ring-inset ring-emerald-600/20">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Terisi Hari Ini</span>
            </div>
        @endif
    </div>
</div>

<!-- Logs List Card -->
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden border border-slate-200">
    
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider">Riwayat Log Harian</h3>
        <span class="text-xs font-medium text-slate-500 bg-white border border-slate-200 px-2 py-1 rounded-full">{{ $logs->total() }} Entri</span>
    </div>

    <!-- List -->
    <div class="divide-y divide-slate-200">
        @forelse($logs as $log)
            <div class="p-6 hover:bg-slate-50/50 transition duration-150 group">
                <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                    
                    <!-- Left: Date & Status -->
                    <div class="flex items-center gap-4 lg:w-48 shrink-0">
                        <div class="h-10 w-10 rounded-lg bg-slate-100 text-slate-600 flex flex-col items-center justify-center text-xs font-bold ring-1 ring-slate-200">
                            <span class="text-[10px] uppercase">{{ $log->tanggal->format('M') }}</span>
                            <span class="text-sm">{{ $log->tanggal->format('d') }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $log->tanggal->format('l') }}</p>
                            <p class="text-xs text-slate-500">{{ $log->tanggal->format('Y') }}</p>
                        </div>
                    </div>

                    <!-- Center: Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            @switch($log->status_verifikasi)
                                @case('disetujui')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Disetujui
                                    </span>
                                    @break
                                @case('ditolak')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-rose-100 text-rose-700">
                                        <span class="w-1 h-1 rounded-full bg-rose-500"></span> Ditolak
                                    </span>
                                    @break
                                @default
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-700">
                                        <span class="w-1 h-1 rounded-full bg-yellow-500"></span> Menunggu
                                    </span>
                            @endswitch
                        </div>

                        <div class="space-y-2 text-sm text-slate-600">
                            <div class="flex items-start gap-2">
                                <span class="font-medium text-slate-900 shrink-0 w-16"> Kegiatan:</span>
                                <span class="leading-relaxed">{{ $log->kegiatan_dilakukan }}</span>
                            </div>
                            
                            @if($log->hasil_kegiatan)
                                <div class="flex items-start gap-2">
                                    <span class="font-medium text-slate-900 shrink-0 w-16"> Hasil:</span>
                                    <span class="leading-relaxed">{{ $log->hasil_kegiatan }}</span>
                                </div>
                            @endif

                            @if($log->kendala)
                                <div class="flex items-start gap-2">
                                    <span class="font-medium text-slate-900 shrink-0 w-16"> Kendala:</span>
                                    <span class="leading-relaxed text-rose-600 bg-rose-50 px-2 py-0.5 rounded">{{ $log->kendala }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Action -->
                    <div class="flex items-center gap-2 lg:w-32 justify-end">
                        @if($log->status_verifikasi !== 'disetujui')
                            <a href="{{ route('mahasiswa.log-harian.edit', $log->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-md transition">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                        @else
                            <span class="text-xs text-slate-400 italic">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <div class="mx-auto h-12 w-12 text-slate-300 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-slate-900">Belum ada log harian</h3>
                <p class="text-sm text-slate-500 mt-1">Mulai catat kegiatan magangmu hari ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex items-center justify-between">
            <div class="text-sm text-slate-500">
                Menampilkan {{ $logs->firstItem() }}-{{ $logs->lastItem() }} dari {{ $logs->total() }}
            </div>
            <div>
                {{ $logs->links() }}
            </div>
        </div>
    @endif
</div>

@endsection