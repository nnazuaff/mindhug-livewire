<?php

namespace App\Services;

use App\Models\IncomeExpense;
use App\Models\SubscriptionOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubscriptionService
{
    public function createOrder(int $userId, int $planId, int $amount): SubscriptionOrder
    {
        return SubscriptionOrder::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'user_id' => $userId,
            'subscription_plan_id' => $planId,
            'amount' => $amount,
            'status' => 'awaiting_payment',
        ]);
    }

    public function confirmOrder(SubscriptionOrder $order): void
    {
        DB::transaction(function () use ($order) {
            $order->update([
                'status' => 'completed',
                'confirmed_at' => now(),
            ]);

            $plan = $order->plan;
            $user = $order->user;

            // Set plus_expires_at
            $currentExpiry = $user->plus_expires_at && $user->plus_expires_at > now()
                ? Carbon::parse($user->plus_expires_at)
                : now();

            $user->update([
                'role' => 'plus',
                'plus_expires_at' => $currentExpiry->addDays($plan->duration_days),
            ]);

            // Catat pemasukan
            IncomeExpense::create([
                'type' => 'income',
                'source' => 'upgrade',
                'description' => 'Upgrade: '.$user->full_name.' - '.$plan->name,
                'amount' => $order->amount,
                'transaction_date' => now()->format('Y-m-d'),
                'subscription_order_id' => $order->id,
            ]);
        });
    }

    public function rejectOrder(SubscriptionOrder $order): void
    {
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $order->update([
            'status' => 'cancelled',
            'payment_proof' => null,
        ]);
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'UPG-'.now()->format('Ymd').'-';
        $last = SubscriptionOrder::where('invoice_number', 'like', $prefix.'%')
            ->orderByDesc('invoice_number')->first();
        $num = $last ? (int) substr($last->invoice_number, -5) + 1 : 1;

        return $prefix.str_pad($num, 5, '0', STR_PAD_LEFT);
    }
}
