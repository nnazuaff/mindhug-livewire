<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-stone-800">Edit Metode Pembayaran</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="update" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Kode</label>
                        <input wire:model="code" type="text" placeholder="Contoh: bank_transfer"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('code') border-rose-300 bg-rose-50/50 @enderror">
                        @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama</label>
                        <input wire:model="name" type="text" placeholder="Contoh: Bank Transfer"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('name') border-rose-300 bg-rose-50/50 @enderror">
                        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Subtitle</label>
                        <input wire:model="subtitle" type="text" placeholder="Contoh: Transfer antar bank"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Urutan</label>
                            <input wire:model="sortOrder" type="number" min="0"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Status</label>
                            <label class="flex items-center gap-2 cursor-pointer mt-2.5">
                                <input wire:model="isActive" type="checkbox" class="rounded border-stone-300 text-[#a47551] focus:ring-[#a47551]/20">
                                <span class="text-sm text-stone-700">Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Icon / Gambar</label>
                        @if ($existingIcon)
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ Storage::url($existingIcon) }}" class="h-14 w-14 rounded-xl object-contain border border-stone-200 bg-white p-1">
                                <button type="button" wire:click="removeIcon" class="text-xs text-rose-500 hover:text-rose-600">Hapus</button>
                            </div>
                        @endif
                        <input type="file" wire:model="icon" accept="image/jpeg,image/png,image/svg+xml,image/webp"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 file:mr-4 file:rounded-xl file:border-0 file:bg-[#f5e9df] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#7a5d45] hover:file:bg-[#ead8c2]">
                        @error('icon') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        @if ($icon && !$errors->has('icon'))
                            <img src="{{ $icon->temporaryUrl() }}" class="mt-2 h-20 w-20 rounded-xl object-contain border border-stone-200 bg-white p-1">
                        @endif
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
