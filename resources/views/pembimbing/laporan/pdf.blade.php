<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Magang</title>

    <style>
        body{
            font-family: sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header{
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header table{
            border: none;
            margin-top: 0;
        }

        .header td{
            border: none;
            vertical-align: middle;
        }

        .title{
            text-align: center;
        }

        .title h2{
            margin: 0;
            font-size: 22px;
        }

        .title p{
            margin: 4px 0;
            font-size: 13px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:10px;
        }

        table, th, td{
            border:1px solid #000;
        }

        th{
            background: #f3f4f6;
        }

        th, td{
            padding:6px;
            text-align:left;
        }

        h3{
            margin-top: 25px;
            margin-bottom: 8px;
        }

        .info-table td:first-child{
            font-weight: bold;
            width: 30%;
        }

        .footer{
            margin-top: 50px;
            width: 100%;
        }

        .signature{
            width: 250px;
            float: right;
            text-align: center;
        }

        .signature-space{
            height: 70px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">

        <table width="100%">
            <tr>

                <td width="20%">
                    <img src="{{ public_path('images/logo-telentapp.png') }}"
                         width="90">
                </td>

                <td width="80%" class="title">
                    <h2>TELENT Internship System</h2>

                    <p>
                        Laporan Kehadiran & Log Harian Mahasiswa Magang
                    </p>

                    <p>
                        PT Tanjungenim Lestari
                    </p>
                </td>

            </tr>
        </table>

    </div>

    {{-- DATA MAHASISWA --}}
    <h3>Data Mahasiswa</h3>

    <table class="info-table">
        <tr>
            <td>Nama</td>
            <td>{{ $mahasiswa->nama_lengkap }}</td>
        </tr>

        <tr>
            <td>NIM</td>
            <td>{{ $mahasiswa->nim }}</td>
        </tr>

        <tr>
            <td>Universitas</td>
            <td>{{ $mahasiswa->universitas }}</td>
        </tr>

        <tr>
            <td>Jurusan</td>
            <td>{{ $mahasiswa->jurusan }}</td>
        </tr>
    </table>

    {{-- DATA PROPOSAL --}}
    <h3>Data Proposal</h3>

    <table class="info-table">
        <tr>
            <td>Judul Proposal</td>
            <td>{{ $proposal->judul_proposal ?? '-' }}</td>
        </tr>

        <tr>
            <td>Divisi</td>
            <td>{{ $proposal->divisi_tujuan ?? '-' }}</td>
        </tr>

        <tr>
            <td>Status</td>
            <td>{{ ucfirst($proposal->status ?? '-') }}</td>
        </tr>
    </table>

    {{-- REKAP KEHADIRAN --}}
    <h3>Rekap Kehadiran</h3>

    <table>
        <tr>
            <th>Hadir</th>
            <th>Terlambat</th>
            <th>Izin/Sakit</th>
            <th>Tidak Hadir</th>
        </tr>

        <tr>
            <td>{{ $rekap['hadir'] }}</td>
            <td>{{ $rekap['terlambat'] }}</td>
            <td>{{ $rekap['izin'] }}</td>
            <td>{{ $rekap['tidak_hadir'] }}</td>
        </tr>
    </table>

    {{-- RIWAYAT KEHADIRAN --}}
    <h3>Riwayat Kehadiran</h3>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($kehadiran as $item)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                </td>

                <td>{{ $item->jam_masuk ?? '-' }}</td>

                <td>{{ $item->jam_keluar ?? '-' }}</td>

                <td>{{ ucfirst($item->status) }}</td>
            </tr>

            @empty

            <tr>
                <td colspan="5" style="text-align:center;">
                    Tidak ada data kehadiran
                </td>
            </tr>

            @endforelse

        </tbody>
    </table>

    {{-- LOG HARIAN --}}
    <h3>Log Harian</h3>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($logs as $log)

            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                </td>

                <td>{{ $log->kegiatan_dilakukan }}</td>

                <td>{{ ucfirst($log->status_verifikasi) }}</td>
            </tr>

            @empty

            <tr>
                <td colspan="4" style="text-align:center;">
                    Tidak ada log harian
                </td>
            </tr>

            @endforelse

        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="footer">

        <div class="signature">

            <p>
                Muara Enim,
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>

            <p>
                Pembimbing Lapang
            </p>

            <div class="signature-space"></div>

            <p>
                <strong>
                    {{ auth()->user()->nama_lengkap }}
                </strong>
            </p>

        </div>

    </div>

</body>
</html>