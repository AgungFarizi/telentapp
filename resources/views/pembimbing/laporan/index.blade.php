@extends('layouts.app')

@section('title','Laporan Kehadiran')
@section('page-title','Laporan Kehadiran')

@section('sidebar-menu')
    @include('pembimbing._sidebar')
@endsection

@section('content')

<div class="space-y-6">

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="GET" class="grid md:grid-cols-4 gap-4">

            <div>
                <label class="text-sm font-medium text-slate-600">
                    Mahasiswa
                </label>

                <select name="mahasiswa_id"
                    class="w-full mt-1 rounded-xl border-slate-300">
                    <option value="">Semua Mahasiswa</option>

                    @foreach($mahasiswaBimbingan as $mhs)
                        <option value="{{ $mhs->id }}"
                            {{ request('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                            {{ $mhs->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-slate-600">
                    Bulan
                </label>

                <select name="bulan"
                    class="w-full mt-1 rounded-xl border-slate-300">
                    <option value="">Semua Bulan</option>

                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$i,1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-slate-600">
                    Tahun
                </label>

                <input type="number"
                    name="tahun"
                    value="{{ request('tahun', date('Y')) }}"
                    class="w-full mt-1 rounded-xl border-slate-300">
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700">
                    Filter
                </button>
            </div>

        </form>
    </div>

    {{-- REKAP --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-6 border-b">
            <h2 class="font-semibold text-slate-700">
                Rekap Kehadiran Mahasiswa
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left">Mahasiswa</th>
                        <th class="px-6 py-4 text-center">Hadir</th>
                        <th class="px-6 py-4 text-center">Terlambat</th>
                        <th class="px-6 py-4 text-center">Izin/Sakit</th>
                        <th class="px-6 py-4 text-center">Tidak Hadir</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($rekap as $item)

                        <tr class="border-b hover:bg-slate-50">

                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-700">
                                    {{ $item['mahasiswa']->nama_lengkap }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $item['mahasiswa']->nim }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $item['total_hadir'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $item['total_terlambat'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $item['total_izin'] }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $item['total_tidak_hadir'] }}
                            </td>

                            <td class="px-6 py-4 text-center">

                            <a href="{{ route('pembimbing.laporan.pdf', $item['mahasiswa']->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2h-3.5a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0011.672 2H6a2 2 0 00-2 2v14a2 2 0 002 2z" />

                                </svg>

                                PDF
                            </a>

                        </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="px-6 py-8 text-center text-slate-500">
                                Belum ada data laporan kehadiran.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection