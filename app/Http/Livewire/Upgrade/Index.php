<?php

namespace App\Http\Livewire\Upgrade;

use App\Models\SubscriptionOrder;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $plan = SubscriptionPlan::where('slug', 'plus-bulanan')->first();
        $pendingUpgrade = null;

        if (auth()->check()) {
            $pendingUpgrade = SubscriptionOrder::where('user_id', auth()->id())
                ->whereIn('status', ['awaiting_payment', 'awaiting_confirmation'])
                ->first();
        }

        return view('livewire.upgrade.index', [
            'plan' => $plan,
            'pendingUpgrade' => $pendingUpgrade,
        ])->layout('components.layouts.app', ['title' => 'Upgrade ke Plus - MindHug']);

    }
}
