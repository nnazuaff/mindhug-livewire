<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;

    public ?int $userId = null;

    public string $fullName = '';

    public string $email = '';

    public string $username = '';

    public string $phone = '';

    protected $listeners = ['openEditUser' => 'openModal'];

    public function openModal(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->userId = $userId;
        $this->fullName = $user->full_name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->phone = $user->phone ?? '';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['userId', 'fullName', 'email', 'username', 'phone']);
    }

    public function updateUser(): void
    {
        $this->validate([
            'fullName' => 'required|string|min:3|max:150',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'username' => 'required|string|min:3|max:50|unique:users,username,'.$this->userId,
            'phone' => 'required|numeric|min_digits:10',
        ]);

        User::findOrFail($this->userId)->update([
            'full_name' => $this->fullName,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
        ]);

        $this->closeModal();
        $this->dispatch('userUpdated');
        session()->flash('success', 'Pengguna berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
