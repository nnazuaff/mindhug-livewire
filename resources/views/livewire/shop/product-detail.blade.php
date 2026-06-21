<div class="max-w-[1100px] mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-6">
            <div class="bg-white rounded-xl border overflow-hidden">
                <img class="w-full h-[520px] object-cover" src="{{ asset('products/' . $product->id . '/1.jpg') }}"
                    alt="{{ $product->name }}">
            </div>
        </div>

        <div class="lg:col-span-6 space-y-6">
            @if ($successMessage)
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ $successMessage }}
                </div>
            @endif

            <div class="rounded-3xl border border-[#c19a6b]/20 bg-white p-6">
                <h1 class="text-3xl font-bold text-[#1f1f1f]">{{ $product->name }}</h1>
                <div class="mt-2 text-sm text-[#6a5a4f]">Kategori: {{ $product->category?->name ?? 'Umum' }}</div>
                <div class="mt-4 text-3xl font-semibold text-[#a47551]">Rp
                    {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="mt-1 text-sm text-[#6a5a4f]">
                    {{ $product->stock > 0 ? 'Tersedia: ' . $product->stock : 'Stok Habis' }}</div>

                <div class="mt-6 text-sm text-[#333] leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>

                @if ($product->stock > 0)
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button wire:click="addToCart('shop')"
                            class="rounded-lg bg-[#a47551] px-4 py-3 text-white hover:bg-[#8f6243] transition">
                            Masukkan Keranjang
                        </button>
                        <button wire:click="addToCart('checkout')"
                            class="rounded-lg border border-[#a47551]/40 px-4 py-3 text-[#2b2b2b] hover:bg-[#a47551]/10 transition">
                            Beli Sekarang
                        </button>
                    </div>
                @else
                    <button disabled class="w-full rounded-lg bg-gray-100 px-4 py-3 text-gray-500">
                        Stok Habis
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
