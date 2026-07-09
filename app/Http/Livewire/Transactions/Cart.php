<?php

namespace App\Http\Livewire\Transactions;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Cart extends Component
{
    public array $cartItems = [];

    public array $inactiveItems = [];

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

        // Hapus produk yang sudah dihapus dari database
        if (! empty($cart)) {
            $allProductIds = array_keys($cart);
            $existingIds = Product::whereIn('id', $allProductIds)->pluck('id')->toArray();
            $deletedIds = array_diff($allProductIds, $existingIds);
            foreach ($deletedIds as $id) {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            $this->cartItems = [];
            $this->inactiveItems = [];
            $this->resetTotals();

            return;
        }

        $productIds = array_map('intval', array_keys($cart));
        $allProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $disk = Storage::disk('public');

        $activeItems = [];
        $inactiveItems = [];

        foreach ($cart as $productId => $quantity) {
            $product = $allProducts->get((int) $productId);
            if (! $product) {
                continue;
            }

            $files = $disk->files('products/'.$product->id);
            $image = ! empty($files) ? basename($files[0]) : 'default.png';

            $item = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
                'image' => asset('storage/products/'.$product->id.'/'.$image),
                'is_active' => $product->is_active,
            ];

            if ($product->is_active) {
                $activeItems[] = $item;
            } else {
                $inactiveItems[] = $item;
            }
        }

        $this->cartItems = $activeItems;
        $this->inactiveItems = $inactiveItems;

        $this->subtotal = array_sum(array_column($this->cartItems, 'subtotal'));
        $this->discountAmount = (int) round($this->subtotal * ($this->discountPercent / 100));
        $this->total = $this->subtotal - $this->discountAmount;
    }

    private function resetTotals(): void
    {
        $this->subtotal = 0;
        $this->discountAmount = 0;
        $this->total = 0;
        $this->promoCode = '';
        $this->discountPercent = 0;
        $this->promoMessage = null;
    }

    public function increment(int $productId): void
    {
        $cart = session()->get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + 1;
        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cart-updated', $this->getActiveCartCount());
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
        $this->dispatch('cart-updated', $this->getActiveCartCount());
    }

    public function removeItem(int $productId): void
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cart-updated', $this->getActiveCartCount());
    }

    public function removeInactiveItem(int $productId): void
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cart-updated', $this->getActiveCartCount());
    }

    private function getActiveCartCount(): int
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return 0;
        }

        $activeIds = Product::whereIn('id', array_keys($cart))->where('is_active', true)->pluck('id')->toArray();
        $count = 0;
        foreach ($cart as $id => $qty) {
            if (in_array((int) $id, $activeIds)) {
                $count += $qty;
            }
        }

        return $count;
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
