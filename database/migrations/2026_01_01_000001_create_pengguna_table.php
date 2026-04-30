<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('kata_sandi', 255);
            $table->string('no_telepon', 20)->nullable();
            $table->string('peran', 10)->default('user'); // 'user' | 'admin'
            $table->string('foto_profil', 255)->nullable();
            $table->boolean('sudah_verifikasi')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
