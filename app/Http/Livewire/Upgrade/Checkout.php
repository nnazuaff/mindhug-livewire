<?php

namespace App\Http\Livewire\Upgrade;

use App\Models\PaymentMethod;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Checkout extends Component
{
    use WithFileUploads;

    public SubscriptionPlan $plan;

    public $paymentProof;

    public bool $uploaded = false;

    public ?int $selectedPayment = null;

    public array $paymentMethods = [];

    public function mount(SubscriptionPlan $plan): void
    {
        if ($plan->slug !== 'plus-bulanan' || ! $plan->is_active) {
            abort(404);
        }
        $this->plan = $plan;
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
    }

    public function uploadProof(): void
    {
        $this->validate([
            'paymentProof' => 'required|file|mimes:jpg,png|max:5120',
            'selectedPayment' => 'required|integer',
        ], [
            'paymentProof.required' => 'Silakan pilih file bukti pembayaran.',
            'paymentProof.mimes' => 'Format yang didukung: JPG dan PNG.',
            'paymentProof.max' => 'Ukuran file maksimal 5MB.',
            'selectedPayment.required' => 'Pilih metode pembayaran.',
        ]);

        $method = collect($this->paymentMethods)->firstWhere('id', $this->selectedPayment);

        $path = $this->paymentProof->store('payment-proofs', 'public');

        $order = app(SubscriptionService::class)->createOrder(
            auth()->id(),
            $this->plan->id,
            $this->plan->price
        );

        $order->update([
            'payment_proof' => $path,
            'payment_method' => $method['label'] ?? 'Unknown',
            'status' => 'awaiting_confirmation',
        ]);

        $this->uploaded = true;
    }

    public function render()
    {
        return view('livewire.upgrade.checkout');
    }
}
