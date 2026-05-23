@extends('layouts.app')
@section('title','Proposal')
@section('page-title','Manajemen Proposal')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, judul, nama mahasiswa..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status')=='diajukan'?'selected':'' }}>Diajukan</option>
                <option value="diteruskan_manager" {{ request('status')=='diteruskan_manager'?'selected':'' }}>Diteruskan Manager</option>
                <option value="disetujui" {{ request('status')=='disetujui'?'selected':'' }}>Disetujui</option>
                <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold">Filter</button>
            @if(request('search')||request('status'))
            <a href="{{ route('hrd.proposal.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold">Reset</a>
            @endif
        </form>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">No. Proposal</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Pengaju</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Divisi</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Tanggal</th>
                    <th class="text-center text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Pertinjau</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($proposals as $proposal)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4"><span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded-lg">{{ $proposal->nomor_proposal }}</span></td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $proposal->pengaju->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">{{ $proposal->pengaju->nim }} · {{ $proposal->jumlah_anggota }} orang</p>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-slate-600 text-xs">{{ $proposal->divisi_tujuan }}</td>
                    <td class="px-6 py-4"><span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span></td>
                    <td class="px-6 py-4 hidden lg:table-cell text-xs text-slate-500">{{ $proposal->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('hrd.proposal.detail', $proposal->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-100">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">Tidak ada proposal</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($proposals->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $proposals->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
