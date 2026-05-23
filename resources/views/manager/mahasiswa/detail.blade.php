@extends('layouts.app')
@section('title','Detail Mahasiswa')
@section('page-title','Detail Mahasiswa')
@section('sidebar-menu') @include('manager._sidebar') @endsection
@section('content')
<div class="space-y-6">
    <a href="{{ route('manager.mahasiswa.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Mahasiswa --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="text-center mb-5">
                    <img src="{{ $mahasiswa->foto_profil_url }}" class="w-20 h-20 rounded-full object-cover ring-4 ring-blue-100 mx-auto mb-3" alt="">
                    <h2 class="font-bold text-slate-800 text-lg">{{ $mahasiswa->nama_lengkap }}</h2>
                    <p class="text-slate-500 text-sm">{{ $mahasiswa->nim }}</p>
                </div>
                <dl class="space-y-2.5 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-500">Universitas</dt><dd class="font-medium text-slate-800 text-right max-w-[55%]">{{ $mahasiswa->universitas }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Jurusan</dt><dd class="font-medium text-slate-800 text-right max-w-[55%]">{{ $mahasiswa->jurusan }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Semester</dt><dd class="font-medium text-slate-800">{{ $mahasiswa->semester }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Email</dt><dd class="font-medium text-slate-800 text-right max-w-[55%] truncate">{{ $mahasiswa->email }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Pembimbing</dt><dd class="font-medium text-slate-800">{{ $mahasiswa->pembimbing?->nama_lengkap ?? '-' }}</dd></div>
                </dl>
            </div>

            @if($proposal)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-3 text-sm">Info Magang</h3>
                <dl class="space-y-2 text-xs">
                    <div><dt class="text-slate-500">Proposal</dt><dd class="font-medium text-slate-700 mt-0.5">{{ $proposal->judul_proposal }}</dd></div>
                    <div><dt class="text-slate-500">Periode</dt><dd class="font-medium text-slate-700 mt-0.5">{{ $proposal->periode?->nama_periode }}</dd></div>
                    <div><dt class="text-slate-500">Divisi</dt><dd class="font-medium text-slate-700 mt-0.5">{{ $proposal->divisi_tujuan }}</dd></div>
                </dl>
            </div>
            @endif
        </div>

        {{-- Statistik & Aktivitas --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Statistik Kehadiran --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">{{ $statsKehadiran['hadir'] }}</p>
                    <p class="text-xs text-green-600 mt-0.5">Hadir</p>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-amber-700">{{ $statsKehadiran['terlambat'] }}</p>
                    <p class="text-xs text-amber-600 mt-0.5">Terlambat</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ $statsKehadiran['izin'] }}</p>
                    <p class="text-xs text-blue-600 mt-0.5">Izin/Sakit</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-red-700">{{ $statsKehadiran['tidak_hadir'] }}</p>
                    <p class="text-xs text-red-600 mt-0.5">Tidak Hadir</p>
                </div>
            </div>

            {{-- Progress Kehadiran --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-slate-800 text-sm">Tingkat Kehadiran</h3>
                    <span class="text-2xl font-bold {{ $persentaseKehadiran >= 80 ? 'text-green-600' : ($persentaseKehadiran >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                        {{ $persentaseKehadiran }}%
                    </span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3">
                    <div class="h-3 rounded-full transition-all {{ $persentaseKehadiran >= 80 ? 'bg-green-500' : ($persentaseKehadiran >= 60 ? 'bg-amber-500' : 'bg-red-500') }}"
                         style="width: {{ $persentaseKehadiran }}%"></div>
                </div>
                <p class="text-xs text-slate-500 mt-2">Total {{ $statsKehadiran['total'] }} hari tercatat</p>
            </div>

            {{-- Riwayat Kehadiran --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Riwayat Kehadiran (30 Terakhir)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Masuk</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Keluar</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($kehadiran as $k)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-3 text-slate-700">{{ $k->tanggal->format('d M Y') }}</td>
                                <td class="px-6 py-3 text-slate-600">{{ $k->jam_masuk ?? '-' }}</td>
                                <td class="px-6 py-3 text-slate-600">{{ $k->jam_keluar ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    <span class="text-xs px-2 py-1 rounded-full font-medium
                                        {{ $k->status==='hadir'?'bg-green-100 text-green-700':
                                           ($k->status==='terlambat'?'bg-amber-100 text-amber-700':
                                           ($k->status==='tidak_hadir'?'bg-red-100 text-red-700':'bg-blue-100 text-blue-700')) }}">
                                        {{ $k->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-xs px-2 py-1 rounded-full font-medium
                                        {{ $k->status_verifikasi==='disetujui'?'bg-green-100 text-green-700':
                                           ($k->status_verifikasi==='ditolak'?'bg-red-100 text-red-700':'bg-amber-100 text-amber-700') }}">
                                        {{ ucfirst($k->status_verifikasi) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada riwayat kehadiran</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Log Harian Terbaru --}}
            @if($logHarian->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Log Harian Terbaru</h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($logHarian as $log)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-semibold text-slate-700">{{ $log->tanggal->format('d M Y') }}</p>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $log->status_verifikasi==='disetujui'?'bg-green-100 text-green-700':($log->status_verifikasi==='menunggu'?'bg-amber-100 text-amber-700':'bg-slate-100 text-slate-600') }}">
                                {{ $log->status_label }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 line-clamp-2">{{ $log->kegiatan_dilakukan }}</p>
                        @if($log->feedback_pembimbing)
                        <p class="text-xs text-blue-600 mt-1 italic">💬 {{ $log->feedback_pembimbing }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
