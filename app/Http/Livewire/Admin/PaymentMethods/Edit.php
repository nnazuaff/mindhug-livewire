<?php

namespace App\Http\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?int $methodId = null;
    public string $code = '';
    public string $name = '';
    public string $subtitle = '';
    public $icon;
    public ?string $existingIcon = null;
    public bool $isActive = true;
    public int $sortOrder = 0;

    protected $listeners = ['openEditPaymentMethod' => 'openModal'];

    public function openModal(int $methodId): void
    {
        $method = PaymentMethod::findOrFail($methodId);
        $this->methodId = $methodId;
        $this->code = $method->code;
        $this->name = $method->name;
        $this->subtitle = $method->subtitle ?? '';
        $this->existingIcon = $method->icon;
        $this->isActive = $method->is_active;
        $this->sortOrder = $method->sort_order;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['methodId', 'code', 'name', 'subtitle', 'icon', 'existingIcon', 'isActive', 'sortOrder']);
    }

    public function removeIcon(): void
    {
        if ($this->methodId) {
            $method = PaymentMethod::find($this->methodId);
            if ($method->icon) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($method->icon);
                $method->update(['icon' => null]);
                $this->existingIcon = null;
                $this->icon = null;
            }
        }
    }

    public function update(): void
    {
        $this->validate([
            'code' => 'required|string|max:50|unique:payment_methods,code,'.$this->methodId,
            'name' => 'required|string|max:100',
            'icon' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ]);

        $method = PaymentMethod::findOrFail($this->methodId);

        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
        ];

        if ($this->icon) {
            if ($method->icon) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($method->icon);
            }
            $data['icon'] = $this->icon->store('payment-methods', 'public');
        }

        $method->update($data);

        $this->closeModal();
        $this->dispatch('paymentMethodUpdated');
        $this->dispatch('notify', type: 'success', message: 'Metode pembayaran berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.payment-methods.edit');
    }
}
