<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SubscriptionOrder;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function createSnapTokenForUpgrade(SubscriptionOrder $order): ?string
    {
        $user = $order->user;

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number.'-'.uniqid(),
                'gross_amount' => $order->amount,
            ],
            'customer_details' => [
                'first_name' => $user->full_name ?? $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'upgrade-'.$order->subscription_plan_id,
                    'price' => $order->amount,
                    'quantity' => 1,
                    'name' => $order->plan->name ?? 'MindHug Plus',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            return $snapToken;
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Upgrade Error: '.$e->getMessage());

            return null;
        }
    }

    public function createSnapToken(Order $order): ?string
    {
        $user = $order->user;

        $items = $order->items->map(function ($item) {
            return [
                'id' => $item->product_id ?? 'item-'.$item->id,
                'price' => $item->unit_price,
                'quantity' => $item->qty,
                'name' => $item->product_name,
            ];
        })->toArray();

        // Tambah ongkir sebagai item
        if ($order->shipping_fee > 0) {
            $items[] = [
                'id' => 'shipping',
                'price' => $order->shipping_fee,
                'quantity' => 1,
                'name' => 'Ongkos Kirim',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number.'-'.uniqid(),
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $user->full_name ?? $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'shipping_address' => [
                    'address' => $order->shipping_address ?? '',
                    'city' => '',
                    'postal_code' => '',
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => $items,
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

    /**
     * Cancel transaksi di Midtrans.
     */
    public function cancelTransaction(Order $order): bool
    {
        try {
            // Coba cancel pakai invoice_number asli
            Transaction::cancel($order->invoice_number);

            return true;
        } catch (\Exception $e) {
            \Log::error('Midtrans Cancel Error: '.$e->getMessage());

            // Fallback: coba cancel pakai order_id yang ada di snap token
            try {
                // Ambil order_id dari snap_token (format: INV-xxx-uniqid)
                // Midtrans simpen order_id di transaksi, kita coba query status dulu
                $status = Transaction::status($order->invoice_number);
                if (isset($status->transaction_id)) {
                    Transaction::cancel($order->invoice_number);

                    return true;
                }
            } catch (\Exception $e2) {
                \Log::error('Midtrans Cancel Fallback Error: '.$e2->getMessage());
            }

            return false;
        }
    }

    public function checkAndUpdateStatus(Order $order): bool
    {
        try {
            $response = Transaction::status($order->invoice_number);

            $order->update([
                'midtrans_transaction_id' => $response->transaction_id ?? null,
                'payment_type' => $response->payment_type ?? null,
            ]);

            $status = $response->transaction_status ?? null;
            $fraud = $response->fraud_status ?? null;

            // Sukses
            if (($status === 'capture' && $fraud === 'accept') || $status === 'settlement') {
                if ($order->status === 'awaiting_payment') {
                    app(OrderService::class)->updateStatus($order, 'processing', 'Pembayaran Berhasil', 'Pembayaran diterima via Midtrans.');
                }

                return true;
            }

            // Gagal / Cancel / Expired
            if (in_array($status, ['deny', 'cancel', 'expire', 'failure'])) {
                if ($order->status === 'awaiting_payment') {
                    $labels = ['deny' => 'Ditolak', 'cancel' => 'Dibatalkan', 'expire' => 'Kadaluarsa', 'failure' => 'Gagal'];
                    $label = $labels[$status] ?? $status;
                    app(OrderService::class)->updateStatus($order, 'cancelled', 'Pembayaran '.$label, 'Status Midtrans: '.$status);
                }

                return true;
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Midtrans Check Error: '.$e->getMessage());

            return false;
        }
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
