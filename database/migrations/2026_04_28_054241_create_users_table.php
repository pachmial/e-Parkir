<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key (Auto-increment)
            $table->string('name'); // Nama user
            $table->string('email')->unique(); // Email unik untuk login
            $table->timestamp('email_verified_at')->nullable(); // Tanggal verifikasi email
            $table->string('password'); // Password terenkripsi
            $table->rememberToken(); // Token untuk fitur "Remember Me"
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};