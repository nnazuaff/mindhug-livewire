<?php

namespace App\Http\Livewire\Upgrade;

use App\Models\SubscriptionOrder;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{
    public SubscriptionOrder $order;

    public ?string $snapToken = null;

    public function mount(SubscriptionOrder $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $this->order = $order->load(['plan']);

        if ($this->order->status === 'awaiting_payment' && $this->order->snap_token) {
            $flag = 'snap_auto_upgrade_'.$this->order->id;
            if (! session()->has($flag)) {
                $this->snapToken = $this->order->snap_token;
                session()->put($flag, true);
            }
        }
    }

    public function openSnap(): void
    {
        if ($this->order->status !== 'awaiting_payment') {
            return;
        }

        if ($this->order->snap_token) {
            $this->snapToken = $this->order->snap_token;
        } else {
            $token = app(MidtransService::class)->createSnapTokenForUpgrade($this->order);
            if ($token) {
                $this->snapToken = $token;
            } else {
                $this->dispatch('notify', type: 'error', message: 'Gagal membuat sesi pembayaran.');

                return;
            }
        }

        session()->forget('snap_auto_upgrade_'.$this->order->id);
        $this->dispatch('snap-open');
    }

    public function render()
    {
        return view('livewire.upgrade.order-detail')->layout('components.layouts.app', [
            'title' => 'Detail Langganan - MindHug',
        ]);
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'awaiting_payment' => 'Menunggu Pembayaran',
            'awaiting_confirmation' => 'Menunggu Konfirmasi',
            'completed' => 'Aktif',
            'cancelled' => 'Dibatalkan',
            default => $status,
        };
    }

    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'awaiting_payment' => 'bg-amber-100 text-amber-800 border-amber-200',
            'awaiting_confirmation' => 'bg-blue-100 text-blue-800 border-blue-200',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
            default => 'bg-stone-100 text-stone-800 border-stone-200',
        };
    }
}
