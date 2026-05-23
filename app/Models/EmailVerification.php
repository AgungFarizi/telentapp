<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EmailVerification extends Model
{
    protected $table = 'email_verifications';

    protected $fillable = [
        'pengguna_id', 'token', 'expired_at', 'sudah_diverifikasi',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'sudah_diverifikasi' => 'boolean',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public static function buatToken(int $penggunaId): static
    {
        // Hapus token lama
        static::where('pengguna_id', $penggunaId)->delete();

        return static::create([
            'pengguna_id' => $penggunaId,
            'token' => Str::random(64),
            'expired_at' => now()->addHours(24),
        ]);
    }

    public function isValid(): bool
    {
        return !$this->sudah_diverifikasi && $this->expired_at->isFuture();
    }
}
