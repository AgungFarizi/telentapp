@extends('layouts.app')
@section('title', 'Profil Saya — TELENT')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan data diri Anda')
@section('sidebar-menu') @include('mahasiswa._sidebar') @endsection

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- ── Header Card: Avatar + Info Singkat ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center gap-5">
            {{-- Avatar --}}
            <div class="relative flex-shrink-0">
                <img src="{{ $mahasiswa->foto_profil_url }}"
                     alt="{{ $mahasiswa->nama_lengkap }}"
                     id="avatar-preview"
                     class="w-20 h-20 rounded-2xl object-cover ring-4 ring-gray-100">
                <label for="foto-input"
                       class="absolute -bottom-1.5 -right-1.5 w-7 h-7 bg-green-600 hover:bg-green-700 rounded-full flex items-center justify-center cursor-pointer transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
            </div>
            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-bold text-gray-900 truncate">{{ $mahasiswa->nama_lengkap }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $mahasiswa->email }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                        {{ $mahasiswa->getRoleLabel() }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $mahasiswa->status_akun === 'aktif' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($mahasiswa->status_akun) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Form Update Profil ── --}}
    <form action="{{ route('mahasiswa.profil.update') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Input foto tersembunyi --}}
        <input type="file" id="foto-input" name="foto_profil" accept="image/*" class="hidden"
               onchange="previewAvatar(this)">

        {{-- ── Data Diri ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Data Diri
                </h3>
            </div>
            <div class="p-6 space-y-4">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="nama_lengkap"
                           value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('nama_lengkap') border-red-400 @enderror">
                    @error('nama_lengkap')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email (readonly) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                    <input type="email"
                           value="{{ $mahasiswa->email }}"
                           disabled
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah</p>
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="no_hp"
                           value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                           required
                           placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('no_hp') border-red-400 @enderror">
                    @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── Data Akademik (readonly) ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    Data Akademik
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">Data akademik dikelola oleh HRD</p>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">NIM</label>
                    <div class="px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-500">
                        {{ $mahasiswa->nim ?? '—' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Semester</label>
                    <div class="px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-500">
                        {{ $mahasiswa->semester ? 'Semester ' . $mahasiswa->semester : '—' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Universitas</label>
                    <div class="px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-500">
                        {{ $mahasiswa->universitas ?? '—' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Jurusan</label>
                    <div class="px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-500">
                        {{ $mahasiswa->jurusan ?? '—' }}
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Ganti Password ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
             x-data="{ showPass: false }">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Ganti Password
                </h3>
                <button type="button" @click="showPass = !showPass"
                        class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg font-medium transition-colors">
                    <span x-text="showPass ? 'Tutup' : 'Ubah Password'"></span>
                </button>
            </div>
            <div x-show="showPass" x-cloak class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru</label>
                    <input type="password"
                           name="password"
                           placeholder="Kosongkan jika tidak ingin mengubah"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('password') border-red-400 @enderror">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password"
                           name="password_confirmation"
                           placeholder="Ulangi password baru"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                </div>
            </div>
        </div>

        {{-- ── Tombol Simpan ── --}}
        <div class="flex items-center justify-end gap-3 pt-1">
            <a href="{{ route('mahasiswa.dashboard') }}"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush