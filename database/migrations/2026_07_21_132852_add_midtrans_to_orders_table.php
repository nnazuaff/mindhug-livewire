<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('snap_token', 100)->nullable()->after('payment_proof');
            $table->string('midtrans_transaction_id', 100)->nullable()->after('snap_token');
            $table->string('payment_type', 30)->nullable()->after('midtrans_transaction_id');
            $table->string('payment_channel', 30)->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_transaction_id', 'payment_type', 'payment_channel']);
        });
    }
};
