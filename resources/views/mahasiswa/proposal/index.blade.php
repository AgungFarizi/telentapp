@extends('layouts.app')
@section('title','Proposal Saya')
@section('page-title','Proposal Saya')
@section('sidebar-menu') @include('mahasiswa._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="flex justify-end">
        <a href="{{ route('mahasiswa.proposal.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan Proposal
        </a>
    </div>
    @forelse($proposals as $proposal)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $proposal->nomor_proposal }}</span>
                    <span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span>
                </div>
                <h3 class="font-semibold text-slate-800">{{ $proposal->judul_proposal }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $proposal->divisi_tujuan }} · {{ $proposal->jumlah_anggota }} anggota</p>
                <p class="text-xs text-slate-400 mt-0.5">Diajukan: {{ $proposal->created_at->format('d M Y') }}</p>
            </div>
            <a href="{{ route('mahasiswa.proposal.detail', $proposal->id) }}" class="px-4 py-2 bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-100 flex-shrink-0">Detail →</a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-10 text-center">
        <p class="text-slate-500 mb-4">Belum ada proposal yang diajukan</p>
        <a href="{{ route('mahasiswa.proposal.create') }}" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800">Ajukan Sekarang</a>
    </div>
    @endforelse
    @if($proposals->hasPages())
    <div>{{ $proposals->links() }}</div>
    @endif
</div>
@endsection
