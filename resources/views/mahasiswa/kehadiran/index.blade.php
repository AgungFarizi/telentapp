@extends('layouts.app')

@section('title', 'Absensi')
@section('page-title', 'Absensi Magang')

@section('sidebar-menu')
    @include('mahasiswa._sidebar')
@endsection

@section('content')
<div class="space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Info Proposal --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Proposal Aktif</p>
                <h3 class="text-lg font-semibold text-slate-800">
                    {{ $proposal->judul_proposal }}
                </h3>
                <p class="text-sm text-slate-600 mt-1">
                    Divisi: {{ $proposal->divisi_tujuan }}
                </p>
            </div>

            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                {{ ucfirst($proposal->status) }}
            </span>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 mb-1">Hadir</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $stats['hadir'] }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 mb-1">Terlambat</p>
            <p class="text-2xl font-bold text-yellow-600">
                {{ $stats['terlambat'] }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 mb-1">Izin/Sakit</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $stats['izin'] }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 mb-1">Tidak Hadir</p>
            <p class="text-2xl font-bold text-red-600">
                {{ $stats['tidak_hadir'] }}
            </p>
        </div>

    </div>

    {{-- Absensi Hari Ini --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Absensi Hari Ini ({{ now()->format('d M Y') }})
        </h3>

        @if(!$sudahAbsenHariIni)

            {{-- Form Absen Masuk --}}
            <form id="formAbsenMasuk" enctype="multipart/form-data">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Foto Selfie (Opsional)
                        </label>

                        <input
                            type="file"
                            name="foto_masuk"
                            accept="image/*"
                            capture="user"
                            class="w-full text-sm border border-slate-200 rounded-lg p-2"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Keterangan
                        </label>

                        <input
                            type="text"
                            name="keterangan"
                            placeholder="Opsional"
                            class="w-full text-sm border border-slate-200 rounded-lg p-2"
                        >
                    </div>

                </div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <button
                    type="submit"
                    class="mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium"
                >
                    Absen Masuk
                </button>
            </form>

        @else

            {{-- Info Kehadiran --}}
            <div class="grid md:grid-cols-3 gap-4 text-sm">

                <div>
                    <p class="text-slate-500">Jam Masuk</p>
                    <p class="font-semibold text-slate-800">
                        {{ $sudahAbsenHariIni->jam_masuk ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-500">Jam Keluar</p>
                    <p class="font-semibold text-slate-800">
                        {{ $sudahAbsenHariIni->jam_keluar ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-500">Status</p>
                    <p class="font-semibold text-slate-800">
                        {{ $sudahAbsenHariIni->status_label }}
                    </p>
                </div>

            </div>

            {{-- Tombol Absen Keluar --}}
            @if($sudahAbsenHariIni->jam_masuk && !$sudahAbsenHariIni->jam_keluar)

                <form id="formAbsenKeluar" enctype="multipart/form-data" class="mt-4">
                    @csrf

                    <input type="hidden" name="latitude" id="latitude_keluar">
                    <input type="hidden" name="longitude" id="longitude_keluar">

                    <button
                        type="submit"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium"
                    >
                        Absen Keluar
                    </button>
                </form>

            @endif

        @endif

    </div>

    {{-- Riwayat Kehadiran --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Riwayat Kehadiran
        </h3>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left p-3">Tanggal</th>
                        <th class="text-left p-3">Jam Masuk</th>
                        <th class="text-left p-3">Jam Keluar</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-left p-3">Verifikasi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kehadiran as $k)

                        <tr class="border-t border-slate-100">

                            <td class="p-3">
                                {{ $k->tanggal->format('d M Y') }}
                            </td>

                            <td class="p-3">
                                {{ $k->jam_masuk ?? '-' }}
                            </td>

                            <td class="p-3">
                                {{ $k->jam_keluar ?? '-' }}
                            </td>

                            <td class="p-3">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($k->status === 'hadir')
                                        bg-green-100 text-green-700
                                    @elseif($k->status === 'terlambat')
                                        bg-yellow-100 text-yellow-700
                                    @elseif(in_array($k->status, ['izin', 'sakit']))
                                        bg-blue-100 text-blue-700
                                    @else
                                        bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ $k->status_label }}
                                </span>
                            </td>

                            <td class="p-3 capitalize">
                                {{ $k->status_verifikasi }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400">
                                Belum ada data kehadiran
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $kehadiran->links() }}
        </div>

    </div>

</div>

@push('scripts')
<script>

    // Ambil lokasi GPS
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {

            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            if (document.getElementById('latitude')) {
                document.getElementById('latitude').value = lat;
            }

            if (document.getElementById('longitude')) {
                document.getElementById('longitude').value = lng;
            }

            if (document.getElementById('latitude_keluar')) {
                document.getElementById('latitude_keluar').value = lat;
            }

            if (document.getElementById('longitude_keluar')) {
                document.getElementById('longitude_keluar').value = lng;
            }

        });
    }

    // Absen Masuk
    const formMasuk = document.getElementById('formAbsenMasuk');

    if (formMasuk) {

        formMasuk.addEventListener('submit', async function(e) {

            e.preventDefault();

            const formData = new FormData(this);

            const res = await fetch("{{ route('mahasiswa.kehadiran.masuk') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();

            alert(data.message || data.error);

            if (data.success) {
                location.reload();
            }

        });

    }

    // Absen Keluar
    const formKeluar = document.getElementById('formAbsenKeluar');

    if (formKeluar) {

        formKeluar.addEventListener('submit', async function(e) {

            e.preventDefault();

            const formData = new FormData(this);

            const res = await fetch("{{ route('mahasiswa.kehadiran.keluar') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();

            alert(data.message || data.error);

            if (data.success) {
                location.reload();
            }

        });

    }

</script>
@endpush

@endsection