<?php

namespace App\Http\Livewire\Admin\Promotions;

use App\Models\Promotion;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['promotionCreated' => '$refresh', 'promotionUpdated' => '$refresh'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Promotion::findOrFail($id)->delete();
        session()->flash('success', 'Voucher berhasil dihapus.');
    }

    public function render()
    {
        $promotions = Promotion::query()
            ->when($this->search, fn ($q) => $q->where('code', 'like', '%'.$this->search.'%'))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin.promotions.index', [
            'promotions' => $promotions,
        ])->layout('components.layouts.admin');
    }
}
