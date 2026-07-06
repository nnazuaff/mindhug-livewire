<?php

namespace App\Http\Livewire\Admin\Curhats;

use Livewire\Component;

class Index extends Component
{
    public ?int $activeConversationId = null;

    public string $statusFilter = 'open';

    protected $listeners = ['conversationSelected' => 'selectConversation'];

    public function selectConversation(int $conversationId): void
    {
        $this->activeConversationId = $conversationId;
    }

    public function render()
    {
        return view('livewire.admin.curhats.index')
            ->layout('components.layouts.admin');
    }
}
