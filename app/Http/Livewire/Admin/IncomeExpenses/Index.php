<?php

namespace App\Http\Livewire\Admin\IncomeExpenses;

use App\Models\IncomeExpense;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $typeFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
    ];

    protected $listeners = ['incomeExpenseCreated' => '$refresh', 'incomeExpenseUpdated' => '$refresh'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingTypeFilter(): void { $this->resetPage(); }

    public function delete(int $id): void
    {
        IncomeExpense::findOrFail($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Data berhasil dihapus.');
    }

    public function render()
    {
        $items = IncomeExpense::query()
            ->when($this->search, fn ($q) => $q->where('description', 'like', '%'.$this->search.'%'))
            ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
            ->orderByDesc('transaction_date')
            ->orderByDesc('created_at')
            ->paginate(15);

        $totalIncome = IncomeExpense::where('type', 'income')->sum('amount');
        $totalExpense = IncomeExpense::where('type', 'expense')->sum('amount');

        return view('livewire.admin.income-expenses.index', [
            'items' => $items,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ])->layout('components.layouts.admin');
    }
}
