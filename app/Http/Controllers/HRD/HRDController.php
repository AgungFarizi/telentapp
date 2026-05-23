<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\AksesTokenAdmin;
use App\Models\AnggotaProposal;
use App\Models\EmailVerification;
use App\Models\Kehadiran;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use App\Models\PeriodeMagang;
use App\Models\Proposal;
use App\Models\SuratBalasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HRDController extends Controller
{
    // ============================================================
    // DASHBOARD
    // ============================================================
    public function dashboard()
    {
        $stats = [
            'total_mahasiswa' => Pengguna::mahasiswa()->count(),
            'total_proposal_pending' => Proposal::pending()->count(),
            'total_proposal_disetujui' => Proposal::disetujui()->count(),
            'total_pembimbing' => Pengguna::rolePembimbing()->count(),
            'periode_aktif' => PeriodeMagang::aktif()->first(),
            'proposal_menunggu_review' => Proposal::whereIn('status', ['diajukan', 'review_hrd'])->count(),
            'kehadiran_menunggu' => Kehadiran::where('status_verifikasi', 'menunggu')->count(),
        ];

        $proposalTerbaru = Proposal::with(['pengaju', 'periode'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $notifikasi = auth()->user()->notifikasiBelumDibaca()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('hrd.dashboard', compact('stats', 'proposalTerbaru', 'notifikasi'));
    }

    // ============================================================
    // MANAJEMEN PERIODE MAGANG
    // ============================================================
    public function periode()
    {
        $periodes = PeriodeMagang::with('dibuatOleh')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('hrd.periode.index', compact('periodes'));
    }

    public function periodeCreate()
    {
        return view('hrd.periode.create');
    }

    public function periodeStore(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_akhir_pendaftaran' => 'required|date|after:tanggal_mulai_pendaftaran',
            'tanggal_mulai_magang' => 'required|date|after:tanggal_akhir_pendaftaran',
            'tanggal_akhir_magang' => 'required|date|after:tanggal_mulai_magang',
            'kuota_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'persyaratan' => 'nullable|string',
            'status' => 'required|in:draft,aktif',
        ]);

        $validated['dibuat_oleh'] = auth()->id();
        PeriodeMagang::create($validated);

        return redirect()->route('hrd.periode.index')
            ->with('success', 'Periode magang berhasil dibuat.');
    }

    public function periodeEdit(PeriodeMagang $periode)
    {
        return view('hrd.periode.edit', compact('periode'));
    }

    public function periodeUpdate(Request $request, PeriodeMagang $periode)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_akhir_pendaftaran' => 'required|date|after:tanggal_mulai_pendaftaran',
            'tanggal_mulai_magang' => 'required|date|after:tanggal_akhir_pendaftaran',
            'tanggal_akhir_magang' => 'required|date|after:tanggal_mulai_magang',
            'kuota_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'persyaratan' => 'nullable|string',
            'status' => 'required|in:draft,aktif,ditutup,selesai',
        ]);

        $periode->update($validated);

        return redirect()->route('hrd.periode.index')
            ->with('success', 'Periode magang berhasil diperbarui.');
    }

    public function periodeToggleStatus(PeriodeMagang $periode)
    {
        $statusBaru = $periode->status === 'aktif' ? 'ditutup' : 'aktif';
        $periode->update(['status' => $statusBaru]);

        $label = $statusBaru === 'aktif' ? 'dibuka' : 'ditutup';
        return back()->with('success', "Periode magang berhasil {$label}.");
    }

    // ============================================================
    // MANAJEMEN PROPOSAL
    // ============================================================
    public function proposal(Request $request)
    {
        $query = Proposal::with(['pengaju', 'periode'])
            ->orderBy('created_at', 'desc');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_proposal', 'like', "%{$request->search}%")
                    ->orWhere('judul_proposal', 'like', "%{$request->search}%")
                    ->orWhereHas('pengaju', fn($q) => $q->where('nama_lengkap', 'like', "%{$request->search}%"));
            });
        }

        $proposals = $query->paginate(15);

        return view('hrd.proposal.index', compact('proposals'));
    }

    public function proposalDetail(Proposal $proposal)
    {
        $proposal->load(['pengaju', 'periode', 'anggota', 'reviewerHRD', 'approver', 'pembimbing']);
        return view('hrd.proposal.detail', compact('proposal'));
    }

    public function proposalReview(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'aksi' => 'required|in:disetujui,ditolak',
            'catatan_hrd' => 'required|string',
            'pembimbing_id' => 'nullable|exists:pengguna,id',
        ]);

        if ($validated['aksi'] === 'disetujui') {
            $pembimbingId = $validated['pembimbing_id'] ?? null;

            $proposal->update([
                'status' => 'disetujui',
                'reviewer_hrd_id' => auth()->id(),
                'tanggal_review_hrd' => now(),
                'catatan_hrd' => $validated['catatan_hrd'],
                'approver_id' => auth()->id(),
                'tanggal_approval' => now(),
                'catatan_approval' => $validated['catatan_hrd'],
                'keputusan_final' => 'disetujui',
                'pembimbing_id' => $pembimbingId,
            ]);

            // Update kuota periode
            $proposal->periode->increment('kuota_terisi', $proposal->jumlah_anggota);

            // Buat akun anggota yang belum punya akun
            $this->buatAkunAnggota($proposal);

            // Set pembimbing untuk semua mahasiswa
            if ($pembimbingId) {
                Pengguna::where('id', $proposal->pengaju_id)->update(['pembimbing_id' => $pembimbingId]);
                $proposal->anggota->each(function ($anggota) use ($pembimbingId) {
                    if ($anggota->mahasiswa_id) {
                        Pengguna::where('id', $anggota->mahasiswa_id)->update(['pembimbing_id' => $pembimbingId]);
                    }
                });
            }

            // Notifikasi Manager (informasi saja, bukan untuk approve)
            Pengguna::roleManager()->aktif()->each(function ($manager) use ($proposal) {
                Notifikasi::kirim(
                    $manager->id,
                    'Proposal Magang Disetujui',
                    "Proposal {$proposal->nomor_proposal} dari {$proposal->pengaju->nama_lengkap} telah disetujui HRD.",
                    'proposal_disetujui',
                    route('manager.proposal.detail', $proposal->id),
                    $proposal
                );
            });

            // Notifikasi mahasiswa
            Notifikasi::kirim(
                $proposal->pengaju_id,
                'Proposal Disetujui! 🎉',
                "Selamat! Proposal {$proposal->nomor_proposal} Anda telah disetujui oleh HRD.",
                'proposal_disetujui',
                route('mahasiswa.proposal.detail', $proposal->id),
                $proposal
            );

            $message = 'Proposal berhasil disetujui.';
        } else {
            $proposal->update([
                'status' => 'ditolak',
                'reviewer_hrd_id' => auth()->id(),
                'tanggal_review_hrd' => now(),
                'catatan_hrd' => $validated['catatan_hrd'],
                'keputusan_final' => 'ditolak',
                'tanggal_approval' => now(),
                'approver_id' => auth()->id(),
            ]);

            Notifikasi::kirim(
                $proposal->pengaju_id,
                'Proposal Ditolak',
                "Proposal {$proposal->nomor_proposal} Anda telah ditolak oleh HRD.",
                'proposal_ditolak',
                route('mahasiswa.proposal.detail', $proposal->id),
                $proposal
            );

            $message = 'Proposal berhasil ditolak.';
        }

        return redirect()->route('hrd.proposal.index')
            ->with('success', $message);
    }

    public function proposalApprove(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'aksi' => 'required|in:disetujui,ditolak',
            'catatan_approval' => 'required|string',
            'pembimbing_id' => 'nullable|exists:pengguna,id',
        ]);

        if ($validated['aksi'] === 'disetujui') {
            $pembimbingId = $validated['pembimbing_id'] ?? null;

            $proposal->update([
                'status' => 'disetujui',
                'approver_id' => auth()->id(),
                'tanggal_approval' => now(),
                'catatan_approval' => $validated['catatan_approval'],
                'keputusan_final' => 'disetujui',
                'pembimbing_id' => $pembimbingId,
            ]);

            // Update kuota periode
            $proposal->periode->increment('kuota_terisi', $proposal->jumlah_anggota);

            // Buat akun anggota yang belum punya akun
            $this->buatAkunAnggota($proposal);

            // Update pembimbing untuk semua mahasiswa di proposal
            if ($pembimbingId) {
                $proposal->anggota->each(function ($anggota) use ($pembimbingId) {
                    if ($anggota->mahasiswa_id) {
                        Pengguna::where('id', $anggota->mahasiswa_id)
                            ->update(['pembimbing_id' => $pembimbingId]);
                    }
                });
                Pengguna::where('id', $proposal->pengaju_id)
                    ->update(['pembimbing_id' => $pembimbingId]);
            }

            // Notifikasi mahasiswa
            Notifikasi::kirim(
                $proposal->pengaju_id,
                'Proposal Disetujui! 🎉',
                "Selamat! Proposal {$proposal->nomor_proposal} Anda telah disetujui.",
                'proposal_disetujui',
                route('mahasiswa.proposal.detail', $proposal->id),
                $proposal
            );

            $message = 'Proposal berhasil disetujui.';
        } else {
            $proposal->update([
                'status' => 'ditolak',
                'approver_id' => auth()->id(),
                'tanggal_approval' => now(),
                'catatan_approval' => $validated['catatan_approval'],
                'keputusan_final' => 'ditolak',
            ]);

            Notifikasi::kirim(
                $proposal->pengaju_id,
                'Proposal Ditolak',
                "Proposal {$proposal->nomor_proposal} Anda telah ditolak.",
                'proposal_ditolak',
                route('mahasiswa.proposal.detail', $proposal->id),
                $proposal
            );

            $message = 'Proposal berhasil ditolak.';
        }

        return redirect()->route('hrd.proposal.index')
            ->with('success', $message);
    }

    private function buatAkunAnggota(Proposal $proposal): void
    {
        $anggotaTanpaAkun = $proposal->anggota()
            ->whereNull('mahasiswa_id')
            ->where('adalah_ketua', false)
            ->get();

        foreach ($anggotaTanpaAkun as $anggota) {
            // Cek apakah email sudah ada di pengguna
            $existing = Pengguna::where('email', $anggota->email)->first();

            if (!$existing) {
                $passwordSementara = \Illuminate\Support\Str::random(10);
                $pengguna = Pengguna::create([
                    'nama_lengkap' => $anggota->nama_lengkap,
                    'email' => $anggota->email,
                    'password' => Hash::make($passwordSementara),
                    'role' => 'mahasiswa',
                    'status_akun' => 'aktif',
                    'nim' => $anggota->nim,
                    'universitas' => $anggota->universitas,
                    'jurusan' => $anggota->jurusan,
                    'semester' => $anggota->semester,
                    'no_hp' => $anggota->no_hp,
                    'email_verified_at' => now(),
                    'pembimbing_id' => $proposal->pembimbing_id,
                    'dibuat_oleh' => auth()->id(),
                ]);

                $anggota->update([
                    'mahasiswa_id' => $pengguna->id,
                    'status_akun' => 'aktif',
                ]);

                // Kirim email dengan password sementara
                try {
                    Mail::send('emails.akun-anggota-dibuat', [
                        'pengguna' => $pengguna,
                        'password_sementara' => $passwordSementara,
                        'proposal' => $proposal,
                    ], function ($message) use ($pengguna) {
                        $message->to($pengguna->email, $pengguna->nama_lengkap)
                            ->subject('Akun TELENT Anda Telah Dibuat');
                    });
                } catch (\Exception $e) {
                    \Log::error("Gagal kirim email ke {$pengguna->email}: " . $e->getMessage());
                }

                Notifikasi::kirim(
                    $pengguna->id,
                    'Akun Magang Berhasil Dibuat',
                    'Akun magang Anda telah dibuat. Silakan cek email untuk password sementara.',
                    'akun_dibuat'
                );
            } else {
                $anggota->update([
                    'mahasiswa_id' => $existing->id,
                    'status_akun' => 'aktif',
                ]);
            }
        }
    }

    // ============================================================
    // SURAT BALASAN
    // ============================================================
    // ============================================================
