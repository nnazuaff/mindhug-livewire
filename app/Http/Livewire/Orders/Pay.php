<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
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

        // Hanya bisa bayar kalau status awaiting_payment
        if ($order->status !== 'awaiting_payment') {
            redirect()->route('orders.show', $order->invoice_number);
        }

        $this->order = $order;
    }

    public function uploadProof(): void
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048', // max 2MB
        ], [
            'paymentProof.required' => 'Silakan pilih file bukti pembayaran.',
            'paymentProof.image' => 'File harus berupa gambar (JPG, PNG).',
            'paymentProof.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Simpan file
        $path = $this->paymentProof->store('payment-proofs', 'public');

        // Update order
        $this->order->update([
            'payment_proof' => $path,
            'status' => 'awaiting_confirmation',
        ]);

        // Tracking event
        $this->order->trackingEvents()->create([
            'occurred_at' => now(),
            'title' => 'Bukti Pembayaran Diunggah',
            'description' => 'Menunggu konfirmasi dari admin.',
        ]);

        $this->uploaded = true;
    }

    public function render()
    {
        return view('livewire.orders.pay');
    }
}
