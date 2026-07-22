<?php

namespace App\Http\Livewire\Upgrade;

use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public ?array $upgradePlan = null;

    public string $paymentNotice = '';

    public function mount(): void
    {
        $this->upgradePlan = session()->get('upgrade_plan');
        if (empty($this->upgradePlan)) {
            $this->redirectRoute('plus');

            return;
        }
    }

    public function placeOrder(): void
    {
        if (! $this->upgradePlan) {
            return;
        }

        $order = app(SubscriptionService::class)->createOrder(
            Auth::id(),
            $this->upgradePlan['id'],
            $this->upgradePlan['price']
        );

        session()->forget('upgrade_plan');

        $this->redirect(route('plus.orders.show', $order->invoice_number), navigate: true);
    }

    public function render()
    {
        return view('livewire.upgrade.checkout', [
            'plan' => $this->upgradePlan,
        ])->layout('components.layouts.app', ['title' => 'Checkout Plus - MindHug']);
    }
}
