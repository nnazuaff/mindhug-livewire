<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;
    public ?int $categoryId = null;
    public string $name = '';
    public string $description = '';

    protected $listeners = ['openEditCategory' => 'openModal'];

    public function openModal(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        $this->categoryId = $categoryId;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['categoryId', 'name', 'description']);
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$this->categoryId,
        ]);

        Category::findOrFail($this->categoryId)->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        $this->closeModal();
        $this->dispatch('categoryUpdated');
        $this->dispatch('notify', type: 'success', message: 'Kategori berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.categories.edit');
    }
}
