<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pengguna';

    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
        'status_akun',

        // Mahasiswa
        'nim',
        'universitas',
        'jurusan',
        'semester',

        // Umum
        'no_hp',
        'foto_profil',

        // Karyawan
        'divisi',
        'jabatan',
        'no_induk_karyawan',

        // Relasi
        'pembimbing_id',
        'dibuat_oleh',

        'token_admin_dipakai',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Role Checking
    |--------------------------------------------------------------------------
    */

    public function isHRD(): bool
    {
        return $this->role === 'hrd';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isPembimbingLapang(): bool
    {
        return $this->role === 'pembimbing_lapang';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isAdmin(): bool
    {
        return in_array(
            $this->role,
            ['hrd', 'manager', 'pembimbing_lapang']
        );
    }

    public function isAktif(): bool
    {
        return $this->status_akun === 'aktif';
    }


    /*
    |--------------------------------------------------------------------------
    | Label Role
    |--------------------------------------------------------------------------
    */

    public function getRoleLabel(): string
    {
        return match ($this->role) {

            'hrd' => 'HRD',

            'manager' => 'Manager',

            'pembimbing_lapang' => 'Pembimbing Lapang',

            'mahasiswa' => 'Mahasiswa',

            default => 'Unknown'
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Route Profil
    |--------------------------------------------------------------------------
    | Dipakai sidebar dan menu profil otomatis
    |--------------------------------------------------------------------------
    */

    public function getProfilRoute(): string
    {
        return match ($this->role) {

            'hrd' => 'hrd.profil',

            'manager' => 'manager.profil',

            'pembimbing_lapang' => 'pembimbing.profil',

            'mahasiswa' => 'mahasiswa.profil',

            default => 'auth.login'
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Redirect
    |--------------------------------------------------------------------------
    */

    public function getDashboardRoute(): string
    {
        return match ($this->role) {

            'hrd' => 'hrd.dashboard',

            'manager' => 'manager.dashboard',

            'pembimbing_lapang' => 'pembimbing.dashboard',

            'mahasiswa' => 'mahasiswa.dashboard',

            default => 'dashboard'
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'pembimbing_id'
        );
    }

    public function mahasiswaBimbingan(): HasMany
    {
        return $this->hasMany(
            Pengguna::class,
            'pembimbing_id'
        );
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(
            Pengguna::class,
            'dibuat_oleh'
        );
    }

    public function proposal(): HasMany
    {
        return $this->hasMany(
            Proposal::class,
            'pengaju_id'
        );
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(
            Kehadiran::class,
            'mahasiswa_id'
        );
    }

    public function logHarian(): HasMany
    {
        return $this->hasMany(
            LogHarian::class,
            'mahasiswa_id'
        );
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(
            Notifikasi::class,
            'pengguna_id'
        );
    }

    public function notifikasiBelumDibaca(): HasMany
    {
        return $this->hasMany(
            Notifikasi::class,
            'pengguna_id'
        )->where(
            'sudah_dibaca',
            false
        );
    }

    public function emailVerifications(): HasMany
    {
        return $this->hasMany(
            EmailVerification::class,
            'pengguna_id'
        );
    }

    public function anggotaProposal(): HasMany
    {
        return $this->hasMany(
            AnggotaProposal::class,
            'mahasiswa_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeMahasiswa($query)
    {
        return $query->where(
            'role',
            'mahasiswa'
        );
    }

    public function scopeHrd($query)
    {
        return $query->where(
            'role',
            'hrd'
        );
    }

    public function scopeRolePembimbing($query)
    {
        return $query->where(
            'role',
            'pembimbing_lapang'
        );
    }

    public function scopeRoleManager($query)
    {
        return $query->where(
            'role',
            'manager'
        );
    }

    public function scopeAktif($query)
    {
        return $query->where(
            'status_akun',
            'aktif'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'status_akun' => 'aktif',
        ])->save();
    }

    public function sendEmailVerificationNotification(): void
    {
        // handle manual
    }


    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getFotoProfilUrlAttribute(): string
    {
        if ($this->foto_profil) {
            return asset(
                'storage/' . $this->foto_profil
            );
        }

        return asset(
            'images/default-avatar.png'
        );
    }
}