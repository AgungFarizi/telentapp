@extends('layouts.app')

@section('title', 'Proposal Saya')
@section('page-title', 'Proposal Saya')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

<!-- Page Header -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Proposal Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola pengajuan proposal magang kamu</p>
    </div>
    <a href="{{ route('mahasiswa.proposal.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Ajukan Proposal
    </a>
</div>

<!-- Proposals List -->
<div class="space-y-4">
    @forelse($proposals as $proposal)
        <div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden border border-slate-200 hover:ring-indigo-300 transition duration-200 group">
            <div class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    
                    <!-- Info Section -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200">{{ $proposal->nomor_proposal }}</span>
                            <span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span>
                        </div>
                        
                        <h3 class="text-base font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors">
                            {{ $proposal->judul_proposal }}
                        </h3>
                        
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>{{ $proposal->divisi_tujuan }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ $proposal->jumlah_anggota }} anggota</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Diajukan: {{ $proposal->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="sm:ml-4">
                        <a href="{{ route('mahasiswa.proposal.detail', $proposal->id) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-slate-50 text-slate-700 hover:bg-slate-100 hover:text-indigo-600 rounded-lg text-sm font-medium transition border border-slate-200 hover:border-indigo-300 group-hover:ring-1 group-hover:ring-indigo-100">
                            Detail
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        
        <!-- Empty State -->
        <div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden border border-slate-200">
            <div class="p-12 text-center">
                <div class="mx-auto h-16 w-16 text-slate-300 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">Belum ada proposal</h3>
                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                    Ajukan proposal magang kamu sekarang untuk memulai proses magang.
                </p>
                <div class="mt-6">
                    <a href="{{ route('mahasiswa.proposal.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-sm transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajukan Sekarang
                    </a>
                </div>
            </div>
        </div>

    @endforelse

    <!-- Pagination -->
    @if($proposals->hasPages())
        <div class="pt-2">
            {{ $proposals->links() }}
        </div>
    @endif
</div>

@endsection