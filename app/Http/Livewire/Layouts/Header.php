<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public $cartCount = 0;

    // Listener interaksi realtime dari komponen lain (misal: saat klik 'Tambah ke Keranjang')
    #[On('cart-updated')]
    public function updateCartCount($count)
    {
        $this->cartCount = $count;
    }

    public function mount()
    {
        // Mendapatkan total quantity dari session cart saat reload pertama kali
        $cart = session()->get('cart', []);
        $this->cartCount = array_sum($cart);
    }

    public function render()
    {
        return view('livewire.layouts.header');
    }
}
