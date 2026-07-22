<div class="grid gap-8 xl:grid-cols-[1.8fr_1fr]">
    <div class="space-y-6">
        {{-- Pending Order --}}
        @php
            $pendingOrder = App\Models\Order::where('user_id', Auth::id())
                ->whereIn('status', ['awaiting_payment', 'awaiting_confirmation'])
                ->first();
        @endphp
        @if ($pendingOrder)
            <div
                class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-amber-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-700">Pesanan belum diselesaikan</p>
                        <p class="text-xs text-amber-600 mt-0.5">{{ $pendingOrder->invoice_number }} - Rp
                            {{ number_format($pendingOrder->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <a href="{{ route('orders.show', $pendingOrder->invoice_number) }}"
                    class="text-sm font-semibold text-[#a47551] hover:text-[#8f6243] whitespace-nowrap">Lanjut Bayar
                    →</a>
            </div>
        @endif

        {{-- Alamat --}}
        <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                    <svg class="h-5.5 w-5.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70 mb-1">Langkah 1</p>
                    <h2 class="text-xl font-semibold text-[#2b1d12]">Alamat Pengiriman</h2>
                </div>
            </div>
            @if (empty($selectedAddress))
                <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50/70 p-5 text-sm text-[#8f5d34]">Alamat
                    belum tersedia. <a href="{{ route('account.addresses') }}"
                        class="font-semibold underline hover:text-[#a47551]">Tambah di Alamat Saya</a>.</div>
            @else
                <div class="mt-6 rounded-2xl border border-[#e8d5c4] bg-[#fefbf8] p-5">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="inline-flex items-center rounded-full bg-[#f5e9df] px-3 py-1 text-xs font-semibold text-[#7a5d45]">{{ ucfirst($selectedAddress['label']) }}</span>
                        <a href="{{ route('account.addresses') }}" class="text-sm font-semibold text-[#a47551]">Ubah</a>
                    </div>
                    <p class="font-semibold text-base">{{ $selectedAddress['recipient_name'] }}</p>
                    <p class="text-sm text-[#7a5a4f]">{{ $selectedAddress['phone'] }}</p>
                    <div class="h-px bg-[#ede0d4] my-3"></div>
                    <p class="text-sm text-[#5f4a3f]">{{ $selectedAddress['street'] }}, {{ $selectedAddress['region'] }}
                    </p>
                </div>
            @endif
        </section>

        {{-- Pembayaran --}}
        <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                    <svg class="h-5.5 w-5.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70 mb-1">Langkah 2</p>
                    <h2 class="text-xl font-semibold text-[#2b1d12]">Pembayaran</h2>
                    <p class="mt-1 text-sm text-[#6a5a4f]">Bayar aman melalui Midtrans. Pilih metode di popup
                        pembayaran.</p>
                </div>
            </div>
        </section>
    </div>

    {{-- Right --}}
    <aside class="hidden lg:block lg:sticky lg:top-28 self-start">
        <div class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-7">
            <h2 class="text-lg font-semibold text-[#2b1d12] mb-4">Ringkasan</h2>
            <div class="space-y-2.5 mb-5">
                @foreach ($cartItems as $item)
                    <div class="flex items-center gap-3">
                        <img src="{{ $item['image'] }}"
                            class="h-12 w-12 rounded-xl object-cover border border-[#ede0d4] shrink-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-[#6a5a4f]">{{ $item['quantity'] }}x Rp
                                {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-[#a47551] tabular-nums">Rp
                            {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            <div class="h-px bg-[#ede0d4] mb-5"></div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-[#6a5a4f]">Subtotal</span><span
                        class="font-semibold tabular-nums">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-[#6a5a4f]">Ongkir</span><span
                        class="font-semibold tabular-nums">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                </div>
                @if ($discountAmount > 0)
                    <div class="flex justify-between text-emerald-600"><span>Diskon</span><span
                            class="font-semibold tabular-nums">-Rp
                            {{ number_format($discountAmount, 0, ',', '.') }}</span></div>
                @endif
                <div class="h-px bg-[#ede0d4]"></div>
                <div class="flex justify-between text-base font-bold"><span>Total</span><span
                        class="text-[#a47551] tabular-nums">Rp {{ number_format($total, 0, ',', '.') }}</span></div>
            </div>
            @if ($this->canCheckout)
                <button wire:click="placeOrder" wire:loading.attr="disabled"
                    class="mt-6 w-full rounded-2xl bg-[#a47551] px-5 py-3.5 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] transition-all duration-200">Bayar
                    Sekarang</button>
            @else
                <button disabled
                    class="mt-6 w-full rounded-2xl bg-stone-200 px-5 py-3.5 text-sm font-semibold text-stone-400 cursor-not-allowed">{{ $this->checkoutDisabledReason }}</button>
            @endif
        </div>
    </aside>

    {{-- Mobile --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-[#e8d5c4]"
        x-data="{ expanded: false }">
        <div class="px-4 py-3">
            <div class="flex items-center justify-between mb-2">
                <button @click="expanded = !expanded" class="flex items-center gap-1.5 text-sm font-semibold">Ringkasan
                    <svg class="h-4 w-4 transition-transform" :class="expanded ? 'rotate-180' : ''" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9" />
                    </svg></button>
                <span class="text-base font-bold text-[#a47551] tabular-nums">Rp
                    {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            @if ($this->canCheckout)
                <button wire:click="placeOrder"
                    class="w-full rounded-2xl bg-[#a47551] px-5 py-3 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] transition-all duration-200">Bayar
                    Sekarang</button>
            @else
                <button disabled
                    class="w-full rounded-2xl bg-stone-200 px-5 py-3 text-sm font-semibold text-stone-400 cursor-not-allowed">{{ $this->checkoutDisabledReason }}</button>
            @endif
        </div>
        <div x-show="expanded" x-collapse class="px-4 pb-4 border-t border-[#ede0d4]">
            <div class="space-y-2 pt-3 text-sm">
                @foreach ($cartItems as $item)
                    <div class="flex justify-between"><span class="truncate max-w-[65%]">{{ $item['name'] }}
                            (x{{ $item['quantity'] }})</span><span class="tabular-nums">Rp
                            {{ number_format($item['subtotal'], 0, ',', '.') }}</span></div>
                @endforeach
                <div class="h-px bg-[#ede0d4]"></div>
                <div class="flex justify-between"><span>Subtotal</span><span class="tabular-nums">Rp
                        {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span>Ongkir</span><span class="tabular-nums">Rp
                        {{ number_format($shippingCost, 0, ',', '.') }}</span></div>
                @if ($discountAmount > 0)
                    <div class="flex justify-between text-emerald-600"><span>Diskon</span><span
                            class="tabular-nums">-Rp {{ number_format($discountAmount, 0, ',', '.') }}</span></div>
                @endif
            </div>
        </div>
    </div>
    <div class="lg:hidden h-28"></div>
</div>
