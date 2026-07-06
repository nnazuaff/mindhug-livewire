<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public bool $showModal = false;

    public ?int $productId = null;

    public string $name = '';

    public ?int $categoryId = null;

    public string $description = '';

    public string $badge = '';

    public int $price = 0;

    public int $stock = 0;

    public bool $isActive = true;

    public array $existingPhotos = [];

    public array $croppedPhotos = [];

    public bool $isDropship = false;

    public int $shopeePrice = 0;

    public int $markup = 0;

    public string $shopeeLink = '';

    public array $deletedPhotos = [];

    protected $listeners = ['openEditProduct' => 'openModal'];

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

    public function openModal(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $this->productId = $productId;
        $this->name = $product->name;
        $this->categoryId = $product->category_id;
        $this->description = $product->description ?? '';
        $this->badge = $product->badge ?? '';
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->isActive = $product->is_active;
        $this->isDropship = $product->shopee_price > 0 || $product->shopee_link;
        $this->shopeePrice = $product->shopee_price;
        $this->markup = $product->markup;
        $this->shopeeLink = $product->shopee_link ?? '';
        $this->existingPhotos = Storage::disk('public')->files('products/'.$productId);
        $this->croppedPhotos = [];
        $this->deletedPhotos = [];
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->deletedPhotos = [];
    }

    public function deleteExistingPhoto(string $filename): void
    {
        // Tandai untuk dihapus nanti, jangan hapus sekarang
        $this->deletedPhotos[] = $filename;
        $this->existingPhotos = array_values(array_diff($this->existingPhotos, ['products/'.$this->productId.'/'.$filename]));
    }

    public function restoreDeletedPhoto(string $filename): void
    {
        // Kembalikan ke existing photos
        $this->deletedPhotos = array_values(array_diff($this->deletedPhotos, [$filename]));
        $this->existingPhotos[] = 'products/'.$this->productId.'/'.$filename;
    }

    public function addCroppedPhoto(string $base64): void
    {
        if ((count($this->existingPhotos) + count($this->croppedPhotos)) >= 8) {
            return;
        }
        $this->croppedPhotos[] = $base64;
    }

    public function removeCroppedPhoto(int $index): void
    {
        array_splice($this->croppedPhotos, $index, 1);
    }

    public function updateProduct(): void
    {
        $totalPhotos = count($this->existingPhotos) + count($this->croppedPhotos);

        $this->validate([
            'name' => 'required|string|max:150|unique:products,name,'.$this->productId,
            'categoryId' => 'nullable|exists:categories,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'shopeeLink' => 'nullable|url|max:255',
        ], [
            'name.unique' => 'Nama produk sudah digunakan.',
        ]);

        if ($totalPhotos < 1) {
            $this->addError('croppedPhotos', 'Minimal 1 foto produk.');

            return;
        }

        $product = Product::findOrFail($this->productId);
        $product->update([
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

        // Hapus foto yang ditandai
        foreach ($this->deletedPhotos as $filename) {
            Storage::disk('public')->delete('products/'.$this->productId.'/'.$filename);
        }

        // Upload foto baru
        if (! empty($this->croppedPhotos)) {
            foreach ($this->croppedPhotos as $base64) {
                $img = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
                $img = base64_decode($img);
                $filename = Str::random(16).'.webp';
                Storage::disk('public')->put('products/'.$this->productId.'/'.$filename, $img);
            }
        }

        $this->closeModal();
        $this->dispatch('productUpdated');
        session()->flash('success', 'Produk berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.products.edit', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
