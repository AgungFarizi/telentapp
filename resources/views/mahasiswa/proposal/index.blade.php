@extends('layouts.app')

@section('title', 'Proposal Saya')
@section('page-title', 'Proposal Saya')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

@if(!$sudahPunyaProposal)

<div class="bg-white border border-slate-200 rounded-2xl p-8 mb-8">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">
            Selamat datang di portal magang TELENT
        </h2>

        <p class="text-slate-600">
            Pastikan Anda membaca seluruh alur pengajuan sebelum memulai proposal.
        </p>
    </div>

    {{-- STEP PROGRESS --}}
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <div class="border rounded-xl p-5">
            <div class="text-lg font-semibold mb-2">
                1. Lengkapi Profil
            </div>

            <p class="text-sm text-slate-500">
                Pastikan data diri dan kontak sudah benar.
            </p>
        </div>

        <div class="border rounded-xl p-5">
            <div class="text-lg font-semibold mb-2">
                2. Siapkan Dokumen
            </div>

            <p class="text-sm text-slate-500">
                Siapkan proposal PDF dan surat pengantar kampus.
            </p>
        </div>

        <div class="border rounded-xl p-5">
            <div class="text-lg font-semibold mb-2">
                3. Pilih Divisi
            </div>

            <p class="text-sm text-slate-500">
                Sesuaikan dengan minat dan kemampuan Anda.
            </p>
        </div>

    </div>

    {{-- ALUR --}}
    <div class="border rounded-2xl p-8 mb-8">

        <h3 class="text-2xl font-bold text-center mb-10">
            Alur Proses Pengajuan
        </h3>

        <div class="flex flex-col md:flex-row items-center justify-between gap-8">

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-green-600 text-white flex items-center justify-center mx-auto mb-3 text-xl font-bold">
                    1
                </div>

                <h4 class="font-semibold">Submission</h4>

                <p class="text-sm text-slate-500 mt-2">
                    Upload proposal dan dokumen pendukung
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-indigo-500 text-white flex items-center justify-center mx-auto mb-3 text-xl font-bold">
                    2
                </div>

                <h4 class="font-semibold">Review HRD</h4>

                <p class="text-sm text-slate-500 mt-2">
                    HRD melakukan seleksi proposal
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-slate-500 text-white flex items-center justify-center mx-auto mb-3 text-xl font-bold">
                    3
                </div>

                <h4 class="font-semibold">Pengumuman</h4>

                <p class="text-sm text-slate-500 mt-2">
                    Mahasiswa diterima atau ditolak
                </p>
            </div>

        </div>
    </div>

    {{-- CHECKBOX --}}
    <div class="text-center">

        <label class="inline-flex items-center gap-3 mb-6">
            <input type="checkbox"
                   id="checkPanduan"
                   class="w-5 h-5 rounded border-slate-300">

            <span class="text-slate-700">
                Saya telah membaca dan memahami seluruh ketentuan magang
            </span>
        </label>

        <div>
            <a href="{{ route('mahasiswa.proposal.create') }}"
               id="btnMulai"
               class="pointer-events-none opacity-50 inline-flex items-center gap-2 px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-full text-lg font-semibold transition">
                Mulai Pengajuan
            </a>
        </div>

    </div>

</div>

<script>
    const check = document.getElementById('checkPanduan');
    const btn = document.getElementById('btnMulai');

    check.addEventListener('change', function () {

        if(this.checked){
            btn.classList.remove('opacity-50');
            btn.classList.remove('pointer-events-none');
        }else{
            btn.classList.add('opacity-50');
            btn.classList.add('pointer-events-none');
        }

    });
</script>

@endif

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
        
    @endforelse

    <!-- Pagination -->
    @if($proposals->hasPages())
        <div class="pt-2">
            {{ $proposals->links() }}
        </div>
    @endif
</div>

@endsection