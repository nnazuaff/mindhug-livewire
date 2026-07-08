<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->refreshCartCount();
    }

    #[On('cart-updated')]
    public function updateCartCount($count)
    {
        $this->refreshCartCount();
    }

    protected function refreshCartCount(): void
    {
        $cart = session()->get('cart', []);
        $this->cartCount = 0;

        if (empty($cart)) return;

        // Hanya hitung produk yang masih ada di database
        $validProductIds = \App\Models\Product::whereIn('id', array_keys($cart), 'and', false)->pluck('id')->toArray();

        foreach ($cart as $productId => $qty) {
            if (in_array((int) $productId, $validProductIds)) {
                $this->cartCount += $qty;
            } else {
                // Hapus produk yang sudah tidak ada dari session
                unset($cart[$productId]);
            }
        }

        session()->put('cart', $cart);
    }

    public function render()
    {
        return view('livewire.layouts.header');
    }
}
