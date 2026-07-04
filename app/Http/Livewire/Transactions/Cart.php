<?php

namespace App\Http\Livewire\Transactions;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Cart extends Component
{
    public array $cartItems = [];

    public string $promoCode = '';

    public int $discountPercent = 0;

    public int $subtotal = 0;

    public int $discountAmount = 0;

    public int $total = 0;

    public ?string $promoMessage = null;

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            $this->cartItems = [];
            $this->promoCode = '';
            $this->discountPercent = 0;
            $this->subtotal = 0;
            $this->discountAmount = 0;
            $this->total = 0;
            $this->promoMessage = null;

            return;
        }

        $productIds = array_map('intval', array_keys($cart));
        $products = Product::query()
            ->get()
            ->filter(fn ($product) => in_array($product->id, $productIds, true))
            ->keyBy('id');

        $disk = Storage::disk('public');

        $this->cartItems = collect($cart)
            ->map(function ($quantity, $productId) use ($products, $disk) {
                $product = $products->get((int) $productId);

                if (! $product) {
                    return null;
                }

                // Ambil gambar pertama dari folder produk
                $files = $disk->files('products/'.$product->id);
                $image = ! empty($files) ? basename($files[0]) : 'default.png';

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                    'image' => asset('storage/products/'.$product->id.'/'.$image),
                ];
            })
            ->filter()
            ->values()
            ->all();

        $this->subtotal = array_sum(array_column($this->cartItems, 'subtotal'));
        $this->discountAmount = (int) round($this->subtotal * ($this->discountPercent / 100));
        $this->total = $this->subtotal - $this->discountAmount;
    }

    public function increment(int $productId): void
    {
        $cart = session()->get('cart', []);

        $cart[$productId] = ($cart[$productId] ?? 0) + 1;
        session()->put('cart', $cart);

        $this->loadCart();
        $this->dispatch('cart-updated', array_sum($cart));
    }

    public function decrement(int $productId): void
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$productId])) {
            return;
        }

        if ($cart[$productId] <= 1) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $cart[$productId] - 1;
        }

        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cart-updated', array_sum($cart));
    }

    public function removeItem(int $productId): void
    {
        $cart = session()->get('cart', []);

        if (! isset($cart[$productId])) {
            return;
        }

        unset($cart[$productId]);
        session()->put('cart', $cart);

        $this->loadCart();
        $this->dispatch('cart-updated', array_sum($cart));
    }

    public function applyPromo(): void
    {
        $this->promoMessage = null;

        if (trim($this->promoCode) === '') {
            $this->promoMessage = 'Masukkan kode promo terlebih dahulu.';
            $this->discountPercent = 0;
            $this->recalculateTotals();

            return;
        }

        if (strtoupper(trim($this->promoCode)) === 'MINDHUG10') {
            $this->discountPercent = 10;
            $this->promoMessage = 'Kode promo berhasil diterapkan: diskon 10%.';
            $this->recalculateTotals();

            return;
        }

        $this->discountPercent = 0;
        $this->promoMessage = 'Kode promo tidak valid. Coba lagi atau lewati saja.';
        $this->recalculateTotals();
    }

    protected function recalculateTotals(): void
    {
        $this->discountAmount = (int) round($this->subtotal * ($this->discountPercent / 100));
        $this->total = $this->subtotal - $this->discountAmount;
    }

    public function getSubtotalProperty(): int
    {
        return array_sum(array_column($this->cartItems, 'subtotal'));
    }

    public function getDiscountAmountProperty(): int
    {
        return (int) round($this->subtotal * ($this->discountPercent / 100));
    }

    public function getTotalProperty(): int
    {
        return $this->subtotal - $this->discountAmount;
    }

    public function render()
    {
        return view('livewire.transactions.cart', [
            'subtotal' => $this->subtotal,
            'discountAmount' => $this->discountAmount,
            'total' => $this->total,
        ]);
    }
}
