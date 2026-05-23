@extends('layouts.app')
@section('title', isset($pengguna) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('page-title', isset($pengguna) ? 'Edit Pengguna' : 'Tambah Pengguna Admin')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ isset($pengguna) ? route('hrd.pengguna.update', $pengguna->id) : route('hrd.pengguna.store') }}">
            @csrf
            @if(isset($pengguna)) @method('PUT') @endif
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap', $pengguna->nama_lengkap ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email *</label>
                        <input type="email" name="email" required value="{{ old('email', $pengguna->email ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                @if(!isset($pengguna))
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role *</label>
                    <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Role</option>
                        <option value="hrd">HRD</option>
                        <option value="manager">Manager</option>
                        <option value="pembimbing_lapang">Pembimbing Lapang</option>
                    </select>
                </div>
                @else
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Akun *</label>
                    <select name="status_akun" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="aktif" {{ ($pengguna->status_akun??'')=='aktif'?'selected':'' }}>Aktif</option>
                        <option value="nonaktif" {{ ($pengguna->status_akun??'')=='nonaktif'?'selected':'' }}>Nonaktif</option>
                    </select>
                </div>
                @endif
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. Induk Karyawan</label>
                        <input type="text" name="no_induk_karyawan" value="{{ old('no_induk_karyawan', $pengguna->no_induk_karyawan ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP *</label>
                        <input type="text" name="no_hp" required value="{{ old('no_hp', $pengguna->no_hp ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Divisi *</label>
                        <input type="text" name="divisi" required value="{{ old('divisi', $pengguna->divisi ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jabatan *</label>
                        <input type="text" name="jabatan" required value="{{ old('jabatan', $pengguna->jabatan ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                @if(!isset($pengguna))
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700">
                    ℹ️ Password sementara akan digenerate otomatis dan dikirim ke email.
                </div>
                @endif
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800">{{ isset($pengguna) ? 'Simpan' : 'Buat Akun' }}</button>
                    <a href="{{ route('hrd.pengguna.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
