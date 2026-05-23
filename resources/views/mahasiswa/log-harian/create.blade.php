@extends('layouts.app')

@section('title','Upload Log Harian')
@section('page-title','Upload Log Harian')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')

<div class="max-w-2xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <ul class="list-disc ml-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <form
            action="{{ route('mahasiswa.log-harian.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-5"
        >

            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    required
                    value="{{ date('Y-m-d') }}"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Upload PDF Log Harian
                </label>

                <input
                    type="file"
                    name="file_dokumentasi"
                    accept=".pdf"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3"
                >
            </div>

            <button
                type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl"
            >
                Upload Log Harian
            </button>

        </form>

    </div>

</div>

@endsection