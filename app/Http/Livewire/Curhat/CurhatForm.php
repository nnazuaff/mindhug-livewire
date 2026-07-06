<?php

namespace App\Http\Livewire\Curhat;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CurhatForm extends Component
{
    #[Rule('required|string|min:5|max:1000', message: [
        'required' => 'Ceritamu tidak boleh kosong.',
        'min' => 'Minimal 5 karakter ya — kami ingin mendengar lebih banyak.',
        'max' => 'Maksimal 1000 karakter per pesan.',
    ])]
    public string $message = '';

    public bool $submitted = false;

    public function getCharCountProperty(): int
    {
        return mb_strlen($this->message);
    }

    public function send(): void
    {
        $this->validate();

        $user = Auth::user();

        $conversation = Conversation::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'open'],
            ['user_id' => $user->id, 'status' => 'open']
        );

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_role' => 'user',
            'sender_id' => $user->id,
            'message' => $this->message,
        ]);

        $this->message = '';
        // Keep the user in the chat flow instead of switching to a full success screen.
        $this->submitted = false;
    }

    public function resetForm(): void
    {
        $this->message = '';
        $this->submitted = false;
    }

    public function render()
    {
        $user = Auth::user();
        $conversation = Conversation::query()
            ->where('user_id', $user->id)
            ->where('status', 'open')
            ->with(['messages' => fn ($q) => $q->orderBy('created_at')])
            ->first();

        $this->dispatch('conversation-loaded');

        return view('livewire.curhat.curhat-form', [
            'conversation' => $conversation,
            'messages' => $conversation?->messages ?? collect(),
            'charCount' => $this->charCount,
        ]);
    }
}
