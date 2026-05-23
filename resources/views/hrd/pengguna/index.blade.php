@extends('layouts.app')
@section('title','Kelola Admin')
@section('page-title','Kelola Pengguna Admin')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-4">
    {{-- Info banner --}}
    <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-semibold text-blue-800">Cara menambah pengguna admin:</p>
            <p class="text-sm text-blue-700 mt-0.5">Generate <strong>Token Registrasi</strong> lalu berikan ke calon Admin. Mereka daftar sendiri di halaman <code class="bg-blue-100 px-1 rounded">/daftar-admin</code> menggunakan token tersebut.</p>
        </div>
        <a href="{{ route('hrd.token.index') }}"
           class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 text-white rounded-xl text-xs font-semibold hover:bg-blue-800 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            Generate Token
        </a>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="role" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Role</option>
                <option value="hrd" {{ request('role')==='hrd'?'selected':'' }}>HRD</option>
                <option value="manager" {{ request('role')==='manager'?'selected':'' }}>Manager</option>
                <option value="pembimbing_lapang" {{ request('role')==='pembimbing_lapang'?'selected':'' }}>Pembimbing Lapang</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-700 text-white rounded-xl text-sm font-semibold hover:bg-slate-800">Filter</button>
            @if(request('search') || request('role'))
            <a href="{{ route('hrd.pengguna.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200">Reset</a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Pengguna</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Role</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Departemen</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pengguna as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $p->foto_profil_url }}" class="w-9 h-9 rounded-full object-cover" alt="">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $p->nama_lengkap }}</p>
                                <p class="text-xs text-slate-500">{{ $p->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="{{ $p->role==='hrd'?'badge-blue':($p->role==='manager'?'badge-purple':'badge-green') }}">
                            {{ $p->getRoleLabel() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell text-slate-600 text-xs">{{ $p->divisi ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="{{ $p->status_akun==='aktif'?'badge-green':'badge-red' }}">
                            {{ ucfirst(str_replace('_', ' ', $p->status_akun)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('hrd.pengguna.edit', $p->id) }}"
                               class="px-3 py-1.5 text-xs bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200 transition-colors">
                                Edit
                            </a>
                            @if($p->id !== auth()->id())
                            <form method="POST" action="{{ route('hrd.pengguna.toggle-status', $p->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1.5 text-xs {{ $p->status_akun==='aktif'?'bg-amber-100 text-amber-700 hover:bg-amber-200':'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-lg font-semibold transition-colors">
                                    {{ $p->status_akun==='aktif'?'Nonaktifkan':'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('hrd.pengguna.delete', $p->id) }}"
                                  onsubmit="return confirm('Yakin hapus akun {{ $p->nama_lengkap }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 text-xs bg-red-100 text-red-700 hover:bg-red-200 rounded-lg font-semibold transition-colors">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <p class="text-slate-400 text-sm">Belum ada pengguna admin</p>
                        <a href="{{ route('hrd.token.index') }}" class="mt-3 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Generate token untuk mengundang admin →
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($pengguna->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $pengguna->links() }}</div>
        @endif
    </div>
</div>
@endsection
