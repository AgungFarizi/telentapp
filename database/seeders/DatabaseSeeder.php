<?php

namespace Database\Seeders;

use App\Models\AksesTokenAdmin;
use App\Models\Pengguna;
use App\Models\PeriodeMagang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HRDSeeder::class,
            PeriodeMagangSeeder::class,
            TokenAdminSeeder::class,
        ]);
    }
}

// ============================================================
// FILE: database/seeders/HRDSeeder.php
// ============================================================
/*
<?php
namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HRDSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin HRD
        Pengguna::create([
            'nama_lengkap' => 'Admin HRD TELENT',
            'email' => 'hrd@telent.id',
            'password' => Hash::make('HRD@telent2024'),
            'role' => 'hrd',
            'status_akun' => 'aktif',
            'no_induk_karyawan' => 'HRD-001',
            'divisi' => 'Human Resource Department',
            'jabatan' => 'HRD Manager',
            'no_hp' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Manager
        Pengguna::create([
            'nama_lengkap' => 'Manager TELENT',
            'email' => 'manager@telent.id',
            'password' => Hash::make('Manager@telent2024'),
            'role' => 'manager',
            'status_akun' => 'aktif',
            'no_induk_karyawan' => 'MGR-001',
            'divisi' => 'Management',
            'jabatan' => 'General Manager',
            'no_hp' => '081234567891',
            'email_verified_at' => now(),
        ]);

        // Pembimbing Lapang
        Pengguna::create([
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'pembimbing@telent.id',
            'password' => Hash::make('Pembimbing@telent2024'),
            'role' => 'pembimbing_lapang',
            'status_akun' => 'aktif',
            'no_induk_karyawan' => 'PBM-001',
            'divisi' => 'IT Development',
            'jabatan' => 'Senior Developer',
            'no_hp' => '081234567892',
            'email_verified_at' => now(),
        ]);
    }
}
*/
