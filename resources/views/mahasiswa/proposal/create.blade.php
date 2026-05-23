@extends('layouts.app')
@section('title','Ajukan Proposal')
@section('page-title','Ajukan Proposal Magang')
@section('sidebar-menu') @include('mahasiswa._sidebar') @endsection
@section('content')
<div class="max-w-2xl" x-data="{ anggotaCount: 0, anggota: [] }">
    @if($periodeAktif->isEmpty())
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
        <p class="font-semibold text-amber-800">Tidak ada periode pendaftaran yang aktif saat ini.</p>
        <a href="{{ route('mahasiswa.dashboard') }}" class="mt-3 inline-block text-sm text-blue-700">Kembali ke Dashboard</a>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('mahasiswa.proposal.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Periode Magang *</label>
                <select name="periode_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($periodeAktif as $periode)
                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }} (Sisa: {{ $periode->sisaKuota() }} kuota)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Proposal *</label>
                <input type="text" name="judul_proposal" required value="{{ old('judul_proposal') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Divisi yang Dituju *</label>
                <input type="text" name="divisi_tujuan" required value="{{ old('divisi_tujuan') }}" placeholder="Contoh: IT Development, Marketing, dll" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Kegiatan * <span class="text-slate-400 font-normal">(min. 50 karakter)</span></label>
                <textarea name="deskripsi_kegiatan" required rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('deskripsi_kegiatan') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Mulai Diinginkan *</label>
                    <input type="date" name="tanggal_mulai_diinginkan" required value="{{ old('tanggal_mulai_diinginkan') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Akhir Diinginkan *</label>
                    <input type="date" name="tanggal_akhir_diinginkan" required value="{{ old('tanggal_akhir_diinginkan') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">File Proposal PDF * <span class="text-slate-400 font-normal">(maks. 5MB)</span></label>
                <input type="file" name="file_proposal_pdf" required accept=".pdf" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Surat Pengantar <span class="text-slate-400 font-normal">(opsional, PDF, maks. 5MB)</span></label>
                <input type="file" name="file_surat_pengantar" accept=".pdf" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="border border-slate-200 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-slate-800 text-sm">Anggota Kelompok <span class="text-slate-400 font-normal">(opsional, maks. 9 anggota)</span></h3>
                    <button type="button" @click="if(anggotaCount < 9){ anggotaCount++; anggota.push({}) }" class="text-xs px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg font-semibold hover:bg-blue-200">+ Tambah Anggota</button>
                </div>
                <template x-for="(a, i) in anggota" :key="i">
                    <div class="border border-slate-100 rounded-xl p-3 mb-3">
                        <div class="flex justify-between mb-2">
                            <span class="text-xs font-semibold text-slate-600" x-text="'Anggota '+(i+1)"></span>
                            <button type="button" @click="anggota.splice(i,1); anggotaCount--" class="text-xs text-red-600 hover:text-red-800">Hapus</button>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" :name="'anggota['+i+'][nama_lengkap]'" required placeholder="Nama Lengkap" class="px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="text" :name="'anggota['+i+'][nim]'" required placeholder="NIM" class="px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="text" :name="'anggota['+i+'][universitas]'" required placeholder="Universitas" class="px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="text" :name="'anggota['+i+'][jurusan]'" required placeholder="Jurusan" class="px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="email" :name="'anggota['+i+'][email]'" required placeholder="Email" class="px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="text" :name="'anggota['+i+'][semester]'" required placeholder="Semester" class="px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800">Ajukan Proposal</button>
                <a href="{{ route('mahasiswa.proposal.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200">Batal</a>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
