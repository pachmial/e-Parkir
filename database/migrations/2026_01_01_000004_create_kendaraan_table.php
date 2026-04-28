<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->string('plat_nomor', 20);
            $table->string('merek', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('warna', 30)->nullable();
            $table->string('jenis', 15)->default('mobil'); // 'mobil' | 'motor'
            $table->boolean('utama')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('pengguna_id')
                  ->references('id')
                  ->on('pengguna')
                  ->onDelete('cascade');

            $table->unique(['pengguna_id', 'plat_nomor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
