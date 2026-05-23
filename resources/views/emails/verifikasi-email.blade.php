<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi Email - TELENT</title>
<style>
  body { margin: 0; padding: 0; background: #f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; }
  .wrapper { max-width: 560px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
  .header { background: linear-gradient(135deg, #1e3a8a, #1d4ed8); padding: 40px 32px; text-align: center; }
  .logo { width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; }
  .logo span { color: white; font-size: 22px; font-weight: 900; }
  .header h1 { color: white; font-size: 24px; font-weight: 700; margin: 0; }
  .header p { color: #bfdbfe; font-size: 14px; margin: 6px 0 0; }
  .body { padding: 36px 32px; }
  .greeting { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
  .text { font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
  .btn { display: block; width: fit-content; margin: 0 auto 24px; padding: 14px 36px; background: #1d4ed8; color: white; text-decoration: none; border-radius: 12px; font-size: 15px; font-weight: 700; text-align: center; }
  .link-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; word-break: break-all; font-size: 12px; color: #475569; margin-bottom: 24px; }
  .warning { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 0 8px 8px 0; font-size: 13px; color: #92400e; margin-bottom: 24px; }
  .footer { background: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
  .footer p { font-size: 12px; color: #94a3b8; margin: 4px 0; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <div class="logo"><span>T</span></div>
    <h1>TELENT</h1>
    <p>Sistem Manajemen Magang</p>
  </div>
  <div class="body">
    <p class="greeting">Halo, {{ $pengguna->nama_lengkap }}! 👋</p>
    <p class="text">
      Terima kasih telah mendaftar di TELENT. Untuk mengaktifkan akun Anda,
      silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.
    </p>
    <a href="{{ $url }}" class="btn">✅ Verifikasi Email Sekarang</a>
    <p class="text" style="text-align:center; font-size:13px;">Atau salin link berikut ke browser Anda:</p>
    <div class="link-box">{{ $url }}</div>
    <div class="warning">
      ⚠️ Link verifikasi ini berlaku selama <strong>24 jam</strong>. Jika sudah kedaluwarsa, silakan minta link baru dari halaman login.
    </div>
    <p class="text">Jika Anda tidak mendaftar di TELENT, abaikan email ini. Akun tidak akan diaktifkan tanpa verifikasi.</p>
  </div>
  <div class="footer">
    <p>© {{ date('Y') }} TELENT — Sistem Manajemen Magang</p>
    <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
  </div>
</div>
</body>
</html>
