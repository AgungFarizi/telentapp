@extends('layouts.app')

@section('title', 'Verifikasi Kehadiran')
@section('page-title', 'Verifikasi Kehadiran')

@section('sidebar-menu')
    @include('pembimbing._sidebar')
@endsection

@section('content')

<div class="space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h3 class="text-lg font-semibold text-slate-800">
                    Data Kehadiran Mahasiswa
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Verifikasi absensi mahasiswa magang
                </p>
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left p-3">Mahasiswa</th>
                        <th class="text-left p-3">Tanggal</th>
                        <th class="text-left p-3">Jam Masuk</th>
                        <th class="text-left p-3">Jam Keluar</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-left p-3">Verifikasi</th>
                        <th class="text-left p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kehadiran as $k)

                        <tr class="border-t border-slate-100">

                            <td class="p-3">
                                {{ $k->mahasiswa->nama_lengkap ?? '-' }}
                            </td>

                            <td class="p-3">
                                {{ $k->tanggal->format('d M Y') }}
                            </td>

                            <td class="p-3">
                                {{ $k->jam_masuk ?? '-' }}
                            </td>

                            <td class="p-3">
                                {{ $k->jam_keluar ?? '-' }}
                            </td>

                            <td class="p-3">

                                <span class="px-2 py-1 text-xs rounded-full

                                    @if($k->status == 'hadir')
                                        bg-green-100 text-green-700

                                    @elseif($k->status == 'terlambat')
                                        bg-yellow-100 text-yellow-700

                                    @elseif(in_array($k->status, ['izin', 'sakit']))
                                        bg-blue-100 text-blue-700

                                    @else
                                        bg-red-100 text-red-700
                                    @endif

                                ">
                                    {{ $k->status_label }}
                                </span>

                            </td>

                            <td class="p-3">

                                @if($k->status_verifikasi == 'disetujui')

                                    <span class="text-green-600 font-medium">
                                        Disetujui
                                    </span>

                                @elseif($k->status_verifikasi == 'ditolak')

                                    <span class="text-red-600 font-medium">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="text-yellow-600 font-medium">
                                        Menunggu
                                    </span>

                                @endif

                            </td>

                            <td class="p-3">

                                @if($k->status_verifikasi != 'disetujui')

                                    <form
                                        action="{{ route('pembimbing.kehadiran.verifikasi', $k->id) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="aksi"
                                            value="disetujui"
                                        >

                                        <button
                                            type="submit"
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs"
                                        >
                                            Verifikasi
                                        </button>

                                    </form>

                                @else

                                    <span class="text-green-600 text-xs">
                                        Sudah Diverifikasi
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-400">
                                Belum ada data kehadiran
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-6">
            {{ $kehadiran->links() }}
        </div>

    </div>

</div>

@endsection