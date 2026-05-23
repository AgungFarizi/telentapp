<?php

namespace Database\Seeders;

use App\Models\AksesTokenAdmin;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class TokenAdminSeeder extends Seeder
{
    public function run(): void
    {
        $hrd = Pengguna::where('email', 'hrd@telent.id')->first();
        if (!$hrd) return;

        $tokens = [
            ['role_target' => 'hrd', 'keterangan' => 'Token sample untuk registrasi HRD'],
            ['role_target' => 'manager', 'keterangan' => 'Token sample untuk registrasi Manager'],
            ['role_target' => 'pembimbing_lapang', 'keterangan' => 'Token sample untuk registrasi Pembimbing'],
        ];

        foreach ($tokens as $tokenData) {
            $token = AksesTokenAdmin::generate(
                $tokenData['role_target'],
                $tokenData['keterangan'],
                $hrd->id,
                720 // 30 hari
            );

            $this->command->line("Token {$tokenData['role_target']}: <info>{$token->token}</info>");
        }

        $this->command->info('✅ Token admin sample berhasil dibuat (lihat di tabel akses_token_admin).');
    }
}
