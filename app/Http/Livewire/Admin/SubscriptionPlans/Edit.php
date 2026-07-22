<?php

namespace App\Http\Livewire\Admin\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;

    public ?int $planId = null;

    public string $name = '';

    public string $features = '';

    public int $price = 0;

    public int $durationDays = 30;

    public bool $isActive = true;

    protected $listeners = ['openEditPlan' => 'openModal'];

    public function openModal(int $planId): void
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $this->planId = $planId;
        $this->name = $plan->name;
        $this->features = implode("\n", $plan->features ?? []);
        $this->price = $plan->price;
        $this->durationDays = $plan->duration_days;
        $this->isActive = $plan->is_active;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['planId', 'name', 'features', 'price', 'durationDays']);
        $this->isActive = true;
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'durationDays' => 'required|integer|min:1',
        ]);

        $featuresArray = ! empty(trim($this->features))
            ? array_map('trim', explode("\n", $this->features))
            : [];

        SubscriptionPlan::findOrFail($this->planId)->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'features' => $featuresArray,
            'price' => $this->price,
            'duration_days' => $this->durationDays,
            'is_active' => $this->isActive,
        ]);

        $this->closeModal();
        $this->dispatch('planUpdated');
        $this->dispatch('notify', type: 'success', message: 'Paket berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.subscription-plans.edit');
    }
}
