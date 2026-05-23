@extends('layouts.app')

@section('title','Profil')
@section('page-title','Profil Saya')

@section('sidebar-menu')
@include('pembimbing._sidebar')
@endsection

@section('content')
<div class="max-w-xl">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <form method="POST"
              action="{{ route('pembimbing.profil.update') }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="flex items-center gap-4 mb-6">

                <img
                    src="{{ auth()->user()->foto_profil_url }}"
                    class="w-20 h-20 rounded-full object-cover border"
                >

                <div>
                    <h2 class="font-bold text-slate-800 text-lg">
                        {{ auth()->user()->nama_lengkap }}
                    </h2>

                    <span class="badge-green">
                        {{ auth()->user()->getRoleLabel() }}
                    </span>

                    <div class="mt-3">
                        <input
                            type="file"
                            name="foto_profil"
                            class="text-sm"
                        >
                    </div>
                </div>

            </div>

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ auth()->user()->nama_lengkap }}"
                        class="w-full px-4 py-2 rounded-xl border"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">
                        No HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="{{ auth()->user()->no_hp }}"
                        class="w-full px-4 py-2 rounded-xl border"
                    >
                </div>

                <button
                    type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-xl"
                >
                    Simpan Profil
                </button>

            </div>

        </form>

    </div>
</div>
@endsection