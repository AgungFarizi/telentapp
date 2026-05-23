@extends('layouts.app')

@section('title', 'Buat Surat Balasan')
@section('page-title', 'Buat Surat Balasan')

@section('sidebar-menu')
    @include('hrd._sidebar')
@endsection

@section('content')

<div class="max-w-3xl">

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="text-lg font-semibold text-slate-800">
                Form Surat Balasan HRD
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Upload surat balasan resmi untuk mahasiswa magang.
            </p>
        </div>

        {{-- Informasi Proposal --}}
        <div class="px-6 py-5 bg-slate-50 border-b border-slate-100">

            <div class="grid md:grid-cols-2 gap-4 text-sm">

                <div>
                    <p class="text-slate-500 mb-1">
                        Nomor Proposal
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $proposal->nomor_proposal }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-500 mb-1">
                        Mahasiswa
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $proposal->pengaju->nama_lengkap }}
                    </p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-slate-500 mb-1">
                        Judul Proposal
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $proposal->judul_proposal }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('hrd.proposal.surat.store', $proposal->id) }}"
            enctype="multipart/form-data"
            class="p-6 space-y-5"
        >
            @csrf

            {{-- Jenis Surat --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Jenis Surat <span class="text-red-500">*</span>
                </label>

                <select
                    name="jenis"
                    required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="penerimaan"
                        {{ old('jenis') == 'penerimaan' ? 'selected' : '' }}>
                        Surat Penerimaan
                    </option>

                    <option value="penolakan"
                        {{ old('jenis') == 'penolakan' ? 'selected' : '' }}>
                        Surat Penolakan
                    </option>
                </select>
            </div>

            {{-- Perihal --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Perihal <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="perihal"
                    required
                    value="{{ old('perihal', 'Surat Balasan Magang Mahasiswa') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan perihal surat"
                >
            </div>

            {{-- Tanggal Surat --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tanggal Surat <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="tanggal_surat"
                    required
                    value="{{ old('tanggal_surat', date('Y-m-d')) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            {{-- Isi Surat --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Isi Surat
                </label>

                <textarea
                    name="isi_surat"
                    rows="7"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Tulis isi surat balasan..."
                >{{ old('isi_surat') }}</textarea>
            </div>

            {{-- Upload PDF --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Upload File Surat PDF <span class="text-red-500">*</span>
                </label>

                <input
                    type="file"
                    name="file_surat"
                    accept=".pdf"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-lg file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                >

                <p class="text-xs text-slate-400 mt-2">
                    Format file: PDF • Maksimal 5 MB
                </p>
            </div>

            {{-- Action --}}
            <div class="flex items-center gap-3 pt-2">

                <button
                    type="submit"
                    class="px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-sm font-semibold transition"
                >
                    Kirim Surat
                </button>

                <a
                    href="{{ route('hrd.proposal.detail', $proposal->id) }}"
                    class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection