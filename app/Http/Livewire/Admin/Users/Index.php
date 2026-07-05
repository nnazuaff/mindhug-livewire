<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $viewingUserId = null;

    public ?User $viewingUser = null;

    protected $listeners = ['userCreated' => '$refresh', 'userUpdated' => '$refresh'];

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

    public function deleteUser(int $userId): void
    {
        User::findOrFail($userId)->delete();

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

        return view('livewire.admin.users.index', [
            'users' => $users,
        ])->layout('components.layouts.admin');
    }
}
