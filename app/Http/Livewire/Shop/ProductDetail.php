<?php

namespace App\Http\Livewire\Shop;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;

    public $quantity = 1;

    public $successMessage = '';

    public function addToCart(): void
    {
        if (! Auth::check()) {
            redirect()->route('login');

            return;
        }

        $cart = session()->get('cart', []);
        $cart[$this->product->id] = ($cart[$this->product->id] ?? 0) + $this->quantity;
        session()->put('cart', $cart);

        $this->dispatch('cart-updated', array_sum($cart));
        $this->successMessage = 'Produk berhasil ditambahkan ke keranjang.';
    }

    public function buyNow(): void
    {
        if (! Auth::check()) {
            redirect()->route('login');

            return;
        }

        redirect()->route('checkout', [
            'product' => $this->product->id,
            'quantity' => $this->quantity,
        ]);
    }

    public function render()
    {
        return view('livewire.shop.product-detail');
    }
}
