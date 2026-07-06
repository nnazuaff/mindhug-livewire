<?php

namespace App\Http\Livewire\Admin;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class Curhats extends Component
{
    public ?int $activeConversationId = null;

    public ?Conversation $activeConversation = null;

    public string $replyMessage = '';

    public string $statusFilter = 'open';

    public string $productSearch = '';

    public array $searchResults = [];

    public bool $showProductSearch = false;

    public function openConversation(int $id): void
    {
        $this->activeConversationId = $id;
        $this->loadConversation();
    }

    public function loadConversation(): void
    {
        $this->activeConversation = Conversation::with(['user', 'assignedAdmin', 'messages' => fn ($q) => $q->orderBy('created_at')])
            ->find($this->activeConversationId);
        $this->replyMessage = '';
    }

    public function takeConversation(int $id): void
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->update(['assigned_to' => auth('admin')->id()]);
        $this->loadConversation();
        session()->flash('success', 'Percakapan berhasil diambil alih.');
    }

    public function closeConversation(int $id): void
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->update(['status' => 'closed']);

        if ($this->activeConversationId === $id) {
            $this->activeConversationId = null;
            $this->activeConversation = null;
        }

        session()->flash('success', 'Percakapan ditutup.');
    }

    public function sendReply(): void
    {
        if (empty(trim($this->replyMessage))) {
            return;
        }

        if ($this->activeConversation->assigned_to !== auth('admin')->id()) {
            session()->flash('error', 'Anda harus mengambil alih percakapan ini terlebih dahulu.');

            return;
        }

        Message::create([
            'conversation_id' => $this->activeConversationId,
            'sender_role' => 'admin',
            'sender_id' => auth('admin')->id(),
            'message' => $this->replyMessage,
        ]);

        $this->replyMessage = '';
        $this->loadConversation();
        $this->dispatch('message-sent');
        $this->dispatch('admin-replied');
    }

    public function deleteMessage(int $messageId): void
    {
        $message = Message::findOrFail($messageId);

        if ($this->activeConversation->assigned_to !== auth('admin')->id()) {
            return;
        }
        if ($message->sender_role !== 'admin' || $message->sender_id !== auth('admin')->id()) {
            return;
        }

        $message->delete();
        $this->loadConversation();
        $this->dispatch('message-sent');
    }

    public function updatedProductSearch(): void
    {
        $this->searchProduct();
    }

    public function searchProduct(): void
    {
        if (strlen($this->productSearch) < 2) {
            $this->searchResults = [];

            return;
        }

        $this->searchResults = Product::where('name', 'like', '%'.$this->productSearch.'%')
            ->where('is_active', true)->take(5)->get()->toArray();
    }

    #[On('product-selected')]
    public function handleProductSelected(int $productId): void
    {
        $this->sendProductRecommendation($productId);
    }

    public function sendProductRecommendation(int $productId): void
    {
        if ($this->activeConversation->assigned_to !== auth('admin')->id()) {
            return;
        }

        $product = Product::findOrFail($productId);
        $files = Storage::disk('public')->files('products/'.$product->id);
        $image = ! empty($files) ? basename($files[0]) : 'default.png';

        Message::create([
            'conversation_id' => $this->activeConversationId,
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

        $this->productSearch = '';
        $this->searchResults = [];
        $this->showProductSearch = false;
        $this->loadConversation();
        $this->dispatch('message-sent');
    }

    #[On('message-sent')]
    public function refreshChat(): void
    {
        $this->loadConversation();
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

        return view('livewire.admin.curhats', [
            'conversations' => $conversations,
        ])->layout('components.layouts.admin');
    }
}
