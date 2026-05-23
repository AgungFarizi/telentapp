<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_magang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode'); // e.g. "Magang Semester Ganjil 2024/2025"
            $table->date('tanggal_mulai_pendaftaran');
            $table->date('tanggal_akhir_pendaftaran');
            $table->date('tanggal_mulai_magang');
            $table->date('tanggal_akhir_magang');
            $table->integer('kuota_total')->default(0);
            $table->integer('kuota_terisi')->default(0);
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->enum('status', ['draft', 'aktif', 'ditutup', 'selesai'])->default('draft');
            $table->unsignedBigInteger('dibuat_oleh'); // hrd yang membuat
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dibuat_oleh')->references('id')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_magang');
    }
};
