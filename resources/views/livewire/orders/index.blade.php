<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <span
                    class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">
                    Pesanan Saya
                </span>
                <h1 class="text-2xl md:text-3xl font-semibold text-[#1f1f1f]">Riwayat Transaksi</h1>
                <p class="mt-2 text-sm text-[#6a5a4f]">Pantau status pesanan dan riwayat pembelian Anda.</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search Invoice --}}
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-[#aaa]" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nomor invoice (INV-...)"
                    class="w-full rounded-2xl border border-[#c19a6b]/30 bg-white pl-11 pr-10 py-3 text-sm shadow-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20" />

                @if ($search)
                    <button wire:click="clearSearch"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#aaa] hover:text-[#a47551] transition-colors">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                @endif
            </div>

            {{-- Status Filter --}}
            <div class="w-full sm:w-56">
                <select wire:model.live="statusFilter"
                    class="w-full rounded-2xl border border-[#c19a6b]/30 bg-white px-4 py-3 text-sm shadow-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                    <option value="">Semua Status</option>
                    <option value="awaiting_payment">Menunggu Pembayaran</option>
                    <option value="awaiting_confirmation">Menunggu Konfirmasi</option>
                    <option value="processing">Diproses</option>
                    <option value="shipped">Dikirim</option>
                    <option value="delivered">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        {{-- Active filters badge --}}
        @if ($search || $statusFilter)
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs text-[#8b6f5c]">Filter aktif:</span>
                @if ($search)
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-[#f5e9df] px-3 py-1 text-xs font-medium text-[#7a5d45]">
                        Invoice: {{ $search }}
                        <button wire:click="$set('search', '')" class="hover:text-[#a47551]">×</button>
                    </span>
                @endif
                @if ($statusFilter)
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-[#f5e9df] px-3 py-1 text-xs font-medium text-[#7a5d45]">
                        Status: {{ $this->getStatusLabel($statusFilter) }}
                        <button wire:click="$set('statusFilter', '')" class="hover:text-[#a47551]">×</button>
                    </span>
                @endif
                <button wire:click="$set('search', ''); $set('statusFilter', '')"
                    class="text-xs text-[#a47551] hover:text-[#8f6243] font-medium">
                    Hapus semua filter
                </button>
            </div>
        @endif

        {{-- Result count --}}
        @if (!$orders->isEmpty())
            <p class="text-sm text-[#6a5a4f]">
                Menampilkan <span class="font-semibold text-[#2b1d12]">{{ $orders->total() }}</span> pesanan
                @if ($search || $statusFilter)
                    dari hasil filter
                @endif
            </p>
        @endif

        {{-- Order List --}}
        @if ($orders->isEmpty())
            <div class="rounded-3xl border border-stone-200 bg-white p-10 text-center shadow-sm">
                <div
                    class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-[#f7ede0]/80 text-[#a47551]">
                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 12h6M9 16h6M9 8h6" />
                        <path d="M6 21h12a2 2 0 0 0 2-2V7l-5-4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-[#2b1d12]">
                    {{ $search || $statusFilter ? 'Pesanan tidak ditemukan' : 'Belum ada transaksi' }}
                </h2>
                <p class="mt-2 text-sm leading-7 text-[#6a5a4f]">
                    {{ $search || $statusFilter
                        ? 'Tidak ada pesanan yang sesuai dengan filter. Coba ubah kata kunci atau hapus filter.'
                        : 'Anda belum melakukan transaksi apapun.' }}
                </p>
                @if ($search || $statusFilter)
                    <button wire:click="$set('search', ''); $set('statusFilter', '')"
                        class="mt-4 text-sm font-semibold text-[#a47551] hover:text-[#8f6243]">
                        Hapus semua filter →
                    </button>
                @else
                    <a href="{{ route('shop') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors">
                        Mulai Belanja
                    </a>
                @endif
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', $order->invoice_number) }}" wire:navigate
                        class="block rounded-3xl border border-stone-200/60 bg-white p-5 shadow-sm transition hover:shadow-md hover:border-[#c19a6b]/30">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            {{-- Left --}}
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7ede0] text-[#a47551]">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 12h6M9 16h6M9 8h6" />
                                        <path d="M6 21h12a2 2 0 0 0 2-2V7l-5-4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#2b1d12]">{{ $order->invoice_number }}</p>
                                    <p class="text-xs text-[#6a5a4f] mt-1">
                                        {{ $order->created_at->format('d M Y, H:i') }} WIB
                                    </p>
                                    <p class="text-xs text-[#8b6f5c] mt-0.5">
                                        {{ $order->items_count }} produk
                                    </p>
                                </div>
                            </div>

                            {{-- Right --}}

                            <div class="flex items-center gap-3 md:text-right">
                                <span
                                    class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-semibold
                                    {{ $this->getStatusColor($order->status) }}">
                                    {{ $this->getStatusLabel($order->status) }}
                                </span>

                                <div>

                                    <p class="text-lg font-semibold text-[#a47551]">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
