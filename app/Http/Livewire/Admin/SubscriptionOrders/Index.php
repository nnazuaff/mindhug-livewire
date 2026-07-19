<?php

namespace App\Http\Livewire\Admin\SubscriptionOrders;

use App\Models\SubscriptionOrder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public ?int $viewingId = null;
    public ?SubscriptionOrder $viewingOrder = null;

    protected $listeners = ['refreshSubscriptionOrders' => '$refresh'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }

    public function viewOrder(int $id): void
    {
        $this->viewingId = $id;
        $this->viewingOrder = SubscriptionOrder::with(['user', 'plan'])->find($id);
    }

    public function closeDetail(): void
    {
        $this->viewingId = null;
        $this->viewingOrder = null;
    }

    public function render()
    {
        $orders = SubscriptionOrder::query()
            ->with(['user', 'plan'])
            ->when($this->search, fn ($q) => $q->where('invoice_number', 'like', '%'.$this->search.'%')
                ->orWhereHas('user', fn ($uq) => $uq->where('full_name', 'like', '%'.$this->search.'%')))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.subscription-orders.index', [
            'orders' => $orders,
        ])->layout('components.layouts.admin');
    }
}
