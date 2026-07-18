<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    public string $editRole = 'free';

    public string $editStatus = 'active';

    public function openModal(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->userId = $userId;
        $this->fullName = $user->full_name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->phone = $user->phone ?? '';
        $this->editRole = $user->role;
        $this->editStatus = $user->status;
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
            'editRole' => 'required|in:free,plus',
            'editStatus' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($this->userId);
        $oldStatus = $user->status;

        $user->update([
            'full_name' => $this->fullName,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'role' => $this->editRole,
            'status' => $this->editStatus,
        ]);

        // // Jika status berubah dari active ke inactive, logout user
        // if ($oldStatus === 'active' && $this->editStatus === 'inactive') {
        //     // Hapus session user
        //     DB::table('sessions')
        //         ->where('user_id', $this->userId)
        //         ->delete();
        // }

        $this->closeModal();
        $this->dispatch('userUpdated');
        $this->dispatch('notify', type: 'success', message: 'Pengguna berhasil diperbarui.');

        $this->closeModal();
        $this->dispatch('userUpdated');
    }

    public function render()
    {
        return view('livewire.admin.users.edit');
    }
}
