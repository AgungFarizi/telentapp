<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_balasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->unsignedBigInteger('dibuat_oleh'); // hrd
            $table->enum('jenis', ['penerimaan', 'penolakan']);
            $table->string('nomor_surat', 50)->unique();
            $table->string('perihal');
            $table->text('isi_surat');
            $table->string('file_surat')->nullable(); // PDF yang di-generate
            $table->date('tanggal_surat');
            $table->timestamp('dikirim_pada')->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposal');
            $table->foreign('dibuat_oleh')->references('id')->on('pengguna');
        });

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id'); // penerima notifikasi
            $table->string('judul');
            $table->text('pesan');
            $table->enum('jenis', [
                'proposal_diajukan',
                'proposal_disetujui',
                'proposal_ditolak',
                'proposal_diteruskan',
                'kehadiran_diverifikasi',
                'log_diverifikasi',
                'surat_balasan',
                'akun_dibuat',
                'periode_dibuka',
                'sistem'
            ])->default('sistem');
            $table->string('url_tujuan')->nullable(); // link ke halaman terkait
            $table->morphs('notifiable'); // polymorphic relation
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();

            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
            $table->index(['pengguna_id', 'sudah_dibaca']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('surat_balasan');
    }
};
