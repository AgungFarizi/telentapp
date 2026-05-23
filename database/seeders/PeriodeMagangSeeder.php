<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use App\Models\PeriodeMagang;
use Illuminate\Database\Seeder;

class PeriodeMagangSeeder extends Seeder
{
    public function run(): void
    {
        $hrd = Pengguna::where('email', 'hrd@telent.id')->first();

        if (!$hrd) return;

        PeriodeMagang::firstOrCreate(
            ['nama_periode' => 'Magang Semester Ganjil 2024/2025'],
            [
                'tanggal_mulai_pendaftaran' => now()->subDays(5),
                'tanggal_akhir_pendaftaran' => now()->addDays(25),
                'tanggal_mulai_magang' => now()->addDays(30),
                'tanggal_akhir_magang' => now()->addDays(120),
                'kuota_total' => 30,
                'kuota_terisi' => 0,
                'deskripsi' => 'Program magang semester ganjil tahun akademik 2024/2025. Terbuka untuk mahasiswa aktif semester 5 ke atas.',
                'persyaratan' => "1. Mahasiswa aktif minimal semester 5\n2. IPK minimal 2.75\n3. Menyertakan surat pengantar dari kampus\n4. Menyertakan transkrip nilai terakhir\n5. CV terbaru",
                'status' => 'aktif',
                'dibuat_oleh' => $hrd->id,
            ]
        );

        $this->command->info('✅ Periode magang sample berhasil dibuat.');
    }
}
