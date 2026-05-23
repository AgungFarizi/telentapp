@extends('layouts.app')
@section('title','Surat Balasan')
@section('page-title','Surat Balasan')
@section('sidebar-menu') @include('mahasiswa._sidebar') @endsection
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('mahasiswa.surat-balasan.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-700 mb-4">← Kembali</a>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <div class="text-center mb-6 pb-6 border-b border-slate-100">
            <div class="w-14 h-14 {{ $surat->jenis==='penerimaan'?'bg-green-100':'bg-red-100' }} rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="text-2xl">{{ $surat->jenis==='penerimaan'?'✅':'❌' }}</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Surat {{ ucfirst($surat->jenis) }}</h2>
            <p class="text-sm text-slate-500 mt-1">{{ $surat->nomor_surat }}</p>
        </div>
        <div class="mb-4">
            <p class="text-sm text-slate-600"><b>Perihal:</b> {{ $surat->perihal }}</p>
            <p class="text-sm text-slate-600 mt-1"><b>Tanggal:</b> {{ $surat->tanggal_surat->format('d M Y') }}</p>
        </div>
        <div class="prose prose-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $surat->isi_surat }}</div>
    </div>
</div>
@endsection
