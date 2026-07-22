<?php

namespace App\Http\Livewire\Admin\SubscriptionPlans;

use App\Models\SubscriptionPlan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['planCreated' => '$refresh', 'planUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        SubscriptionPlan::findOrFail($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Paket berhasil dihapus.');
    }

    public function render()
    {
        $plans = SubscriptionPlan::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('price')
            ->paginate(15);

        return view('livewire.admin.subscription-plans.index', [
            'plans' => $plans,
        ])->layout('components.layouts.admin');
    }
}
