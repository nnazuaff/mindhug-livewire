<?php

namespace App\Http\Livewire\Admin\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['paymentMethodCreated' => '$refresh', 'paymentMethodUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteMethod(int $id): void
    {
        $method = PaymentMethod::findOrFail($id);
        if ($method->icon) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($method->icon);
        }
        $method->delete();
        $this->dispatch('notify', type: 'success', message: 'Metode pembayaran berhasil dihapus.');
    }

    public function render()
    {
        $methods = PaymentMethod::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('sort_order')
            ->paginate(15);

        return view('livewire.admin.payment-methods.index', [
            'methods' => $methods,
        ])->layout('components.layouts.admin');
    }
}
