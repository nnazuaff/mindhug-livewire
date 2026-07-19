<?php

namespace App\Http\Livewire\Upgrade;

use App\Models\SubscriptionOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrderPay extends Component
{
    use WithFileUploads;

    public SubscriptionOrder $order;

    public $paymentProof;

    public bool $uploaded = false;

    public function mount(SubscriptionOrder $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'awaiting_payment') {
            redirect()->route('plus.orders.show', $order->invoice_number);
        }

        $this->order = $order;
    }

    public function uploadProof(): void
    {
        $this->validate([
            'paymentProof' => 'required|file|mimes:jpg,png|max:5120',
        ], [
            'paymentProof.required' => 'Silakan pilih file bukti pembayaran.',
            'paymentProof.mimes' => 'Format yang didukung: JPG dan PNG.',
            'paymentProof.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $path = $this->paymentProof->store('payment-proofs', 'public');

        $this->order->update([
            'payment_proof' => $path,
            'status' => 'awaiting_confirmation',
        ]);

        $this->uploaded = true;
    }

    public function render()
    {
        return view('livewire.upgrade.order-pay')
            ->layout('components.layouts.app', ['title' => 'Pembayaran - '.$this->order->invoice_number]);
    }
}
