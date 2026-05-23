<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_proposal', 30)->unique(); // auto-generated
            $table->unsignedBigInteger('pengaju_id'); // mahasiswa ketua kelompok
            $table->unsignedBigInteger('periode_id');
            $table->string('judul_proposal');
            $table->text('deskripsi_kegiatan');
            $table->string('divisi_tujuan');
            $table->string('file_proposal_pdf');
            $table->string('file_surat_pengantar')->nullable();
            $table->date('tanggal_mulai_diinginkan');
            $table->date('tanggal_akhir_diinginkan');
            $table->integer('jumlah_anggota')->default(1); // termasuk ketua

            // Status alur: draft -> diajukan -> review_hrd -> diteruskan_manager -> disetujui/ditolak
            $table->enum('status', [
                'draft',
                'diajukan',
                'review_hrd',
                'diteruskan_manager',
                'disetujui',
                'ditolak'
            ])->default('draft');

            // Review HRD
            $table->unsignedBigInteger('reviewer_hrd_id')->nullable();
            $table->timestamp('tanggal_review_hrd')->nullable();
            $table->text('catatan_hrd')->nullable();

            // Final Approval Manager/HRD
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->timestamp('tanggal_approval')->nullable();
            $table->text('catatan_approval')->nullable();
            $table->enum('keputusan_final', ['disetujui', 'ditolak'])->nullable();

            // Pembimbing yang ditugaskan
            $table->unsignedBigInteger('pembimbing_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pengaju_id')->references('id')->on('pengguna');
            $table->foreign('periode_id')->references('id')->on('periode_magang');
            $table->foreign('reviewer_hrd_id')->references('id')->on('pengguna');
            $table->foreign('approver_id')->references('id')->on('pengguna');
            $table->foreign('pembimbing_id')->references('id')->on('pengguna');
        });

        Schema::create('anggota_proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->unsignedBigInteger('mahasiswa_id')->nullable(); // null jika belum punya akun
            $table->string('nama_lengkap');
            $table->string('nim', 20);
            $table->string('universitas');
            $table->string('jurusan');
            $table->string('semester', 5);
            $table->string('no_hp', 20)->nullable();
            $table->string('email');
            $table->boolean('adalah_ketua')->default(false);
            $table->enum('status_akun', ['menunggu', 'aktif'])->default('menunggu');
            // Akun dibuat otomatis saat proposal disetujui
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposal')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('pengguna')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_proposal');
        Schema::dropIfExists('proposal');
    }
};
