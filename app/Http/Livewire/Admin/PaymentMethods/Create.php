<?php

namespace App\Http\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public string $code = '';
    public string $name = '';
    public string $subtitle = '';
    public $icon;
    public bool $isActive = true;
    public int $sortOrder = 0;

    protected $listeners = ['openCreatePaymentMethod' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['code', 'name', 'subtitle', 'icon', 'isActive', 'sortOrder']);
        $this->isActive = true;
        $this->sortOrder = 0;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $this->validate([
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'name' => 'required|string|max:100',
            'icon' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ]);

        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
        ];

        if ($this->icon) {
            $data['icon'] = $this->icon->store('payment-methods', 'public');
        }

        PaymentMethod::create($data);

        $this->closeModal();
        $this->dispatch('paymentMethodCreated');
        $this->dispatch('notify', type: 'success', message: 'Metode pembayaran berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.payment-methods.create');
    }
}
