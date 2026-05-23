@extends('layouts.app')
@section('title','Detail Mahasiswa')
@section('page-title','Detail Mahasiswa')
@section('sidebar-menu') @include('pembimbing._sidebar') @endsection
@section('content')
<div class="space-y-6">
    <a href="{{ route('pembimbing.mahasiswa.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-700">← Kembali</a>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-4 mb-4">
            <img src="{{ $mahasiswa->foto_profil_url }}" class="w-14 h-14 rounded-full object-cover" alt="">
            <div>
                <h2 class="text-lg font-bold text-slate-800">{{ $mahasiswa->nama_lengkap }}</h2>
                <p class="text-sm text-slate-500">{{ $mahasiswa->nim }} · {{ $mahasiswa->universitas }}</p>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-green-50 rounded-xl p-3 text-center"><p class="text-2xl font-bold text-green-700">{{ $statsKehadiran['hadir'] }}</p><p class="text-xs text-green-600">Hadir</p></div>
            <div class="bg-amber-50 rounded-xl p-3 text-center"><p class="text-2xl font-bold text-amber-700">{{ $statsKehadiran['terlambat'] }}</p><p class="text-xs text-amber-600">Terlambat</p></div>
            <div class="bg-blue-50 rounded-xl p-3 text-center"><p class="text-2xl font-bold text-blue-700">{{ $statsKehadiran['izin'] }}</p><p class="text-xs text-blue-600">Izin/Sakit</p></div>
            <div class="bg-red-50 rounded-xl p-3 text-center"><p class="text-2xl font-bold text-red-700">{{ $statsKehadiran['tidak_hadir'] }}</p><p class="text-xs text-red-600">Absen</p></div>
        </div>
    </div>
</div>
@endsection
