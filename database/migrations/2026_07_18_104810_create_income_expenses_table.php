<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 10); // 'income' or 'expense'
            $table->string('source', 100); // 'upgrade', 'manual', dll
            $table->string('description', 255)->nullable();
            $table->unsignedInteger('amount');
            $table->date('transaction_date');
            $table->foreignId('subscription_order_id')->nullable()->constrained('subscription_orders')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_expenses');
    }
};
