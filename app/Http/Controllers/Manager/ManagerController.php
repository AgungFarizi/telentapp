<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\LogHarian;
use App\Models\Pengguna;
use App\Models\PeriodeMagang;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $periodeAktif = PeriodeMagang::aktif()->first();

        $stats = [
            'total_mahasiswa_aktif' => Pengguna::mahasiswa()->aktif()->count(),
            'total_proposal_disetujui' => Proposal::where('status', 'disetujui')->count(),
            'total_pembimbing' => Pengguna::rolePembimbing()->aktif()->count(),
            'total_kehadiran_hari_ini' => Kehadiran::whereDate('tanggal', today())->count(),
            'periode_aktif' => $periodeAktif,
        ];

        $kehadiranMingguIni = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            $kehadiranMingguIni[] = [
                'tanggal' => $tanggal->format('d M'),
                'hadir' => Kehadiran::whereDate('tanggal', $tanggal)->where('status', 'hadir')->count(),
                'tidak_hadir' => Kehadiran::whereDate('tanggal', $tanggal)->where('status', 'tidak_hadir')->count(),
                'izin' => Kehadiran::whereDate('tanggal', $tanggal)->whereIn('status', ['izin', 'sakit'])->count(),
            ];
        }

        $mahasiswaTerbaru = Pengguna::mahasiswa()->aktif()
            ->whereNotNull('pembimbing_id')
            ->with('pembimbing')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        $kehadiranHariIni = Kehadiran::whereDate('tanggal', today())
            ->with('mahasiswa')->orderBy('jam_masuk', 'desc')->take(10)->get();

        return view('manager.dashboard', compact('stats','kehadiranMingguIni','mahasiswaTerbaru','kehadiranHariIni'));
    }

    public function mahasiswa(Request $request)
    {
        $query = Pengguna::mahasiswa()
            ->with(['pembimbing', 'proposal' => fn($q) => $q->where('status','disetujui')->with('periode')])
            ->orderBy('nama_lengkap');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap','like',"%{$request->search}%")
                  ->orWhere('nim','like',"%{$request->search}%")
                  ->orWhere('universitas','like',"%{$request->search}%");
            });
        }
        if ($request->pembimbing_id) {
            $query->where('pembimbing_id', $request->pembimbing_id);
        }

        $mahasiswa = $query->paginate(20);
        $pembimbingList = Pengguna::rolePembimbing()->aktif()->get(['id','nama_lengkap']);

        return view('manager.mahasiswa.index', compact('mahasiswa','pembimbingList'));
    }

    public function mahasiswaDetail(Pengguna $mahasiswa)
    {
        abort_if(!$mahasiswa->isMahasiswa(), 404);

        $proposal = Proposal::where(function ($q) use ($mahasiswa) {
            $q->where('pengaju_id', $mahasiswa->id)
              ->orWhereHas('anggota', fn($q) => $q->where('mahasiswa_id', $mahasiswa->id));
        })->where('status','disetujui')->with(['periode','pembimbing'])->latest()->first();

        $kehadiran = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal','desc')->take(30)->get();

        $logHarian = LogHarian::where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal','desc')->take(10)->get();

        $statsKehadiran = [
            'hadir' => Kehadiran::where('mahasiswa_id',$mahasiswa->id)->where('status','hadir')->count(),
            'terlambat' => Kehadiran::where('mahasiswa_id',$mahasiswa->id)->where('status','terlambat')->count(),
            'izin' => Kehadiran::where('mahasiswa_id',$mahasiswa->id)->whereIn('status',['izin','sakit'])->count(),
            'tidak_hadir' => Kehadiran::where('mahasiswa_id',$mahasiswa->id)->where('status','tidak_hadir')->count(),
            'total' => Kehadiran::where('mahasiswa_id',$mahasiswa->id)->count(),
        ];

        $persentaseKehadiran = $statsKehadiran['total'] > 0
            ? round((($statsKehadiran['hadir'] + $statsKehadiran['terlambat']) / $statsKehadiran['total']) * 100, 1)
            : 0;

        return view('manager.mahasiswa.detail', compact(
            'mahasiswa','proposal','kehadiran','logHarian','statsKehadiran','persentaseKehadiran'
        ));
    }

    public function kehadiran(Request $request)
    {
        $tanggalFilter = $request->tanggal ?? today()->format('Y-m-d');

        $query = Kehadiran::with(['mahasiswa','verifikator'])->orderBy('tanggal','desc');
        $query->whereDate('tanggal', $tanggalFilter);

        if ($request->status) $query->where('status', $request->status);
        if ($request->mahasiswa_id) $query->where('mahasiswa_id', $request->mahasiswa_id);

        $kehadiran = $query->paginate(25);

        $statsHariIni = [
            'hadir' => Kehadiran::whereDate('tanggal',$tanggalFilter)->where('status','hadir')->count(),
            'terlambat' => Kehadiran::whereDate('tanggal',$tanggalFilter)->where('status','terlambat')->count(),
            'izin' => Kehadiran::whereDate('tanggal',$tanggalFilter)->whereIn('status',['izin','sakit'])->count(),
            'tidak_hadir' => Kehadiran::whereDate('tanggal',$tanggalFilter)->where('status','tidak_hadir')->count(),
        ];

        $mahasiswaList = Pengguna::mahasiswa()->aktif()->get(['id','nama_lengkap','nim']);

        return view('manager.kehadiran.index', compact('kehadiran','statsHariIni','mahasiswaList','tanggalFilter'));
    }

    public function proposal(Request $request)
    {
        $query = Proposal::with(['pengaju','periode','pembimbing'])->orderBy('created_at','desc');

        if ($request->status) $query->where('status', $request->status);
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_proposal','like',"%{$request->search}%")
                  ->orWhere('judul_proposal','like',"%{$request->search}%")
                  ->orWhereHas('pengaju', fn($q) => $q->where('nama_lengkap','like',"%{$request->search}%"));
            });
        }

        $proposals = $query->paginate(15);
        return view('manager.proposal.index', compact('proposals'));
    }

    public function proposalDetail(Proposal $proposal)
    {
        $proposal->load(['pengaju','periode','anggota','reviewerHRD','approver','pembimbing']);
        return view('manager.proposal.detail', compact('proposal'));
    }

    public function laporan(Request $request)
    {
        $periodes = PeriodeMagang::orderBy('created_at','desc')->get();
        $periodeId = $request->periode_id;
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $queryProposal = Proposal::with(['pengaju','periode','pembimbing','anggota'])
            ->where('status','disetujui');
        if ($periodeId) $queryProposal->where('periode_id', $periodeId);
        $proposals = $queryProposal->get();

        $rekapKehadiran = [];
        foreach ($proposals as $proposal) {
            $mahasiswaIds = collect([$proposal->pengaju_id])
                ->merge($proposal->anggota->pluck('mahasiswa_id')->filter())->unique();

            foreach ($mahasiswaIds as $mhsId) {
                $mhs = Pengguna::find($mhsId);
                if (!$mhs) continue;
                $base = Kehadiran::where('mahasiswa_id',$mhsId)
                    ->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun);
                $rekapKehadiran[] = [
                    'mahasiswa' => $mhs,
                    'proposal' => $proposal,
                    'hadir' => (clone $base)->where('status','hadir')->count(),
                    'terlambat' => (clone $base)->where('status','terlambat')->count(),
                    'izin' => (clone $base)->whereIn('status',['izin','sakit'])->count(),
                    'tidak_hadir' => (clone $base)->where('status','tidak_hadir')->count(),
                    'total_log' => LogHarian::where('mahasiswa_id',$mhsId)
                        ->whereMonth('tanggal',$bulan)->whereYear('tanggal',$tahun)->count(),
                ];
            }
        }

        $summary = [
            'total_mahasiswa' => count($rekapKehadiran),
            'total_proposal' => $proposals->count(),
            'total_hadir' => array_sum(array_column($rekapKehadiran,'hadir')),
            'total_tidak_hadir' => array_sum(array_column($rekapKehadiran,'tidak_hadir')),
        ];

        $bulanList = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];

        return view('manager.laporan.index', compact(
            'proposals','periodes','periodeId','rekapKehadiran','summary','bulan','tahun','bulanList'
        ));
    }

    public function profil()
    {
        return view('manager.profil');
    }

    public function profilUpdate(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('foto_profil')){
            $path = $request->file('foto_profil')->store('profil','public');
            $validated['foto_profil']=$path;
        }

        $user->update($validated);

        return back()->with('success','Profil berhasil diperbarui');
    }

}
