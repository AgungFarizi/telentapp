<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!Auth::attempt($credentials, $request->boolean('ingat_saya'))) {
            return back()->withErrors([
                'email' => 'Email atau password tidak valid.',
            ])->onlyInput('email');
        }

        $pengguna = Auth::user();

        // Cek email terverifikasi (skip jika APP_ENV=local untuk kemudahan development)
        if (!$pengguna->hasVerifiedEmail() && config('app.env') !== 'local') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Silakan verifikasi email Anda terlebih dahulu.',
            ])->onlyInput('email');
        }

        // Jika local dan belum verifikasi, otomatis verifikasi
        if (!$pengguna->hasVerifiedEmail() && config('app.env') === 'local') {
            $pengguna->markEmailAsVerified();
        }

        // Cek status akun
        if ($pengguna->status_akun === 'nonaktif') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi HRD untuk informasi lebih lanjut.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($pengguna->getDashboardRoute()))
            ->with('success', 'Selamat datang kembali, ' . $pengguna->nama_lengkap . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
