<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pemesanan_id');
            $table->decimal('jumlah', 10, 2);
            $table->string('metode', 30); // 'transfer' | 'qris' | 'e-wallet' | 'tunai'
            $table->string('status', 15)->default('menunggu'); // 'menunggu' | 'berhasil' | 'gagal' | 'refund'
            $table->string('referensi_pembayaran', 100)->nullable();
            $table->timestamp('dibayar_pada')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diperbarui_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('pemesanan_id')
                  ->references('id')
                  ->on('pemesanan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
