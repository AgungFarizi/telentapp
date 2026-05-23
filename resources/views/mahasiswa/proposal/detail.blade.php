@extends('layouts.app')
@section('title','Detail Proposal')
@section('page-title','Detail Proposal')
@section('sidebar-menu') @include('mahasiswa._sidebar') @endsection
@section('content')
<div class="space-y-6">
    <a href="{{ route('mahasiswa.proposal.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-700">← Kembali</a>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded">{{ $proposal->nomor_proposal }}</span>
            <span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span>
        </div>
        <h2 class="text-lg font-bold text-slate-800 mb-4">{{ $proposal->judul_proposal }}</h2>
        <dl class="space-y-3 text-sm">
            <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Divisi Tujuan</dt><dd>{{ $proposal->divisi_tujuan }}</dd></div>
            <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Periode</dt><dd>{{ $proposal->periode?->nama_periode }}</dd></div>
            <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Tanggal Diinginkan</dt><dd>{{ $proposal->tanggal_mulai_diinginkan->format('d M Y') }} – {{ $proposal->tanggal_akhir_diinginkan->format('d M Y') }}</dd></div>
            <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Pembimbing</dt><dd>{{ $proposal->pembimbing?->nama_lengkap ?? 'Belum ditugaskan' }}</dd></div>
        </dl>
        @if($proposal->catatan_hrd || $proposal->catatan_approval)
        <div class="mt-4 p-4 bg-slate-50 rounded-xl">
            @if($proposal->catatan_hrd)<p class="text-sm text-slate-700"><b>Catatan HRD:</b> {{ $proposal->catatan_hrd }}</p>@endif
            @if($proposal->catatan_approval)<p class="text-sm text-slate-700 mt-1"><b>Catatan Approval:</b> {{ $proposal->catatan_approval }}</p>@endif
        </div>
        @endif
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-bold text-slate-800 mb-4">Anggota Kelompok</h3>
        <div class="space-y-3">
            @foreach($proposal->anggota as $anggota)
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 font-bold text-sm">{{ substr($anggota->nama_lengkap,0,1) }}</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-slate-800 text-sm">{{ $anggota->nama_lengkap }}</p>
                        @if($anggota->adalah_ketua)<span class="badge-blue">Ketua</span>@endif
                    </div>
                    <p class="text-xs text-slate-500">{{ $anggota->nim }} · {{ $anggota->universitas }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if($proposal->suratBalasan->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="font-bold text-slate-800 mb-4">Surat Balasan</h3>
        @foreach($proposal->suratBalasan as $surat)
        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
            <div>
                <p class="font-semibold text-sm text-slate-800">{{ $surat->nomor_surat }}</p>
                <p class="text-xs text-slate-500">{{ $surat->jenis === 'penerimaan' ? '✅ Penerimaan' : '❌ Penolakan' }} · {{ $surat->tanggal_surat->format('d M Y') }}</p>
            </div>
            <a href="{{ route('mahasiswa.surat-balasan.detail', $surat->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold">Baca →</a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
