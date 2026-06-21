<?php

namespace App\Http\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $q = '';

    public $sort = '';

    protected $queryString = ['q', 'sort'];

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($this->q, fn ($query) => $query->where(fn ($sub) => $sub
                ->where('name', 'like', '%'.$this->q.'%')
                ->orWhere('description', 'like', '%'.$this->q.'%')))
            ->when($this->sort === 'price_asc', fn ($query) => $query->orderBy('price', 'asc'))
            ->when($this->sort === 'price_desc', fn ($query) => $query->orderBy('price', 'desc'))
            ->when($this->sort === 'stock_asc', fn ($query) => $query->orderBy('stock', 'asc'))
            ->when($this->sort === 'stock_desc', fn ($query) => $query->orderBy('stock', 'desc'))
            ->when($this->sort === 'name_asc', fn ($query) => $query->orderBy('name', 'asc'))
            ->when($this->sort === 'name_desc', fn ($query) => $query->orderBy('name', 'desc'))
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('livewire.shop.index', [
            'products' => $products,
        ]);
    }
}
