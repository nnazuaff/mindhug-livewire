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
            $table->id();
            $table->string('full_name', 150);
            $table->string('username', 50)->unique();
            $table->string('email', 150)->unique();
            $table->string('phone', 30);
            $table->string('role', 10)->default('free'); // Pengganti ENUM
            $table->dateTime('trial_started_at')->nullable();
            $table->boolean('is_trial_active')->default(false);
            $table->date('birth_date');
            $table->string('password', 255); // Gunakan 'password' untuk bawaan Laravel Auth
            $table->dateTime('last_login_at')->nullable();
            $table->timestamps();
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
