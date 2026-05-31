@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Dashboard')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

@if(!$proposalAktif)

{{-- HERO --}}
<div class="bg-gradient-to-r from-green-600 via-emerald-500 to-green-500 rounded-3xl p-8 lg:p-10 text-white shadow-xl mb-8 overflow-hidden relative">

    <div class="absolute right-0 top-0 opacity-10 text-[180px] font-black leading-none">
        TELENT
    </div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">

        <div class="max-w-3xl">

            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/20 backdrop-blur text-sm font-semibold mb-5">
                PORTAL MAHASISWA
            </span>

            <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-5">
                Selamat datang di portal magang TELENT
            </h1>

            <p class="text-green-50 text-lg leading-relaxed">
                Lengkapi data diri, baca panduan magang, lalu ajukan proposal
                sesuai divisi yang Anda minati.
            </p>

            <div class="flex flex-wrap gap-4 mt-8">

                <a href="{{ route('mahasiswa.proposal.index') }}"
                   class="inline-flex items-center gap-3 px-7 py-4 bg-white text-green-700 rounded-2xl font-bold hover:scale-105 transition-all shadow-lg">

                    Ajukan Proposal

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

                <a href="{{ route('mahasiswa.profil') }}"
                   class="inline-flex items-center gap-3 px-7 py-4 bg-white/10 hover:bg-white/20 border border-white/20 rounded-2xl font-semibold transition-all">

                    Lengkapi Profil

                </a>

            </div>

        </div>

        {{-- PROGRESS --}}
        <div class="bg-white/10 backdrop-blur rounded-3xl p-6 min-w-[320px] border border-white/10">

            <div class="flex items-center justify-between mb-5">

                <h3 class="font-bold text-lg">
                    Progress Pendaftaran
                </h3>

                <span class="text-sm bg-white/20 px-3 py-1 rounded-full">
                    0%
                </span>

            </div>

            <div class="w-full bg-white/20 rounded-full h-3 mb-6">
                <div class="bg-white h-3 rounded-full w-[10%]"></div>
            </div>

            <div class="space-y-4">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                            👤
                        </div>

                        <span>Lengkapi Profil</span>

                    </div>

                    <span class="text-xs bg-yellow-300 text-yellow-900 px-2 py-1 rounded-full font-semibold">
                        Pending
                    </span>

                </div>

                <div class="flex items-center justify-between opacity-70">

                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                            📄
                        </div>

                        <span>Upload Proposal</span>

                    </div>

                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">
                        Belum
                    </span>

                </div>

                <div class="flex items-center justify-between opacity-70">

                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                            ✅
                        </div>

                        <span>Review HRD</span>

                    </div>

                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">
                        Menunggu
                    </span>

                </div>

            </div>

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

        } else {

            btn.classList.add('opacity-50');
            btn.classList.add('pointer-events-none');

        }

    });

</script>

@else

{{-- DASHBOARD MAGANG AKTIF --}}
<div class="grid md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-2 text-slate-700">
            Total Hadir
        </h3>

        <p class="text-5xl font-bold text-green-600">
            {{ $totalHadir }}
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-2 text-slate-700">
            Izin / Sakit
        </h3>

        <p class="text-5xl font-bold text-yellow-500">
            {{ $totalIzin }}
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-lg font-bold mb-2 text-slate-700">
            Log Pending
        </h3>

        <p class="text-5xl font-bold text-indigo-600">
            {{ $logPending }}
        </p>
    </div>

</div>

@endif

@endsection