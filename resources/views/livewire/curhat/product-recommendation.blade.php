<div>
    @if ($showModal)
        <div class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-lg max-h-[80vh] flex flex-col shadow-xl">
                {{-- Header --}}
                <div class="p-5 border-b border-stone-200 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-stone-800">Rekomendasi Produk</h3>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>

                {{-- Filters --}}
                <div class="p-4 border-b border-stone-100 space-y-3">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama produk..."
                        class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">

                    <div class="flex gap-2">
                        <select wire:model.live="categoryFilter"
                            class="flex-1 rounded-xl border border-stone-200 px-3 py-2.5 text-xs focus:outline-none focus:border-[#a47551]">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <select wire:model.live="sortBy"
                            class="flex-1 rounded-xl border border-stone-200 px-3 py-2.5 text-xs focus:outline-none focus:border-[#a47551]">
                            <option value="name_asc">Nama A-Z</option>
                            <option value="name_desc">Nama Z-A</option>
                            <option value="price_asc">Harga Terendah</option>
                            <option value="price_desc">Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                {{-- Results --}}
                <div class="flex-1 overflow-y-auto p-4 space-y-2">
                    @forelse ($results as $product)
                        <button wire:click="confirmSelect({{ $product['id'] }})"
                            class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-stone-50 transition-colors text-left border border-stone-100 hover:border-amber-200">
                            <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}"
                                class="h-14 w-14 rounded-xl object-cover border border-stone-200 shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-stone-800 truncate">{{ $product['name'] }}</p>
                                <p class="text-xs text-stone-400 mt-0.5">
                                    {{ $product['category_id'] ? \App\Models\Category::find($product['category_id'])->name ?? '' : 'Umum' }}
                                </p>
                                <p class="text-sm font-bold text-[#a47551] mt-1">Rp
                                    {{ number_format($product['price'], 0, ',', '.') }}</p>
                            </div>
                            <svg class="h-5 w-5 text-stone-300 shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <polyline points="19 12 12 19 5 12" />
                            </svg>
                        </button>
                    @empty
                        <p class="text-center text-sm text-stone-400 py-8">Produk tidak ditemukan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    {{-- Confirmation Dialog --}}
    @if ($selectedProduct)
        <div class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-black/40">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">

                <p class="font-semibold text-stone-800">Kirim rekomendasi?</p>
                <p class="text-sm text-stone-500 mt-1">Produk ini akan dikirim sebagai rekomendasi ke user.</p>
                <div class="flex gap-2 mt-4">
                    <button wire:click="$set('selectedProduct', null)"
                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">Batal</button>
                    <button wire:click="sendRecommendation"
                        class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">Kirim</button>
                </div>
            </div>
        </div>
    @endif
</div>
