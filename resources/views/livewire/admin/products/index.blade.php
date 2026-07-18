<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Produk</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola katalog produk MindHug</p>
        </div>
        <button onclick="Livewire.dispatch('openCreateProduct')"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Produk
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="mb-6">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama produk..."
            class="w-full max-w-md rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Produk</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Kategori</th>
                        <th class="px-5 py-3 font-medium">Harga</th>
                        <th class="px-5 py-3 font-medium">Stok</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($products as $product)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    @php
                                        $files = Storage::disk('public')->files('products/' . $product->id);
                                        $img = !empty($files) ? basename($files[0]) : 'default.png';
                                    @endphp
                                    <img src="{{ asset('storage/products/' . $product->id . '/' . $img) }}"
                                        class="h-9 w-9 rounded-lg object-cover border border-stone-200">
                                    <div>
                                        <p class="font-medium text-stone-700">{{ $product->name }}</p>
                                        @if ($product->badge)
                                            <span
                                                class="text-[0.6rem] px-1.5 py-0.5 rounded-full bg-amber-50 text-amber-600 font-medium">{{ $product->badge }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-500 hidden sm:table-cell">
                                {{ $product->category?->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-stone-700">Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-stone-600">{{ $product->stock }}</td>
                            <td class="px-5 py-3">
                                <button wire:click="toggleActive({{ $product->id }})"
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $product->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="viewProduct({{ $product->id }})"
                                        class="text-xs text-stone-400 hover:text-[#a47551]" title="Lihat">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="Livewire.dispatch('openEditProduct', { productId: {{ $product->id }} })"
                                        class="text-xs text-stone-400 hover:text-blue-500" title="Edit">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <div x-data="{ showConfirm: false }">
                                        <button @click="showConfirm = true"
                                            class="text-xs text-stone-400 hover:text-rose-500" title="Hapus">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                        <div x-show="showConfirm" x-cloak
                                            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <p class="font-semibold text-stone-800">Hapus produk?</p>
                                                <p class="text-sm text-stone-500 mt-1">Produk yang dihapus tidak bisa
                                                    dikembalikan.</p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click="deleteProduct({{ $product->id }})"
                                                        @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($products->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada produk ditemukan.</div>
        @endif
    </div>

    <div class="mt-4">{{ $products->links() }}</div>

    {{-- Detail Modal --}}
    @if ($viewingProduct)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeDetail">
            <div class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <div>
                        <h2 class="text-lg font-semibold text-stone-800">{{ $viewingProduct->name }}</h2>
                        <p class="text-xs text-stone-400 mt-0.5">
                            {{ $viewingProduct->category?->name ?? 'Tanpa Kategori' }}</p>
                    </div>
                    <button wire:click="closeDetail"
                        class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Gambar --}}
                    @php
                        $pFiles = Storage::disk('public')->files('products/' . $viewingProduct->id);
                    @endphp
                    @if (!empty($pFiles))
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Galeri Produk</p>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach ($pFiles as $file)
                                    <div
                                        class="aspect-square rounded-xl overflow-hidden border border-stone-200 bg-stone-50">
                                        <img src="{{ asset('storage/' . $file) }}" alt="{{ $viewingProduct->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Info Utama --}}
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">Harga Jual</p>
                            <p class="text-lg font-bold text-[#a47551]">Rp
                                {{ number_format($viewingProduct->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Stok</p>
                            <p class="text-lg font-bold text-stone-800">{{ number_format($viewingProduct->stock) }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Badge</p>
                            <p class="font-medium text-stone-700">{{ $viewingProduct->badge ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Status</p>
                            <span
                                class="inline-flex text-xs px-2.5 py-1 rounded-full font-medium {{ $viewingProduct->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">
                                {{ $viewingProduct->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    @if ($viewingProduct->description)
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-1">Deskripsi</p>
                            <p class="text-sm text-stone-600 leading-relaxed">{{ $viewingProduct->description }}</p>
                        </div>
                    @endif

                    {{-- Dropship Info --}}
                    @php $isDropship = $viewingProduct->shopee_price > 0 || $viewingProduct->shopee_link; @endphp
                    <div
                        class="rounded-2xl border {{ $isDropship ? 'border-amber-200 bg-amber-50' : 'border-stone-200 bg-stone-50' }} p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span
                                class="text-xs font-semibold uppercase tracking-wider {{ $isDropship ? 'text-amber-600' : 'text-stone-400' }}">
                                {{ $isDropship ? '📦 Produk Dropship (Shopee)' : 'Produk Non-Dropship' }}
                            </span>
                        </div>

                        @if ($isDropship)
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-stone-400 text-xs">Harga Shopee</p>
                                    <p class="font-semibold text-stone-700">Rp
                                        {{ number_format($viewingProduct->shopee_price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-stone-400 text-xs">Markup</p>
                                    <p class="font-semibold text-stone-700">Rp
                                        {{ number_format($viewingProduct->markup, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-stone-400 text-xs">Keuntungan</p>
                                    <p class="font-semibold text-emerald-600">Rp
                                        {{ number_format($viewingProduct->price - $viewingProduct->shopee_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-stone-400 text-xs">Margin</p>
                                    <p class="font-semibold text-emerald-600">
                                        {{ $viewingProduct->shopee_price > 0 ? round((($viewingProduct->price - $viewingProduct->shopee_price) / $viewingProduct->shopee_price) * 100) : 0 }}%
                                    </p>
                                </div>
                                @if ($viewingProduct->shopee_link)
                                    <div class="col-span-2">
                                        <p class="text-stone-400 text-xs mb-1">Link Shopee</p>
                                        <a href="{{ $viewingProduct->shopee_link }}" target="_blank" rel="noopener"
                                            class="text-sm text-[#a47551] hover:text-[#8f6243] underline break-all">
                                            {{ $viewingProduct->shopee_link }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-stone-500">Produk ini bukan produk dropship. Harga ditentukan
                                manual.</p>
                        @endif
                    </div>

                    {{-- Info Tambahan --}}
                    <div class="grid grid-cols-2 gap-3 text-xs text-stone-500 border-t border-stone-100 pt-4">
                        <div>Dibuat: <span
                                class="text-stone-700">{{ $viewingProduct->created_at?->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</span>
                        </div>
                        <div>Diperbarui: <span
                                class="text-stone-700">{{ $viewingProduct->updated_at?->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <livewire:admin.products.create />
    <livewire:admin.products.edit />
</div>
