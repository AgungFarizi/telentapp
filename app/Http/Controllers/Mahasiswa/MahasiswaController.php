<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaProposal;
use App\Models\Kehadiran;
use App\Models\LogHarian;
use App\Models\Notifikasi;
use App\Models\PeriodeMagang;
use App\Models\Proposal;
use App\Models\SuratBalasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    // ============================================================
    // DASHBOARD
    // ============================================================
    public function dashboard()
    {
        $mahasiswa = auth()->user();

        $proposalAktif = Proposal::where('pengaju_id', $mahasiswa->id)
            ->orWhereHas('anggota', fn($q) => $q->where('mahasiswa_id', $mahasiswa->id))
            ->with(['periode', 'pembimbing'])
            ->latest()
            ->first();

        $kehadiranBulanIni = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $totalHadir = $kehadiranBulanIni->where('status', 'hadir')->count();
        $totalTidakHadir = $kehadiranBulanIni->where('status', 'tidak_hadir')->count();
        $totalIzin = $kehadiranBulanIni->whereIn('status', ['izin', 'sakit'])->count();

        $logPending = LogHarian::where('mahasiswa_id', $mahasiswa->id)
            ->where('status_verifikasi', 'menunggu')
            ->count();

        $notifikasi = $mahasiswa->notifikasiBelumDibaca()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $sudahAbsenHariIni = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        return view('mahasiswa.dashboard', compact(
            'mahasiswa', 'proposalAktif', 'totalHadir', 'totalTidakHadir',
            'totalIzin', 'logPending', 'notifikasi', 'sudahAbsenHariIni'
        ));
    }

    // ============================================================
    // PROPOSAL
    // ============================================================
    public function proposalIndex()
    {
        $mahasiswa = auth()->user();

        $proposals = Proposal::where('pengaju_id', $mahasiswa->id)
            ->with(['periode', 'anggota'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $sudahPunyaProposal = Proposal::where('pengaju_id', $mahasiswa->id)
            ->exists();

        return view('mahasiswa.proposal.index', compact(
            'proposals',
            'sudahPunyaProposal'
        ));
    }

    public function proposalCreate()
    {
        $periodeAktif = PeriodeMagang::aktif()
            ->where('tanggal_mulai_pendaftaran', '<=', today())
            ->where('tanggal_akhir_pendaftaran', '>=', today())
            ->get();

        if ($periodeAktif->isEmpty()) {
            return redirect()->route('mahasiswa.proposal.index')
                ->with('info', 'Tidak ada periode pendaftaran magang yang aktif saat ini.');
        }

        // Cek apakah mahasiswa sudah punya proposal aktif
        $hasActiveProposal = Proposal::where('pengaju_id', auth()->id())
            ->whereNotIn('status', ['ditolak'])
            ->exists();

        if ($hasActiveProposal) {
            return redirect()->route('mahasiswa.proposal.index')
                ->with('info', 'Anda sudah memiliki proposal yang sedang diproses.');
        }

        return view('mahasiswa.proposal.create', compact('periodeAktif'));
    }

    public function proposalStore(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_magang,id',
            'judul_proposal' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string|min:50',
            'divisi_tujuan' => 'required|string|max:100',
            'file_proposal_pdf' => 'required|file|mimes:pdf|max:5120',
            'file_surat_pengantar' => 'nullable|file|mimes:pdf|max:5120',
            'tanggal_mulai_diinginkan' => 'required|date|after:today',
            'tanggal_akhir_diinginkan' => 'required|date|after:tanggal_mulai_diinginkan',
            // Anggota kelompok
            'anggota' => 'nullable|array|max:9',
            'anggota.*.nama_lengkap' => 'required_with:anggota|string|max:255',
            'anggota.*.nim' => 'required_with:anggota|string|max:20',
            'anggota.*.universitas' => 'required_with:anggota|string|max:255',
            'anggota.*.jurusan' => 'required_with:anggota|string|max:255',
            'anggota.*.semester' => 'required_with:anggota|string|max:5',
            'anggota.*.email' => 'required_with:anggota|email',
            'anggota.*.no_hp' => 'nullable|string|max:20',
        ]);

        // Upload file
        $pathProposal = $request->file('file_proposal_pdf')->store('proposals/pdf', 'public');
        $pathSurat = null;
        if ($request->hasFile('file_surat_pengantar')) {
            $pathSurat = $request->file('file_surat_pengantar')->store('proposals/surat', 'public');
        }

        $mahasiswa = auth()->user();
        $jumlahAnggota = 1 + count($validated['anggota'] ?? []);

        $proposal = Proposal::create([
            'pengaju_id' => $mahasiswa->id,
            'periode_id' => $validated['periode_id'],
            'judul_proposal' => $validated['judul_proposal'],
            'deskripsi_kegiatan' => $validated['deskripsi_kegiatan'],
            'divisi_tujuan' => $validated['divisi_tujuan'],
            'file_proposal_pdf' => $pathProposal,
            'file_surat_pengantar' => $pathSurat,
            'tanggal_mulai_diinginkan' => $validated['tanggal_mulai_diinginkan'],
            'tanggal_akhir_diinginkan' => $validated['tanggal_akhir_diinginkan'],
            'jumlah_anggota' => $jumlahAnggota,
            'status' => 'diajukan',
        ]);

        // Tambah pengaju sebagai ketua
        AnggotaProposal::create([
            'proposal_id' => $proposal->id,
            'mahasiswa_id' => $mahasiswa->id,
            'nama_lengkap' => $mahasiswa->nama_lengkap,
            'nim' => $mahasiswa->nim,
            'universitas' => $mahasiswa->universitas,
            'jurusan' => $mahasiswa->jurusan,
            'semester' => $mahasiswa->semester,
            'no_hp' => $mahasiswa->no_hp,
            'email' => $mahasiswa->email,
            'adalah_ketua' => true,
            'status_akun' => 'aktif',
        ]);

        // Tambah anggota lain
        foreach ($validated['anggota'] ?? [] as $anggotaData) {
            AnggotaProposal::create([
                'proposal_id' => $proposal->id,
                'nama_lengkap' => $anggotaData['nama_lengkap'],
                'nim' => $anggotaData['nim'],
                'universitas' => $anggotaData['universitas'],
                'jurusan' => $anggotaData['jurusan'],
                'semester' => $anggotaData['semester'],
                'email' => $anggotaData['email'],
                'no_hp' => $anggotaData['no_hp'] ?? null,
                'adalah_ketua' => false,
                'status_akun' => 'menunggu',
            ]);
        }

        // Notifikasi HRD
        \App\Models\Pengguna::hrd()->aktif()->each(function ($hrd) use ($proposal, $mahasiswa) {
            Notifikasi::kirim(
                $hrd->id,
                'Proposal Baru Masuk',
                "Proposal baru dari {$mahasiswa->nama_lengkap} ({$mahasiswa->nim}) telah diajukan.",
                'proposal_diajukan',
                route('hrd.proposal.detail', $proposal->id),
                $proposal
            );
        });

        return redirect()->route('mahasiswa.proposal.detail', $proposal->id)
            ->with('success', 'Proposal berhasil diajukan! Silakan tunggu review dari HRD.');
    }

    public function proposalDetail(Proposal $proposal)
    {
        $this->authorizeProposal($proposal);
        $proposal->load(['periode', 'anggota', 'reviewerHRD', 'approver', 'pembimbing', 'suratBalasan']);

        return view('mahasiswa.proposal.detail', compact('proposal'));
    }

    // ============================================================
    // KEHADIRAN / ABSENSI
    // ============================================================
    public function kehadiranIndex()
    {
        $mahasiswa = auth()->user();
        $proposal = $this->getProposalAktif($mahasiswa->id);

        if (!$proposal) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda belum memiliki proposal yang disetujui.');
        }

        $kehadiran = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        $stats = [
            'hadir' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->where('status', 'hadir')->count(),
            'terlambat' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->where('status', 'terlambat')->count(),
            'izin' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->whereIn('status', ['izin', 'sakit'])->count(),
            'tidak_hadir' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->where('status', 'tidak_hadir')->count(),
        ];

        $sudahAbsenHariIni = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->first();

        return view('mahasiswa.kehadiran.index', compact('kehadiran', 'stats', 'proposal', 'sudahAbsenHariIni'));
    }

    public function absenMasuk(Request $request)
    {
        $mahasiswa = auth()->user();
        $proposal = $this->getProposalAktif($mahasiswa->id);

        if (!$proposal) {
            return response()->json(['error' => 'Tidak ada proposal aktif.'], 403);
        }

        // Cek sudah absen hari ini
        $existing = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($existing && $existing->jam_masuk) {
            return response()->json(['error' => 'Anda sudah melakukan absen masuk hari ini.'], 422);
        }

        $validated = $request->validate([
            'foto_masuk' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_masuk')) {
            $fotoPath = $request->file('foto_masuk')->store('kehadiran/foto', 'public');
        }

        $jamMasuk = now()->format('H:i:s');
        // Batas hadir tepat waktu jam 08:00
        $batasMasuk = '08:00:00';
        $status = now()->format('H:i:s') > $batasMasuk
            ? 'terlambat'
             : 'hadir'; 
    
        $kehadiran = Kehadiran::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'tanggal' => today()],
            [
                'proposal_id' => $proposal->id,
                'jam_masuk' => $jamMasuk,
                'foto_masuk' => $fotoPath,
                'latitude_masuk' => $validated['latitude'] ?? null,
                'longitude_masuk' => $validated['longitude'] ?? null,
                'status' => $status,
                'status_verifikasi' => 'menunggu',
                'keterangan' => $validated['keterangan'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Absen masuk berhasil dicatat!',
            'jam_masuk' => $jamMasuk,
            'status' => $status,
        ]);
    }

    public function absenKeluar(Request $request)
    {
        $mahasiswa = auth()->user();

        $kehadiran = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->whereNotNull('jam_masuk')
            ->whereNull('jam_keluar')
            ->first();

        if (!$kehadiran) {
            return response()->json([
                'error' => 'Belum melakukan absen masuk atau sudah absen keluar.'
            ], 422);
        }

        // Minimal pulang jam 17:00
        if (now()->format('H:i:s') < '17:00:00') {
            return response()->json([
                'error' => 'Absen keluar hanya bisa setelah jam 17:00 WIB.'
            ], 422);
        }

        $validated = $request->validate([
            'foto_keluar' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto_keluar')) {
            $fotoPath = $request->file('foto_keluar')
                ->store('kehadiran/foto', 'public');
        }

        $kehadiran->update([
            'jam_keluar' => now()->format('H:i:s'),
            'foto_keluar' => $fotoPath,
            'latitude_keluar' => $validated['latitude'] ?? null,
            'longitude_keluar' => $validated['longitude'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen keluar berhasil dicatat!',
            'jam_keluar' => now()->format('H:i'),
            'durasi' => $kehadiran->fresh()->durasi,
        ]);
    }

    public function izinStore(Request $request)
    {
        $mahasiswa = auth()->user();
        $proposal = $this->getProposalAktif($mahasiswa->id);

        if (!$proposal) {
            return back()->with('error', 'Tidak ada proposal aktif.');
        }

        $validated = $request->validate([
            'jenis_izin' => 'required|in:izin,sakit',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $filePath = $request->file('file_surat')->store('kehadiran/izin', 'public');
        }

        Kehadiran::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'tanggal' => $validated['tanggal']],
            [
                'proposal_id' => $proposal->id,
                'status' => $validated['jenis_izin'],
                'status_verifikasi' => 'menunggu',
                'keterangan' => $validated['keterangan'],
                'foto_masuk' => $filePath,
            ]
        );

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    // ============================================================
    // LOG HARIAN
    // ============================================================
    public function logHarianIndex()
    {
        $mahasiswa = auth()->user();
        $proposal = $this->getProposalAktif($mahasiswa->id);

        if (!$proposal) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda belum memiliki proposal yang disetujui.');
        }

        $logs = LogHarian::where('mahasiswa_id', $mahasiswa->id)
            ->with('kehadiran')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        $sudahIsiHariIni = LogHarian::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        return view('mahasiswa.log-harian.index', compact('logs', 'proposal', 'sudahIsiHariIni'));
    }

    public function logHarianCreate()
    {
        $mahasiswa = auth()->user();
        $proposal = $this->getProposalAktif($mahasiswa->id);

        if (!$proposal) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Tidak ada proposal aktif.');
        }

        $kehadiranHariIni = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->first();

        $sudahIsiHariIni = LogHarian::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahIsiHariIni) {
            return redirect()->route('mahasiswa.log-harian.index')
                ->with('info', 'Anda sudah mengisi log harian hari ini.');
        }

        return view('mahasiswa.log-harian.create', compact('proposal', 'kehadiranHariIni'));
    }

    public function logHarianStore(Request $request)
    {
        $mahasiswa = auth()->user();

        $proposal = $this->getProposalAktif($mahasiswa->id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'file_dokumentasi' => 'required|file|mimes:pdf|max:5120',
        ]);

        // Upload PDF
        $filePath = $request->file('file_dokumentasi')
            ->store('log-harian', 'public');

        // Cari kehadiran sesuai tanggal
        $kehadiran = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', $validated['tanggal'])
            ->first();

        // Simpan log harian
        LogHarian::create([
            'mahasiswa_id' => $mahasiswa->id,
            'proposal_id' => $proposal->id,
            'kehadiran_id' => $kehadiran?->id,
            'tanggal' => $validated['tanggal'],

            // wajib diisi karena kolom tidak nullable
            'kegiatan_dilakukan' => 'Upload log harian PDF',

            'file_dokumentasi' => $filePath,
            'status_verifikasi' => 'menunggu',
        ]);

        // Notifikasi pembimbing
        if ($mahasiswa->pembimbing_id) {

            Notifikasi::kirim(
                $mahasiswa->pembimbing_id,
                'Log Harian Baru',
                "{$mahasiswa->nama_lengkap} telah mengupload log harian.",
                'log_diverifikasi',
                route('pembimbing.log-harian.index')
            );
        }

        return redirect()
            ->route('mahasiswa.log-harian.index')
            ->with('success', 'Log harian berhasil diupload.');
    }

    public function logHarianEdit(LogHarian $log)
    {
        abort_if($log->mahasiswa_id !== auth()->id(), 403);
        abort_if($log->status_verifikasi === 'disetujui', 403, 'Log yang sudah disetujui tidak dapat diedit.');

        $proposal = $this->getProposalAktif(auth()->id());
        return view('mahasiswa.log-harian.edit', compact('log', 'proposal'));
    }

   public function logHarianUpdate(Request $request, LogHarian $log)
    {
        $request->validate([
            'file_dokumentasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Hapus file lama
        if ($log->file_dokumentasi && Storage::disk('public')->exists($log->file_dokumentasi)) {
            Storage::disk('public')->delete($log->file_dokumentasi);
        }

        // Upload file baru
        $filePath = $request->file('file_dokumentasi')
            ->store('log-harian/dokumentasi', 'public');

        // Update database
        $log->update([
            'file_dokumentasi' => $filePath,
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()
            ->route('mahasiswa.log-harian.index')
            ->with('success', 'File dokumentasi berhasil diperbarui.');
    }

    // ============================================================
    // SURAT BALASAN
    // ============================================================
    public function suratBalasanIndex()
    {
        $mahasiswa = auth()->user();

        // Ambil proposal mahasiswa
        $proposal = Proposal::where(function ($q) use ($mahasiswa) {

            $q->where('pengaju_id', $mahasiswa->id)
            ->orWhereHas('anggota', function ($q) use ($mahasiswa) {
                $q->where('mahasiswa_id', $mahasiswa->id);
            });

        })
        ->with('suratBalasan')
        ->latest()
        ->first();

        // Tandai semua surat sudah dibaca
        if ($proposal && $proposal->suratBalasan->count()) {

            foreach ($proposal->suratBalasan as $surat) {
                $surat->update([
                    'sudah_dibaca' => true
                ]);
            }
        }

        return view('mahasiswa.surat-balasan.index', compact('proposal'));
    }

    public function suratBalasanDetail(SuratBalasan $surat)
    {
    $proposal = $surat->proposal;

    $this->authorizeProposal($proposal);

    return view('mahasiswa.surat-balasan.detail', compact('surat'));
}

    // ============================================================
    // NOTIFIKASI
    // ============================================================
    public function notifikasiIndex()
    {
        $notifikasi = auth()->user()->notifikasi()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Tandai semua dibaca
        auth()->user()->notifikasiBelumDibaca()->update([
            'sudah_dibaca' => true,
            'dibaca_pada' => now(),
        ]);

        return view('mahasiswa.notifikasi.index', compact('notifikasi'));
    }

    // ============================================================
    // PROFIL
    // ============================================================
    public function profil()
    {
        return view('mahasiswa.profil', ['mahasiswa' => auth()->user()]);
    }

    // Ganti method profilUpdate() di MahasiswaController dengan ini:

    public function profilUpdate(Request $request)
    {
        $mahasiswa = auth()->user();

        $validated = $request->validate([
            'nama_lengkap'          => 'required|string|max:255',
            'no_hp'                 => 'required|string|max:20',
            'foto_profil'           => 'nullable|image|max:2048',
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        // Upload foto baru jika ada
        if ($request->hasFile('foto_profil')) {
            if ($mahasiswa->foto_profil) {
                Storage::disk('public')->delete($mahasiswa->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')
                ->store('profil/foto', 'public');
        } else {
            unset($validated['foto_profil']);
        }

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $mahasiswa->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ============================================================
    // HELPERS
    // ============================================================
    private function getProposalAktif(int $mahasiswaId): ?Proposal
    {
        return Proposal::where(function ($q) use ($mahasiswaId) {
            $q->where('pengaju_id', $mahasiswaId)
                ->orWhereHas('anggota', fn($q) => $q->where('mahasiswa_id', $mahasiswaId));
        })->where('status', 'disetujui')->latest()->first();
    }

    private function authorizeProposal(Proposal $proposal): void
    {
        $mahasiswaId = auth()->id();
        $isKetua = $proposal->pengaju_id === $mahasiswaId;
        $isAnggota = $proposal->anggota()->where('mahasiswa_id', $mahasiswaId)->exists();

        abort_if(!$isKetua && !$isAnggota, 403);
    }
}
