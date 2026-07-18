<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public bool $showModal = false;
    public string $name = '';
    public string $description = '';

    protected $listeners = ['openCreateCategory' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['name', 'description']);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        $this->closeModal();
        $this->dispatch('categoryCreated');
        $this->dispatch('notify', type: 'success', message: 'Kategori berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.categories.create');
    }
}
