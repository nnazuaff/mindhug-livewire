<?php

namespace App\Http\Livewire\Layouts;

use App\Models\Conversation;
use Livewire\Component;

class AdminCurhatBadge extends Component
{
    public function render()
    {
        return view('livewire.layouts.admin-curhat-badge', [
            'openChats' => Conversation::where('status', 'open')->whereNull('assigned_to')->count(),
        ]);
    }
}
