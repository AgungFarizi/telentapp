@extends('layouts.app')

@section('title','Profil Manager')
@section('page-title','Profil Manager')

@section('sidebar-menu')
@include('manager._sidebar')
@endsection

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">

    <form action="{{ route('manager.profil.update') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="flex items-center gap-4 mb-6">

            <img src="{{ auth()->user()->foto_profil_url }}"
                 class="w-20 h-20 rounded-full object-cover">

            <div>
                <input type="file"
                       name="foto_profil"
                       class="text-sm">
            </div>

        </div>

        <div class="space-y-4">

            <div>
                <label>Nama Lengkap</label>
                <input type="text"
                       name="nama_lengkap"
                       value="{{ auth()->user()->nama_lengkap }}"
                       class="w-full border rounded-xl p-3">
            </div>

            <div>
                <label>Email</label>
                <input type="email"
                       name="email"
                       value="{{ auth()->user()->email }}"
                       class="w-full border rounded-xl p-3">
            </div>

            <button class="bg-emerald-600 text-white px-6 py-3 rounded-xl">
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection