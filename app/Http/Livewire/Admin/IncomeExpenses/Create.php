<?php

namespace App\Http\Livewire\Admin\IncomeExpenses;

use App\Models\IncomeExpense;
use Livewire\Component;

class Create extends Component
{
    public bool $showModal = false;

    public string $type = 'income';
    public string $source = 'manual';
    public string $description = '';
    public string $amount = '';
    public string $transactionDate = '';

    protected $listeners = ['openCreateIncomeExpense' => 'openModal'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['type', 'source', 'description', 'amount', 'transactionDate']);
        $this->type = 'income';
        $this->source = 'manual';
        $this->transactionDate = now()->format('Y-m-d');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
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

        IncomeExpense::create([
            'type' => $this->type,
            'source' => $this->source,
            'description' => $this->description,
            'amount' => (int) $this->amount,
            'transaction_date' => $this->transactionDate,
            'admin_id' => auth('admin')->id(),
        ]);

        $this->closeModal();
        $this->dispatch('incomeExpenseCreated');
        $this->dispatch('notify', type: 'success', message: 'Data berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.income-expenses.create');
    }
}
