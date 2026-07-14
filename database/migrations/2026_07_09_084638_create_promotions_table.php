<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('type', 10); // 'fixed' or 'percent'
            $table->unsignedInteger('value');
            $table->unsignedInteger('min_order')->default(0);
            $table->unsignedInteger('max_discount')->nullable();
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->date('starts_date')->nullable();
            $table->time('starts_time')->nullable();
            $table->date('ends_date')->nullable();
            $table->time('ends_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
