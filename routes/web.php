<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HRD\HRDController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\PembimbingLapang\PembimbingLapangController;
use Illuminate\Support\Facades\Route;

// ============================================================
// ROOT - Redirect ke login
// ============================================================
Route::get('/', fn() => redirect()->route('auth.login'));

// ============================================================
// AUTH ROUTES (Guest only)
// ============================================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showForm'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.post');

    // Register Mahasiswa
    Route::get('/daftar', [RegisterController::class, 'showFormMahasiswa'])->name('auth.register');
    Route::post('/daftar', [RegisterController::class, 'registerMahasiswa'])->name('auth.register.post');

    // Register Admin (dengan token)
    Route::get('/daftar-admin', [RegisterController::class, 'showFormAdmin'])->name('auth.register-admin');
    Route::post('/daftar-admin', [RegisterController::class, 'registerAdmin'])->name('auth.register-admin.post');

    // Register Anggota Kelompok
    Route::get('/daftar-anggota/{token}', [RegisterController::class, 'showFormAnggota'])->name('auth.register-anggota');
    Route::post('/daftar-anggota/{token}', [RegisterController::class, 'registerAnggota'])->name('auth.register-anggota.post');
});

// Email Verification (tidak butuh login)
Route::get('/verifikasi-email', fn() => view('auth.verifikasi-email-notice'))
    ->name('auth.verifikasi-email-notice');
Route::get('/verifikasi-email/{token}', [RegisterController::class, 'verifikasiEmail'])
    ->name('auth.verifikasi-email');
Route::post('/kirim-ulang-verifikasi', [RegisterController::class, 'kirimUlangVerifikasi'])
    ->name('auth.kirim-ulang-verifikasi');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('auth.logout')
    ->middleware('auth');

// ============================================================
// HRD ROUTES
// ============================================================
Route::prefix('hrd')->name('hrd.')->middleware(['auth', 'role:hrd'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HRDController::class, 'dashboard'])->name('dashboard');

    // Periode Magang
    Route::prefix('periode')->name('periode.')->group(function () {
        Route::get('/', [HRDController::class, 'periode'])->name('index');
        Route::get('/tambah', [HRDController::class, 'periodeCreate'])->name('create');
        Route::post('/tambah', [HRDController::class, 'periodeStore'])->name('store');
        Route::get('/{periode}/edit', [HRDController::class, 'periodeEdit'])->name('edit');
        Route::put('/{periode}', [HRDController::class, 'periodeUpdate'])->name('update');
        Route::patch('/{periode}/toggle-status', [HRDController::class, 'periodeToggleStatus'])->name('toggle-status');
    });

    // Proposal Management
    Route::prefix('proposal')->name('proposal.')->group(function () {
        Route::get('/', [HRDController::class, 'proposal'])->name('index');
        Route::get('/{proposal}', [HRDController::class, 'proposalDetail'])->name('detail');
        Route::post('/{proposal}/review', [HRDController::class, 'proposalReview'])->name('review');
        // Approve sekarang digabung dalam route review
        // Surat Balasan
        Route::get('/{proposal}/surat/buat', [HRDController::class, 'suratBalasanCreate'])->name('surat.create');
        Route::post('/{proposal}/surat', [HRDController::class, 'suratBalasanStore'])->name('surat.store');
    });

    // Manajemen Pengguna (HRD/Manager/Pembimbing)
    // Penambahan akun admin dilakukan via Token Registrasi
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [HRDController::class, 'pengguna'])->name('index');
        Route::get('/{pengguna}/edit', [HRDController::class, 'penggunaEdit'])->name('edit');
        Route::put('/{pengguna}', [HRDController::class, 'penggunaUpdate'])->name('update');
        Route::patch('/{pengguna}/toggle-status', [HRDController::class, 'penggunaToggleStatus'])->name('toggle-status');
        Route::delete('/{pengguna}', [HRDController::class, 'penggunaDelete'])->name('delete');
    });

    // Mahasiswa
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', [HRDController::class, 'mahasiswa'])->name('index');
        Route::get('/{mahasiswa}', [HRDController::class, 'mahasiswaDetail'])->name('detail');
    });

    // Token Admin
    Route::prefix('token')->name('token.')->group(function () {
        Route::get('/', [HRDController::class, 'token'])->name('index');
        Route::post('/generate', [HRDController::class, 'tokenGenerate'])->name('generate');
    });

    // Laporan
    Route::get('/laporan', [HRDController::class, 'laporan'])->name('laporan');

    // Profil
    Route::get('/profil', [HRDController::class, 'profil'])->name('profil');
    Route::put('/profil', [HRDController::class, 'profilUpdate'])->name('profil.update');
});

