<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $viewingAdminId = null;

    public ?Admin $viewingAdmin = null;

    protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    public function updatingSearch(): void
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
        // Cegah hapus diri sendiri
        if ($adminId === auth('admin')->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun sendiri.');

            return;
        }

        Admin::findOrFail($adminId)->delete();

        if ($this->viewingAdminId === $adminId) {
            $this->closeDetail();
        }

        session()->flash('success', 'Admin berhasil dihapus.');
    }

    public function render()
    {
        $admins = Admin::query()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('full_name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('username', 'like', '%'.$this->search.'%');
            }))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.admins.index', [
            'admins' => $admins,
        ])->layout('components.layouts.admin');
    }
}
