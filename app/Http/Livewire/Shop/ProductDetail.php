<?php

namespace App\Http\Livewire\Shop;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;

    public $quantity = 1;

    public $successMessage = '';

    public array $images = [];

    public string $selectedImage = '';

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

    /**
     * Navigasi ke gambar berikutnya
     */
    public function nextImage(): void
    {
        if (count($this->images) <= 1) {
            return;
        }

        $currentIndex = array_search($this->selectedImage, $this->images);
        $nextIndex = ($currentIndex + 1) % count($this->images);
        $this->selectedImage = $this->images[$nextIndex];
    }

    /**
     * Navigasi ke gambar sebelumnya
     */
    public function previousImage(): void
    {
        if (count($this->images) <= 1) {
            return;
        }

        $currentIndex = array_search($this->selectedImage, $this->images);
        $prevIndex = ($currentIndex - 1 + count($this->images)) % count($this->images);
        $this->selectedImage = $this->images[$prevIndex];
    }

    /**
     * Pilih gambar tertentu dari thumbnail
     */
    public function selectImage(string $image): void
    {
        if (in_array($image, $this->images)) {
            $this->selectedImage = $image;
        }
    }

    public function mount(Product $product): void
    {
        $this->product = $product;

        $path = storage_path("app/public/products/{$product->id}");

        if (File::exists($path)) {
            $this->images = collect(File::files($path))
                ->map(fn ($file) => $file->getFilename())
                ->sort()
                ->values()
                ->all();
        }

        // Fallback jika tidak ada gambar
        $this->selectedImage = $this->images[0] ?? 'default.png';
    }

    public function render()
    {
        return view('livewire.shop.product-detail');
    }
}
