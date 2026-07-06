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
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                    <h2 class="text-lg font-semibold text-stone-800">{{ $viewingProduct->name }}</h2>
                    <button wire:click="closeDetail"
                        class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    @php
                        $pFiles = Storage::disk('public')->files('products/' . $viewingProduct->id);
                    @endphp
                    @if (!empty($pFiles))
                        <div class="grid grid-cols-4 gap-2">
                            @foreach ($pFiles as $file)
                                <img src="{{ asset('storage/products/' . $viewingProduct->id . '/' . basename($file)) }}"
                                    class="rounded-xl object-cover w-full h-20 border border-stone-200">
                            @endforeach
                        </div>
                    @endif
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">Kategori</p>
                            <p class="font-medium text-stone-700">{{ $viewingProduct->category?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Harga</p>
                            <p class="font-semibold text-[#a47551]">Rp
                                {{ number_format($viewingProduct->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Stok</p>
                            <p class="font-medium text-stone-700">{{ $viewingProduct->stock }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Badge</p>
                            <p class="font-medium text-stone-700">{{ $viewingProduct->badge ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Status</p>
                            <p
                                class="font-medium {{ $viewingProduct->is_active ? 'text-emerald-600' : 'text-stone-400' }}">
                                {{ $viewingProduct->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Harga Shopee</p>
                            <p class="font-medium text-stone-700">Rp
                                {{ number_format($viewingProduct->shopee_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @if ($viewingProduct->description)
                        <div>
                            <p class="text-stone-400 text-xs mb-1">Deskripsi</p>
                            <p class="text-sm text-stone-600">{{ $viewingProduct->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <livewire:admin.products.create />
    <livewire:admin.products.edit />
</div>
