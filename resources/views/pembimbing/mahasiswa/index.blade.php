@extends('layouts.app')

@section('title','Mahasiswa Bimbingan')
@section('page-title','Mahasiswa Bimbingan')

@section('sidebar-menu')
    @include('pembimbing._sidebar')
@endsection

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Daftar Mahasiswa Bimbingan
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Total {{ $mahasiswa->count() }} mahasiswa
            </p>
        </div>
    </div>

    @forelse($mahasiswa as $mhs)

        <div class="border border-slate-200 rounded-xl p-4 mb-4">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-4">

                    {{-- Foto Profil --}}
                    <img
                        src="{{ $mhs->foto_profil
                            ? asset('storage/' . $mhs->foto_profil)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($mhs->nama_lengkap) }}"
                        class="w-14 h-14 rounded-full object-cover border"
                    >

                    {{-- Data Mahasiswa --}}
                    <div>

                        <h3 class="font-semibold text-slate-800 text-lg">
                            {{ $mhs->nama_lengkap }}
                        </h3>

                        <p class="text-sm text-slate-500">
                            {{ $mhs->nim }}
                        </p>

                        <p class="text-sm text-slate-500">
                            {{ $mhs->universitas }}
                        </p>

                        @if($mhs->proposal)
                            <div class="mt-2">

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Proposal Disetujui
                                </span>

                            </div>
                        @endif

                    </div>
                </div>

                {{-- Tombol Detail --}}
                <div>

                    <a href="{{ route('pembimbing.mahasiswa.detail', $mhs->id) }}"
                       class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">

                        Detail

                    </a>

                </div>

            </div>

        </div>

    @empty

        <div class="text-center py-16">

            <div class="text-slate-400 text-lg">
                Belum ada mahasiswa bimbingan
            </div>

        </div>

    @endforelse

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $mahasiswa->links() }}
    </div>

</div>

@endsection