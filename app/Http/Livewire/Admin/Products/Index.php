<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $categoryFilter = null;

    public string $statusFilter = '';

    public string $dropshipFilter = '';

    public string $sortBy = '';

    public ?int $viewingProductId = null;

    public ?Product $viewingProduct = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'dropshipFilter' => ['except' => ''],
        'sortBy' => ['except' => ''],
    ];

    protected $listeners = ['productCreated' => '$refresh', 'productUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDropshipFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSortBy(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'categoryFilter', 'statusFilter', 'dropshipFilter', 'sortBy']);
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
        $this->dispatch('notify', type: 'success', message: 'Status produk berhasil diubah.');
    }

    public function deleteProduct(int $productId): void
    {
        Product::findOrFail($productId)->delete();
        if ($this->viewingProductId === $productId) {
            $this->closeDetail();
        }
        $this->dispatch('notify', type: 'success', message: 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('id', 'like', '%'.$this->search.'%')
                    ->orWhere('name', 'like', '%'.$this->search.'%');
            }))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->statusFilter === 'active', fn ($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn ($q) => $q->where('is_active', false))
            ->when($this->dropshipFilter === 'yes', fn ($q) => $q->where(function ($q) {
                $q->where('shopee_price', '>', 0)->orWhereNotNull('shopee_link')->where('shopee_link', '!=', '');
            }))
            ->when($this->dropshipFilter === 'no', fn ($q) => $q->where(function ($q) {
                $q->where('shopee_price', 0)->where(function ($q) {
                    $q->whereNull('shopee_link')->orWhere('shopee_link', '');
                });
            }))
            ->when($this->sortBy === 'price_asc', fn ($q) => $q->orderBy('price', 'asc'))
            ->when($this->sortBy === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->when($this->sortBy === 'stock_asc', fn ($q) => $q->orderBy('stock', 'asc'))
            ->when($this->sortBy === 'stock_desc', fn ($q) => $q->orderBy('stock', 'desc'))
            ->when($this->sortBy === 'oldest', fn ($q) => $q->orderBy('created_at', 'asc'))
            ->when(empty($this->sortBy) || $this->sortBy === 'newest', fn ($q) => $q->orderByDesc('created_at'))
            ->paginate(15);

        return view('livewire.admin.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ])->layout('components.layouts.admin');
    }
}
