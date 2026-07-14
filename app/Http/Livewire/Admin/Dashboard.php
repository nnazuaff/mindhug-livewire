<?php

namespace App\Http\Livewire\Admin;

use App\Models\Conversation;
use App\Models\Order;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    #[On('order-updated')]
    public function refreshDashboard(): void {}

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalUsers' => User::count(),
            'totalOrders' => Order::count(),
            'pendingPayments' => Order::where('status', 'awaiting_payment')->count(),
            'pendingConfirm' => Order::where('status', 'awaiting_confirmation')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'openConversations' => Conversation::where('status', 'open')->count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
           
        ])->layout('components.layouts.admin');
    }
}
