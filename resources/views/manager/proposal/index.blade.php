@extends('layouts.app')
@section('title','Data Proposal')
@section('page-title','Data Proposal (Pantau)')
@section('sidebar-menu') @include('manager._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
        <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-xs text-slate-600">Halaman ini bersifat <strong>read-only</strong>. Approval proposal dikelola oleh HRD.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, judul, nama..."
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="disetujui" {{ request('status')==='disetujui'?'selected':'' }}>Disetujui</option>
                <option value="ditolak" {{ request('status')==='ditolak'?'selected':'' }}>Ditolak</option>
                <option value="diajukan" {{ request('status')==='diajukan'?'selected':'' }}>Diajukan</option>
                <option value="diteruskan_manager" {{ request('status')==='diteruskan_manager'?'selected':'' }}>Proses HRD</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold">Filter</button>
            @if(request('search')||request('status'))
            <a href="{{ route('manager.proposal.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold">Reset</a>
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
                    <th class="px-6 py-3.5"></th>
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
                    <td class="px-6 py-4 hidden md:table-cell text-xs text-slate-600">{{ $proposal->divisi_tujuan }}</td>
                    <td class="px-6 py-4"><span class="{{ $proposal->status_badge_class }}">{{ $proposal->status_label }}</span></td>
                    <td class="px-6 py-4 hidden lg:table-cell text-xs text-slate-500">{{ $proposal->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('manager.proposal.detail', $proposal->id) }}"
                           class="px-3 py-1.5 text-xs bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200">Lihat →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada proposal</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($proposals->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $proposals->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
