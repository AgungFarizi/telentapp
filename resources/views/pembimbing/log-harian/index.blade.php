@extends('layouts.app')

@section('title', 'Verifikasi Log Harian')
@section('page-title', 'Verifikasi Log Harian')

@section('sidebar-menu')
    @include('pembimbing._sidebar')
@endsection

@section('content')

<div class="space-y-6">

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- Header --}}
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-800">
                Data Log Harian Mahasiswa
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                Verifikasi laporan kegiatan harian mahasiswa magang
            </p>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-4">Mahasiswa</th>
                        <th class="text-left px-6 py-4">Tanggal</th>
                        <th class="text-center px-6 py-4">Dokumen</th>
                        <th class="text-center px-6 py-4">Status</th>
                        <th class="text-left px-6 py-4">Feedback</th>
                        <th class="text-center px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                            {{-- Mahasiswa --}}
                            <td class="px-6 py-5">
                                <div class="font-semibold text-slate-800">
                                    {{ $log->mahasiswa->nama_lengkap }}
                                </div>

                                <div class="text-xs text-slate-500 mt-1">
                                    NIM: {{ $log->mahasiswa->nim }}
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-5 text-slate-700">
                                {{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                            </td>

                            {{-- File PDF --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    @if($log->file_dokumentasi)

                                        {{-- View --}}
                                        <a
                                            href="{{ asset('storage/' . $log->file_dokumentasi) }}"
                                            target="_blank"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                                            title="Lihat PDF"
                                        >
                                            👁
                                        </a>

                                        {{-- Download --}}
                                        <a
                                            href="{{ asset('storage/' . $log->file_dokumentasi) }}"
                                            download
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition"
                                            title="Download PDF"
                                        >
                                            ⬇
                                        </a>

                                    @else

                                        <span class="text-xs text-slate-400">
                                            Tidak ada file
                                        </span>

                                    @endif

                                </div>

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5 text-center">

                                @if($log->status_verifikasi == 'menunggu')

                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                        Menunggu
                                    </span>

                                @elseif($log->status_verifikasi == 'disetujui')

                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        Disetujui
                                    </span>

                                @elseif($log->status_verifikasi == 'ditolak')

                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                        Revisi
                                    </span>

                                @endif

                            </td>

                            {{-- Feedback --}}
                            <td class="px-6 py-5 w-72">

                                @if($log->feedback_pembimbing)

                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-600 leading-relaxed">
                                        {{ $log->feedback_pembimbing }}
                                    </div>

                                @else

                                    <span class="text-xs text-slate-400 italic">
                                        Belum ada feedback
                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5">

                                @if($log->status_verifikasi == 'menunggu')

                                    <form
                                        action="{{ route('pembimbing.log-harian.verifikasi', $log->id) }}"
                                        method="POST"
                                        class="space-y-3"
                                    >
                                        @csrf

                                        {{-- Feedback --}}
                                        <textarea
                                            name="feedback_pembimbing"
                                            rows="3"
                                            placeholder="Tulis komentar / feedback..."
                                            class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        ></textarea>

                                        {{-- Button --}}
                                        <div class="flex flex-wrap gap-2">

                                            {{-- Setujui --}}
                                            <button
                                                type="submit"
                                                name="aksi"
                                                value="disetujui"
                                                class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg transition"
                                            >
                                                ✔ Setujui
                                            </button>

                                            {{-- Revisi --}}
                                            <button
                                                type="submit"
                                                name="aksi"
                                                value="revisi"
                                                class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded-lg transition"
                                            >
                                                ✏ Revisi
                                            </button>

                                            {{-- Tolak --}}
                                            <button
                                                type="submit"
                                                name="aksi"
                                                value="ditolak"
                                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg transition"
                                            >
                                                ✖ Tolak
                                            </button>

                                        </div>

                                    </form>

                                @else

                                    <div class="text-xs text-slate-400 text-center">
                                        Sudah diverifikasi
                                    </div>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div class="text-5xl mb-3">
                                        📄
                                    </div>

                                    <p class="text-slate-500 font-medium">
                                        Belum ada log harian
                                    </p>

                                    <p class="text-xs text-slate-400 mt-1">
                                        Data log harian mahasiswa akan muncul di sini
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        @endif

    </div>

</div>

@endsection