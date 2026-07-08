<div wire:poll.3s class="max-w-4xl mx-auto px-4 py-6 sm:py-10">
    <div class="space-y-4 sm:space-y-6">
        {{-- Back button --}}
        <a href="{{ route('orders.index') }}" wire:navigate
            class="inline-flex items-center gap-1.5 text-sm text-[#6a5a4f] hover:text-[#a47551] transition">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        {{-- Header --}}
        <div class="rounded-2xl sm:rounded-3xl border border-stone-200 bg-white p-4 sm:p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70">Detail Pesanan</p>
            <h1 class="mt-1 text-xl sm:text-2xl font-semibold text-[#2b1d12] break-all">{{ $order->invoice_number }}
            </h1>
            <p class="text-sm text-[#6a5a4f] mt-1">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>

            {{-- Status + Actions --}}
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span
                    class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs sm:text-sm font-semibold {{ $this->getStatusColor($order->status) }}">
                    {{ $this->getStatusLabel($order->status) }}
                </span>

                @if ($order->status === 'awaiting_payment')
                    <a href="{{ route('orders.pay', $order->invoice_number) }}" wire:navigate
                        class="inline-flex items-center gap-1.5 rounded-xl bg-[#a47551] px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors whitespace-nowrap">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <line x1="2" y1="10" x2="22" y2="10" />
                        </svg>
                        Bayar
                    </a>
                @endif

                {{-- Tombol Request Batal --}}
                @if (in_array($order->status, ['awaiting_payment', 'awaiting_confirmation', 'cancel_requested']) &&
                        !$order->cancel_requested_at)
                    <div x-data="{ open: false }">
                        <button @click="open = true"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-white px-4 py-2 text-xs sm:text-sm font-medium text-rose-600 hover:bg-rose-50 transition-colors whitespace-nowrap">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            Batal
                        </button>

                        {{-- Fullscreen popup di mobile, popover di desktop --}}
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 sm:bg-transparent sm:relative sm:z-auto sm:p-0 sm:block"
                            @click.self="open = false">
                            <div class="bg-white rounded-2xl w-full max-w-[90vw] sm:absolute sm:right-0 sm:top-full sm:mt-2 sm:w-72 sm:border sm:border-stone-200 sm:shadow-xl p-4 z-50"
                                @click.outside="open = false">
                                <p class="text-sm font-semibold text-stone-800 mb-2 sm:hidden">Request Pembatalan</p>
                                <textarea wire:model="cancelReason" rows="2" placeholder="Tulis alasan pembatalan..."
                                    class="w-full rounded-xl border border-stone-200 px-3 py-2 text-sm focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200/50"></textarea>
                                <div class="flex gap-2 mt-3">
                                    <button wire:click="requestCancel({{ $order->id }})" @click="open = false"
                                        class="flex-1 rounded-xl bg-rose-500 px-3 py-2.5 text-sm font-medium text-white hover:bg-rose-600 transition-colors">
                                        Kirim
                                    </button>
                                    <button @click="open = false; $wire.set('cancelReason', '')"
                                        class="flex-1 rounded-xl bg-stone-100 px-3 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Request Cancel Status --}}
            @if ($order->cancel_requested_at && $order->status === 'cancel_requested')
                <div class="mt-4 rounded-xl bg-orange-50 border border-orange-200 px-4 py-3">
                    <p class="text-xs font-medium text-orange-600 uppercase tracking-wider">Request Pembatalan Dikirim
                    </p>
                    <p class="text-sm text-orange-700 mt-1">{{ $order->cancel_reason }}</p>
                    <p class="text-xs text-orange-500 mt-1">Menunggu konfirmasi admin</p>
                </div>
            @endif

            {{-- Cancel Rejected --}}
            @if ($order->cancel_rejected_reason)
                <div class="mt-4 rounded-xl bg-amber-50 border border-amber-200 px-4 py-3">
                    <p class="text-xs font-medium text-amber-600 uppercase tracking-wider">Pembatalan Ditolak</p>
                    <p class="text-sm text-amber-700 mt-1">{{ $order->cancel_rejected_reason }}</p>
                    <p class="text-xs text-amber-500 mt-1">Pesanan kembali ke status pembayaran. Silakan lanjutkan
                        pembayaran.</p>
                </div>
            @endif
        </div>

        {{-- Items --}}
        <div class="rounded-2xl sm:rounded-3xl border border-stone-200 bg-white p-4 sm:p-6 shadow-sm"
            x-data="{ open: true }">
            <button @click="open = !open" class="w-full flex items-center justify-between">
                <h2 class="text-base sm:text-lg font-semibold text-[#2b1d12]">Produk Dipesan</h2>
                <svg class="h-5 w-5 text-stone-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="open" x-collapse x-cloak>
                <div class="mt-4 space-y-2">
                    @foreach ($order->items as $item)
                        <a href="{{ route('product.detail', $item->product_id) }}" wire:navigate
                            class="flex items-center gap-3 rounded-xl border border-stone-200/60 bg-[#fff7ed] p-3 hover:shadow-sm transition">
                            <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}"
                                class="h-14 w-14 rounded-xl object-cover border border-stone-200/60 shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[#2b1d12] truncate">{{ $item->product_name }}
                                </p>
                                <p class="text-xs text-[#7a5a4f]">{{ $item->qty }}x Rp
                                    {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-semibold text-[#8b6f5c] shrink-0">Rp
                                {{ number_format($item->line_total, 0, ',', '.') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Tracking --}}
        @if ($order->trackingEvents->isNotEmpty())
            <div class="rounded-2xl sm:rounded-3xl border border-stone-200 bg-white p-4 sm:p-6 shadow-sm"
                x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between">
                    <h2 class="text-base sm:text-lg font-semibold text-[#2b1d12]">Lacak Pesanan</h2>
                    <svg class="h-5 w-5 text-stone-400 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-4 space-y-0">
                        @foreach ($order->trackingEvents as $event)
                            <div class="relative flex gap-3 sm:gap-4 pb-5 sm:pb-6 last:pb-0">
                                @if (!$loop->last)
                                    <div
                                        class="absolute left-[15px] sm:left-[19px] top-10 bottom-0 w-0.5 bg-[#ede0d4]">
                                    </div>
                                @endif
                                <div
                                    class="relative z-10 flex h-8 w-8 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full border-2 {{ $loop->first ? 'border-[#a47551] bg-[#a47551]/10' : 'border-[#ede0d4] bg-white' }}">
                                    <div
                                        class="h-2 w-2 sm:h-2.5 sm:w-2.5 rounded-full {{ $loop->first ? 'bg-[#a47551]' : 'bg-[#d4c3b3]' }}">
                                    </div>
                                </div>
                                <div class="pt-1 sm:pt-2 min-w-0">
                                    <p class="font-semibold text-[#2b1d12] text-xs sm:text-sm">{{ $event->title }}
                                    </p>
                                    @if ($event->description)
                                        <p class="text-[0.65rem] sm:text-xs text-[#6a5a4f] mt-0.5">
                                            {{ $event->description }}</p>
                                    @endif
                                    <p class="text-[0.65rem] sm:text-xs text-[#aaa] mt-1">
                                        {{ $event->occurred_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        WIB
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Rincian --}}
        <div class="rounded-2xl sm:rounded-3xl border border-stone-200 bg-white p-4 sm:p-6 shadow-sm"
            x-data="{ open: true }">
            <button @click="open = !open" class="w-full flex items-center justify-between">
                <h2 class="text-base sm:text-lg font-semibold text-[#2b1d12]">Rincian Pembayaran</h2>
                <svg class="h-5 w-5 text-stone-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="open" x-collapse x-cloak>
                <div class="mt-4 space-y-2 text-sm">
                    @php
                        $subtotal = $order->items->sum('line_total');
                        $shipping = $order->shipping_fee;
                    @endphp
                    <div class="flex justify-between">
                        <span class="text-[#6a5a4f]">Subtotal ({{ $order->items->sum('qty') }} produk)</span>
                        <span class="font-semibold text-[#2b1d12]">Rp
                            {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#6a5a4f]">Ongkos Kirim</span>
                        <span class="font-semibold text-[#2b1d12]">Rp
                            {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="h-px bg-stone-200"></div>
                    <div class="flex justify-between text-base font-semibold text-[#1f1f1f]">
                        <span>Total</span>
                        <span class="text-[#a47551]">Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Info --}}
        @if ($order->shipping_address)
            <div class="rounded-2xl sm:rounded-3xl border border-stone-200 bg-white p-4 sm:p-6 shadow-sm"
                x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between">
                    <h2 class="text-base sm:text-lg font-semibold text-[#2b1d12]">Alamat Pengiriman</h2>
                    <svg class="h-5 w-5 text-stone-400 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-4 flex items-start gap-3">
                        <div
                            class="flex h-8 w-8 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-xl bg-[#f7ede0] text-[#a47551]">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-[#2b1d12] text-xs sm:text-sm">Dikirim ke:</p>
                            <p class="text-xs sm:text-sm text-[#6a5a4f] leading-relaxed break-words">
                                {{ $order->shipping_address }}</p>
                            @if ($order->payment_method)
                                <p class="text-[0.65rem] sm:text-xs text-[#aaa] mt-2">Metode bayar:
                                    {{ $order->payment_method }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
