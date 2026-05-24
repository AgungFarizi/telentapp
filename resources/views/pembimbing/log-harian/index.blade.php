@extends('layouts.app')

@section('title', 'Verifikasi Log Harian')
@section('page-title', 'Verifikasi Log Harian')

@section('sidebar-menu')
    @include('pembimbing._sidebar')
@endsection

@section('content')

<!-- Page Heading -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Verifikasi Log Harian</h1>
    <p class="mt-1 text-sm text-slate-500">Verifikasi laporan kegiatan harian mahasiswa magang</p>
</div>

<!-- Alert Success -->
@if(session('success'))
    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <div class="flex-shrink-0 pt-0.5">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<!-- Main Card -->
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl overflow-hidden border border-slate-200">
    
    <!-- Header Card -->
    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-slate-900">Riwayat Log Harian</h3>
            <p class="text-sm text-slate-500 mt-1">Daftar laporan submit mahasiswa</p>
        </div>
    </div>

    <!-- Table Wrapper -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            
            <!-- Table Head -->
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Mahasiswa</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Dokumen</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Feedback</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-slate-200 bg-white">

                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition duration-150">

                        <!-- Column: Mahasiswa -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm ring-2 ring-white shadow-sm shrink-0">
                                    {{ strtoupper(substr($log->mahasiswa->nama_lengkap, 0, 2)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $log->mahasiswa->nama_lengkap }}</div>
                                    <div class="text-xs font-medium text-slate-500">NIM: {{ $log->mahasiswa->nim }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Column: Tanggal -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($log->tanggal)->format('H:i') }} WIB</div>
                        </td>

                        <!-- Column: File -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($log->file_dokumentasi)
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ asset('storage/' . $log->file_dokumentasi) }}" target="_blank" class="text-slate-400 hover:text-indigo-600 transition" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ asset('storage/' . $log->file_dokumentasi) }}" download class="text-slate-400 hover:text-green-600 transition" title="Unduh">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>

                        <!-- Column: Status -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @switch($log->status_verifikasi)
                                @case('menunggu')
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @break
                                @case('disetujui')
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800">Disetujui</span>
                                    @break
                                @case('ditolak')
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-rose-100 text-rose-800">Ditolak</span>
                                    @break
                                @default
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Revisi</span>
                            @endswitch
                        </td>

                        <!-- Column: Feedback Display -->
                        <td class="px-6 py-4">
                            @if($log->feedback_pembimbing)
                                <div class="text-xs text-slate-600 bg-slate-50 p-2 rounded border border-slate-200 line-clamp-2">
                                    {{ $log->feedback_pembimbing }}
                                </div>
                            @else
                                <span class="text-xs italic text-slate-400">Belum ada</span>
                            @endif
                        </td>

                        <!-- Column: Action Form -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($log->status_verifikasi == 'menunggu')
                                <form action="{{ route('pembimbing.log-harian.verifikasi', $log->id) }}" method="POST" class="flex flex-col items-end gap-2">
                                    @csrf
                                    <textarea 
                                        name="feedback_pembimbing" 
                                        rows="2" 
                                        class="w-full max-w-[180px] rounded-md border-slate-300 text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        placeholder="Komentar..."
                                    ></textarea>
                                    <div class="flex gap-2">
                                        <button type="submit" name="aksi" value="disetujui" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-md transition shadow-sm">Setuju</button>
                                        <button type="submit" name="aksi" value="revisi" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded-md transition shadow-sm">Revisi</button>
                                        <button type="submit" name="aksi" value="ditolak" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium rounded-md transition shadow-sm">Tolak</button>
                                    </div>
                                </form>
                            @else
                                <span class="inline-flex text-xs font-medium text-slate-400">Terverifikasi</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-slate-500 font-medium">Belum ada log harian</p>
                                <p class="text-xs text-slate-400 mt-1">Data akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $logs->links() }}
        </div>
    @endif

</div>

<style>
    /* Optional: Custom scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

@endsection