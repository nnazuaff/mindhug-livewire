<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $roleFilter = '';

    public ?int $viewingAdminId = null;

    public ?Admin $viewingAdmin = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function viewAdmin(int $adminId): void
    {
        $this->viewingAdminId = $adminId;
        $this->viewingAdmin = Admin::find($adminId);
    }

    public function closeDetail(): void
    {
        $this->viewingAdminId = null;
        $this->viewingAdmin = null;
    }

    public function deleteAdmin(int $adminId): void
    {
        if ($adminId === auth('admin')->id()) {
            $this->dispatch('notify', type: 'error', message: 'Anda tidak dapat menghapus akun sendiri.');

            return;
        }
        Admin::findOrFail($adminId)->delete();
        if ($this->viewingAdminId === $adminId) {
            $this->closeDetail();
        }
        $this->dispatch('notify', type: 'success', message: 'Admin berhasil dihapus.');
    }

    public function render()
    {
        $admins = Admin::query()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('id', 'like', '%'.$this->search.'%')
                    ->orWhere('full_name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('username', 'like', '%'.$this->search.'%');
            }))
            ->when($this->roleFilter === 'dev', fn ($q) => $q->where('role', 'dev'))
            ->when($this->roleFilter === 'admin', fn ($q) => $q->where('role', 'admin'))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.admins.index', [
            'admins' => $admins,
        ])->layout('components.layouts.admin');
    }
}
