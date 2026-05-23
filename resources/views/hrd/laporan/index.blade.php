@extends('layouts.app')
@section('title','Laporan Magang')
@section('page-title','Laporan Magang')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex gap-3">
            <select name="periode_id" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Periode</option>
                @foreach($periode as $p)
                <option value="{{ $p->id }}" {{ $periodeId==$p->id?'selected':'' }}>{{ $p->nama_periode }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold">Filter</button>
        </form>
    </div>
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_mahasiswa_aktif'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Total Mahasiswa Aktif</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-slate-900">{{ $stats['total_proposal'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Total Proposal Disetujui</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-slate-900">{{ $stats['rata_kehadiran'] }}%</p>
            <p class="text-sm text-slate-500 mt-1">Rata-rata Kehadiran</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-bold text-slate-800">Daftar Peserta Magang</h3></div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Proposal</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Pengaju</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Pembimbing</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Anggota</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($proposals as $p)
                <tr>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800 text-xs">{{ $p->nomor_proposal }}</p>
                        <p class="text-xs text-slate-500">{{ $p->judul_proposal }}</p>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-xs text-slate-600">{{ $p->pengaju?->nama_lengkap }}</td>
                    <td class="px-6 py-4 hidden lg:table-cell text-xs text-slate-600">{{ $p->pembimbing?->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4 text-xs text-slate-600">{{ $p->jumlah_anggota }} orang</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
