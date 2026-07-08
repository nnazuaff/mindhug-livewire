<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pay extends Component
{
    use WithFileUploads;

    public Order $order;
    public $paymentProof;
    public bool $uploaded = false;

    public function mount(Order $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'awaiting_payment') {
            redirect()->route('orders.show', $order->invoice_number);
        }

        $this->order = $order;
    }

    public function uploadProof(): void
    {
        $this->validate([
            'paymentProof' => 'required|file|mimes:jpg,png|max:5120',
        ], [
            'paymentProof.required' => 'Silakan pilih file bukti pembayaran.',
            'paymentProof.file'     => 'Harus berupa file.',
            'paymentProof.mimes'    => 'Format yang didukung: JPG dan PNG.',
            'paymentProof.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $path = $this->paymentProof->store('payment-proofs', 'public');

        $this->order->update([
            'payment_proof' => $path,
            'status'        => 'awaiting_confirmation',
        ]);

        $this->order->trackingEvents()->create([
            'occurred_at' => now(),
            'title'       => 'Bukti Pembayaran Diunggah',
            'description' => 'Menunggu konfirmasi dari admin.',
        ]);

        $this->uploaded = true;
    }

    public function render()
    {
        return view('livewire.orders.pay');
    }
}
