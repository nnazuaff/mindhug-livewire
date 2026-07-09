<?php

namespace App\Http\Livewire\Layouts;

use App\Models\Product;
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

        if (empty($cart)) {
            return;
        }

        $activeIds = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->pluck('id')->toArray();

        foreach ($cart as $productId => $qty) {
            if (in_array((int) $productId, $activeIds)) {
                $this->cartCount += $qty;
            }
        }
    }

    public function render()
    {
        return view('livewire.layouts.header');
    }
}
