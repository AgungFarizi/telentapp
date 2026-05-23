@extends('layouts.app')
@section('title','Data Mahasiswa')
@section('page-title','Data Mahasiswa Magang')
@section('sidebar-menu') @include('manager._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIM, universitas..."
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="pembimbing_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Pembimbing</option>
                @foreach($pembimbingList as $pb)
                <option value="{{ $pb->id }}" {{ request('pembimbing_id')==$pb->id?'selected':'' }}>{{ $pb->nama_lengkap }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold">Filter</button>
            @if(request('search')||request('pembimbing_id'))
            <a href="{{ route('manager.mahasiswa.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Mahasiswa</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Universitas</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Pembimbing</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Periode</th>
                    <th class="px-6 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($mahasiswa as $mhs)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $mhs->foto_profil_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $mhs->nama_lengkap }}</p>
                                <p class="text-xs text-slate-500">{{ $mhs->nim }} · Sem {{ $mhs->semester }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-xs text-slate-600">
                        {{ $mhs->universitas }}<br>{{ $mhs->jurusan }}
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell text-xs text-slate-600">
                        {{ $mhs->pembimbing?->nama_lengkap ?? '-' }}
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell text-xs text-slate-600">
                        @php $p = $mhs->proposal->first(); @endphp
                        {{ $p?->periode?->nama_periode ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('manager.mahasiswa.detail', $mhs->id) }}"
                           class="px-3 py-1.5 text-xs bg-blue-50 text-blue-700 rounded-lg font-semibold hover:bg-blue-100">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada mahasiswa</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($mahasiswa->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $mahasiswa->links() }}</div>
        @endif
    </div>
</div>
@endsection
