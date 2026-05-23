@extends('layouts.app')
@section('title','Token Registrasi')
@section('page-title','Token Registrasi Admin')
@section('sidebar-menu') @include('hrd._sidebar') @endsection
@section('content')
<div class="space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
        <h3 class="font-bold text-slate-800 mb-4">Generate Token Baru</h3>
        <form method="POST" action="{{ route('hrd.token.generate') }}" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <select name="role_target" required class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Role</option>
                <option value="hrd">HRD</option>
                <option value="manager">Manager</option>
                <option value="pembimbing_lapang">Pembimbing Lapang</option>
            </select>
            <input type="text" name="keterangan" placeholder="Keterangan (opsional)" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="jam_expired" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="24">24 jam</option>
                <option value="72" selected>72 jam</option>
                <option value="168">7 hari</option>
                <option value="720">30 hari</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-xl text-sm font-semibold flex-shrink-0">Generate Token</button>
        </form>
    </div>
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-2xl p-4">
        <p class="text-sm font-semibold text-green-800 mb-2">✅ Token berhasil dibuat!</p>
        <p class="font-mono text-base font-bold text-green-900 bg-white border border-green-300 rounded-xl px-4 py-3 break-all">
            {{ explode(': ', session('success'))[1] ?? session('success') }}
        </p>
        <p class="text-xs text-green-600 mt-2">Bagikan token ini ke calon admin. Token hanya bisa dipakai sekali.</p>
    </div>
    @endif
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-bold text-slate-800">Riwayat Token</h3></div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Token</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Role</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Keterangan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($tokens as $token)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-3.5"><span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded-lg tracking-widest">{{ $token->token }}</span></td>
                    <td class="px-6 py-3.5"><span class="{{ $token->role_target==='hrd'?'badge-blue':($token->role_target==='manager'?'badge-purple':'badge-green') }}">{{ $token->role_label }}</span></td>
                    <td class="px-6 py-3.5 hidden md:table-cell text-xs text-slate-500">{{ $token->keterangan ?? '-' }}</td>
                    <td class="px-6 py-3.5">
                        @if($token->sudah_dipakai) <span class="badge-gray">Terpakai</span>
                        @elseif($token->expired_at && $token->expired_at->isPast()) <span class="badge-red">Expired</span>
                        @else <span class="badge-green">Aktif</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">Belum ada token</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($tokens->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $tokens->links() }}</div>
        @endif
    </div>
</div>
@endsection
