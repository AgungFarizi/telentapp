@extends('layouts.app')
@section('title','Pantau Kehadiran')
@section('page-title','Pantau Kehadiran Mahasiswa')
@section('sidebar-menu') @include('manager._sidebar') @endsection
@section('content')
<div class="space-y-4">
    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-wrap">
            <input type="date" name="tanggal" value="{{ request('tanggal', today()->format('Y-m-d')) }}"
                class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="hadir" {{ request('status')==='hadir'?'selected':'' }}>Hadir</option>
                <option value="terlambat" {{ request('status')==='terlambat'?'selected':'' }}>Terlambat</option>
                <option value="izin" {{ request('status')==='izin'?'selected':'' }}>Izin</option>
                <option value="sakit" {{ request('status')==='sakit'?'selected':'' }}>Sakit</option>
                <option value="tidak_hadir" {{ request('status')==='tidak_hadir'?'selected':'' }}>Tidak Hadir</option>
            </select>
            <select name="mahasiswa_id" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Mahasiswa</option>
                @foreach($mahasiswaList as $mhs)
                <option value="{{ $mhs->id }}" {{ request('mahasiswa_id')==$mhs->id?'selected':'' }}>
                    {{ $mhs->nama_lengkap }} ({{ $mhs->nim }})
                </option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold">Filter</button>
        </form>
    </div>

    {{-- Stats Hari Ini --}}
    <div class="grid grid-cols-4 gap-3">
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-green-700">{{ $statsHariIni['hadir'] }}</p>
            <p class="text-xs text-green-600 mt-0.5">Hadir</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-amber-700">{{ $statsHariIni['terlambat'] }}</p>
            <p class="text-xs text-amber-600 mt-0.5">Terlambat</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-blue-700">{{ $statsHariIni['izin'] }}</p>
            <p class="text-xs text-blue-600 mt-0.5">Izin/Sakit</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-red-700">{{ $statsHariIni['tidak_hadir'] }}</p>
            <p class="text-xs text-red-600 mt-0.5">Tidak Hadir</p>
        </div>
    </div>

    {{-- Tabel Kehadiran --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Data Kehadiran — {{ \Carbon\Carbon::parse($tanggalFilter)->isoFormat('dddd, D MMMM Y') }}</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Mahasiswa</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Jam Masuk</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Jam Keluar</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kehadiran as $k)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $k->mahasiswa->foto_profil_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $k->mahasiswa->nama_lengkap }}</p>
                                <p class="text-xs text-slate-500">{{ $k->mahasiswa->nim }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5 hidden md:table-cell text-slate-600">{{ $k->jam_masuk ?? '-' }}</td>
                    <td class="px-6 py-3.5 hidden md:table-cell text-slate-600">{{ $k->jam_keluar ?? '-' }}</td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $k->status==='hadir'?'bg-green-100 text-green-700':
                               ($k->status==='terlambat'?'bg-amber-100 text-amber-700':
                               ($k->status==='tidak_hadir'?'bg-red-100 text-red-700':'bg-blue-100 text-blue-700')) }}">
                            {{ $k->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 hidden lg:table-cell">
                        <span class="text-xs px-2 py-1 rounded-full {{ $k->status_verifikasi==='disetujui'?'bg-green-100 text-green-700':($k->status_verifikasi==='ditolak'?'bg-red-100 text-red-700':'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($k->status_verifikasi) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada data kehadiran untuk tanggal ini</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($kehadiran->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $kehadiran->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
