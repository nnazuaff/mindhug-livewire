<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public bool $showModal = false;

    public string $fullName = '';

    public string $email = '';

    public string $username = '';

    public string $phone = '';

    public string $password = '';

    public string $createRole = 'free';

    protected $listeners = ['openCreateUser' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['fullName', 'email', 'username', 'phone', 'password', 'createRole']);
        $this->createRole = 'free';
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function createUser(): void
    {
        $this->validate([
            'fullName' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'phone' => 'required|numeric|min_digits:10|max_digits:20',
            'password' => 'required|string|min:6',
            'createRole' => 'required|in:free,plus',
        ]);

        User::create([
            'full_name' => $this->fullName,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
            'role' => $this->createRole,
            'status' => 'active',
            'birth_date' => now(),
        ]);
        $this->dispatch('notify', type: 'success', message: 'Pengguna berhasil dibuat.');

        $this->closeModal();
        $this->dispatch('userCreated');
    }

    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
