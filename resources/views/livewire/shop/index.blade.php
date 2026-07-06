<div class="max-w-275 mx-auto px-4 py-10">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <span
                class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">Shop</span>
            <h1 class="text-2xl md:text-4xl font-semibold text-[#1f1f1f]">Belanja Produk</h1>
        </div>

        <div class="w-full md:w-auto flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="relative w-full sm:w-80">
                <input wire:model.live.debounce.200ms="q" type="text" placeholder="Cari produk..."
                    class="w-full rounded-2xl border border-[#c19a6b]/30 bg-white px-4 py-3 pr-32 text-sm shadow-sm shadow-[#a47551]/5 focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20" />
                <div class="absolute inset-y-0 right-3 flex items-center gap-2">
                    <button type="button" wire:click="clearSearch" wire:loading.attr="disabled"
                        class="rounded-full bg-[#f5e9df] px-3 py-1 text-xs font-semibold text-[#7a5d45] hover:bg-[#ead8c2] transition">
                        Bersihkan
                    </button>
                    <span wire:loading wire:target="q,sort" class="text-xs text-[#a47551]">Memuat...</span>
                </div>
            </div>

            <div class="w-full sm:w-64">
                <select wire:model="sort"
                    class="w-full rounded-2xl border border-[#c19a6b]/30 bg-white px-4 py-3 text-sm shadow-sm shadow-[#a47551]/5 focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                    <option value="">Urutkan</option>
                    <option value="price_asc">Harga: termurah</option>
                    <option value="price_desc">Harga: termahal</option>
                    <option value="stock_desc">Stok: terbanyak</option>
                    <option value="stock_asc">Stok: tersedikit</option>
                    <option value="name_asc">Abjad: A - Z</option>
                    <option value="name_desc">Abjad: Z - A</option>
                </select>
            </div>
        </div>
    </div>

    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-[#6d5d4e]">
            Menampilkan {{ $products->total() }} produk untuk
            <span class="font-semibold text-[#3f2f20]">"{{ $q ?: 'semua' }}"</span>
        </div>
        <div class="text-sm text-[#6d5d4e]">
            {{ $sort? str('sort')->replace(['_asc', '_desc'], [' ↑', ' ↓'])->replace('_', ' '): 'Urutkan sesuai kebutuhan' }}
        </div>
    </div>

    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
        @forelse($products as $product)
            @php
                $files = Storage::disk('public')->files('products/' . $product->id);
                $firstImage = !empty($files) ? basename($files[0]) : 'default.png';
            @endphp
            <article class="rounded-lg border border-gray-100 bg-white p-2 hover:shadow-md transition">
                <a href="{{ route('product.detail', $product) }}" class="block h-full">
                    <div class="relative w-full pb-[100%] rounded-md overflow-hidden bg-[#f7f2ed]">
                        <img src="{{ asset('storage/products/' . $product->id . '/' . $firstImage) }}"
                            alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover" />
                    </div>

                    <div class="pt-2 text-center">
                        <h3 class="text-sm font-medium text-[#1f1f1f] line-clamp-2 leading-tight min-h-[2.5rem]">
                            {{ $product->name }}
                        </h3>

                        <div class="mt-2 text-lg font-semibold text-[#a47551]">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <div class="mt-1 text-xs text-[#9aa0a6]">
                            {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                        </div>
                    </div>
                </a>
            </article>
        @empty
            <div
                class="col-span-full rounded-3xl border border-[#c19a6b]/25 bg-white/70 p-6 text-center text-sm text-[#595959]">
                Produk tidak ditemukan.
            </div>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
