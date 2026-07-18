<?php

namespace App\Http\Livewire\Admin;

use App\Models\SubscriptionOrder;
use App\Services\SubscriptionService;
use Livewire\Component;
use Livewire\WithPagination;

class SubscriptionOrders extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public ?int $viewingId = null;

    public ?SubscriptionOrder $viewingOrder = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

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

    public function confirmOrder(int $id): void
    {
        $order = SubscriptionOrder::findOrFail($id);
        if ($order->status === 'awaiting_confirmation') {
            app(SubscriptionService::class)->confirmOrder($order);
            $this->viewingOrder->refresh();
            $this->dispatch('notify', type: 'success', message: 'Upgrade berhasil dikonfirmasi. User sekarang Plus.');
        }
    }

    public function rejectOrder(int $id): void
    {
        $order = SubscriptionOrder::findOrFail($id);
        if ($order->status === 'awaiting_confirmation') {
            app(SubscriptionService::class)->rejectOrder($order);
            $this->viewingOrder->refresh();
            $this->dispatch('notify', type: 'success', message: 'Upgrade ditolak.');
        }
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

        return view('livewire.admin.subscription-orders', ['orders' => $orders])
            ->layout('components.layouts.admin');
    }
}
