<?php
// ============================================================
// All Model Files - TELENT Application
// Save each class to its own file in app/Models/
// ============================================================

namespace App\Models;

// ============================================================
// FILE: app/Models/PeriodeMagang.php
// ============================================================
/*
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodeMagang extends Model
{
    use SoftDeletes;

    protected $table = 'periode_magang';

    protected $fillable = [
        'nama_periode', 'tanggal_mulai_pendaftaran', 'tanggal_akhir_pendaftaran',
        'tanggal_mulai_magang', 'tanggal_akhir_magang', 'kuota_total',
        'kuota_terisi', 'deskripsi', 'persyaratan', 'status', 'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_mulai_pendaftaran' => 'date',
        'tanggal_akhir_pendaftaran' => 'date',
        'tanggal_mulai_magang' => 'date',
        'tanggal_akhir_magang' => 'date',
    ];

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    public function proposal(): HasMany
    {
        return $this->hasMany(Proposal::class, 'periode_id');
    }

    public function isTerbuka(): bool
    {
        return $this->status === 'aktif'
            && now()->between($this->tanggal_mulai_pendaftaran, $this->tanggal_akhir_pendaftaran);
    }

    public function sisaKuota(): int
    {
        return max(0, $this->kuota_total - $this->kuota_terisi);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'aktif' => 'Aktif',
            'ditutup' => 'Ditutup',
            'selesai' => 'Selesai',
            default => 'Unknown',
        };
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
*/
