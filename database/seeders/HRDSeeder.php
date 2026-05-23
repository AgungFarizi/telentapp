<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HRDSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin HRD (pemegang penuh aplikasi)
        Pengguna::firstOrCreate(
            ['email' => 'hrd@telent.id'],
            [
                'nama_lengkap' => 'Admin HRD TELENT',
                'password' => Hash::make('HRD@telent2024'),
                'role' => 'hrd',
                'status_akun' => 'aktif',
                'no_induk_karyawan' => 'HRD-001',
                'divisi' => 'Human Resource Department',
                'jabatan' => 'HRD Manager',
                'no_hp' => '081234567890',
                'email_verified_at' => now(),
            ]
        );

        // Manager
        Pengguna::firstOrCreate(
            ['email' => 'manager@telent.id'],
            [
                'nama_lengkap' => 'Manager TELENT',
                'password' => Hash::make('Manager@telent2024'),
                'role' => 'manager',
                'status_akun' => 'aktif',
                'no_induk_karyawan' => 'MGR-001',
                'divisi' => 'Management',
                'jabatan' => 'General Manager',
                'no_hp' => '081234567891',
                'email_verified_at' => now(),
            ]
        );

        // Pembimbing Lapang Sample
        Pengguna::firstOrCreate(
            ['email' => 'pembimbing1@telent.id'],
            [
                'nama_lengkap' => 'Budi Santoso',
                'password' => Hash::make('Pembimbing@telent2024'),
                'role' => 'pembimbing_lapang',
                'status_akun' => 'aktif',
                'no_induk_karyawan' => 'PBM-001',
                'divisi' => 'IT Development',
                'jabatan' => 'Senior Developer',
                'no_hp' => '081234567892',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Akun default berhasil dibuat:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['HRD (Super Admin)', 'hrd@telent.id', 'HRD@telent2024'],
                ['Manager', 'manager@telent.id', 'Manager@telent2024'],
                ['Pembimbing', 'pembimbing1@telent.id', 'Pembimbing@telent2024'],
            ]
        );
    }
}
