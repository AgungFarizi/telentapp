@extends('layouts.app')
@section('title','Log Harian')
@section('page-title','Log Harian')
@section('sidebar-menu') @include('mahasiswa._sidebar') @endsection

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
            {{ session('info') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div>
            <h3 class="text-lg font-semibold text-slate-800">{{ $proposal->judul_proposal }}</h3>
            <p class="text-sm text-slate-500">Divisi: {{ $proposal->divisi_tujuan }}</p>
        </div>
        @if(!$sudahIsiHariIni)
            <a href="{{ route('mahasiswa.log-harian.create') }}"
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg font-medium">
                + Isi Log Hari Ini
            </a>
        @else
            <span class="text-sm text-slate-500">✓ Sudah mengisi log hari ini</span>
        @endif
    </div>

    {{-- Daftar Log --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Riwayat Log Harian</h3>

        @forelse($logs as $log)
            <div class="border border-slate-100 rounded-xl p-4 mb-3 hover:shadow-sm transition">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $log->tanggal->format('l, d M Y') }}</p>
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($log->status_verifikasi === 'disetujui') bg-green-100 text-green-700
                            @elseif($log->status_verifikasi === 'ditolak') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($log->status_verifikasi) }}
                        </span>
                    </div>
                    @if($log->status_verifikasi !== 'disetujui')
                        <a href="{{ route('mahasiswa.log-harian.edit', $log->id) }}"
                           class="text-xs text-blue-600 hover:underline">Edit</a>
                    @endif
                </div>
                <p class="text-sm text-slate-600 mt-2"><strong>Kegiatan:</strong> {{ $log->kegiatan_dilakukan }}</p>
                @if($log->hasil_kegiatan)
                    <p class="text-sm text-slate-600 mt-1"><strong>Hasil:</strong> {{ $log->hasil_kegiatan }}</p>
                @endif
                @if($log->kendala)
                    <p class="text-sm text-slate-600 mt-1"><strong>Kendala:</strong> {{ $log->kendala }}</p>
                @endif
            </div>
        @empty
            <p class="text-center text-slate-400 py-8">Belum ada log harian</p>
        @endforelse

        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</div>
@endsection