    <div>
        @if ($showModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
                <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                    <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-stone-800">Edit Kategori</h2>
                        <button wire:click="closeModal"
                            class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                    </div>
                    <form wire:submit.prevent="update" class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama Kategori</label>
                            <input wire:model="name" type="text"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('name') border-rose bg-rose-50/50 @enderror">
                            @error('name')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Deskripsi</label>
                            <textarea wire:model="description" rows="3"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20"></textarea>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">Batal</button>
                            <button type="submit"
                                class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