// SURAT BALASAN
// ============================================================

public function suratBalasanCreate(Proposal $proposal)
{
    return view('hrd.surat.create', compact('proposal'));
}

public function suratBalasanStore(Request $request, Proposal $proposal)
{
    $validated = $request->validate([
        'jenis' => 'required|in:penerimaan,penolakan',
        'perihal' => 'required|string|max:255',
        'isi_surat' => 'nullable|string',
        'tanggal_surat' => 'required|date',
        'file_surat' => 'required|file|mimes:pdf|max:5120',
    ]);

    // Upload PDF surat
    $filePath = null;

    if ($request->hasFile('file_surat')) {
        $filePath = $request->file('file_surat')
            ->store('surat-balasan', 'public');
    }

    // Simpan surat
    $surat = SuratBalasan::create([
        'proposal_id' => $proposal->id,
        'dibuat_oleh' => auth()->id(),
        'jenis' => $validated['jenis'],
        'nomor_surat' => SuratBalasan::generateNomor($validated['jenis']),
        'perihal' => $validated['perihal'],
        'isi_surat' => $validated['isi_surat'] ?? null,
        'tanggal_surat' => $validated['tanggal_surat'],
        'file_surat' => $filePath,
        'dikirim_pada' => now(),
    ]);

    // Notifikasi mahasiswa
    Notifikasi::kirim(
        $proposal->pengaju_id,
        'Surat Balasan Tersedia',
        "Surat balasan untuk proposal {$proposal->nomor_proposal} telah tersedia.",
        'surat_balasan',
        route('mahasiswa.surat-balasan.index'),
        $surat
    );

    return redirect()->route('hrd.proposal.detail', $proposal->id)
        ->with('success', 'Surat balasan berhasil dibuat dan dikirim.');
}
    // ============================================================
    // MANAJEMEN PENGGUNA ADMIN
    // ============================================================
    public function pengguna(Request $request)
    {
        $query = Pengguna::whereIn('role', ['hrd', 'manager', 'pembimbing_lapang']);

        if ($request->role) {
            $query->where('role', $request->role);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $pengguna = $query->orderBy('role')->orderBy('nama_lengkap')->paginate(15);

        return view('hrd.pengguna.index', compact('pengguna'));
    }

    public function penggunaEdit(Pengguna $pengguna)
    {
        return view('hrd.pengguna.edit', compact('pengguna'));
    }

    public function penggunaUpdate(Request $request, Pengguna $pengguna)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => "required|email|unique:pengguna,email,{$pengguna->id}",
            'divisi' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        $pengguna->update($validated);

        return redirect()->route('hrd.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function penggunaToggleStatus(Pengguna $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak dapat menonaktifkan akun sendiri.']);
        }

        $statusBaru = $pengguna->status_akun === 'aktif' ? 'nonaktif' : 'aktif';
        $pengguna->update(['status_akun' => $statusBaru]);

        $label = $statusBaru === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$pengguna->nama_lengkap} berhasil {$label}.");
    }

    public function penggunaDelete(Pengguna $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        }

        $pengguna->delete();
        return redirect()->route('hrd.pengguna.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    // ============================================================
    // MANAJEMEN TOKEN ADMIN
    // ============================================================
    public function token()
    {
        $tokens = AksesTokenAdmin::with(['dibuatOleh', 'dipakaiOleh'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('hrd.token.index', compact('tokens'));
    }

    public function tokenGenerate(Request $request)
    {
        $validated = $request->validate([
            'role_target' => 'required|in:hrd,manager,pembimbing_lapang',
            'keterangan' => 'nullable|string|max:255',
            'jam_expired' => 'required|integer|min:1|max:720',
        ]);

        $token = AksesTokenAdmin::generate(
            $validated['role_target'],
            $validated['keterangan'],
            auth()->id(),
            (int) $validated['jam_expired']
        );

        return redirect()->route('hrd.token.index')
            ->with('success', "Token berhasil dibuat: {$token->token}");
    }

    // ============================================================
    // MANAJEMEN MAHASISWA
    // ============================================================
    public function mahasiswa(Request $request)
    {
        $query = Pengguna::mahasiswa()->with('pembimbing');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                    ->orWhere('nim', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $mahasiswa = $query->orderBy('nama_lengkap')->paginate(20);

        return view('hrd.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaDetail(Pengguna $mahasiswa)
    {
        abort_if(!$mahasiswa->isMahasiswa(), 404);

        $mahasiswa->load(['proposal', 'pembimbing', 'kehadiran', 'logHarian']);
        $proposal = $mahasiswa->proposal()->with(['periode', 'anggota'])->latest()->first();

        return view('hrd.mahasiswa.detail', compact('mahasiswa', 'proposal'));
    }

    // ============================================================
    // LAPORAN
    // ============================================================
    public function laporan(Request $request)
    {
        $periode = PeriodeMagang::all();
        $periodeId = $request->periode_id;

        $query = Proposal::with(['pengaju', 'periode', 'pembimbing'])->disetujui();

        if ($periodeId) {
            $query->where('periode_id', $periodeId);
        }

        $proposals = $query->get();

        $stats = [
            'total_mahasiswa_aktif' => $proposals->sum('jumlah_anggota'),
            'total_proposal' => $proposals->count(),
            'rata_kehadiran' => $this->hitungRataKehadiran($proposals),
        ];

        return view('hrd.laporan.index', compact('proposals', 'periode', 'periodeId', 'stats'));
    }

    // ============================================================
    // PROFIL HRD
    // ============================================================
    public function profil()
    {
        return view('hrd.profil', ['pengguna' => auth()->user()]);
    }

    public function profilUpdate(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            if (auth()->user()->foto_profil) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(auth()->user()->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')
                ->store('profil/foto', 'public');
        }

        auth()->user()->update($validated);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    private function hitungRataKehadiran($proposals): float
    {
        // Kalkulasi rata-rata kehadiran
        $totalKehadiran = Kehadiran::whereIn('proposal_id', $proposals->pluck('id'))
            ->where('status', 'hadir')
            ->count();

        $totalHariKerja = Kehadiran::whereIn('proposal_id', $proposals->pluck('id'))->count();

        if ($totalHariKerja === 0) return 0;

        return round(($totalKehadiran / $totalHariKerja) * 100, 2);
    }
}
