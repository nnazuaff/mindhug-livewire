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

    public function addToCart($redirect = null)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $cart = session()->get('cart', []);
        $cart[$this->product->id] = ($cart[$this->product->id] ?? 0) + $this->quantity;
        session()->put('cart', $cart);

        if ($redirect === 'checkout') {
            return redirect()->route('checkout');
        }

        $this->successMessage = 'Produk berhasil ditambahkan ke keranjang.';
    }

    public function render()
    {
        return view('livewire.shop.product-detail');
    }
}
