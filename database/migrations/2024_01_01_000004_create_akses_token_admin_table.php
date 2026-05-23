<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akses_token_admin', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->enum('role_target', ['hrd', 'manager', 'pembimbing_lapang']);
            $table->string('keterangan')->nullable();
            $table->boolean('sudah_dipakai')->default(false);
            $table->unsignedBigInteger('dipakai_oleh')->nullable();
            $table->timestamp('dipakai_pada')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akses_token_admin');
    }
};
