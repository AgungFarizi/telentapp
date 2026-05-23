@extends('layouts.app')
@section('title', 'Profil HRD')
@section('page-title', 'Profil Saya')
@section('sidebar-menu') @include('hrd._sidebar') @endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ auth()->user()->foto_profil_url }}" class="w-16 h-16 rounded-full object-cover ring-2 ring-blue-200" alt="">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ auth()->user()->nama_lengkap }}</h2>
                <span class="badge-blue">{{ auth()->user()->getRoleLabel() }}</span>
                <p class="text-sm text-slate-500 mt-1">{{ auth()->user()->divisi }} · {{ auth()->user()->jabatan }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('hrd.profil.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-50 text-slate-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP</label>
                <input type="text" name="no_hp" value="{{ auth()->user()->no_hp }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto Profil</label>
                <input type="file" name="foto_profil" accept="image/*"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="pt-2">
                <button type="submit" class="px-6 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
