<?php

namespace App\Http\Livewire\Admin;

use App\Models\IncomeExpense;
use Livewire\Component;
use Livewire\WithPagination;

class IncomeExpenses extends Component
{
    use WithPagination;

    public string $search = '';

    public string $typeFilter = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $type = 'income';

    public string $source = 'manual';

    public string $description = '';

    public string $amount = '';

    public string $transactionDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->transactionDate = now()->format('Y-m-d');
    }

    public function edit(int $id): void
    {
        $item = IncomeExpense::findOrFail($id);
        $this->editingId = $id;
        $this->type = $item->type;
        $this->source = $item->source;
        $this->description = $item->description ?? '';
        $this->amount = (string) $item->amount;
        $this->transactionDate = $item->transaction_date->format('Y-m-d');
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->type = 'income';
        $this->source = 'manual';
        $this->description = '';
        $this->amount = '';
        $this->transactionDate = now()->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate([
            'type' => 'required|in:income,expense',
            'source' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|integer|min:1',
            'transactionDate' => 'required|date',
        ]);

        $data = [
            'type' => $this->type,
            'source' => $this->source,
            'description' => $this->description,
            'amount' => (int) $this->amount,
            'transaction_date' => $this->transactionDate,
            'admin_id' => auth('admin')->id(),
        ];

        if ($this->editingId) {
            IncomeExpense::findOrFail($this->editingId)->update($data);
            $this->dispatch('notify', type: 'success', message: 'Data berhasil diperbarui.');
        } else {
            IncomeExpense::create($data);
            $this->dispatch('notify', type: 'success', message: 'Data berhasil ditambahkan.');
        }

        $this->closeForm();
    }

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

        return view('livewire.admin.income-expenses', [
            'items' => $items,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ])->layout('components.layouts.admin');
    }
}
