<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public string $customerSearch = '';

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    public ?int $viewingOrderId = null;

    public ?Order $viewingOrder = null;

    public string $rejectReason = '';

    public string $cancelReason = '';

    public string $rejectPaymentReason = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'customerSearch' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingCustomerSearch(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'customerSearch', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    #[On('order-updated')]
    public function refreshOrders(): void {}

    public function viewOrder(int $orderId): void
    {
        $this->viewingOrderId = $orderId;
        $this->viewingOrder = Order::with(['items', 'trackingEvents', 'user'])->find($orderId);
    }

    public function closeDetail(): void
    {
        $this->viewingOrderId = null;
        $this->viewingOrder = null;
    }

    public function confirmPayment(int $orderId): void
    {
        $order = Order::findOrFail($orderId);
        if ($order->status === 'awaiting_confirmation') {
            app(OrderService::class)->updateStatus($order, 'processing', 'Pembayaran Dikonfirmasi', 'Pembayaran telah dikonfirmasi oleh admin. Pesanan sedang diproses.');
            $this->viewingOrder->refresh();
            $this->dispatch('order-updated');
            $this->dispatch('notify', type: 'success', message: 'Pembayaran berhasil dikonfirmasi.');
        }
    }

    public function rejectPayment(int $orderId): void
    {
        if (empty(trim($this->rejectPaymentReason))) {
            $this->dispatch('notify', type: 'error', message: 'Alasan penolakan harus diisi.');

            return;
        }
        $order = Order::findOrFail($orderId);
        if ($order->status !== 'awaiting_confirmation') {
            return;
        }

        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }
        $order->update(['status' => 'awaiting_payment', 'payment_proof' => null]);
        $order->trackingEvents()->create(['occurred_at' => now(), 'title' => 'Pembayaran Ditolak', 'description' => 'Admin menolak bukti pembayaran: '.$this->rejectPaymentReason]);
        $this->rejectPaymentReason = '';
        $this->viewingOrder->refresh();
        $this->dispatch('order-updated');
        $this->dispatch('notify', type: 'success', message: 'Pembayaran ditolak. Pesanan kembali ke status menunggu pembayaran.');
    }

    public function rejectCancelRequest(int $orderId): void
    {
        if (empty(trim($this->rejectReason))) {
            $this->dispatch('notify', type: 'error', message: 'Alasan penolakan harus diisi.');

            return;
        }
        $order = Order::findOrFail($orderId);
        if ($order->status !== 'cancel_requested') {
            return;
        }

        $order->update(['status' => 'awaiting_payment', 'cancel_rejected_reason' => $this->rejectReason, 'cancel_requested_at' => null]);
        $order->trackingEvents()->create(['occurred_at' => now(), 'title' => 'Pembatalan Ditolak', 'description' => 'Admin menolak permintaan pembatalan: '.$this->rejectReason]);
        $this->rejectReason = '';
        $this->viewingOrder->refresh();
        $this->dispatch('order-updated');
        $this->dispatch('notify', type: 'success', message: 'Permintaan pembatalan ditolak. Pesanan kembali ke status pembayaran.');
    }

    public function cancelOrder(int $orderId): void
    {
        if (empty(trim($this->cancelReason))) {
            $this->dispatch('notify', type: 'error', message: 'Alasan pembatalan harus diisi.');

            return;
        }
        $order = Order::findOrFail($orderId);
        if (! in_array($order->status, ['delivered', 'cancelled'])) {
            app(OrderService::class)->updateStatus($order, 'cancelled', 'Pesanan Dibatalkan', 'Alasan: '.$this->cancelReason, $this->cancelReason);
            $this->viewingOrder->refresh();
            $this->cancelReason = '';
            $this->dispatch('order-updated');
            $this->dispatch('notify', type: 'success', message: 'Pesanan berhasil dibatalkan.');
        }
    }

    public function updateStatus(int $orderId, string $newStatus): void
    {
        $order = Order::findOrFail($orderId);
        $statusMap = [
            'processing' => ['title' => 'Pesanan Diproses', 'desc' => 'Pesanan sedang disiapkan.'],
            'shipped' => ['title' => 'Pesanan Dikirim', 'desc' => 'Pesanan telah dikirim ke alamat tujuan.'],
            'delivered' => ['title' => 'Pesanan Selesai', 'desc' => 'Pesanan telah diterima.'],
            'cancelled' => ['title' => 'Pesanan Dibatalkan', 'desc' => 'Pesanan dibatalkan.'],
        ];
        if (isset($statusMap[$newStatus])) {
            app(OrderService::class)->updateStatus($order, $newStatus, $statusMap[$newStatus]['title'], $statusMap[$newStatus]['desc']);
            $this->viewingOrder->refresh();
            $this->dispatch('order-updated');
            $this->dispatch('notify', type: 'success', message: 'Status pesanan berhasil diperbarui.');
        }
    }

    public function render()
    {
        $orders = Order::query()
            ->with('user')
            ->withCount('items')
            ->when($this->search, fn ($q) => $q->where('invoice_number', 'like', '%'.$this->search.'%'))
            ->when($this->customerSearch, fn ($q) => $q->whereHas('user', fn ($uq) => $uq->where('full_name', 'like', '%'.$this->customerSearch.'%')->orWhere('email', 'like', '%'.$this->customerSearch.'%')))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.orders', ['orders' => $orders])->layout('components.layouts.admin');
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'awaiting_payment' => 'Menunggu Bayar',
            'awaiting_confirmation' => 'Menunggu Konfirmasi',
            'cancel_requested' => 'Request Batal',
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
            'awaiting_payment' => 'bg-amber-100 text-amber-700',
            'awaiting_confirmation' => 'bg-blue-100 text-blue-700',
            'cancel_requested' => 'bg-orange-100 text-orange-700',
            'processing' => 'bg-indigo-100 text-indigo-700',
            'shipped' => 'bg-purple-100 text-purple-700',
            'delivered' => 'bg-emerald-100 text-emerald-700',
            'cancelled' => 'bg-rose-100 text-rose-700',
            default => 'bg-stone-100 text-stone-700',
        };
    }
}
