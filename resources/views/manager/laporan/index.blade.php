@extends('layouts.app')
@section('title','Laporan Rekap')
@section('page-title','Laporan Rekap Magang')
@section('sidebar-menu') @include('manager._sidebar') @endsection
@section('content')
<div class="space-y-4">
    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-wrap">
            <select name="periode_id" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Periode</option>
                @foreach($periodes as $p)
                <option value="{{ $p->id }}" {{ $periodeId==$p->id?'selected':'' }}>{{ $p->nama_periode }}</option>
                @endforeach
            </select>
            <select name="bulan" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($bulanList as $num => $nama)
                <option value="{{ $num }}" {{ $bulan==$num?'selected':'' }}>{{ $nama }}</option>
                @endforeach
            </select>
            <select name="tahun" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                @for($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold">Tampilkan</button>
        </form>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-slate-900">{{ $summary['total_mahasiswa'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Total Mahasiswa</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-slate-900">{{ $summary['total_proposal'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Proposal Aktif</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $summary['total_hadir'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Total Hari Hadir</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-red-600">{{ $summary['total_tidak_hadir'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Total Tidak Hadir</p>
        </div>
    </div>

    {{-- Rekap Per Mahasiswa --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">
                Rekap Kehadiran — {{ $bulanList[$bulan] }} {{ $tahun }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Mahasiswa</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Pembimbing</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-green-600 uppercase">Hadir</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-amber-600 uppercase">Terlambat</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-blue-600 uppercase">Izin</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-red-600 uppercase">Absen</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-purple-600 uppercase">Log</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-slate-500 uppercase">%</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rekapKehadiran as $rekap)
                    @php
                        $total = $rekap['hadir'] + $rekap['terlambat'] + $rekap['izin'] + $rekap['tidak_hadir'];
                        $persen = $total > 0 ? round((($rekap['hadir'] + $rekap['terlambat']) / $total) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $rekap['mahasiswa']->foto_profil_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $rekap['mahasiswa']->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-500">{{ $rekap['mahasiswa']->nim }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell text-xs text-slate-600">
                            {{ $rekap['proposal']->pembimbing?->nama_lengkap ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $rekap['hadir'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $rekap['terlambat'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $rekap['izin'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $rekap['tidak_hadir'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-block bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $rekap['total_log'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-xs font-bold {{ $persen >= 80 ? 'text-green-600' : ($persen >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $persen }}%
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <a href="{{ route('manager.mahasiswa.detail', $rekap['mahasiswa']->id) }}"
                               class="px-3 py-1.5 text-xs bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada data untuk filter yang dipilih</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
