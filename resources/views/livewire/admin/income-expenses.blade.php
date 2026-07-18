<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Pemasukan & Pengeluaran</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola keuangan MindHug</p>
        </div>
        <button wire:click="openCreate"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Data
        </button>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div
            class="rounded-2xl bg-white border border-emerald-200 bg-emerald-50/30 p-5 hover:shadow-sm transition-shadow">
            <p class="text-xs text-emerald-600 uppercase tracking-wider">Total Pemasukan</p>
            <p class="text-2xl font-bold text-emerald-700 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-rose-200 bg-rose-50/30 p-5 hover:shadow-sm transition-shadow">
            <p class="text-xs text-rose-600 uppercase tracking-wider">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-rose-700 mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-1 max-w-xs">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari..."
                class="w-full rounded-xl border border-stone-200 bg-white pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
        </div>
        <select wire:model.live="typeFilter"
            class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
            <option value="">Semua</option>
            <option value="income">Pemasukan</option>
            <option value="expense">Pengeluaran</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Tgl</th>
                        <th class="px-5 py-3 font-medium">Tipe</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Sumber</th>
                        <th class="px-5 py-3 font-medium hidden md:table-cell">Deskripsi</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium w-10"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($items as $item)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3 text-xs text-stone-500">{{ $item->transaction_date->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $item->type === 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    {{ $item->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm hidden sm:table-cell">{{ $item->source }}</td>
                            <td class="px-5 py-3 text-sm text-stone-500 hidden md:table-cell">
                                {{ $item->description ?: '-' }}</td>
                            <td class="px-5 py-3 font-medium text-sm">Rp {{ number_format($item->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="edit({{ $item->id }})"
                                        class="text-xs text-stone-400 hover:text-blue-500 transition-colors"
                                        title="Edit">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <div x-data="{ showConfirm: false }">
                                        <button @click="showConfirm = true"
                                            class="text-xs text-stone-400 hover:text-rose-500 transition-colors"
                                            title="Hapus">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                        <div x-show="showConfirm" x-cloak
                                            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <p class="font-semibold text-stone-800">Hapus data?</p>
                                                <p class="text-sm text-stone-500 mt-1">Data yang dihapus tidak bisa
                                                    dikembalikan.</p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click="delete({{ $item->id }})"
                                                        @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($items->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada data.</div>
        @endif
    </div>
    <div class="mt-4">{{ $items->links() }}</div>

    {{-- Modal --}}
    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeForm">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-stone-800">{{ $editingId ? 'Edit' : 'Tambah' }} Data</h2>
                    <button wire:click="closeForm" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Tipe</label>
                        <select wire:model="type"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Sumber</label>
                        <input wire:model="source" type="text"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Deskripsi</label>
                        <input wire:model="description" type="text"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Jumlah (Rp)</label>
                        <input wire:model="amount" type="number"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Tanggal</label>
                        <input wire:model="transactionDate" type="date"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" wire:click="closeForm"
                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">Batal</button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
