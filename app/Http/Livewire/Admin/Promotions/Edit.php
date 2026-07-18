<?php

namespace App\Http\Livewire\Admin\Promotions;

use App\Models\Promotion;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;

    public ?int $promotionId = null;

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

    protected $listeners = ['openEditPromotion' => 'openModal'];

    public function openModal(int $promotionId): void
    {
        $promo = Promotion::findOrFail($promotionId);
        $this->promotionId = $promotionId;
        $this->code = $promo->code;
        $this->type = $promo->type;
        $this->value = $promo->value;
        $this->minOrder = $promo->min_order;
        $this->maxDiscount = $promo->max_discount;
        $this->maxUses = $promo->max_uses;
        $this->startsDate = $promo->starts_date?->format('Y-m-d');
        $this->startsTime = $promo->starts_time ? substr($promo->starts_time, 0, 5) : null;
        $this->endsDate = $promo->ends_date?->format('Y-m-d');
        $this->endsTime = $promo->ends_time ? substr($promo->ends_time, 0, 5) : null;
        $this->isActive = $promo->is_active;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['promotionId', 'code', 'type', 'value', 'minOrder', 'maxDiscount', 'maxUses', 'startsDate', 'startsTime', 'endsDate', 'endsTime']);
        $this->type = 'fixed';
        $this->isActive = true;
    }

    public function update(): void
    {
        $this->validate([
            'code' => 'required|string|max:50|unique:promotions,code,'.$this->promotionId,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|integer|min:1',
        ]);

        Promotion::findOrFail($this->promotionId)->update([
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'min_order' => $this->minOrder,
            'max_discount' => $this->maxDiscount,
            'max_uses' => $this->maxUses,
            'starts_date' => blank($this->startsDate) ? null : $this->startsDate,
            'starts_time' => blank($this->startsTime) ? null : $this->startsTime,
            'ends_date' => blank($this->endsDate) ? null : $this->endsDate,
            'ends_time' => blank($this->endsTime) ? null : $this->endsTime,
            'is_active' => $this->isActive,
        ]);

        $this->closeModal();
        $this->dispatch('promotionUpdated');
        $this->dispatch('notify', type: 'success', message: 'Voucher berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.promotions.edit');
    }
}
