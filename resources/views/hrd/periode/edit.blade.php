@extends('layouts.app')
@section('title', isset($periode) ? 'Edit Periode' : 'Buat Periode')
@section('page-title', isset($periode) ? 'Edit Periode Magang' : 'Buat Periode Magang Baru')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ isset($periode) ? route('hrd.periode.update', $periode->id) : route('hrd.periode.store') }}">
            @csrf
            @if(isset($periode)) @method('PUT') @endif
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Periode *</label>
                    <input type="text" name="nama_periode" value="{{ old('nama_periode', $periode->nama_periode ?? '') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mulai Pendaftaran *</label>
                        <input type="date" name="tanggal_mulai_pendaftaran" required value="{{ old('tanggal_mulai_pendaftaran', isset($periode) ? $periode->tanggal_mulai_pendaftaran->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Akhir Pendaftaran *</label>
                        <input type="date" name="tanggal_akhir_pendaftaran" required value="{{ old('tanggal_akhir_pendaftaran', isset($periode) ? $periode->tanggal_akhir_pendaftaran->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mulai Magang *</label>
                        <input type="date" name="tanggal_mulai_magang" required value="{{ old('tanggal_mulai_magang', isset($periode) ? $periode->tanggal_mulai_magang->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Akhir Magang *</label>
                        <input type="date" name="tanggal_akhir_magang" required value="{{ old('tanggal_akhir_magang', isset($periode) ? $periode->tanggal_akhir_magang->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kuota Total *</label>
                        <input type="number" name="kuota_total" min="1" required value="{{ old('kuota_total', $periode->kuota_total ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status *</label>
                        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="draft" {{ old('status',$periode->status??'')=='draft'?'selected':'' }}>Draft</option>
                            <option value="aktif" {{ old('status',$periode->status??'')=='aktif'?'selected':'' }}>Aktif</option>
                            @isset($periode)
                            <option value="ditutup" {{ $periode->status==='ditutup'?'selected':'' }}>Ditutup</option>
                            <option value="selesai" {{ $periode->status==='selesai'?'selected':'' }}>Selesai</option>
                            @endisset
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('deskripsi', $periode->deskripsi ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Persyaratan</label>
                    <textarea name="persyaratan" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('persyaratan', $periode->persyaratan ?? '') }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800">{{ isset($periode) ? 'Simpan' : 'Buat Periode' }}</button>
                    <a href="{{ route('hrd.periode.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
