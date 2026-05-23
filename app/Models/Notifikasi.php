<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'pengguna_id', 'judul', 'pesan', 'jenis', 'url_tujuan',
        'notifiable_type', 'notifiable_id', 'sudah_dibaca', 'dibaca_pada',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function tandaiDibaca(): void
    {
        $this->update([
            'sudah_dibaca' => true,
            'dibaca_pada' => now(),
        ]);
    }

    public static function kirim(
    int $penggunaId,
    string $judul,
    string $pesan,
    string $jenis = 'sistem',
    ?string $urlTujuan = null,
    ?Model $notifiable = null
    ): static {
        return static::create([
            'pengguna_id' => $penggunaId,
            'judul' => $judul,
            'pesan' => $pesan,
            'jenis' => $jenis,
            'url_tujuan' => $urlTujuan,

            // perbaikan
            'notifiable_type' => $notifiable ? get_class($notifiable) : self::class,
            'notifiable_id' => $notifiable?->id ?? 0,
        ]);
    }

    public function getIconAttribute(): string
    {
        return match ($this->jenis) {
            'proposal_diajukan' => '📄',
            'proposal_disetujui' => '✅',
            'proposal_ditolak' => '❌',
            'proposal_diteruskan' => '📨',
            'kehadiran_diverifikasi' => '📋',
            'log_diverifikasi' => '📝',
            'surat_balasan' => '📬',
            'akun_dibuat' => '👤',
            'periode_dibuka' => '🗓️',
            default => '🔔',
        };
    }

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }
}
