<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;

class Create extends Component
{
    public bool $showModal = false;

    public string $username = '';

    public string $email = '';

    public string $fullName = '';

    public string $password = '';

    public string $role = 'admin'; // default: admin

    protected $listeners = ['openCreateAdmin' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['username', 'email', 'fullName', 'password', 'role']);
        $this->role = 'admin';
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $this->validate([
            'username' => 'required|string|min:3|max:50|unique:admins,username',
            'email' => 'required|email|max:150|unique:admins,email',
            'fullName' => 'required|string|min:3|max:150',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,dev',
        ]);

        Admin::create([
            'username' => $this->username,
            'email' => $this->email,
            'full_name' => $this->fullName,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);

        $this->dispatch('notify', type: 'success', message: 'Admin berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('adminCreated');
    }

    public function render()
    {
        return view('livewire.admin.admins.create');
    }
}
