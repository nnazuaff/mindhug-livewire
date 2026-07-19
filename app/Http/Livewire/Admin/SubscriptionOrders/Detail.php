<?php

namespace App\Http\Livewire\Admin\SubscriptionOrders;

use App\Models\SubscriptionOrder;
use App\Services\SubscriptionService;
use Livewire\Component;

class Detail extends Component
{
    public bool $showModal = false;

    public ?int $orderId = null;

    public ?SubscriptionOrder $order = null;

    protected $listeners = ['openSubscriptionDetail' => 'openModal'];

    public function openModal(int $orderId): void
    {
        $this->orderId = $orderId;
        $this->order = SubscriptionOrder::with(['user', 'plan'])->find($orderId);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->orderId = null;
        $this->order = null;
    }

    public function confirmOrder(): void
    {
        if (! $this->order || $this->order->status !== 'awaiting_confirmation') {
            return;
        }

        app(SubscriptionService::class)->confirmOrder($this->order);
        $this->order->refresh();
        $this->dispatch('refreshSubscriptionOrders');
        $this->dispatch('notify', type: 'success', message: 'Upgrade berhasil dikonfirmasi. User sekarang Plus.');
    }

    public function rejectOrder(): void
    {
        if (! $this->order || $this->order->status !== 'awaiting_confirmation') {
            return;
        }

        app(SubscriptionService::class)->rejectOrder($this->order);
        $this->order->refresh();
        $this->dispatch('refreshSubscriptionOrders');
        $this->dispatch('notify', type: 'success', message: 'Upgrade ditolak.');
    }

    public function render()
    {
        return view('livewire.admin.subscription-orders.detail');
    }
}
