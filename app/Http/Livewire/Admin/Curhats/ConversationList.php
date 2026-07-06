<?php

namespace App\Http\Livewire\Admin\Curhats;

use App\Models\Conversation;
use Livewire\Component;

class ConversationList extends Component
{
    public ?int $activeConversationId = null;

    public string $statusFilter = 'open';

    protected $listeners = ['refreshList' => '$refresh'];

    public function openConversation(int $id): void
    {
        $this->activeConversationId = $id;
        $this->dispatch('conversationSelected', conversationId: $id);
        $this->dispatch('switch-to-chat-mobile');
    }

    public function render()
    {
        $conversations = Conversation::query()
            ->with(['user', 'assignedAdmin'])
            ->withCount('messages')
            ->when($this->statusFilter === 'open', fn ($q) => $q->where('status', 'open'))
            ->when($this->statusFilter === 'closed', fn ($q) => $q->where('status', 'closed'))
            ->orderByDesc('updated_at')
            ->get();

        return view('livewire.admin.curhats.conversation-list', [
            'conversations' => $conversations,
        ]);
    }
}
