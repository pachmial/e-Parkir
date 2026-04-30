<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_sensor', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('slot_id');
            $table->string('id_sensor', 50);
            $table->string('status', 15); // 'tersedia' | 'terisi'
            $table->decimal('jarak_cm', 6, 2)->nullable();
            $table->timestamp('dicatat_pada')->useCurrent();

            $table->foreign('slot_id')
                  ->references('id')
                  ->on('slot_parkir')
                  ->onDelete('cascade');

            $table->index(['slot_id', 'dicatat_pada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_sensor');
    }
};
