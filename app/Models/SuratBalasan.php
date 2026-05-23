<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratBalasan extends Model
{
    protected $table = 'surat_balasan';

    protected $fillable = [
        'proposal_id', 'dibuat_oleh', 'jenis', 'nomor_surat',
        'perihal', 'isi_surat', 'file_surat', 'tanggal_surat',
        'dikirim_pada', 'sudah_dibaca',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'dikirim_pada' => 'datetime',
        'sudah_dibaca' => 'boolean',
    ];

    public static function generateNomor(string $jenis): string
    {
        $tahun = now()->year;
        $bulan = str_pad(now()->month, 2, '0', STR_PAD_LEFT);
        $kode = $jenis === 'penerimaan' ? 'ACC' : 'REJ';
        $count = static::whereYear('created_at', $tahun)->count() + 1;
        $urut = str_pad($count, 3, '0', STR_PAD_LEFT);
        return "TELENT/SB/{$kode}/{$tahun}/{$bulan}/{$urut}";
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }
}
