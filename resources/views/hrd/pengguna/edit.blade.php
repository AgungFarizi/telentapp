@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna Admin')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        {{-- Info user --}}
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
            <img src="{{ $pengguna->foto_profil_url }}" class="w-14 h-14 rounded-full object-cover" alt="">
            <div>
                <h2 class="font-bold text-slate-800">{{ $pengguna->nama_lengkap }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="{{ $pengguna->role==='hrd'?'badge-blue':($pengguna->role==='manager'?'badge-purple':'badge-green') }}">
                        {{ $pengguna->getRoleLabel() }}
                    </span>
                    <span class="text-xs text-slate-500">{{ $pengguna->email }}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('hrd.pengguna.update', $pengguna->id) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required value="{{ old('email', $pengguna->email) }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Divisi</label>
                    <input type="text" name="divisi" value="{{ old('divisi', $pengguna->divisi) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $pengguna->jabatan) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $pengguna->no_hp) }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Akun <span class="text-red-500">*</span></label>
                <select name="status_akun" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="aktif" {{ ($pengguna->status_akun==='aktif')?'selected':'' }}>Aktif</option>
                    <option value="nonaktif" {{ ($pengguna->status_akun==='nonaktif')?'selected':'' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800 transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('hrd.pengguna.index') }}"
                    class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
