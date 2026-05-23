<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['hrd', 'manager', 'pembimbing_lapang', 'mahasiswa']);
            $table->enum('status_akun', ['aktif', 'nonaktif', 'menunggu_verifikasi'])->default('menunggu_verifikasi');

            // Data Mahasiswa
            $table->string('nim', 20)->nullable()->unique();
            $table->string('universitas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('semester', 5)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('foto_profil')->nullable();

            // Data Staff (HRD/Manager/Pembimbing)
            $table->string('divisi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_induk_karyawan', 20)->nullable();

            // Relasi Pembimbing
            $table->unsignedBigInteger('pembimbing_id')->nullable();

            // Dibuat oleh (untuk akun yang dibuat HRD)
            $table->unsignedBigInteger('dibuat_oleh')->nullable();

            // Token admin yang dipakai saat registrasi
            $table->string('token_admin_dipakai', 64)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pembimbing_id')->references('id')->on('pengguna')->onDelete('set null');
            $table->foreign('dibuat_oleh')->references('id')->on('pengguna')->onDelete('set null');
        });

        Schema::create('email_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id');
            $table->string('token', 64)->unique();
            $table->timestamp('expired_at');
            $table->boolean('sudah_diverifikasi')->default(false);
            $table->timestamps();

            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
        });

        // CATATAN: password_reset_tokens sudah dibuat oleh Laravel bawaan
        // di 0001_01_01_000000_create_users_table.php — tidak perlu dibuat lagi
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verifications');
        Schema::dropIfExists('pengguna');
    }
};
