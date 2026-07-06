<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $viewingProductId = null;

    public ?Product $viewingProduct = null;

    protected $listeners = ['productCreated' => '$refresh', 'productUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function viewProduct(int $productId): void
    {
        $this->viewingProductId = $productId;
        $this->viewingProduct = Product::with('category')->find($productId);
    }

    public function closeDetail(): void
    {
        $this->viewingProductId = null;
        $this->viewingProduct = null;
    }

    public function toggleActive(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_active' => ! $product->is_active]);
        session()->flash('success', 'Status produk berhasil diubah.');
    }

    public function deleteProduct(int $productId): void
    {
        Product::findOrFail($productId)->delete();
        if ($this->viewingProductId === $productId) {
            $this->closeDetail();
        }
        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.products.index', [
            'products' => $products,
        ])->layout('components.layouts.admin');
    }
}
