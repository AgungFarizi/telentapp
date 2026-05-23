@extends('layouts.app')
@section('title','Detail Mahasiswa')
@section('page-title','Detail Mahasiswa')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-6">
    <a href="{{ route('hrd.mahasiswa.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ $mahasiswa->foto_profil_url }}" class="w-16 h-16 rounded-full object-cover ring-2 ring-blue-200" alt="">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $mahasiswa->nama_lengkap }}</h2>
                <p class="text-slate-500 text-sm">{{ $mahasiswa->nim }} · {{ $mahasiswa->jurusan }}</p>
                <p class="text-slate-400 text-xs">{{ $mahasiswa->universitas }} · Semester {{ $mahasiswa->semester }}</p>
            </div>
        </div>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div><dt class="text-slate-500 text-xs">Email</dt><dd class="font-medium text-slate-800">{{ $mahasiswa->email }}</dd></div>
            <div><dt class="text-slate-500 text-xs">No. HP</dt><dd class="font-medium text-slate-800">{{ $mahasiswa->no_hp ?? '-' }}</dd></div>
            <div><dt class="text-slate-500 text-xs">Pembimbing</dt><dd class="font-medium text-slate-800">{{ $mahasiswa->pembimbing?->nama_lengkap ?? 'Belum ditugaskan' }}</dd></div>
            <div><dt class="text-slate-500 text-xs">Status</dt><dd><span class="{{ $mahasiswa->status_akun==='aktif'?'badge-green':'badge-gray' }}">{{ ucfirst($mahasiswa->status_akun) }}</span></dd></div>
        </dl>
    </div>
    @if($proposal)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-bold text-slate-800 mb-3">Proposal Aktif</h3>
        <div class="flex items-center justify-between">
            <div>
                <p class="font-semibold text-slate-800">{{ $proposal->judul_proposal }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $proposal->nomor_proposal }} · {{ $proposal->periode?->nama_periode }}</p>
            </div>
            <a href="{{ route('hrd.proposal.detail', $proposal->id) }}" class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-semibold">Lihat →</a>
        </div>
    </div>
    @endif
</div>
@endsection
