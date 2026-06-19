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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('total_amount')->default(0);
            $table->string('status', 30)->default('awaiting_payment');
            $table->string('payment_method', 50)->nullable();
            $table->string('shipping_method', 100)->nullable();
            $table->unsignedInteger('shipping_fee')->default(0);
            $table->unsignedInteger('handling_fee')->default(0);
            $table->string('payment_proof', 255)->nullable();
            $table->text('shipping_address')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
