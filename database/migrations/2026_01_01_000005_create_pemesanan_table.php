<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->uuid('slot_id');
            $table->uuid('kendaraan_id');
            $table->string('kode_pemesanan', 20)->unique();
            $table->timestamp('waktu_mulai');
            $table->timestamp('waktu_selesai')->nullable();
            $table->decimal('durasi_jam', 4, 2)->nullable();
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->string('status', 15)->default('menunggu'); // 'menunggu' | 'aktif' | 'selesai' | 'dibatalkan'
            $table->text('catatan')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('pengguna_id')
                  ->references('id')
                  ->on('pengguna')
                  ->onDelete('cascade');

            $table->foreign('slot_id')
                  ->references('id')
                  ->on('slot_parkir')
                  ->onDelete('cascade');

            $table->foreign('kendaraan_id')
                  ->references('id')
                  ->on('kendaraan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
