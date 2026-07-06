<?php

namespace App\Http\Livewire\Admin\Curhats;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatPanel extends Component
{
    public ?int $conversationId = null;

    public ?Conversation $conversation = null;

    public string $replyMessage = '';

    public string $productSearch = '';

    public array $searchResults = [];

    protected $listeners = ['messageSent' => 'loadConversation'];

    public function mount(?int $conversationId = null): void
    {
        $this->conversationId = $conversationId;
        if ($conversationId) {
            $this->loadConversation();
        }
    }

    public function loadConversation(): void
    {
        if (! $this->conversationId) {
            return;
        }
        $this->conversation = Conversation::with(['user', 'assignedAdmin', 'messages' => fn ($q) => $q->orderBy('created_at')])
            ->find($this->conversationId);
        $this->replyMessage = '';
        $this->dispatch('conversation-loaded');
    }

    public function takeConversation(): void
    {
        if (! $this->conversation) {
            return;
        }
        $this->conversation->update(['assigned_to' => auth('admin')->id()]);
        $this->loadConversation();
        $this->dispatch('refreshList');
    }

    public function closeConversation(): void
    {
        if (! $this->conversation) {
            return;
        }
        $this->conversation->update(['status' => 'closed']);
        $this->conversation = null;
        $this->conversationId = null;
        $this->dispatch('refreshList');
    }

    public function sendReply(): void
    {
        if (empty(trim($this->replyMessage))) {
            return;
        }
        if ($this->conversation->assigned_to !== auth('admin')->id()) {
            return;
        }

        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_role' => 'admin',
            'sender_id' => auth('admin')->id(),
            'message' => $this->replyMessage,
        ]);

        $this->replyMessage = '';
        $this->loadConversation();
        $this->dispatch('message-sent');
    }

    public function deleteMessage(int $messageId): void
    {
        $message = Message::findOrFail($messageId);
        if ($this->conversation->assigned_to !== auth('admin')->id()) {
            return;
        }
        if ($message->sender_role !== 'admin' || $message->sender_id !== auth('admin')->id()) {
            return;
        }

        $message->delete();
        $this->loadConversation();
        $this->dispatch('message-sent');
    }

    #[On('product-selected')]
    public function handleProductSelected(int $productId): void
    {
        if ($this->conversation->assigned_to !== auth('admin')->id()) {
            return;
        }

        $product = Product::findOrFail($productId);
        $files = Storage::disk('public')->files('products/'.$product->id);
        $image = ! empty($files) ? basename($files[0]) : 'default.png';

        Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_role' => 'admin',
            'sender_id' => auth('admin')->id(),
            'message' => '📦 Rekomendasi produk untukmu:',
            'metadata' => [
                'type' => 'product_recommendation',
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => asset('storage/products/'.$product->id.'/'.$image),
                'url' => route('product.detail', $product->id),
            ],
        ]);

        $this->loadConversation();
        $this->dispatch('message-sent');
    }

    public function render()
    {
        return view('livewire.admin.curhats.chat-panel');
    }
}
