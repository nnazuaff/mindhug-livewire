<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $viewingCategoryId = null;

    public ?Category $viewingCategory = null;

    protected $listeners = ['categoryCreated' => '$refresh', 'categoryUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function viewCategory(int $id): void
    {
        $this->viewingCategoryId = $id;
        $this->viewingCategory = Category::withCount('products')->find($id);
    }

    public function closeDetail(): void
    {
        $this->viewingCategoryId = null;
        $this->viewingCategory = null;
    }

    public function deleteCategory(int $id): void
    {
        Category::findOrFail($id)->delete();
        if ($this->viewingCategoryId === $id) {
            $this->closeDetail();
        }
        $this->dispatch('notify', type: 'success', message: 'Kategori berhasil dihapus.');
    }

    public function render()
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.categories.index', [
            'categories' => $categories,
        ])->layout('components.layouts.admin');
    }
}
