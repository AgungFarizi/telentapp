@php
    $route = request()->route()->getName();

    $proposalAktif = \App\Models\Proposal::where(function ($q) {
        $q->where('pengaju_id', auth()->id())
          ->orWhereHas('anggota', function ($q) {
              $q->where('mahasiswa_id', auth()->id());
          });
    })
    ->where('status', 'disetujui')
    ->exists();
@endphp

<a href="{{ route('mahasiswa.dashboard') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ $route==='mahasiswa.dashboard'?'active':'' }}">
    <span>Dashboard</span>
</a>

<div class="px-3 pt-4 pb-1">
    <p class="text-xs font-semibold text-slate-500 uppercase">Magang Saya</p>
</div>

<a href="{{ route('mahasiswa.proposal.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route,'mahasiswa.proposal')?'active':'' }}">
    <span>Proposal Saya</span>
</a>

{{-- MUNCUL JIKA SUDAH DITERIMA --}}
@if($proposalAktif)

<a href="{{ route('mahasiswa.kehadiran.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route,'mahasiswa.kehadiran')?'active':'' }}">
    <span>Absensi</span>
</a>

<a href="{{ route('mahasiswa.log-harian.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route,'mahasiswa.log-harian')?'active':'' }}">
    <span>Log Harian</span>
</a>

@endif

<a href="{{ route('mahasiswa.surat-balasan.index') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ str_starts_with($route,'mahasiswa.surat-balasan')?'active':'' }}">
    <span>Surat Balasan</span>
</a>

<div class="px-3 pt-4 pb-1">
    <p class="text-xs font-semibold text-slate-500 uppercase">Akun</p>
</div>

<a href="{{ route('mahasiswa.profil') }}"
   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700 transition-all text-sm {{ $route==='mahasiswa.profil'?'active':'' }}">
    <span>Profil Saya</span>
</a>