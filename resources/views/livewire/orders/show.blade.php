<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="space-y-6" wire:poll.5s>
        {{-- Back button --}}
        <a href="{{ route('orders.index') }}" wire:navigate
            class="inline-flex items-center gap-1.5 text-sm text-[#6a5a4f] hover:text-[#a47551] transition">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Kembali ke daftar pesanan
        </a>

        {{-- Header --}}
        <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70">Detail Pesanan</p>
                    <h1 class="mt-2 text-2xl font-semibold text-[#2b1d12]">{{ $order->invoice_number }}</h1>
                    <p class="text-sm text-[#6a5a4f] mt-1">
                        {{ $order->created_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>
                <span
                    class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold
                    {{ $this->getStatusColor($order->status) }}">
                    {{ $this->getStatusLabel($order->status) }}
                </span>
            </div>

            @if ($order->status === 'awaiting_payment')
                <div class="mt-4">
                    <a href="{{ route('orders.pay', $order->invoice_number) }}" wire:navigate
                        class="inline-flex items-center gap-2 rounded-2xl bg-[#a47551] px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors">
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <line x1="2" y1="10" x2="22" y2="10" />
                        </svg>
                        Bayar Sekarang
                    </a>
                </div>
            @endif
        </div>

        {{-- Items --}}
        <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" x-data="{ open: true }">
            <button @click="open = !open" class="w-full flex items-center justify-between">
                <h2 class="text-lg font-semibold text-[#2b1d12]">Produk Dipesan</h2>
                <svg class="h-5 w-5 text-stone-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="open" x-collapse x-cloak>
                <div class="mt-4 space-y-3">
                    @foreach ($order->items as $item)
                        <a href="{{ route('product.detail', $item->product_id) }}" wire:navigate
                            class="flex items-center gap-4 rounded-2xl border border-stone-200/60 bg-[#fff7ed] p-4 hover:shadow-sm hover:border-[#c19a6b]/40 transition">
                            <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}"
                                class="h-16 w-16 rounded-xl object-cover border border-stone-200/60 shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-[#2b1d12] hover:text-[#a47551] transition-colors">
                                    {{ $item->product_name }}</p>
                                <p class="text-xs text-[#7a5a4f]">{{ $item->qty }}x Rp
                                    {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-[#8b6f5c] shrink-0">Rp
                                {{ number_format($item->line_total, 0, ',', '.') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Tracking --}}
        @if ($order->trackingEvents->isNotEmpty())
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-[#2b1d12]">Lacak Pesanan</h2>
                    <svg class="h-5 w-5 text-stone-400 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-4 space-y-0">
                        @foreach ($order->trackingEvents as $event)
                            <div class="relative flex gap-4 pb-6 last:pb-0">
                                @if (!$loop->last)
                                    <div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-[#ede0d4]"></div>
                                @endif
                                <div
                                    class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2
                                    {{ $loop->first ? 'border-[#a47551] bg-[#a47551]/10' : 'border-[#ede0d4] bg-white' }}">
                                    <div
                                        class="h-2.5 w-2.5 rounded-full {{ $loop->first ? 'bg-[#a47551]' : 'bg-[#d4c3b3]' }}">
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <p class="font-semibold text-[#2b1d12] text-sm">{{ $event->title }}</p>
                                    @if ($event->description)
                                        <p class="text-xs text-[#6a5a4f] mt-0.5">{{ $event->description }}</p>
                                    @endif
                                    <p class="text-xs text-[#aaa] mt-1">
                                        {{ $event->occurred_at->format('d M Y, H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Rincian --}}
        <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" x-data="{ open: true }">
            <button @click="open = !open" class="w-full flex items-center justify-between">
                <h2 class="text-lg font-semibold text-[#2b1d12]">Rincian Pembayaran</h2>
                <svg class="h-5 w-5 text-stone-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>
            <div x-show="open" x-collapse x-cloak>
                <div class="mt-4 space-y-3 text-sm text-[#6a5a4f]">
                    @php
                        $subtotal = $order->items->sum('line_total');
                        $shipping = $order->shipping_fee;
                    @endphp
                    <div class="flex justify-between">
                        <span>Subtotal ({{ $order->items->sum('qty') }} produk)</span>
                        <span class="font-semibold text-[#2b1d12]">Rp
                            {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkos Kirim</span>
                        <span class="font-semibold text-[#2b1d12]">Rp
                            {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="h-px bg-stone-200"></div>
                    <div class="flex justify-between text-base font-semibold text-[#1f1f1f]">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Info --}}
        @if ($order->shipping_address)
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm" x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-[#2b1d12]">Alamat Pengiriman</h2>
                    <svg class="h-5 w-5 text-stone-400 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div x-show="open" x-collapse x-cloak>
                    <div class="mt-4 flex items-start gap-3">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#f7ede0] text-[#a47551]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold text-[#2b1d12] text-sm">Dikirim ke:</p>
                            <p class="text-sm text-[#6a5a4f] leading-relaxed">{{ $order->shipping_address }}</p>
                            @if ($order->payment_method)
                                <p class="text-xs text-[#aaa] mt-2">Metode bayar: {{ $order->payment_method }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
