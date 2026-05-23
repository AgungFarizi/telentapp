@extends('layouts.app')

@section('title', 'Surat Balasan')
@section('page-title', 'Surat Balasan')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

    {{-- Header --}}
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-semibold text-slate-800">
            Surat Balasan HRD
        </h3>
    </div>

    <div class="p-6">

        @if($proposal && $proposal->suratBalasan->count())

            <div class="space-y-4">

                @foreach($proposal->suratBalasan as $surat)

                    <div class="border border-slate-200 rounded-2xl p-5">

                        {{-- Nomor Surat --}}
                        <div class="mb-3">
                            <label class="text-sm text-slate-500">
                                Nomor Surat
                            </label>

                            <div class="font-medium text-slate-800">
                                {{ $surat->nomor_surat ?? '-' }}
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label class="text-sm text-slate-500">
                                Tanggal Surat
                            </label>

                            <div class="font-medium text-slate-800">
                                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}
                            </div>
                        </div>

                        {{-- Jenis --}}
                        <div class="mb-3">
                            <label class="text-sm text-slate-500">
                                Jenis Surat
                            </label>

                            <div class="font-medium text-slate-800 capitalize">
                                {{ $surat->jenis }}
                            </div>
                        </div>

                        {{-- Perihal --}}
                        <div class="mb-3">
                            <label class="text-sm text-slate-500">
                                Perihal
                            </label>

                            <div class="font-medium text-slate-800">
                                {{ $surat->perihal }}
                            </div>
                        </div>

                        {{-- Isi Surat --}}
                        @if($surat->isi_surat)
                        <div class="mb-4">
                            <label class="text-sm text-slate-500">
                                Isi Surat
                            </label>

                            <div class="text-slate-700 whitespace-pre-line">
                                {{ $surat->isi_surat }}
                            </div>
                        </div>
                        @endif

                        {{-- File PDF --}}
                        @if($surat->file_surat)
                        <div class="flex gap-3 mt-4">

                            <a
                                href="{{ asset('storage/' . $surat->file_surat) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm"
                            >
                                👁 Lihat Surat
                            </a>

                            <a
                                href="{{ asset('storage/' . $surat->file_surat) }}"
                                download
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm"
                            >
                                ⬇ Download
                            </a>

                        </div>
                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10">

                <div class="text-slate-400 text-lg mb-2">
                    Belum Ada Surat Balasan
                </div>

                <p class="text-sm text-slate-500">
                    Surat balasan dari HRD belum tersedia.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection