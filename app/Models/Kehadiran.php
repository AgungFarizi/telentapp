<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';

    protected $fillable = [
        'mahasiswa_id', 'proposal_id', 'tanggal', 'jam_masuk', 'jam_keluar',
        'foto_masuk', 'foto_keluar', 'latitude_masuk', 'longitude_masuk',
        'latitude_keluar', 'longitude_keluar', 'status', 'status_verifikasi',
        'verifikator_id', 'tanggal_verifikasi', 'catatan_verifikasi', 'keterangan',
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

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'verifikator_id');
    }

    public function logHarian(): HasOne
    {
        return $this->hasOne(LogHarian::class, 'kehadiran_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'hadir' => 'Hadir',
            'tidak_hadir' => 'Tidak Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'terlambat' => 'Terlambat',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            default => 'Unknown',
        };
    }

    public function getDurasiAttribute(): ?string
    {
        if ($this->jam_masuk && $this->jam_keluar) {
            $masuk = \Carbon\Carbon::parse($this->jam_masuk);
            $keluar = \Carbon\Carbon::parse($this->jam_keluar);
            $diff = $masuk->diff($keluar);
            return $diff->format('%H jam %I menit');
        }
        return null;
    }

    public function scopeMenungguVerifikasi($query)
    {
        return $query->where('status_verifikasi', 'menunggu');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status_verifikasi', 'disetujui');
    }
}
