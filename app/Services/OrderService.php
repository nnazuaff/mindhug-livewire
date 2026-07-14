<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrackingEvent;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(int $userId, int $promoId, array $cartItems, array $address, int $shippingCost, int $discountAmount, ?string $paymentMethod = null): Order
    {
        return DB::transaction(function () use ($userId, $cartItems, $address, $shippingCost, $discountAmount, $paymentMethod, $promoId) {
            $subtotal = array_sum(array_column($cartItems, 'subtotal'));
            $totalAmount = $subtotal + $shippingCost - $discountAmount;

            $itemIds = array_column($cartItems, 'id');
            $validProducts = Product::whereIn('id', $itemIds)
                ->where('is_active', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($promoId) {
                Promotion::find($promoId)?->increment('used_count');
            }

            // Cek apakah ada item yang tidak valid
            foreach ($cartItems as $item) {
                $product = $validProducts->get($item['id']);
                if (! $product) {
                    throw new \Exception('Maaf, beberapa produk di keranjang Anda sudah tidak tersedia. Pesanan gagal diproses.');
                }
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk {$product->name}.");
                }
                $product->decrement('stock', $item['quantity']);
            }

            $shippingAddress = implode(', ', array_filter([
                $address['recipient_name'] ?? '',
                $address['phone'] ?? '',
                $address['street'] ?? '',
                $address['region'] ?? '',
                $address['detail'] ?? '',
            ]));

            $order = Order::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'user_id' => $userId,
                'total_amount' => max(0, $totalAmount),
                'status' => 'awaiting_payment',
                'payment_method' => $paymentMethod,
                'shipping_method' => 'Standard',
                'shipping_fee' => $shippingCost,
                'handling_fee' => 0,
                'shipping_address' => $shippingAddress,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'qty' => $item['quantity'],
                    'line_total' => $item['subtotal'],
                ]);
            }

            OrderTrackingEvent::create([
                'order_id' => $order->id,
                'occurred_at' => now(),
                'title' => 'Pesanan Dibuat',
                'description' => 'Pesanan Anda telah berhasil dibuat dan menunggu pembayaran.',
            ]);

            return $order;
        });
    }

    public function updateStatus(Order $order, string $status, string $title, ?string $description = null, ?string $cancellationReason = null): void
    {
        DB::transaction(function () use ($order, $status, $title, $description, $cancellationReason) {
            $data = ['status' => $status];
            if ($status === 'cancelled' && $cancellationReason) {
                $data['cancellation_reason'] = $cancellationReason;
            }
            $order->update($data);
            OrderTrackingEvent::create([
                'order_id' => $order->id,
                'occurred_at' => now(),
                'title' => $title,
                'description' => $description,
            ]);
        });
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-'.now()->format('Ymd').'-';
        $lastOrder = Order::where('invoice_number', 'like', $prefix.'%')->orderByDesc('invoice_number')->first();
        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->invoice_number, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix.$newNumber;
    }
}
