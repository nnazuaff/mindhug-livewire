<div class="max-w-5xl mx-auto px-4 py-10">
    {{-- Header --}}
    <div class="mb-8 sm:mb-10">
        <span class="text-xs font-medium tracking-[0.2em] uppercase text-[#8b6f5c]">Shop</span>
        <h1 class="mt-2 text-2xl sm:text-3xl font-semibold text-[#2b1d12]">Temukan yang kamu butuhkan</h1>
        <p class="mt-1.5 text-sm text-[#6a5a4f] max-w-xl">Produk pilihan untuk menemani hari-harimu.</p>
    </div>

    {{-- Search + Sort --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-8">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-[#b0a090]" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input wire:model.live.debounce.300ms="q" type="text" placeholder="Cari produk..."
                class="w-full rounded-2xl border border-[#e0d0c0] bg-white pl-11 pr-10 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15">
            @if ($q)
                <button wire:click="clearSearch"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#b0a090] hover:text-[#a47551] transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            @endif
        </div>
        <select wire:model.live="sort"
            class="w-full sm:w-48 rounded-2xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm text-[#2b2b2b] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15">
            <option value="">Urutkan</option>
            <option value="name_asc">Nama A-Z</option>
            <option value="name_desc">Nama Z-A</option>
            <option value="price_asc">Harga Terendah</option>
            <option value="price_desc">Harga Tertinggi</option>
        </select>
    </div>

    {{-- Product Grid --}}
    @if ($products->isEmpty())
        <div class="text-center py-16">
            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551] mb-5">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </div>
            <p class="font-semibold text-[#2b1d12]">Produk tidak ditemukan</p>
            <p class="mt-1 text-sm text-[#6a5a4f]">Coba kata kunci lain atau hapus filter.</p>
            @if ($q)
                <button wire:click="clearSearch"
                    class="mt-4 text-sm font-semibold text-[#a47551] hover:text-[#8f6243] transition-colors">Hapus
                    pencarian →</button>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-5">
            @foreach ($products as $product)
                @php
                    $files = \Illuminate\Support\Facades\Storage::disk('public')->files('products/' . $product->id);
                    $image = !empty($files) ? basename($files[0]) : 'default.png';
                @endphp

                <a href="{{ route('product.detail', $product) }}" wire:navigate
                    class="group flex flex-col rounded-2xl border border-[#e8d5c4] bg-white overflow-hidden transition duration-200 hover:border-[#c19a6b]/60">

                    {{-- Image --}}
                    <div class="relative aspect-square overflow-hidden bg-[#fdfaf7]">
                        <img src="{{ asset('storage/products/' . $product->id . '/' . $image) }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover transition duration-350 group-hover:scale-105">

                        {{-- Badge (kalau ada) --}}
                        @if ($product->badge)
                            <span
                                class="absolute top-2.5 left-2.5 rounded-full bg-[#2b1d12]/75 backdrop-blur-sm text-white text-[0.6rem] font-medium px-2.5 py-1 leading-none tracking-wide">
                                {{ $product->badge }}
                            </span>
                        @endif

                        {{-- Kategori label subtle --}}
                        @if ($product->category)
                            <span
                                class="absolute bottom-2.5 left-2.5 rounded-lg bg-white/90 backdrop-blur-sm text-[#6a5a4f] text-[0.6rem] font-medium px-2 py-0.5 leading-none">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-col flex-1 p-3.5 sm:p-4">
                        <p
                            class="text-sm font-medium text-[#2b1d12] leading-snug line-clamp-2 group-hover:text-[#a47551] transition-colors duration-200">
                            {{ $product->name }}
                        </p>

                        <div class="mt-auto pt-3 flex items-end justify-between gap-2">
                            <span class="text-sm font-semibold text-[#a47551] tabular-nums">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @if ($product->shopee_link)
                                <span class="text-[0.6rem] text-[#b0a090] italic shrink-0">dropship</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">{{ $products->links() }}</div>
    @endif
</div>
