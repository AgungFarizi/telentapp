@extends('layouts.app')
@section('title','Detail Proposal')
@section('page-title','Detail Proposal')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('hrd.proposal.index') }}" class="p-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50">
            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="font-bold text-slate-800">{{ $proposal->nomor_proposal }}</h2>
            <span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4">Informasi Proposal</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex gap-3"><dt class="w-40 text-slate-500 flex-shrink-0">Judul</dt><dd class="font-semibold text-slate-800">{{ $proposal->judul_proposal }}</dd></div>
                    <div class="flex gap-3"><dt class="w-40 text-slate-500 flex-shrink-0">Divisi Tujuan</dt><dd class="text-slate-700">{{ $proposal->divisi_tujuan }}</dd></div>
                    <div class="flex gap-3"><dt class="w-40 text-slate-500 flex-shrink-0">Periode</dt><dd class="text-slate-700">{{ $proposal->periode->nama_periode ?? '-' }}</dd></div>
                    <div class="flex gap-3"><dt class="w-40 text-slate-500 flex-shrink-0">Tanggal Diinginkan</dt><dd class="text-slate-700">{{ $proposal->tanggal_mulai_diinginkan->format('d M Y') }} – {{ $proposal->tanggal_akhir_diinginkan->format('d M Y') }}</dd></div>
                    <div class="flex gap-3"><dt class="w-40 text-slate-500 flex-shrink-0">Jumlah Anggota</dt><dd class="text-slate-700">{{ $proposal->jumlah_anggota }} orang</dd></div>
                    <div class="flex gap-3"><dt class="w-40 text-slate-500 flex-shrink-0">Deskripsi</dt><dd class="text-slate-700 leading-relaxed">{{ $proposal->deskripsi_kegiatan }}</dd></div>
                </dl>
                <div class="mt-4 pt-4 border-t border-slate-100 flex gap-3 flex-wrap">
                    @if($proposal->file_proposal_pdf)
                    <a href="{{ asset('storage/'.$proposal->file_proposal_pdf) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-semibold hover:bg-red-100">📄 Proposal PDF</a>
                    @endif
                    @if($proposal->file_surat_pengantar)
                    <a href="{{ asset('storage/'.$proposal->file_surat_pengantar) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm font-semibold hover:bg-blue-100">📋 Surat Pengantar</a>
                    @endif
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4">Anggota Kelompok</h3>
                <div class="space-y-3">
                    @foreach($proposal->anggota as $anggota)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-slate-50">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-700 font-bold text-sm">{{ substr($anggota->nama_lengkap,0,1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-semibold text-slate-800 text-sm">{{ $anggota->nama_lengkap }}</p>
                                @if($anggota->adalah_ketua) <span class="badge-blue">Ketua</span> @endif
                            </div>
                            <p class="text-xs text-slate-500">{{ $anggota->nim }} · {{ $anggota->jurusan }} · {{ $anggota->universitas }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full {{ $anggota->status_akun==='aktif' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $anggota->status_akun==='aktif' ? 'Aktif' : 'Menunggu' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="space-y-4">
            @if($proposal->status === 'diajukan' || $proposal->status === 'review_hrd')
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-1">Keputusan HRD</h3>
                <p class="text-xs text-slate-500 mb-4">HRD berwenang menyetujui atau menolak proposal langsung.</p>
                <form method="POST" action="{{ route('hrd.proposal.review', $proposal->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Pembimbing</label>
                        @php $pembimbingList = \App\Models\Pengguna::rolePembimbing()->aktif()->get(['id','nama_lengkap','divisi']); @endphp
                        <select name="pembimbing_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Pembimbing (jika disetujui) --</option>
                            @foreach($pembimbingList as $pb)
                            <option value="{{ $pb->id }}">{{ $pb->nama_lengkap }} — {{ $pb->divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan / Alasan <span class="text-red-500">*</span></label>
                        <textarea name="catatan_hrd" rows="3" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" placeholder="Masukkan catatan atau alasan keputusan..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="submit" name="aksi" value="disetujui"
                                class="py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors">
                            ✅ Setujui Proposal
                        </button>
                        <button type="submit" name="aksi" value="ditolak"
                                onclick="return confirm('Yakin menolak proposal ini?')"
                                class="py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors">
                            ❌ Tolak Proposal
                        </button>
                    </div>
                </form>
            </div>
            @elseif($proposal->status === 'disetujui')
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-green-800">Disetujui</h3>
                </div>
                <p class="text-sm text-green-700">Oleh: {{ $proposal->approver->nama_lengkap ?? '-' }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $proposal->tanggal_approval?->format('d M Y H:i') }}</p>
                <a href="{{ route('hrd.proposal.surat.create', $proposal->id) }}" class="mt-3 w-full flex items-center justify-center gap-2 py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700">📬 Buat Surat Balasan</a>
            </div>
            @elseif($proposal->status === 'ditolak')
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
                <h3 class="font-bold text-red-800 mb-1">Ditolak</h3>
                <p class="text-sm text-red-700">{{ $proposal->catatan_approval ?? $proposal->catatan_hrd }}</p>
            </div>
            @endif
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <h3 class="font-bold text-slate-800 mb-3">Data Pengaju</h3>
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ $proposal->pengaju->foto_profil_url }}" class="w-10 h-10 rounded-full object-cover" alt="">
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">{{ $proposal->pengaju->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">{{ $proposal->pengaju->nim }}</p>
                    </div>
                </div>
                <dl class="space-y-1.5 text-xs">
                    <div class="flex justify-between"><dt class="text-slate-500">Universitas</dt><dd class="font-medium text-slate-700">{{ $proposal->pengaju->universitas }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Jurusan</dt><dd class="font-medium text-slate-700">{{ $proposal->pengaju->jurusan }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Email</dt><dd class="font-medium text-slate-700">{{ $proposal->pengaju->email }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
