<div class="max-w-[1100px] mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-6">
            <div class="relative overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-sm">
                <div class="aspect-square w-full bg-stone-100">
                    <img src="{{ asset("storage/products/{$product->id}/{$selectedImage}") }}" alt="{{ $product->name }}"
                        class="h-full w-full object-cover transition-opacity duration-300">
                </div>
                @if (count($images) > 1)
                    <button wire:click="previousImage"
                        class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 p-2 shadow-lg hover:bg-white transition-all duration-200 hover:scale-110">
                        <svg class="h-6 w-6 text-[#2b2b2b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button wire:click="nextImage"
                        class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 p-2 shadow-lg hover:bg-white transition-all duration-200 hover:scale-110">
                        <svg class="h-6 w-6 text-[#2b2b2b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    @php
                        $currentIndex = array_search($selectedImage, $images);
                        $totalImages = count($images);
                    @endphp
                    <div
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-black/50 px-3 py-1 text-sm text-white">
                        {{ $currentIndex + 1 }} / {{ $totalImages }}
                    </div>
                @endif
            </div>
            @if (count($images) > 1)
                <div class="mt-4 flex gap-3 overflow-x-auto pb-2">
                    @foreach ($images as $image)
                        <button wire:click="selectImage('{{ $image }}')"
                            class="flex-shrink-0 overflow-hidden rounded-xl border-2 transition-all duration-200 {{ $selectedImage === $image ? 'border-[#a47551] ring-2 ring-[#a47551]/30' : 'border-stone-200 hover:border-[#a47551]/50 hover:scale-105' }}">
                            <img src="{{ asset("storage/products/{$product->id}/{$image}") }}"
                                alt="{{ $product->name }}" class="h-20 w-20 object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="lg:col-span-6 space-y-6">
            @if ($successMessage)
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ $successMessage }}</div>
            @endif
            <div class="rounded-3xl border border-[#c19a6b]/20 bg-white p-6">
                <h1 class="text-3xl font-bold text-[#1f1f1f]">{{ $product->name }}</h1>
                <div class="mt-2 text-sm text-[#6a5a4f]">Kategori: {{ $product->category?->name ?? 'Umum' }}</div>
                <div class="mt-4 text-3xl font-semibold text-[#a47551]">Rp
                    {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="mt-1 text-sm text-[#6a5a4f]">
                    {{ $product->stock > 0 ? 'Tersedia: ' . $product->stock : 'Stok Habis' }}</div>
                <div class="mt-6 text-sm text-[#333] leading-relaxed">{!! nl2br(e($product->description ?? 'Tidak ada deskripsi')) !!}</div>

                @if ($product->stock > 0)
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button wire:click="addToCart"
                            class="rounded-lg bg-[#a47551] px-4 py-3 text-white hover:bg-[#8f6243] transition">
                            Masukkan Keranjang
                        </button>
                        <button wire:click="buyNow"
                            class="rounded-lg border border-[#a47551]/40 px-4 py-3 text-[#2b2b2b] hover:bg-[#a47551]/10 transition">
                            Beli Sekarang
                        </button>
                    </div>
                @else
                    <button disabled class="w-full rounded-lg bg-gray-100 px-4 py-3 text-gray-500">Stok Habis</button>
                @endif
            </div>
        </div>
    </div>
</div>
