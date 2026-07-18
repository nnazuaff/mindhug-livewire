<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;

    public ?int $adminId = null;

    public string $username = '';

    public string $email = '';

    public string $fullName = '';

    public string $role = 'admin';

    public string $newPassword = '';

    protected $listeners = ['openEditAdmin' => 'openModal'];

    public function openModal(int $adminId): void
    {
        $admin = Admin::findOrFail($adminId);
        $this->adminId = $adminId;
        $this->username = $admin->username;
        $this->email = $admin->email;
        $this->fullName = $admin->full_name ?? '';
        $this->role = $admin->role;
        $this->newPassword = '';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['adminId', 'username', 'email', 'fullName', 'role', 'newPassword']);
    }

    public function update(): void
    {
        $this->validate([
            'username' => 'required|string|min:3|max:50|unique:admins,username,'.$this->adminId,
            'email' => 'required|email|max:150|unique:admins,email,'.$this->adminId,
            'fullName' => 'required|string|min:3|max:150',
            'role' => 'required|in:admin,dev',
            'newPassword' => 'nullable|string|min:6',
        ]);

        $admin = Admin::findOrFail($this->adminId);

        $data = [
            'username' => $this->username,
            'email' => $this->email,
            'full_name' => $this->fullName,
            'role' => $this->role,
        ];

        // Update password hanya jika diisi
        if (! empty($this->newPassword)) {
            $data['password'] = bcrypt($this->newPassword);
        }

        $admin->update($data);
        $this->dispatch('notify', type: 'success', message: 'Admin berhasil diperbarui.');
        $this->closeModal();
        $this->dispatch('adminUpdated');
    }

    public function render()
    {
        return view('livewire.admin.admins.edit');
    }
}
