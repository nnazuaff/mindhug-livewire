<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $viewingUserId = null;

    public ?User $viewingUser = null;

    public ?int $editingUserId = null;

    public string $editFullName = '';

    public string $editEmail = '';

    public string $editUsername = '';

    public string $editPhone = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function viewUser(int $userId): void
    {
        $this->viewingUserId = $userId;
        $this->viewingUser = User::with(['addresses', 'orders' => fn ($q) => $q->latest()->limit(5)])->find($userId);
    }

    public function closeDetail(): void
    {
        $this->viewingUserId = null;
        $this->viewingUser = null;
    }

    public function editUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $userId;
        $this->editFullName = $user->full_name;
        $this->editEmail = $user->email;
        $this->editUsername = $user->username;
        $this->editPhone = $user->phone ?? '';
    }

    public function cancelEdit(): void
    {
        $this->editingUserId = null;
        $this->reset(['editFullName', 'editEmail', 'editUsername', 'editPhone']);
    }

    public function updateUser(): void
    {
        $this->validate([
            'editFullName' => 'required|string|min:3|max:150',
            'editEmail' => 'required|email|unique:users,email,'.$this->editingUserId,
            'editUsername' => 'required|string|min:3|max:50|unique:users,username,'.$this->editingUserId,
            'editPhone' => 'nullable|string|max:30',
        ]);

        $user = User::findOrFail($this->editingUserId);
        $user->update([
            'full_name' => $this->editFullName,
            'email' => $this->editEmail,
            'username' => $this->editUsername,
            'phone' => $this->editPhone,
        ]);

        $this->cancelEdit();

        if ($this->viewingUserId === $user->id) {
            $this->viewUser($user->id);
        }

        session()->flash('success', 'Pengguna berhasil diperbarui.');
    }

    public function deleteUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->delete();

        if ($this->viewingUserId === $userId) {
            $this->closeDetail();
        }

        session()->flash('success', 'Pengguna berhasil dihapus.');
    }

    public function render()
    {
        $users = User::query()
            ->withCount('orders')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('full_name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('username', 'like', '%'.$this->search.'%');
            }))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.users', [
            'users' => $users,
        ])->layout('components.layouts.admin');
    }
}
