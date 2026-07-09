<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->reset('search');
        $this->resetPage();
    }

    #[On('order-updated')]
    public function refreshOrders(): void {}

    public function render()
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->when($this->search, fn ($q) => $q->where('invoice_number', 'like', '%'.$this->search.'%'))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->withCount('items')
            ->with(['items'])
            ->with(['items', 'latestTrackingEvent'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.orders.index', ['orders' => $orders]);
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
