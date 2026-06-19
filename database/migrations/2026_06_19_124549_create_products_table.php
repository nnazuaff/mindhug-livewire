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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name', 150)->unique();
            $table->text('description')->nullable();
            $table->string('badge', 30)->nullable();
            $table->unsignedInteger('shopee_price')->default(0);
            $table->unsignedInteger('markup')->default(0);
            $table->string('shopee_link', 255)->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
