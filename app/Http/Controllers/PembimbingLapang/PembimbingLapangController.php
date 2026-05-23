<?php

namespace App\Http\Controllers\PembimbingLapang;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\LogHarian;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use App\Models\Proposal;
use Illuminate\Http\Request;

class PembimbingLapangController extends Controller
{
    // ============================================================
    // DASHBOARD
    // ============================================================
    public function dashboard()
    {
        $pembimbing = auth()->user();

        $mahasiswaBimbingan = Pengguna::mahasiswa()
            ->where('pembimbing_id', $pembimbing->id)
            ->aktif()
            ->with(['proposal' => fn($q) => $q->where('status', 'disetujui')])
            ->get();

        $kehadiranMenunggu = Kehadiran::whereHas('mahasiswa', fn($q) => $q->where('pembimbing_id', $pembimbing->id))
            ->where('status_verifikasi', 'menunggu')
            ->count();

        $logMenunggu = LogHarian::whereHas('mahasiswa', fn($q) => $q->where('pembimbing_id', $pembimbing->id))
            ->where('status_verifikasi', 'menunggu')
            ->count();

        $kehadiranHariIni = Kehadiran::whereHas('mahasiswa', fn($q) => $q->where('pembimbing_id', $pembimbing->id))
            ->whereDate('tanggal', today())
            ->with('mahasiswa')
            ->get();

        $notifikasi = $pembimbing->notifikasiBelumDibaca()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pembimbing.dashboard', compact(
            'mahasiswaBimbingan', 'kehadiranMenunggu', 'logMenunggu',
            'kehadiranHariIni', 'notifikasi'
        ));
    }

    // ============================================================
    // MAHASISWA BIMBINGAN
    // ============================================================
    public function mahasiswaIndex()
    {
        $pembimbing = auth()->user();

        $mahasiswa = Pengguna::mahasiswa()
            ->where('pembimbing_id', $pembimbing->id)
            ->with(['proposal' => fn($q) => $q->where('status', 'disetujui')->with('periode')])
            ->paginate(15);

        return view('pembimbing.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaDetail(Pengguna $mahasiswa)
    {
        $pembimbing = auth()->user();
        abort_if($mahasiswa->pembimbing_id !== $pembimbing->id, 403);

        $proposal = Proposal::where(function ($q) use ($mahasiswa) {
            $q->where('pengaju_id', $mahasiswa->id)
                ->orWhereHas('anggota', fn($q) => $q->where('mahasiswa_id', $mahasiswa->id));
        })->where('status', 'disetujui')->latest()->first();

        $kehadiran = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal', 'desc')
            ->take(30)
            ->get();

        $logs = LogHarian::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        $statsKehadiran = [
            'hadir' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->where('status', 'hadir')->count(),
            'terlambat' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->where('status', 'terlambat')->count(),
            'izin' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->whereIn('status', ['izin', 'sakit'])->count(),
            'tidak_hadir' => Kehadiran::where('mahasiswa_id', $mahasiswa->id)->where('status', 'tidak_hadir')->count(),
        ];

        return view('pembimbing.mahasiswa.detail', compact(
            'mahasiswa', 'proposal', 'kehadiran', 'logs', 'statsKehadiran'
        ));
    }

    // ============================================================
    // VERIFIKASI KEHADIRAN
    // ============================================================
    public function kehadiranIndex(Request $request)
    {
        $pembimbing = auth()->user();

        $query = Kehadiran::whereHas('mahasiswa', fn($q) => $q->where('pembimbing_id', $pembimbing->id))
            ->with(['mahasiswa', 'verifikator'])
            ->orderBy('tanggal', 'desc');

        if ($request->status_verifikasi) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->mahasiswa_id) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        $kehadiran = $query->paginate(20);

        $mahasiswaBimbingan = Pengguna::mahasiswa()
            ->where('pembimbing_id', $pembimbing->id)
            ->get(['id', 'nama_lengkap', 'nim']);

        return view('pembimbing.kehadiran.index', compact('kehadiran', 'mahasiswaBimbingan'));
    }

    public function kehadiranVerifikasi(Request $request, Kehadiran $kehadiran)
    {
        $pembimbing = auth()->user();

        // Pastikan kehadiran ini milik mahasiswa bimbingan
        abort_if($kehadiran->mahasiswa->pembimbing_id !== $pembimbing->id, 403);

        $validated = $request->validate([
            'aksi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:500',
        ]);

        $kehadiran->update([
            'status_verifikasi' => $validated['aksi'],
            'verifikator_id' => $pembimbing->id,
            'tanggal_verifikasi' => now(),
            'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? null,
        ]);

        // Notifikasi mahasiswa
        Notifikasi::kirim(
            $kehadiran->mahasiswa_id,
            'Kehadiran Diverifikasi',
            "Kehadiran Anda pada " . $kehadiran->tanggal->format('d M Y') . " telah " .
                ($validated['aksi'] === 'disetujui' ? 'disetujui' : 'ditolak') . " oleh pembimbing.",
            'kehadiran_diverifikasi',
            route('mahasiswa.kehadiran.index'),
            $kehadiran
        );

        return back()->with('success', 'Kehadiran berhasil diverifikasi.');
    }

    public function kehadiranBulkVerifikasi(Request $request)
    {
        $pembimbing = auth()->user();

        $validated = $request->validate([
            'kehadiran_ids' => 'required|array',
            'kehadiran_ids.*' => 'exists:kehadiran,id',
            'aksi' => 'required|in:disetujui,ditolak',
        ]);

        $kehadiranList = Kehadiran::whereIn('id', $validated['kehadiran_ids'])
            ->whereHas('mahasiswa', fn($q) => $q->where('pembimbing_id', $pembimbing->id))
            ->get();

        foreach ($kehadiranList as $kehadiran) {
            $kehadiran->update([
                'status_verifikasi' => $validated['aksi'],
                'verifikator_id' => $pembimbing->id,
                'tanggal_verifikasi' => now(),
            ]);

            Notifikasi::kirim(
                $kehadiran->mahasiswa_id,
                'Kehadiran Diverifikasi',
                "Kehadiran Anda pada " . $kehadiran->tanggal->format('d M Y') . " telah diverifikasi.",
                'kehadiran_diverifikasi',
                route('mahasiswa.kehadiran'),
                $kehadiran
            );
        }

        return back()->with('success', count($kehadiranList) . ' data kehadiran berhasil diverifikasi.');
    }

    // ============================================================
    // VERIFIKASI LOG HARIAN
    // ============================================================
    public function logHarianIndex(Request $request)
    {
        $pembimbing = auth()->user();

        $query = LogHarian::whereHas('mahasiswa', fn($q) => $q->where('pembimbing_id', $pembimbing->id))
            ->with(['mahasiswa', 'verifikator'])
            ->orderBy('tanggal', 'desc');

        if ($request->status_verifikasi) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        if ($request->mahasiswa_id) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        $logs = $query->paginate(20);

        $mahasiswaBimbingan = Pengguna::mahasiswa()
            ->where('pembimbing_id', $pembimbing->id)
            ->get(['id', 'nama_lengkap', 'nim']);

        return view('pembimbing.log-harian.index', compact('logs', 'mahasiswaBimbingan'));
    }

    public function logHarianVerifikasi(Request $request, LogHarian $log)
    {
        $pembimbing = auth()->user();

        abort_if($log->mahasiswa->pembimbing_id !== $pembimbing->id, 403);

        $validated = $request->validate([
            'aksi' => 'required|in:disetujui,ditolak,revisi',
            'feedback_pembimbing' => 'nullable|string|max:1000',
        ]);

        $log->update([
            'status_verifikasi' => $validated['aksi'],
            'verifikator_id' => $pembimbing->id,
            'tanggal_verifikasi' => now(),
            'feedback_pembimbing' => $validated['feedback_pembimbing'] ?? null,
        ]);

        $statusLabel = match ($validated['aksi']) {
            'disetujui' => 'disetujui',
            'ditolak' => 'ditolak',
            'revisi' => 'diminta revisi',
        };

        Notifikasi::kirim(
            $log->mahasiswa_id,
            'Log Harian Diverifikasi',
            "Log harian Anda pada " .
            $log->tanggal->format('d M Y') .
            " telah {$statusLabel} oleh pembimbing.",
            'log_diverifikasi',
            route('mahasiswa.log-harian.index'),
            $log
        );

        return back()->with('success', 'Log harian berhasil diverifikasi.');
    }

    
    // ============================================================
    // LAPORAN
    // ============================================================
    public function laporan(Request $request)
    {
        $pembimbing = auth()->user();

        $mahasiswaIds = Pengguna::mahasiswa()
            ->where('pembimbing_id', $pembimbing->id)
            ->pluck('id');

        $mahasiswaBimbingan = Pengguna::whereIn('id', $mahasiswaIds)
            ->with(['proposal' => fn($q) => $q->where('status', 'disetujui')])
            ->get();

        $mahasiswaId = $request->mahasiswa_id;

        $query = Kehadiran::whereIn('mahasiswa_id', $mahasiswaIds)
            ->with('mahasiswa');

        if ($mahasiswaId) {
            $query->where('mahasiswa_id', $mahasiswaId);
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $kehadiran = $query->orderBy('tanggal', 'desc')->get();

        // Rekap per mahasiswa
        $rekap = $mahasiswaBimbingan->map(function ($mhs) use ($kehadiran) {
            $kehadiranMhs = $kehadiran->where('mahasiswa_id', $mhs->id);
            return [
                'mahasiswa' => $mhs,
                'total_hadir' => $kehadiranMhs->where('status', 'hadir')->count(),
                'total_terlambat' => $kehadiranMhs->where('status', 'terlambat')->count(),
                'total_izin' => $kehadiranMhs->whereIn('status', ['izin', 'sakit'])->count(),
                'total_tidak_hadir' => $kehadiranMhs->where('status', 'tidak_hadir')->count(),
                'total_hari' => $kehadiranMhs->count(),
            ];
        });

        return view('pembimbing.laporan.index', compact('rekap', 'mahasiswaBimbingan', 'kehadiran'));
    }

    // ============================================================
    // PROFIL
    // ============================================================
    public function profil()
    {
        $pembimbing = auth()->user();

        return view('pembimbing.profil', compact('pembimbing'));
    }

    public function profilUpdate(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto baru
        if ($request->hasFile('foto_profil')) {

            // hapus foto lama kecuali default
            if (
                $user->foto_profil &&
                \Illuminate\Support\Facades\Storage::disk('public')
                    ->exists($user->foto_profil)
            ) {
                \Illuminate\Support\Facades\Storage::disk('public')
                    ->delete($user->foto_profil);
            }

            $validated['foto_profil'] = $request
                ->file('foto_profil')
                ->store('profil/foto', 'public');
        }

        $user->update($validated);

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }
}
