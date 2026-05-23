<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AksesTokenAdmin;
use App\Models\AnggotaProposal;
use App\Models\EmailVerification;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    // ============================================================
    // Registrasi Mahasiswa (self-register)
    // ============================================================
    public function showFormMahasiswa()
    {
        return view('auth.register-mahasiswa');
    }

    public function registerMahasiswa(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'nim' => 'required|string|max:20|unique:pengguna,nim',
            'universitas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|string|max:5',
            'no_hp' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $pengguna = Pengguna::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
            'status_akun' => 'menunggu_verifikasi',
            'nim' => $validated['nim'],
            'universitas' => $validated['universitas'],
            'jurusan' => $validated['jurusan'],
            'semester' => $validated['semester'],
            'no_hp' => $validated['no_hp'],
        ]);

        // Kirim email verifikasi
        $verification = EmailVerification::buatToken($pengguna->id);
        $this->kirimEmailVerifikasi($pengguna, $verification->token);

        return redirect()->route('auth.verifikasi-email-notice')
            ->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk verifikasi akun.');
    }

    // ============================================================
    // Registrasi Admin (HRD/Manager/Pembimbing) dengan Token
    // ============================================================
    public function showFormAdmin()
    {
        return view('auth.register-admin');
    }

    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string|exists:akses_token_admin,token',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'no_induk_karyawan' => 'required|string|max:20',
            'divisi' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        // Cek token admin
        $tokenAdmin = AksesTokenAdmin::where('token', $validated['token'])->first();

        if (!$tokenAdmin || !$tokenAdmin->isValid()) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
        }

        $pengguna = Pengguna::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $tokenAdmin->role_target,
            'status_akun' => 'menunggu_verifikasi',
            'no_induk_karyawan' => $validated['no_induk_karyawan'],
            'divisi' => $validated['divisi'],
            'jabatan' => $validated['jabatan'],
            'no_hp' => $validated['no_hp'],
            'token_admin_dipakai' => $validated['token'],
        ]);

        // Tandai token terpakai
        $tokenAdmin->tandaiDigunakan($pengguna->id);

        // Kirim email verifikasi
        $verification = EmailVerification::buatToken($pengguna->id);
        $this->kirimEmailVerifikasi($pengguna, $verification->token);

        return redirect()->route('auth.verifikasi-email-notice')
            ->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk verifikasi akun.');
    }

    // ============================================================
    // Registrasi Anggota Kelompok (dari link unik)
    // ============================================================
    public function showFormAnggota(string $token)
    {
        $anggota = AnggotaProposal::where('token_undangan', $token)
            ->where('status_akun', 'menunggu')
            ->firstOrFail();

        return view('auth.register-anggota', compact('anggota', 'token'));
    }

    public function registerAnggota(Request $request, string $token)
    {
        $anggota = AnggotaProposal::where('token_undangan', $token)
            ->where('status_akun', 'menunggu')
            ->firstOrFail();

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        // Buat akun mahasiswa untuk anggota
        $pengguna = Pengguna::create([
            'nama_lengkap' => $anggota->nama_lengkap,
            'email' => $anggota->email,
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
            'status_akun' => 'aktif', // langsung aktif karena data sudah diverifikasi di proposal
            'nim' => $anggota->nim,
            'universitas' => $anggota->universitas,
            'jurusan' => $anggota->jurusan,
            'semester' => $anggota->semester,
            'no_hp' => $anggota->no_hp,
            'email_verified_at' => now(),
        ]);

        // Update anggota proposal
        $anggota->update([
            'mahasiswa_id' => $pengguna->id,
            'status_akun' => 'aktif',
        ]);

        // Kirim notifikasi
        Notifikasi::kirim(
            $pengguna->id,
            'Akun Berhasil Dibuat',
            'Selamat datang di TELENT! Akun Anda telah aktif sebagai anggota kelompok magang.',
            'akun_dibuat'
        );

        return redirect()->route('auth.login')
            ->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // ============================================================
    // Email Verification
    // ============================================================
    public function verifikasiEmailNotice()
    {
        return view('auth.verifikasi-email-notice');
    }

    public function verifikasiEmail(string $token)
    {
        $verification = EmailVerification::where('token', $token)->first();

        if (!$verification || !$verification->isValid()) {
            return redirect()->route('auth.login')
                ->withErrors(['email' => 'Link verifikasi tidak valid atau sudah kedaluwarsa.']);
        }

        $pengguna = $verification->pengguna;
        $pengguna->markEmailAsVerified();
        $verification->update(['sudah_diverifikasi' => true]);

        return redirect()->route('auth.login')
            ->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function kirimUlangVerifikasi(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:pengguna,email']);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if ($pengguna->hasVerifiedEmail()) {
            return back()->with('info', 'Email Anda sudah terverifikasi.');
        }

        $verification = EmailVerification::buatToken($pengguna->id);
        $this->kirimEmailVerifikasi($pengguna, $verification->token);

        return back()->with('success', 'Email verifikasi telah dikirim ulang.');
    }

    private function kirimEmailVerifikasi(Pengguna $pengguna, string $token): void
    {
        $url = route('auth.verifikasi-email', $token);

        Mail::send('emails.verifikasi-email', [
            'pengguna' => $pengguna,
            'url' => $url,
        ], function ($message) use ($pengguna) {
            $message->to($pengguna->email, $pengguna->nama_lengkap)
                ->subject('Verifikasi Email - TELENT');
        });
    }
}
