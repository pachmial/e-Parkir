<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token_refresh', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id');
            $table->string('token', 500)->unique();
            $table->timestamp('kedaluwarsa_pada');
            $table->boolean('dicabut')->default(false);
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('pengguna_id')
                  ->references('id')
                  ->on('pengguna')
                  ->onDelete('cascade');

            $table->index(['pengguna_id', 'dicabut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_refresh');
    }
};
