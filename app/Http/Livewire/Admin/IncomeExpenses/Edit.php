<?php

namespace App\Http\Livewire\Admin\IncomeExpenses;

use App\Models\IncomeExpense;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;
    public ?int $itemId = null;

    public string $type = 'income';
    public string $source = 'manual';
    public string $description = '';
    public string $amount = '';
    public string $transactionDate = '';

    protected $listeners = ['openEditIncomeExpense' => 'openModal'];

    public function openModal(int $itemId): void
    {
        $item = IncomeExpense::findOrFail($itemId);
        $this->itemId = $itemId;
        $this->type = $item->type;
        $this->source = $item->source;
        $this->description = $item->description ?? '';
        $this->amount = (string) $item->amount;
        $this->transactionDate = $item->transaction_date->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['itemId', 'type', 'source', 'description', 'amount', 'transactionDate']);
    }

    public function update(): void
    {
        $this->validate([
            'type' => 'required|in:income,expense',
            'source' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|integer|min:1',
            'transactionDate' => 'required|date',
        ]);

        IncomeExpense::findOrFail($this->itemId)->update([
            'type' => $this->type,
            'source' => $this->source,
            'description' => $this->description,
            'amount' => (int) $this->amount,
            'transaction_date' => $this->transactionDate,
        ]);

        $this->closeModal();
        $this->dispatch('incomeExpenseUpdated');
        $this->dispatch('notify', type: 'success', message: 'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.income-expenses.edit');
    }
}
