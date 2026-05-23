<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Proposal extends Model
{
    use SoftDeletes;

    protected $table = 'proposal';

    protected $fillable = [
        'nomor_proposal',
        'pengaju_id',
        'periode_id',
        'judul_proposal',
        'deskripsi_kegiatan',
        'divisi_tujuan',
        'file_proposal_pdf',
        'file_surat_pengantar',
        'tanggal_mulai_diinginkan',
        'tanggal_akhir_diinginkan',
        'jumlah_anggota',
        'status',
        'reviewer_hrd_id',
        'tanggal_review_hrd',
        'catatan_hrd',
        'approver_id',
        'tanggal_approval',
        'catatan_approval',
        'keputusan_final',
        'pembimbing_id',
    ];

    protected $casts = [
        'tanggal_mulai_diinginkan' => 'date',
        'tanggal_akhir_diinginkan' => 'date',
        'tanggal_review_hrd' => 'datetime',
        'tanggal_approval' => 'datetime',
    ];

    // ============================================================
    // Boot - Auto generate nomor_proposal
    // ============================================================
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Proposal $proposal) {
            $proposal->nomor_proposal = static::generateNomor();
        });
    }

    public static function generateNomor(): string
    {
        $tahun = now()->year;
        $bulan = str_pad(now()->month, 2, '0', STR_PAD_LEFT);
        $count = static::whereYear('created_at', $tahun)->count() + 1;
        $urut = str_pad($count, 4, '0', STR_PAD_LEFT);
        return "TELENT/{$tahun}/{$bulan}/{$urut}";
    }

    // ============================================================
    // Status Methods
    // ============================================================
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'review_hrd' => 'Review HRD',
            'diteruskan_manager' => 'Diteruskan ke Manager',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'badge-gray',
            'diajukan' => 'badge-blue',
            'review_hrd' => 'badge-yellow',
            'diteruskan_manager' => 'badge-purple',
            'disetujui' => 'badge-green',
            'ditolak' => 'badge-red',
            default => 'badge-gray',
        };
    }

    public function isDisetujui(): bool
    {
        return $this->status === 'disetujui';
    }

    public function isDitolak(): bool
    {
        return $this->status === 'ditolak';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['diajukan', 'review_hrd', 'diteruskan_manager']);
    }

    // ============================================================
    // Relationships
    // ============================================================
    public function pengaju(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengaju_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeMagang::class, 'periode_id');
    }

    public function reviewerHRD(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'reviewer_hrd_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'approver_id');
    }

    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pembimbing_id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaProposal::class, 'proposal_id');
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'proposal_id');
    }

    public function logHarian(): HasMany
    {
        return $this->hasMany(LogHarian::class, 'proposal_id');
    }

    public function suratBalasan(): HasMany
    {
        return $this->hasMany(SuratBalasan::class, 'proposal_id');
    }

    // ============================================================
    // Scopes
    // ============================================================
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['diajukan', 'review_hrd', 'diteruskan_manager']);
    }
}
