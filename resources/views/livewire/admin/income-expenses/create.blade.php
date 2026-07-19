<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-stone-800">Tambah Data</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Tipe</label>
                        <select wire:model="type" class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] @error('type') border-rose-300 @enderror">
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                        @error('type') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Sumber</label>
                        <input wire:model="source" type="text" class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] @error('source') border-rose-300 @enderror">
                        @error('source') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Deskripsi</label>
                        <input wire:model="description" type="text" class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Jumlah (Rp)</label>
                        <input wire:model="amount" type="number" class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] @error('amount') border-rose-300 @enderror">
                        @error('amount') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Tanggal</label>
                        <input wire:model="transactionDate" type="date" class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] @error('transactionDate') border-rose-300 @enderror">
                        @error('transactionDate') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" wire:click="closeModal" class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
