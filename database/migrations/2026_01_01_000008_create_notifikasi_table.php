<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->string('judul', 150);
            $table->text('pesan');
            $table->string('jenis', 20)->default('info'); // 'info' | 'peringatan' | 'sukses' | 'pembayaran'
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('pengguna_id')
                  ->references('id')
                  ->on('pengguna')
                  ->onDelete('cascade');

            $table->index(['pengguna_id', 'sudah_dibaca']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