// ============================================================
// MANAGER ROUTES (Read-Only - Hanya Pantau Data)
// ============================================================
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');

    // Data Mahasiswa Magang (read-only)
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', [ManagerController::class, 'mahasiswa'])->name('index');
        Route::get('/{mahasiswa}', [ManagerController::class, 'mahasiswaDetail'])->name('detail');
    });

    // Data Kehadiran (read-only)
    Route::get('/kehadiran', [ManagerController::class, 'kehadiran'])->name('kehadiran');

    // Data Proposal (read-only, tidak ada approval)
    Route::prefix('proposal')->name('proposal.')->group(function () {
        Route::get('/', [ManagerController::class, 'proposal'])->name('index');
        Route::get('/{proposal}', [ManagerController::class, 'proposalDetail'])->name('detail');
    });

    // Laporan
    Route::get('/laporan', [ManagerController::class, 'laporan'])->name('laporan');

    // Profil
    Route::get('/profil', [ManagerController::class, 'profil'])->name('profil');
    Route::get('/profil', [ManagerController::class,'profil'])->name('profil');
    Route::put('/profil', [ManagerController::class,'profilUpdate'])->name('profil.update');
});

// ============================================================
// PEMBIMBING LAPANG ROUTES
// ============================================================
Route::prefix('pembimbing')->name('pembimbing.')->middleware(['auth', 'role:pembimbing_lapang'])->group(function () {
    Route::get('/dashboard', [PembimbingLapangController::class, 'dashboard'])->name('dashboard');

    // Mahasiswa Bimbingan
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/', [PembimbingLapangController::class, 'mahasiswaIndex'])->name('index');
        Route::get('/{mahasiswa}', [PembimbingLapangController::class, 'mahasiswaDetail'])->name('detail');
    });

    // Kehadiran
    Route::prefix('kehadiran')->name('kehadiran.')->group(function () {
        Route::get('/', [PembimbingLapangController::class, 'kehadiranIndex'])->name('index');
        Route::post('/{kehadiran}/verifikasi', [PembimbingLapangController::class, 'kehadiranVerifikasi'])->name('verifikasi');
        Route::post('/bulk-verifikasi', [PembimbingLapangController::class, 'kehadiranBulkVerifikasi'])->name('bulk-verifikasi');
    });

    // Log Harian
    Route::prefix('log-harian')->name('log-harian.')->group(function () {
        Route::get('/', [PembimbingLapangController::class, 'logHarianIndex'])->name('index');
        Route::post('/{log}/verifikasi', [PembimbingLapangController::class, 'logHarianVerifikasi'])->name('verifikasi');
    });

    // Laporan
    Route::get('/laporan', [PembimbingLapangController::class, 'laporan'])->name('laporan');

    // Profil
    Route::get('/profil', [PembimbingLapangController::class, 'profil'])->name('profil');
    Route::put('/profil', [PembimbingLapangController::class, 'profilUpdate'])->name('profil.update');
});

// ============================================================
// MAHASISWA ROUTES
// ============================================================
Route::prefix('mahasiswa')->name('mahasiswa.')->middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');

    // Proposal
    Route::prefix('proposal')->name('proposal.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'proposalIndex'])->name('index');
        Route::get('/ajukan', [MahasiswaController::class, 'proposalCreate'])->name('create');
        Route::post('/ajukan', [MahasiswaController::class, 'proposalStore'])->name('store');
        Route::get('/{proposal}', [MahasiswaController::class, 'proposalDetail'])->name('detail');
    });

    // Kehadiran / Absensi
    Route::prefix('kehadiran')->name('kehadiran.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'kehadiranIndex'])->name('index');
        Route::post('/absen-masuk', [MahasiswaController::class, 'absenMasuk'])->name('masuk');
        Route::post('/absen-keluar', [MahasiswaController::class, 'absenKeluar'])->name('keluar');
        Route::post('/izin', [MahasiswaController::class, 'izinStore'])->name('izin');
    });

    // Log Harian
    Route::prefix('log-harian')->name('log-harian.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'logHarianIndex'])->name('index');
        Route::get('/isi', [MahasiswaController::class, 'logHarianCreate'])->name('create');
        Route::post('/isi', [MahasiswaController::class, 'logHarianStore'])->name('store');
        Route::get('/{log}/edit', [MahasiswaController::class, 'logHarianEdit'])->name('edit');
        Route::put('/{log}', [MahasiswaController::class, 'logHarianUpdate'])->name('update');
    });

    // Surat Balasan
    Route::prefix('surat-balasan')->name('surat-balasan.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'suratBalasanIndex'])->name('index');
        Route::get('/{surat}', [MahasiswaController::class, 'suratBalasanDetail'])->name('detail');
    });

    // Notifikasi
    Route::get('/notifikasi', [MahasiswaController::class, 'notifikasiIndex'])->name('notifikasi');

    // Profil
    Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil');
    Route::put('/profil', [MahasiswaController::class, 'profilUpdate'])->name('profil.update');
});

// ============================================================
// API ROUTES (untuk AJAX/fetch)
// ============================================================
Route::prefix('api')->name('api.')->middleware('auth')->group(function () {
    // Notifikasi count
    Route::get('/notifikasi/count', function () {
        return response()->json([
            'count' => auth()->user()->notifikasiBelumDibaca()->count()
        ]);
    })->name('notifikasi.count');

    // Tandai notifikasi dibaca
    Route::post('/notifikasi/{notifikasi}/baca', function (\App\Models\Notifikasi $notifikasi) {
        abort_if($notifikasi->pengguna_id !== auth()->id(), 403);
        $notifikasi->tandaiDibaca();
        return response()->json(['success' => true]);
    })->name('notifikasi.baca');
});
