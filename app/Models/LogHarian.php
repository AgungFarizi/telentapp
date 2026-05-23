<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogHarian extends Model
{
    protected $table = 'log_harian';

    protected $fillable = [
        'mahasiswa_id', 'proposal_id', 'kehadiran_id', 'tanggal',
        'kegiatan_dilakukan', 'hasil_kegiatan', 'kendala', 'rencana_besok',
        'file_dokumentasi', 'status_verifikasi', 'verifikator_id',
        'tanggal_verifikasi', 'feedback_pembimbing',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_verifikasi' => 'datetime',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'mahasiswa_id');
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function kehadiran(): BelongsTo
    {
        return $this->belongsTo(Kehadiran::class, 'kehadiran_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'verifikator_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_verifikasi) {
            'menunggu' => 'Menunggu Review',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'revisi' => 'Perlu Revisi',
            default => 'Unknown',
        };
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status_verifikasi', 'menunggu');
    }
}
