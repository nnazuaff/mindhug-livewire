<?php

namespace App\Http\Livewire\Admin\Promotions;

use App\Models\Promotion;
use Livewire\Component;

class Create extends Component
{
    public bool $showModal = false;

    public string $code = '';

    public string $type = 'fixed';

    public int $value = 0;

    public int $minOrder = 0;

    public ?int $maxDiscount = null;

    public ?int $maxUses = null;

    public ?string $startsDate = null;

    public ?string $startsTime = null;

    public ?string $endsDate = null;

    public ?string $endsTime = null;

    public bool $isActive = true;

    protected $listeners = ['openCreatePromotion' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['code', 'type', 'value', 'minOrder', 'maxDiscount', 'maxUses', 'startsDate', 'startsTime', 'endsDate', 'endsTime']);
        $this->type = 'fixed';
        $this->isActive = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $this->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|integer|min:1',
        ]);

        Promotion::create([
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'min_order' => $this->minOrder,
            'max_discount' => $this->maxDiscount,
            'max_uses' => $this->maxUses,
            'starts_date' => $this->startsDate,
            'starts_time' => $this->startsTime,
            'ends_date' => $this->endsDate,
            'ends_time' => $this->endsTime,
            'is_active' => $this->isActive,
        ]);

        $this->closeModal();
        $this->dispatch('promotionCreated');
        session()->flash('success', 'Voucher berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.promotions.create');
    }
}
