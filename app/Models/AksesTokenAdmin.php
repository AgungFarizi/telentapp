<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AksesTokenAdmin extends Model
{
    protected $table = 'akses_token_admin';

    protected $fillable = [
        'token', 'role_target', 'keterangan', 'sudah_dipakai',
        'dipakai_oleh', 'dipakai_pada', 'dibuat_oleh', 'expired_at',
    ];

    protected $casts = [
        'sudah_dipakai' => 'boolean',
        'dipakai_pada' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public static function generate(
        string $roleTarget,
        ?string $keterangan = null,
        int $dibuatOleh = null,
        int $jamExpired = 72
    ): static {
        return static::create([
            'token' => Str::upper(Str::random(8)) . '-' . Str::upper(Str::random(8)) . '-' . Str::upper(Str::random(8)),
            'role_target' => $roleTarget,
            'keterangan' => $keterangan,
            'dibuat_oleh' => $dibuatOleh,
            'expired_at' => now()->addHours($jamExpired),
        ]);
    }

    public function isValid(): bool
    {
        return !$this->sudah_dipakai
            && ($this->expired_at === null || $this->expired_at->isFuture());
    }

    public function tandaiDigunakan(int $penggunaId): void
    {
        $this->update([
            'sudah_dipakai' => true,
            'dipakai_oleh' => $penggunaId,
            'dipakai_pada' => now(),
        ]);
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    public function dipakaiOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dipakai_oleh');
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role_target) {
            'hrd' => 'HRD',
            'manager' => 'Manager',
            'pembimbing_lapang' => 'Pembimbing Lapang',
            default => 'Unknown',
        };
    }

    public function scopeAktif($query)
    {
        return $query->where('sudah_dipakai', false)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            });
    }
}
