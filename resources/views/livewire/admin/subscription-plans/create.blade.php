<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <h2 class="text-lg font-semibold text-stone-800">Tambah Paket Plus</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="save" class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama Paket</label>
                        <input wire:model.defer="name" type="text" placeholder="Contoh: Plus Bulanan"
                            class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('name') border-rose-300 bg-rose-50/50 @enderror">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Harga (Rp)</label>
                            <input wire:model.defer="price" type="number" min="0" placeholder="0"
                                class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('price') border-rose-300 bg-rose-50/50 @enderror">
                            @error('price')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Durasi (Hari)</label>
                            <input wire:model.defer="durationDays" type="number" min="1" placeholder="30"
                                class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('durationDays') border-rose-300 bg-rose-50/50 @enderror">
                            @error('durationDays')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Fitur (satu per baris)</label>
                        <textarea wire:model.defer="features" rows="5"
                            placeholder="Akses penuh semua fitur&#10;Curhat prioritas&#10;Gratis ongkir"
                            class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20"></textarea>
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input wire:model="isActive" type="checkbox"
                            class="h-4 w-4 rounded border-stone-300 text-[#a47551] focus:ring-[#a47551]/30">
                        <span class="text-sm text-stone-700">Aktif</span>
                    </label>
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-50 transition-colors">Batal</button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
