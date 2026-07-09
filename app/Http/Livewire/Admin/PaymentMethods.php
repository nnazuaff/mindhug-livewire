<?php

namespace App\Http\Livewire\Admin;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentMethods extends Component
{
    use WithFileUploads;

    public string $search = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    // Form fields
    public string $code = '';

    public string $name = '';

    public string $subtitle = '';

    public $icon;

    public ?string $existingIcon = null;

    public bool $isActive = true;

    public int $sortOrder = 0;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $method = PaymentMethod::findOrFail($id);
        $this->editingId = $id;
        $this->code = $method->code;
        $this->name = $method->name;
        $this->subtitle = $method->subtitle ?? '';
        $this->existingIcon = $method->icon;
        $this->isActive = $method->is_active;
        $this->sortOrder = $method->sort_order;
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->code = '';
        $this->name = '';
        $this->subtitle = '';
        $this->icon = null;
        $this->existingIcon = null;
        $this->isActive = true;
        $this->sortOrder = 0;
    }

    public function removeIcon(): void
    {
        $this->icon = null;
        if ($this->editingId) {
            $method = PaymentMethod::find($this->editingId);
            if ($method->icon) {
                Storage::disk('public')->delete($method->icon);
                $method->update(['icon' => null]);
                $this->existingIcon = null;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'code' => 'required|string|max:50|unique:payment_methods,code,'.$this->editingId,
            'name' => 'required|string|max:100',
            'icon' => $this->editingId ? 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:1024'
            : 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ]);

        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
        ];

        // Upload icon
        if ($this->icon) {
            // Hapus icon lama
            if ($this->editingId) {
                $method = PaymentMethod::find($this->editingId);
                if ($method->icon) {
                    Storage::disk('public')->delete($method->icon);
                }
            }
            $data['icon'] = $this->icon->store('payment-methods', 'public');
        }

        if ($this->editingId) {
            PaymentMethod::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Metode pembayaran berhasil diperbarui.');
        } else {
            PaymentMethod::create($data);
            session()->flash('success', 'Metode pembayaran berhasil ditambahkan.');
        }

        $this->closeForm();
    }

    public function delete(int $id): void
    {
        $method = PaymentMethod::findOrFail($id);
        if ($method->icon) {
            Storage::disk('public')->delete($method->icon);
        }
        $method->delete();
        session()->flash('success', 'Metode pembayaran berhasil dihapus.');
    }

    public function render()
    {
        $methods = PaymentMethod::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('sort_order')
            ->paginate(15);

        return view('livewire.admin.payment-methods', [
            'methods' => $methods,
        ])->layout('components.layouts.admin');
    }
}
