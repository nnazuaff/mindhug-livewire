<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <h2 class="text-lg font-semibold text-stone-800">Edit Voucher</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="update" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Kode Voucher</label>
                        <input wire:model="code" type="text"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm uppercase focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('code')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Tipe</label>
                            <select wire:model="type"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                                <option value="fixed">Potongan Rp</option>
                                <option value="percent">Persentase %</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Nilai</label>
                            <input wire:model="value" type="number" min="1"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                            @error('value')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Min. Order
                                (Rp)</label><input wire:model="minOrder" type="number" min="0"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                        <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Max. Diskon
                                (Rp)</label><input wire:model="maxDiscount" type="number" min="0"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                    </div>
                    <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Max. Penggunaan</label><input
                            wire:model="maxUses" type="number" min="1"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Mulai Tanggal</label><input
                                wire:model="startsDate" type="date"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                        <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Mulai Jam</label><input
                                wire:model="startsTime" type="time"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Berakhir
                                Tanggal</label><input wire:model="endsDate" type="date"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                        <div><label class="block text-sm font-medium text-stone-700 mb-1.5">Berakhir Jam</label><input
                                wire:model="endsTime" type="time"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input wire:model="isActive" type="checkbox"
                            class="rounded border-stone-300 text-[#a47551] focus:ring-[#a47551]/20">
                        <span class="text-sm text-stone-700">Voucher Aktif</span>
                    </label>
                    <div class="flex gap-2 pt-2">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
