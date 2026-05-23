<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaProposal extends Model
{
    protected $table = 'anggota_proposal';

    protected $fillable = [
        'proposal_id', 'mahasiswa_id', 'nama_lengkap', 'nim', 'universitas',
        'jurusan', 'semester', 'no_hp', 'email', 'adalah_ketua', 'status_akun',
    ];

    protected $casts = [
        'adalah_ketua' => 'boolean',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'mahasiswa_id');
    }
}
