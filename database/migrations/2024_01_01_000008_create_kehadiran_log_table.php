<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('proposal_id');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('foto_masuk')->nullable(); // selfie saat masuk
            $table->string('foto_keluar')->nullable(); // selfie saat keluar
            $table->decimal('latitude_masuk', 10, 8)->nullable();
            $table->decimal('longitude_masuk', 11, 8)->nullable();
            $table->decimal('latitude_keluar', 10, 8)->nullable();
            $table->decimal('longitude_keluar', 11, 8)->nullable();
            $table->enum('status', [
                'hadir',
                'tidak_hadir',
                'izin',
                'sakit',
                'terlambat',
                'menunggu_verifikasi'
            ])->default('menunggu_verifikasi');
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->unsignedBigInteger('verifikator_id')->nullable(); // pembimbing
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->text('keterangan')->nullable(); // keterangan mahasiswa (misal alasan izin)
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('pengguna');
            $table->foreign('proposal_id')->references('id')->on('proposal');
            $table->foreign('verifikator_id')->references('id')->on('pengguna');
            $table->unique(['mahasiswa_id', 'tanggal']); // 1 absen per hari per mahasiswa
        });

        Schema::create('log_harian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('proposal_id');
            $table->unsignedBigInteger('kehadiran_id')->nullable(); // relasi ke kehadiran hari itu
            $table->date('tanggal');
            $table->text('kegiatan_dilakukan'); // deskripsi kegiatan hari ini
            $table->text('hasil_kegiatan')->nullable();
            $table->text('kendala')->nullable();
            $table->text('rencana_besok')->nullable();
            $table->string('file_dokumentasi')->nullable(); // foto/dokumen kegiatan
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak', 'revisi'])->default('menunggu');
            $table->unsignedBigInteger('verifikator_id')->nullable(); // pembimbing
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->text('feedback_pembimbing')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('pengguna');
            $table->foreign('proposal_id')->references('id')->on('proposal');
            $table->foreign('kehadiran_id')->references('id')->on('kehadiran')->onDelete('set null');
            $table->foreign('verifikator_id')->references('id')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_harian');
        Schema::dropIfExists('kehadiran');
    }
};
