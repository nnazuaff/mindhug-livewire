<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public bool $showModal = false;

    public string $name = '';

    public ?int $categoryId = null;

    public string $description = '';

    public string $badge = '';

    public int $price = 0;

    public int $stock = 0;

    public bool $isActive = true;

    public array $photos = [];

    public array $croppedPhotos = []; // base64 hasil crop

    public bool $isDropship = false;

    public int $shopeePrice = 0;

    public int $markup = 0;

    public string $shopeeLink = '';

    protected $listeners = ['openCreateProduct' => 'openModal'];

    public function updatedIsDropship(): void
    {
        if ($this->isDropship && $this->shopeePrice > 0) {
            $this->price = $this->shopeePrice + $this->markup;
        }
    }

    public function updatedShopeePrice(): void
    {
        if ($this->isDropship) {
            $this->price = $this->shopeePrice + $this->markup;
        }
    }

    public function updatedMarkup(): void
    {
        if ($this->isDropship && $this->shopeePrice > 0) {
            $this->price = $this->shopeePrice + $this->markup;
        }
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['name', 'categoryId', 'description', 'badge', 'price', 'stock', 'photos', 'croppedPhotos', 'isDropship', 'shopeePrice', 'markup', 'shopeeLink']);
        $this->isActive = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function addCroppedPhoto(string $base64): void
    {
        if (count($this->croppedPhotos) >= 8) {
            return;
        }
        $this->croppedPhotos[] = $base64;
    }

    public function removeCroppedPhoto(int $index): void
    {
        array_splice($this->croppedPhotos, $index, 1);
    }

    public function createProduct(): void
    {
        $this->validate([
            'name' => 'required|string|max:150|unique:products,name',
            'categoryId' => 'nullable|exists:categories,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'croppedPhotos' => 'required|array|min:1|max:8',
            'shopeeLink' => 'nullable|url|max:255',
            'shopeePrice' => 'nullable|integer|min:0',
            'markup' => 'nullable|integer|min:0',
        ], [
            'croppedPhotos.required' => 'Minimal 1 foto produk wajib diunggah.',
            'croppedPhotos.max' => 'Maksimal 8 foto per produk.',
            'name.unique' => 'Nama produk sudah digunakan.',
        ]);

        $product = Product::create([
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'description' => $this->description,
            'badge' => $this->badge,
            'price' => $this->price,
            'stock' => $this->stock,
            'shopee_price' => $this->isDropship ? $this->shopeePrice : 0,
            'markup' => $this->isDropship ? $this->markup : 0,
            'shopee_link' => $this->isDropship ? $this->shopeeLink : null,
            'is_active' => $this->isActive,
        ]);

        Storage::disk('public')->makeDirectory('products/'.$product->id);
        Storage::disk('public')->deleteDirectory('products/'.$product->id);
        Storage::disk('public')->makeDirectory('products/'.$product->id);

        foreach ($this->croppedPhotos as $i => $base64) {
            $img = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
            $img = base64_decode($img);
            $filename = Str::random(16).'.webp';
            Storage::disk('public')->put('products/'.$product->id.'/'.$filename, $img);
        }

        $this->closeModal();
        $this->dispatch('productCreated');
        session()->flash('success', 'Produk berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.products.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
