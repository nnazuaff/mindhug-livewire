<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function createSnapToken(Order $order): ?string
    {
        $user = $order->user;

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number.'-'.uniqid(),
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $user->full_name ?? $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id' => $item->product_id ?? 'item-'.$item->id,
                    'price' => $item->unit_price,
                    'quantity' => $item->qty,
                    'name' => $item->product_name,
                ];
            })->toArray(),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            return $snapToken;
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: '.$e->getMessage());

            return null;
        }
    }

    public function checkAndUpdateStatus(Order $order): bool
    {
        if (! $order->midtrans_transaction_id) {
            try {
                $response = Transaction::status($order->invoice_number);
            } catch (\Exception $e) {
                return false;
            }
        } else {
            try {
                $response = Transaction::status($order->invoice_number);
            } catch (\Exception $e) {
                return false;
            }
        }

        $order->update([
            'midtrans_transaction_id' => $response->transaction_id ?? null,
            'payment_type' => $response->payment_type ?? null,
        ]);

        $status = $response->transaction_status ?? null;
        $fraud = $response->fraud_status ?? null;

        if (($status === 'capture' && $fraud === 'accept') || $status === 'settlement') {
            if ($order->status === 'awaiting_payment') {
                app(OrderService::class)->updateStatus(
                    $order, 'processing', 'Pembayaran Berhasil',
                    'Pembayaran telah diterima melalui Midtrans ('.($response->payment_type ?? 'Unknown').').'
                );
            }

            return true;
        }

        return false;
    }

    public function handleNotification(array $payload): bool
    {
        $orderId = explode('-', $payload['order_id'] ?? '')[0];
        $order = Order::where('invoice_number', 'like', $orderId.'%')->first();
        if (! $order) {
            return false;
        }

        $status = $payload['transaction_status'] ?? null;
        $fraud = $payload['fraud_status'] ?? null;

        $order->update([
            'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
            'payment_type' => $payload['payment_type'] ?? null,
        ]);

        if (($status === 'capture' && $fraud === 'accept') || $status === 'settlement') {
            app(OrderService::class)->updateStatus($order, 'processing', 'Pembayaran Berhasil', 'Pembayaran diterima.');
        } elseif (in_array($status, ['deny', 'cancel', 'expire', 'failure'])) {
            app(OrderService::class)->updateStatus($order, 'cancelled', 'Pembayaran Gagal', 'Pembayaran '.$status);
        }

        return true;
    }
}
