<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public Order $order;

    public string $cancelReason = '';

    public function requestCancel(int $orderId): void
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            return;
        }

        if (empty(trim($this->cancelReason))) {
            return;
        }

        $order->update([
            'cancel_reason' => $this->cancelReason,
            'cancel_requested_at' => now(),
            'status' => 'cancel_requested',
        ]);

        $order->trackingEvents()->create([
            'occurred_at' => now(),
            'title' => 'Request Pembatalan',
            'description' => 'User mengajukan pembatalan: '.$this->cancelReason,
        ]);

        $this->cancelReason = '';
        $this->order->refresh();
        $this->order->load(['items', 'trackingEvents' => fn ($q) => $q->orderByDesc('occurred_at')]);
    }

    public function mount(Order $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $this->order = $order->load(['items', 'trackingEvents' => fn ($q) => $q->orderByDesc('occurred_at')]);
    }

    #[On('order-updated')]
    public function refreshOrder(): void
    {
        $this->order->refresh();
        $this->order->load(['items', 'trackingEvents' => fn ($q) => $q->orderByDesc('occurred_at')]);
    }

    public function render()
    {
        return view('livewire.orders.show');
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'awaiting_payment' => 'Menunggu Pembayaran',
            'awaiting_confirmation' => 'Menunggu Konfirmasi',
            'cancel_requested' => 'Request Pembatalan',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $status,
        };
    }

    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'awaiting_payment' => 'bg-amber-100 text-amber-800 border-amber-200',
            'awaiting_confirmation' => 'bg-blue-100 text-blue-800 border-blue-200',
            'cancel_requested' => 'bg-orange-100 text-orange-800 border-orange-200',
            'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
            'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
            default => 'bg-stone-100 text-stone-800 border-stone-200',
        };
    }
}
