@extends('layouts.app')
@section('title','Periode Magang')
@section('page-title','Periode Magang')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="flex justify-end">
        <a href="{{ route('hrd.periode.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold hover:bg-blue-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Periode Baru
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Nama Periode</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Pendaftaran</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($periodes as $periode)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $periode->nama_periode }}</p>
                        <p class="text-xs text-slate-500">Kuota: {{ $periode->kuota_terisi }}/{{ $periode->kuota_total }}</p>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-xs text-slate-600">
                        {{ $periode->tanggal_mulai_pendaftaran->format('d M') }} – {{ $periode->tanggal_akhir_pendaftaran->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="{{ $periode->status==='aktif' ? 'badge-green' : ($periode->status==='draft' ? 'badge-gray' : 'badge-red') }}">{{ $periode->status_label }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('hrd.periode.edit', $periode->id) }}" class="px-3 py-1.5 text-xs bg-slate-100 text-slate-700 rounded-lg font-semibold">Edit</a>
                            <form method="POST" action="{{ route('hrd.periode.toggle-status', $periode->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 text-xs {{ $periode->status==='aktif' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded-lg font-semibold">
                                    {{ $periode->status==='aktif' ? 'Tutup' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada periode magang</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($periodes->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $periodes->links() }}</div>
        @endif
    </div>
</div>
@endsection
