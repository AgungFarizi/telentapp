@extends('layouts.app')

@section('title', 'Edit File Log Harian')
@section('page-title', 'Edit File Log Harian')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

<div class="max-w-2xl">

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm">
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
                Ganti File Dokumentasi
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Upload ulang file PDF atau dokumentasi log harian.
            </p>
        </div>

        {{-- Form --}}
        <form
            action="{{ route('mahasiswa.log-harian.update', $log->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6 space-y-5"
        >
            @csrf
            @method('PUT')

            {{-- File Lama --}}
            @if($log->file_dokumentasi)

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        File Saat Ini
                    </label>

                    <a
                        href="{{ asset('storage/' . $log->file_dokumentasi) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition"
                    >
                        📄 Lihat File Lama
                    </a>
                </div>

            @endif

            {{-- Upload Baru --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Upload File Baru
                </label>

                <input
                    type="file"
                    name="file_dokumentasi"
                    accept=".pdf,.jpg,.jpeg,.png"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm
                    file:mr-4
                    file:py-2
                    file:px-4
                    file:border-0
                    file:rounded-lg
                    file:bg-blue-50
                    file:text-blue-700
                    hover:file:bg-blue-100"
                >

                <p class="text-xs text-slate-400 mt-2">
                    Format: PDF, JPG, JPEG, PNG • Maksimal 5 MB
                </p>
            </div>

            {{-- Button --}}
            <div class="flex items-center gap-3 pt-2">

                <button
                    type="submit"
                    class="px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-sm font-semibold transition"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('mahasiswa.log-harian.index') }}"
                    class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection