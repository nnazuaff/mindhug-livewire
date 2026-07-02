<?php

namespace App\Http\Livewire\Kontak;

use Livewire\Attributes\Rule;
use Livewire\Component;

class KontakForm extends Component
{
    #[Rule('required|string|min:2|max:80', message: [
        'required' => 'Nama tidak boleh kosong.',
        'min'      => 'Nama minimal 2 karakter.',
    ])]
    public string $name = '';

    #[Rule('required|email|max:120', message: [
        'required' => 'Email tidak boleh kosong.',
        'email'    => 'Format email tidak valid.',
    ])]
    public string $email = '';

    #[Rule('required|string|min:10|max:2000', message: [
        'required' => 'Pesan tidak boleh kosong.',
        'min'      => 'Pesan minimal 10 karakter.',
    ])]
    public string $pesan = '';

    public bool $sent = false;

    public function kirim(): void
    {
        $this->validate();

        // TODO: Integrate mail sending (Mail::to('admin@mindhug.id')->send(...))
        // For now we just mark as sent.

        $this->sent = true;
        $this->reset(['name', 'email', 'pesan']);
    }

    public function render()
    {
        return view('livewire.kontak.kontak-form');
    }
}
