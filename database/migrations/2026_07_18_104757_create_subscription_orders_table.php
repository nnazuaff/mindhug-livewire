<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constrained('subscription_plans');
            $table->unsignedInteger('amount');
            $table->string('status', 30)->default('awaiting_payment');
            // awaiting_payment, awaiting_confirmation, completed, cancelled
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_proof', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('confirmed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_orders');
    }
};
