@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->nama_lengkap)

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

<div class="space-y-6">

    {{-- Status Proposal Banner --}}
    @if($proposalAktif)
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl p-5 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></div>
                        <span class="text-green-200 text-xs font-semibold uppercase tracking-wide">
                            Magang Aktif
                        </span>
                    </div>

                    <h3 class="text-base font-bold">
                        {{ $proposalAktif->judul_proposal }}
                    </h3>

                    <p class="text-green-100 text-sm mt-1">
                        {{ $proposalAktif->periode->nama_periode ?? '-' }}

                        @if($proposalAktif->pembimbing)
                            · Pembimbing:
                            {{ $proposalAktif->pembimbing->nama_lengkap }}
                        @endif
                    </p>
                </div>

                <div class="flex gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold">
                            {{ $proposalAktif->periode?->tanggal_mulai_magang?->format('d M') ?? '-' }}
                        </p>
                        <p class="text-green-200 text-xs mt-0.5">Mulai</p>
                    </div>

                    <div class="w-px bg-green-400"></div>

                    <div>
                        <p class="text-2xl font-bold">
                            {{ $proposalAktif->periode?->tanggal_akhir_magang?->format('d M') ?? '-' }}
                        </p>
                        <p class="text-green-200 text-xs mt-0.5">Selesai</p>
                    </div>
                </div>

            </div>
        </div>
    @else

        {{-- Belum Ada Proposal --}}
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-10 text-center">

            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-slate-800 mb-2">
                Belum Ada Proposal Aktif
            </h3>

            <p class="text-slate-500 text-sm mb-5">
                Ajukan proposal magang untuk memulai perjalanan magangmu!
            </p>

            <a href="{{ route('mahasiswa.proposal.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition">

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Ajukan Proposal
            </a>

        </div>

    @endif


    {{-- Statistik --}}
    @if($proposalAktif)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Hadir --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <p class="text-3xl font-bold text-slate-900">
                    {{ $totalHadir }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Hadir Bulan Ini
                </p>
            </div>

            {{-- Tidak Hadir --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-red-500"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <p class="text-3xl font-bold text-slate-900">
                    {{ $totalTidakHadir }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Tidak Hadir
                </p>
            </div>

            {{-- Izin --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-amber-500"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <p class="text-3xl font-bold text-slate-900">
                    {{ $totalIzin }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Izin / Sakit
                </p>
            </div>

            {{-- Log Pending --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-purple-500"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>

                <p class="text-3xl font-bold text-slate-900">
                    {{ $logPending }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Log Pending
                </p>
            </div>

        </div>


        {{-- Absensi Hari Ini --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6"
             x-data="absensiWidget()">

            <h3 class="font-bold text-slate-900 mb-4">
                Absensi Hari Ini —
                {{ now()->isoFormat('dddd, D MMMM Y') }}
            </h3>

            @if($sudahAbsenHariIni)

                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-100 rounded-xl">

                    <svg class="w-5 h-5 text-green-500 flex-shrink-0"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    <div>
                        <p class="font-semibold text-green-800 text-sm">
                            Absensi hari ini sudah dicatat
                        </p>

                        <p class="text-xs text-green-600 mt-0.5">
                            Jangan lupa absen keluar dan isi log harian!
                        </p>
                    </div>

                </div>

            @else

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <button @click="absenMasuk()"
                            :disabled="loading"
                            class="flex items-center justify-center gap-3 p-4 bg-green-600 hover:bg-green-700 text-white rounded-xl transition font-semibold text-sm disabled:opacity-50">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                        </svg>

                        <span>Absen Masuk</span>
                    </button>

                    <button @click="absenKeluar()"
                            :disabled="loading"
                            class="flex items-center justify-center gap-3 p-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition font-semibold text-sm disabled:opacity-50">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                        </svg>

                        <span>Absen Keluar</span>
                    </button>

                </div>

                <p x-show="message"
                   x-text="message"
                   class="mt-3 text-sm text-center font-medium"
                   :class="success ? 'text-green-600' : 'text-red-500'">
                </p>

            @endif

        </div>

    @endif


    {{-- Notifikasi --}}
    @if($notifikasi->isNotEmpty())

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">
                    Notifikasi Terbaru
                </h3>

                <a href="{{ route('mahasiswa.notifikasi') }}"
                   class="text-xs text-green-600 hover:text-green-700 font-semibold">
                    Lihat Semua →
                </a>
            </div>

            <div class="divide-y divide-slate-50">

                @foreach($notifikasi as $notif)

                    <div class="px-6 py-4 flex items-start gap-4 {{ !$notif->sudah_dibaca ? 'bg-blue-50/30' : '' }}">

                        <span class="text-xl flex-shrink-0 mt-0.5">
                            {{ $notif->icon }}
                        </span>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $notif->judul }}
                            </p>

                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $notif->pesan }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                {{ $notif->created_at->diffForHumans() }}
                            </p>
                        </div>

                        @if(!$notif->sudah_dibaca)
                            <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    @endif

</div>


@push('scripts')
<script>
function absensiWidget() {
    return {
        loading: false,
        message: '',
        success: false,

        async absenMasuk() {

            this.loading = true;
            this.message = '';

            try {

                const res = await fetch('{{ route("mahasiswa.kehadiran.masuk") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                const data = await res.json();

                if (data.success) {

                    this.success = true;
                    this.message = data.message + ' Jam: ' + data.jam_masuk;

                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                } else {

                    this.success = false;
                    this.message = data.error || 'Terjadi kesalahan.';
                }

            } catch (e) {

                this.success = false;
                this.message = 'Gagal terhubung ke server.';
            }

            this.loading = false;
        },

        async absenKeluar() {

            this.loading = true;
            this.message = '';

            try {

                const res = await fetch('{{ route("mahasiswa.kehadiran.keluar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                const data = await res.json();

                if (data.success) {

                    this.success = true;
                    this.message = data.message + ' Durasi: ' + (data.durasi || '-');

                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                } else {

                    this.success = false;
                    this.message = data.error || 'Terjadi kesalahan.';
                }

            } catch (e) {

                this.success = false;
                this.message = 'Gagal terhubung ke server.';
            }

            this.loading = false;
        }
    }
}
</script>
@endpush

@endsection