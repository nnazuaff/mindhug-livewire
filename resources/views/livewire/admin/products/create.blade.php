<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <h2 class="text-lg font-semibold text-stone-800">Tambah Produk</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="createProduct" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama Produk</label>
                        <input wire:model="name" type="text"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('name') border-rose-300 bg-rose-50/50 @enderror">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Kategori</label>
                            <select wire:model="categoryId"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                                <option value="">Tanpa Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Badge</label>
                            <input wire:model="badge" type="text" placeholder="Contoh: Best Seller"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                        <label class="flex items-center justify-between cursor-pointer">
                            <div>
                                <p class="text-sm font-semibold text-stone-800">Dropship dari Shopee?</p>
                                <p class="text-xs text-stone-500 mt-0.5">Aktifkan jika produk ini dari supplier Shopee
                                </p>
                            </div>
                            <input type="checkbox" wire:model.live="isDropship" class="sr-only peer">
                            <div
                                class="relative w-10 h-6 rounded-full bg-stone-200 peer-checked:bg-[#a47551] transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:w-5 after:h-5 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-4">
                            </div>
                        </label>
                        @if ($isDropship)
                            <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-amber-100">
                                <div>
                                    <label class="block text-xs font-medium text-stone-600 mb-1">Harga Shopee (Rp) <span
                                            class="text-rose-400">*</span></label>
                                    <input wire:model.live="shopeePrice" type="number" min="0" placeholder="0"
                                        onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '-' && event.key !== '.' && event.key !== '+'"
                                        class="w-full rounded-xl border border-stone-200 px-3 py-2 text-sm focus:outline-none focus:border-[#a47551] @error('shopeePrice') border-rose-300 bg-rose-50/50 @enderror">
                                    @error('shopeePrice')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-stone-600 mb-1">Markup (Rp) <span
                                            class="text-rose-400">*</span></label>
                                    <input wire:model.live="markup" type="number" min="0" placeholder="0"
                                        onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '-' && event.key !== '.' && event.key !== '+'"
                                        class="w-full rounded-xl border border-stone-200 px-3 py-2 text-sm focus:outline-none focus:border-[#a47551] @error('markup') border-rose-300 bg-rose-50/50 @enderror">
                                    @error('markup')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-medium text-stone-600 mb-1">Link Shopee <span
                                            class="text-stone-400">(opsional)</span></label>
                                    <input wire:model="shopeeLink" type="url" placeholder="https://shopee.co.id/..."
                                        class="w-full rounded-xl border border-stone-200 px-3 py-2 text-sm focus:outline-none focus:border-[#a47551] @error('shopeeLink') border-rose-300 bg-rose-50/50 @enderror">
                                    @error('shopeeLink')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Harga Jual (Rp)</label>
                            <input wire:model="price" type="number" min="0" placeholder="0"
                                onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '-' && event.key !== '.' && event.key !== '+'"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 {{ $isDropship ? 'bg-stone-50 text-stone-500' : '' }} @error('price') border-rose-300 bg-rose-50/50 @enderror"
                                {{ $isDropship ? 'readonly' : '' }}>
                            @error('price')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                            @if ($isDropship)
                                <p class="text-[0.65rem] text-stone-400 mt-1">Dihitung otomatis: Harga Shopee + Markup
                                </p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Stok</label>
                            <input wire:model="stock" type="number" min="0" placeholder="0"
                                onkeydown="return event.key !== 'e' && event.key !== 'E' && event.key !== '-' && event.key !== '.' && event.key !== '+'"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 @error('stock') border-rose-300 bg-rose-50/50 @enderror">
                            @error('stock')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Deskripsi</label>
                        <textarea wire:model="description" rows="3"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20"></textarea>
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input wire:model="isActive" type="checkbox"
                            class="rounded border-stone-300 text-[#a47551] focus:ring-[#a47551]/20">
                        <span class="text-sm text-stone-700">Produk Aktif</span>
                    </label>

                    <div x-data="{
                        showCropper: false,
                        image: null,
                        init() {
                            this.image = new Image();
                            this.image.onload = () => this.draw();
                        },
                        onFileSelect(e) {
                            const file = e.target.files[0];
                            if (!file) return;
                            if (file.size > 5120000) { alert('Ukuran foto maksimal 5MB'); return; }
                            const reader = new FileReader();
                            reader.onload = (ev) => {
                                this.image.src = ev.target.result;
                                this.showCropper = true;
                            };
                            reader.readAsDataURL(file);
                            e.target.value = '';
                        },
                        draw() {
                            const canvas = this.$refs.canvas;
                            if (!canvas) return;
                            const ctx = canvas.getContext('2d');
                            const size = Math.min(this.image.width, this.image.height);
                            const sx = (this.image.width - size) / 2;
                            const sy = (this.image.height - size) / 2;
                            const maxDisplay = 350;
                            const scale = Math.min(maxDisplay / size, 1);
                            canvas.width = size * scale;
                            canvas.height = size * scale;
                            ctx.drawImage(this.image, sx, sy, size, size, 0, 0, canvas.width, canvas.height);
                        },
                        cropAndSave() {
                            const size = 500;
                            const outCanvas = document.createElement('canvas');
                            outCanvas.width = size;
                            outCanvas.height = size;
                            const ctx = outCanvas.getContext('2d');
                            const imgSize = Math.min(this.image.width, this.image.height);
                            const sx = (this.image.width - imgSize) / 2;
                            const sy = (this.image.height - imgSize) / 2;
                            ctx.drawImage(this.image, sx, sy, imgSize, imgSize, 0, 0, size, size);
                            const base64 = outCanvas.toDataURL('image/webp', 0.85);
                            $wire.addCroppedPhoto(base64);
                            this.showCropper = false;
                        }
                    }">
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">
                            Foto Produk <span class="text-stone-400 font-normal">(1-8 foto, crop 1:1, max 5MB)</span>
                        </label>
                        <input type="file" accept="image/*" @change="onFileSelect($event)"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 file:mr-4 file:rounded-xl file:border-0 file:bg-[#f5e9df] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#7a5d45] hover:file:bg-[#ead8c2]">
                        @error('croppedPhotos')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror

                        <div x-show="showCropper" x-cloak
                            class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-black/60">
                            <div class="bg-white rounded-2xl p-6 max-w-lg w-full shadow-xl">
                                <h3 class="text-sm font-semibold text-stone-800 mb-4">Crop Foto (1:1)</h3>
                                <div class="flex justify-center mb-4">
                                    <canvas x-ref="canvas"
                                        class="max-w-full max-h-[350px] rounded-xl border border-stone-200"></canvas>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" @click="showCropper = false"
                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                    <button type="button" @click="cropAndSave"
                                        class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243]">Simpan
                                        Crop</button>
                                </div>
                            </div>
                        </div>

                        @if (!empty($croppedPhotos))
                            <div class="grid grid-cols-4 gap-2 mt-3">
                                @foreach ($croppedPhotos as $index => $img)
                                    <div class="relative group">
                                        <img src="{{ $img }}"
                                            class="w-full aspect-square rounded-xl object-cover border border-stone-200">
                                        <button type="button" wire:click="removeCroppedPhoto({{ $index }})"
                                            class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-rose-500 text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

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
