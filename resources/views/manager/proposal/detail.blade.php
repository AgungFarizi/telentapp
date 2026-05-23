@extends('layouts.app')
@section('title','Detail Proposal')
@section('page-title','Detail Proposal (Pantau)')
@section('sidebar-menu') @include('manager._sidebar') @endsection
@section('content')
<div class="space-y-6">
    <a href="{{ route('manager.proposal.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
        <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        <p class="text-xs text-slate-600">Mode Pantau — Approval proposal dikelola oleh HRD.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded">{{ $proposal->nomor_proposal }}</span>
                    <span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span>
                </div>
                <h2 class="font-bold text-slate-800 text-lg mb-4">{{ $proposal->judul_proposal }}</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Divisi Tujuan</dt><dd>{{ $proposal->divisi_tujuan }}</dd></div>
                    <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Periode</dt><dd>{{ $proposal->periode?->nama_periode }}</dd></div>
                    <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Tanggal Diinginkan</dt><dd>{{ $proposal->tanggal_mulai_diinginkan->format('d M Y') }} – {{ $proposal->tanggal_akhir_diinginkan->format('d M Y') }}</dd></div>
                    <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Jumlah Anggota</dt><dd>{{ $proposal->jumlah_anggota }} orang</dd></div>
                    <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Pembimbing</dt><dd>{{ $proposal->pembimbing?->nama_lengkap ?? 'Belum ditugaskan' }}</dd></div>
                    <div class="flex gap-3"><dt class="w-36 text-slate-500 flex-shrink-0">Deskripsi</dt><dd class="leading-relaxed">{{ $proposal->deskripsi_kegiatan }}</dd></div>
                </dl>
            </div>

            {{-- Anggota --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4">Anggota Kelompok</h3>
                <div class="space-y-3">
                    @foreach($proposal->anggota as $anggota)
                    <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl">
                        <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-700 font-bold text-sm">{{ substr($anggota->nama_lengkap,0,1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-slate-800 text-sm">{{ $anggota->nama_lengkap }}</p>
                                @if($anggota->adalah_ketua) <span class="badge-blue">Ketua</span> @endif
                            </div>
                            <p class="text-xs text-slate-500">{{ $anggota->nim }} · {{ $anggota->universitas }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status Panel (read-only) --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-3">Status Approval</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $proposal->status !== 'draft' ? 'bg-green-50' : 'bg-slate-50' }}">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 {{ $proposal->status !== 'draft' ? 'bg-green-500' : 'bg-slate-300' }}">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Pengajuan Mahasiswa</p>
                            <p class="text-xs text-slate-500">{{ $proposal->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ in_array($proposal->status, ['diteruskan_manager','disetujui','ditolak']) ? 'bg-green-50' : 'bg-slate-50' }}">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 {{ in_array($proposal->status, ['diteruskan_manager','disetujui','ditolak']) ? 'bg-green-500' : 'bg-slate-300' }}">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Review HRD</p>
                            <p class="text-xs text-slate-500">{{ $proposal->reviewerHRD?->nama_lengkap ?? 'Menunggu' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ in_array($proposal->status, ['disetujui','ditolak']) ? ($proposal->status==='disetujui' ? 'bg-green-50' : 'bg-red-50') : 'bg-slate-50' }}">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 {{ $proposal->status==='disetujui' ? 'bg-green-500' : ($proposal->status==='ditolak' ? 'bg-red-500' : 'bg-slate-300') }}">
                            @if($proposal->status === 'ditolak')
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            @else
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Keputusan Final HRD</p>
                            <p class="text-xs text-slate-500">
                                @if($proposal->approver) {{ $proposal->approver->nama_lengkap }} · {{ $proposal->tanggal_approval?->format('d M Y') }}
                                @else Menunggu @endif
                            </p>
                        </div>
                    </div>
                </div>
                @if($proposal->catatan_approval)
                <div class="mt-3 p-3 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-600"><strong>Catatan:</strong> {{ $proposal->catatan_approval }}</p>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-3 text-sm">Pengaju</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ $proposal->pengaju->foto_profil_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">{{ $proposal->pengaju->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">{{ $proposal->pengaju->nim }}</p>
                        <p class="text-xs text-slate-400">{{ $proposal->pengaju->universitas }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
