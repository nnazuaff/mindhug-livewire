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

    protected $listeners = ['openCreateUser' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['fullName', 'email', 'username', 'phone', 'password']);
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
        ]);

        User::create([
            'full_name' => $this->fullName,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
            'role' => 'free',
            'birth_date' => now(),
        ]);

        $this->closeModal();
        $this->dispatch('userCreated');
        session()->flash('success', 'Pengguna berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.users.create');
    }
}
