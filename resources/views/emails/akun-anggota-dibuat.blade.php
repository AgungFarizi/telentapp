<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Akun TELENT Anda Dibuat</title>
<style>
  body { margin: 0; padding: 0; background: #f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; }
  .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: linear-gradient(135deg, #065f46, #059669); padding: 36px 32px; text-align: center; }
  .header h1 { color: white; font-size: 22px; font-weight: 700; margin: 0; }
  .header p { color: #a7f3d0; font-size: 14px; margin: 6px 0 0; }
  .body { padding: 32px; }
  .greeting { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
  .text { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 20px; }
  .cred-box { background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
  .cred-box h3 { font-size: 14px; font-weight: 700; color: #065f46; margin: 0 0 14px; }
  .cred-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #d1fae5; }
  .cred-row:last-child { border-bottom: none; }
  .cred-label { font-size: 12px; color: #6b7280; font-weight: 600; }
  .cred-value { font-size: 14px; color: #1e293b; font-weight: 700; font-family: monospace; }
  .btn { display: block; width: fit-content; margin: 0 auto 20px; padding: 13px 32px; background: #059669; color: white; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 14px; }
  .warning { background: #fff7ed; border-left: 4px solid #f97316; padding: 12px 16px; border-radius: 0 8px 8px 0; font-size: 13px; color: #9a3412; margin-bottom: 20px; }
  .footer { background: #f8fafc; padding: 16px 32px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>🎉 Selamat! Proposal Diterima</h1>
    <p>Akun magang Anda telah dibuat oleh sistem TELENT</p>
  </div>
  <div class="body">
    <p class="greeting">Halo, {{ $pengguna->nama_lengkap }}!</p>
    <p class="text">
      Proposal magang kelompok Anda telah <strong>disetujui</strong>. Akun TELENT Anda telah dibuat secara otomatis
      untuk keperluan absensi dan log harian selama masa magang.
    </p>

    <div class="cred-box">
      <h3>🔑 Kredensial Login Anda</h3>
      <div class="cred-row">
        <span class="cred-label">URL Login</span>
        <span class="cred-value">{{ url('/login') }}</span>
      </div>
      <div class="cred-row">
        <span class="cred-label">Email</span>
        <span class="cred-value">{{ $pengguna->email }}</span>
      </div>
      <div class="cred-row">
        <span class="cred-label">Password Sementara</span>
        <span class="cred-value">{{ $password_sementara }}</span>
      </div>
      <div class="cred-row">
        <span class="cred-label">Proposal</span>
        <span class="cred-value">{{ $proposal->nomor_proposal }}</span>
      </div>
    </div>

    <div class="warning">
      ⚠️ <strong>Segera ganti password</strong> setelah login pertama kali demi keamanan akun Anda.
    </div>

    <a href="{{ url('/login') }}" class="btn">Login ke TELENT Sekarang</a>
    <p class="text" style="font-size:13px;">Setelah login, Anda dapat melakukan absensi harian dan mengisi log aktivitas magang.</p>
  </div>
  <div class="footer">
    <p>© {{ date('Y') }} TELENT — Sistem Manajemen Magang</p>
    <p>Email ini dikirim otomatis, mohon tidak membalas.</p>
  </div>
</div>
</body>
</html>
