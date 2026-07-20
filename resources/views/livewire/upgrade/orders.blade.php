<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <span
                    class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">
                    Plus Saya
                </span>
                <h1 class="text-2xl md:text-3xl font-semibold text-[#1f1f1f]">Riwayat Langganan</h1>
                <p class="mt-2 text-sm text-[#6a5a4f]">Pantau status upgrade dan riwayat langganan Plus kamu.</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-[#aaa]" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nomor invoice (UPG-...)"
                    class="w-full rounded-2xl border border-[#c19a6b]/30 bg-white pl-11 pr-10 py-3 text-sm shadow-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20" />
                @if ($search)
                    <button wire:click="clearSearch"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-[#aaa] hover:text-[#a47551] transition-colors">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                @endif
            </div>
            <div class="w-full sm:w-56">
                <select wire:model.live="statusFilter"
                    class="w-full rounded-2xl border border-[#c19a6b]/30 bg-white px-4 py-3 text-sm shadow-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                    <option value="">Semua Status</option>
                    <option value="awaiting_payment">Menunggu Pembayaran</option>
                    <option value="awaiting_confirmation">Menunggu Konfirmasi</option>
                    <option value="completed">Aktif</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>

        {{-- List --}}
        @if ($orders->isEmpty())
            <div class="rounded-3xl border border-stone-200 bg-white p-10 text-center shadow-sm">
                <div
                    class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-[#f7ede0]/80 text-[#a47551]">
                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-[#2b1d12]">
                    {{ $search || $statusFilter ? 'Tidak ditemukan' : 'Belum ada langganan' }}</h2>
                <p class="mt-2 text-sm leading-7 text-[#6a5a4f]">
                    {{ $search || $statusFilter ? 'Tidak ada langganan yang sesuai dengan filter.' : 'Kamu belum pernah berlangganan MindHug Plus.' }}
                </p>
                @if (!$search && !$statusFilter)
                    <a href="{{ route('plus') }}" wire:navigate
                        class="mt-6 inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors">
                        Upgrade ke Plus
                    </a>
                @endif
            </div>
        @else
            <div class="space-y-3">
                @foreach ($orders as $order)
                    <a href="{{ route('plus.orders.show', $order->invoice_number) }}" wire:navigate
                        class="block rounded-2xl sm:rounded-3xl border border-stone-200/60 bg-white p-4 sm:p-5 shadow-sm transition hover:shadow-md hover:border-[#c19a6b]/30">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-[#2b1d12] text-sm">
                                    {{ $order->plan->name ?? 'MindHug Plus' }}
                                </p>
                                <p class="text-xs text-[#6a5a4f] mt-0.5">
                                    {{ $order->invoice_number }} · {{ $order->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span
                                    class="text-[0.65rem] sm:text-xs px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full font-medium {{ $this->getStatusColor($order->status) }}">
                                    {{ $this->getStatusLabel($order->status) }}
                                </span>
                                <p class="text-sm sm:text-base font-semibold text-[#a47551]">
                                    Rp {{ number_format($order->amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
