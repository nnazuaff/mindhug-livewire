<?php

namespace App\Http\Livewire\Admin\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public bool $showModal = false;

    public string $name = '';

    public string $features = '';

    public int $price = 0;

    public int $durationDays = 30;

    public bool $isActive = true;

    protected $listeners = ['openCreatePlan' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['name', 'features', 'price', 'durationDays']);
        $this->isActive = true;
        $this->price = 0;
        $this->durationDays = 30;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'durationDays' => 'required|integer|min:1',
        ]);

        $featuresArray = ! empty(trim($this->features))
            ? array_map('trim', explode("\n", $this->features))
            : [];

        SubscriptionPlan::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'features' => $featuresArray,
            'price' => $this->price,
            'duration_days' => $this->durationDays,
            'is_active' => $this->isActive,
        ]);

        $this->closeModal();
        $this->dispatch('planCreated');
        $this->dispatch('notify', type: 'success', message: 'Paket berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.subscription-plans.create');
    }
}
