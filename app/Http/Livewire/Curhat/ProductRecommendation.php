<?php

namespace App\Http\Livewire\Curhat;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProductRecommendation extends Component
{
    public string $search = '';

    public ?int $categoryFilter = null;

    public string $sortBy = 'name_asc';

    public bool $showModal = false;

    public array $results = [];

    public ?int $selectedProduct = null;

    protected $listeners = ['openProductSearch' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->searchResults();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['search', 'categoryFilter', 'sortBy', 'results', 'selectedProduct']);
    }

    public function updatedSearch(): void
    {
        $this->searchResults();
    }

    public function updatedCategoryFilter(): void
    {
        $this->searchResults();
    }

    public function updatedSortBy(): void
    {
        $this->searchResults();
    }

    public function searchResults(): void
    {
        $this->results = Product::query()
            ->where('is_active', true)
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->sortBy === 'price_asc', fn ($q) => $q->orderBy('price', 'asc'))
            ->when($this->sortBy === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->when($this->sortBy === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortBy === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->take(20)
            ->get()
            ->map(function ($product) {
                $files = Storage::disk('public')->files('products/'.$product->id);
                $image = ! empty($files) ? basename($files[0]) : 'default.png';
                $product->image_url = asset('storage/products/'.$product->id.'/'.$image);

                return $product;
            })
            ->toArray();
    }

    public function confirmSelect(int $productId): void
    {
        $this->selectedProduct = $productId;
    }

    public function sendRecommendation(): void
    {
        if ($this->selectedProduct) {
            $this->dispatch('product-selected', productId: $this->selectedProduct);
            $this->selectedProduct = null;
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.curhat.product-recommendation', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
