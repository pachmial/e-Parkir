<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot_parkir', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lokasi_parkir_id');
            $table->string('kode_slot', 10);
            $table->string('lantai', 10)->nullable();
            $table->string('zona', 10)->nullable();
            $table->string('jenis_slot', 15)->default('reguler'); // 'reguler' | 'disabilitas' | 'motor'
            $table->string('status', 15)->default('tersedia'); // 'tersedia' | 'terisi' | 'dipesan' | 'nonaktif'
            $table->string('id_sensor', 50)->nullable();
            $table->timestamp('terakhir_diperbarui')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('lokasi_parkir_id')
                  ->references('id')
                  ->on('lokasi_parkir')
                  ->onDelete('cascade');

            $table->unique(['lokasi_parkir_id', 'kode_slot']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot_parkir');
    }
};
