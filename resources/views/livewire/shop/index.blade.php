<div class="max-w-[1100px] mx-auto px-4 py-10">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <span
                class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">Shop</span>
            <h1 class="text-2xl md:text-4xl font-semibold text-[#1f1f1f]">Belanja Produk Self-care</h1>
        </div>

        <div class="w-full md:w-auto flex flex-col sm:flex-row sm:items-center gap-3">
            <input wire:model.debounce.300ms="q" type="text" placeholder="Cari produk..."
                class="w-full sm:w-72 rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/20" />
            <select wire:model="sort"
                class="w-full sm:w-56 rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/20">
                <option value="">Default</option>
                <option value="price_asc">Harga: termurah</option>
                <option value="price_desc">Harga: termahal</option>
                <option value="stock_desc">Stok: terbanyak</option>
                <option value="stock_asc">Stok: tersedikit</option>
                <option value="name_asc">Abjad: A - Z</option>
                <option value="name_desc">Abjad: Z - A</option>
            </select>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
        @forelse($products as $product)
            <article class="rounded-lg border border-gray-100 bg-white p-2 hover:shadow-md transition">
                <a href="{{ route('product.detail', $product) }}" class="block h-full">
                    <div class="relative w-full pb-[100%] rounded-md overflow-hidden bg-[#f7f2ed]">
                        <img src="{{ asset('products/' . $product->id . '/1.jpg') }}" alt="{{ $product->name }}"
                            class="absolute inset-0 w-full h-full object-cover" />
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
