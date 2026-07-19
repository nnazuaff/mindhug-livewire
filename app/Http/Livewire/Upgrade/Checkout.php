<?php

namespace App\Http\Livewire\Upgrade;

use App\Models\PaymentMethod;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Checkout extends Component
{
    public ?array $upgradePlan = null;

    public array $paymentMethods = [];

    public ?int $selectedPayment = null;

    public string $paymentNotice = '';

    public function mount(): void
    {
        $this->upgradePlan = session()->get('upgrade_plan');

        if (empty($this->upgradePlan)) {
            $this->redirectRoute('plus');

            return;
        }

        $this->loadPaymentMethods();
    }

    public function loadPaymentMethods(): void
    {
        if (! Schema::hasTable('payment_methods')) {
            $this->paymentMethods = [
                ['id' => 1, 'code' => 'bank_transfer', 'label' => 'Bank Transfer', 'subtitle' => 'Transfer antar bank', 'icon' => null],
                ['id' => 2, 'code' => 'ewallet', 'label' => 'E-Wallet', 'subtitle' => 'Dana / OVO / ShopeePay', 'icon' => null],
                ['id' => 3, 'code' => 'qris', 'label' => 'QRIS', 'subtitle' => 'Scan QR untuk bayar', 'icon' => null],
            ];

            return;
        }

        $this->paymentMethods = PaymentMethod::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'code' => $m->code,
                'label' => $m->name,
                'subtitle' => $m->subtitle,
                'icon' => $m->icon ? Storage::url($m->icon) : null,
            ])
            ->all();
    }

    public function selectPayment(int $methodId): void
    {
        $this->selectedPayment = $methodId;
        $this->paymentNotice = '';
    }

    public function placeOrder(): void
    {
        if (! $this->upgradePlan) {
            return;
        }

        if (! $this->selectedPayment) {
            $this->paymentNotice = 'Pilih metode pembayaran terlebih dahulu.';

            return;
        }

        $paymentMethod = collect($this->paymentMethods)->firstWhere('id', $this->selectedPayment);

        $order = app(SubscriptionService::class)->createOrder(
            Auth::id(),
            $this->upgradePlan['id'],
            $this->upgradePlan['price']
        );

        // Update payment method setelah create (karena service belum support)
        $order->update(['payment_method' => $paymentMethod['label'] ?? 'Unknown']);

        session()->forget('upgrade_plan');

        $this->redirect(route('plus.orders.pay', $order->invoice_number), navigate: true);
    }

    public function render()
    {

        return view('livewire.upgrade.checkout', [
            'plan' => $this->upgradePlan,
        ])->layout('components.layouts.app', ['title' => 'Checkout Plus - MindHug']);
    }
}
