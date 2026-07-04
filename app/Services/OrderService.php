<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrackingEvent;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new order from cart items.
     */
    public function createOrder(int $userId, array $cartItems, array $address, int $shippingCost, int $discountAmount, ?string $paymentMethod = null): Order
    {
        return DB::transaction(function () use ($userId, $cartItems, $address, $shippingCost, $discountAmount, $paymentMethod) {
            $subtotal = array_sum(array_column($cartItems, 'subtotal'));
            $totalAmount = $subtotal + $shippingCost - $discountAmount;

            // Validate stock & lock products
            foreach ($cartItems as $item) {
                // Use query() + find to avoid ambiguous where() overload issues
                $product = Product::query()->lockForUpdate()->find($item['id']);

                if (! $product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk {$product->name}.");
                }

                // Kurangi stok
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

    /**
     * Update order status and add tracking event.
     */
    public function updateStatus(Order $order, string $status, string $title, ?string $description = null): void
    {
        DB::transaction(function () use ($order, $status, $title, $description) {
            $order->update(['status' => $status]);

            OrderTrackingEvent::create([
                'order_id' => $order->id,
                'occurred_at' => now(),
                'title' => $title,
                'description' => $description,
            ]);
        });
    }

    /**
     * Generate unique invoice number.
     * Format: INV-YYYYMMDD-XXXXX
     */
    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-'.now()->format('Ymd').'-';

        $lastOrder = Order::where('invoice_number', 'like', $prefix.'%', 'and')
            ->orderByDesc('invoice_number')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->invoice_number, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix.$newNumber;
    }
}
