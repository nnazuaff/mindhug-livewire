<div class="grid gap-8 xl:grid-cols-[1.8fr_1fr]">
    {{-- LEFT COLUMN --}}
    <div class="space-y-6">

        {{-- Step 1: Alamat --}}
        <section class="rounded-[1.75rem] border border-stone-200/60 bg-white p-6 sm:p-8 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70 mb-1">Langkah 1</p>
                    <h2 class="text-xl font-semibold text-[#2b1d12]">Alamat Pengiriman</h2>
                    <p class="mt-1 text-sm text-[#6a5a4f]">Pastikan alamat sudah benar sebelum melanjutkan.</p>
                </div>
            </div>

            @if (empty($selectedAddress))
                <div class="mt-6 rounded-2xl border border-amber-200/80 bg-amber-50/70 p-5 text-sm text-[#8f5d34]">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-amber-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <div>
                            <p class="font-semibold">Alamat pengiriman belum tersedia</p>
                            <p class="mt-1 text-[#8f5d34]/80">
                                Silakan tambahkan alamat utama terlebih dahulu di menu
                                <a href="{{ route('account.addresses') }}"
                                    class="font-semibold underline hover:text-[#a47551]">Alamat Saya</a>.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-6 rounded-2xl border border-stone-200/60 bg-[#fefbf8] p-5">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center rounded-full bg-[#f5e9df] px-3 py-1 text-xs font-semibold text-[#7a5d45]">
                                {{ ucfirst($selectedAddress['label']) }}
                            </span>
                            <span class="text-xs text-[#aaa]">Alamat Utama</span>
                        </div>
                        <a href="{{ route('account.addresses') }}"
                            class="text-sm font-semibold text-[#a47551] hover:text-[#8f6243] transition-colors duration-200">
                            Ubah
                        </a>
                    </div>
                    <div class="space-y-2 text-sm text-[#5f4a3f]">
                        <p class="font-semibold text-[#3d2b1c] text-base">{{ $selectedAddress['recipient_name'] }}</p>
                        <p class="text-[#7a5a4f]">{{ $selectedAddress['phone'] }}</p>
                        <div class="h-px bg-stone-200/60 my-3"></div>
                        <p class="leading-relaxed">{{ $selectedAddress['street'] }}</p>
                        <p class="leading-relaxed">{{ $selectedAddress['region'] }}</p>
                        @if ($selectedAddress['detail'])
                            <p class="text-[#7a5a4f] text-xs mt-1">Catatan: {{ $selectedAddress['detail'] }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        {{-- Step 2: Pembayaran --}}
        <section class="rounded-[1.75rem] border border-stone-200/60 bg-white p-6 sm:p-8 shadow-sm">
            <div class="flex items-start gap-4 mb-6">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70 mb-1">Langkah 2</p>
                    <h2 class="text-xl font-semibold text-[#2b1d12]">Metode Pembayaran</h2>
                    <p class="mt-1 text-sm text-[#6a5a4f]">Pilih cara bayar yang paling nyaman.</p>
                </div>
            </div>

            @if ($paymentNotice && empty($selectedAddress))
                <div class="mb-6 rounded-2xl border border-amber-200/80 bg-amber-50/70 p-4 text-sm text-[#8f5d34]">
                    {{ $paymentNotice }}
                </div>
            @endif

            <div
                class="grid gap-4 sm:grid-cols-3 {{ empty($selectedAddress) ? 'opacity-50 pointer-events-none' : '' }}">
                @foreach ($paymentMethods as $method)
                    <button type="button" wire:click="selectPayment({{ $method['id'] }})"
                        class="group relative flex flex-col justify-between rounded-2xl border bg-white p-5 text-left transition-all duration-200 focus:outline-none
                            {{ $selectedPayment === $method['id']
                                ? 'border-[#a47551] bg-[#fdf8f3] shadow-sm'
                                : 'border-stone-200 hover:border-[#c19a6b]/50 hover:bg-[#fefbf8]' }}">

                        @if ($selectedPayment === $method['id'])
                            <div class="absolute top-3 right-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-[#a47551]">
                                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                                {{ $selectedPayment === $method['id'] ? 'bg-[#a47551]/10' : 'bg-[#f7ede0]' }}">
                                @if ($method['code'] === 'bank_transfer')
                                    <svg class="h-5 w-5 {{ $selectedPayment === $method['id'] ? 'text-[#a47551]' : 'text-[#8b6f5c]' }}"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="5" width="20" height="14" rx="2" />
                                        <line x1="2" y1="10" x2="22" y2="10" />
                                    </svg>
                                @elseif ($method['code'] === 'ewallet')
                                    <svg class="h-5 w-5 {{ $selectedPayment === $method['id'] ? 'text-[#a47551]' : 'text-[#8b6f5c]' }}"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                                        <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                                    </svg>
                                @else
                                    <img src="{{ asset('storage/images/quick-response-code-indonesia-standard-qris-seeklogo.svg') }}"
                                        alt="QRIS"
                                        class="h-5 w-5 {{ $selectedPayment === $method['id'] ? 'opacity-100' : 'opacity-50' }}">
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#2b1d12]">{{ $method['label'] }}</p>
                                <p class="text-xs text-[#6a5a4f] mt-0.5">{{ $method['subtitle'] }}</p>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-2 text-xs font-medium
                            {{ $selectedPayment === $method['id'] ? 'text-[#a47551]' : 'text-[#aaa]' }}">
                            <span
                                class="inline-flex h-2 w-2 rounded-full {{ $selectedPayment === $method['id'] ? 'bg-[#a47551]' : 'bg-stone-300' }}"></span>
                            <span>{{ $selectedPayment === $method['id'] ? 'Dipilih' : 'Klik untuk pilih' }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </section>
    </div>

    {{-- RIGHT COLUMN --}}
    <aside class="lg:sticky lg:top-28 self-start">
        <div class="rounded-[1.75rem] border border-stone-200/60 bg-white p-6 sm:p-7 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#f5e9df] text-[#a47551]">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6h15l-1.5 9h-12z" />
                        <path d="M6 6 4 3H1" />
                        <circle cx="9" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-[#2b1d12]">Ringkasan Pesanan</h2>
            </div>

            {{-- Items --}}
            <div class="space-y-3 mb-6">
                @foreach ($cartItems as $item)
                    <div class="flex items-center gap-3 rounded-2xl border border-stone-200/40 bg-[#fefbf8] p-3">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                            class="h-16 w-16 rounded-xl object-cover border border-stone-200/60">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-[#2b1d12] truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-[#7a5a4f] mt-0.5">{{ $item['quantity'] }}x Rp
                                {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-semibold text-[#a47551] shrink-0">Rp
                            {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Breakdown --}}
            <div class="rounded-2xl bg-[#faf5ef] p-4 space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[#6a5a4f]">Subtotal ({{ array_sum(array_column($cartItems, 'quantity')) }}
                        produk)</span>
                    <span class="font-semibold text-[#2b1d12]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#6a5a4f]">Ongkos Kirim</span>
                    <span class="font-semibold text-[#2b1d12]">Rp
                        {{ number_format($shippingCost, 0, ',', '.') }}</span>
                </div>
                @if ($discountAmount > 0)
                    <div class="flex items-center justify-between text-emerald-600">
                        <span>Diskon</span>
                        <span class="font-semibold">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="h-px bg-stone-200/60"></div>
                <div class="flex items-center justify-between text-base font-bold text-[#1f1f1f]">
                    <span>Total</span>
                    <span class="text-[#a47551]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- CTA --}}
            <button type="button" wire:click="placeOrder" wire:loading.attr="disabled" @disabled(!$this->canCheckout)
                class="mt-6 w-full rounded-2xl px-5 py-4 text-sm font-semibold transition-colors duration-200
               {{ $this->canCheckout
                   ? 'bg-[#a47551] text-white shadow-sm hover:bg-[#8f6243]'
                   : 'bg-stone-200 text-stone-400 cursor-not-allowed' }}"
                title="{{ $this->checkoutDisabledReason }}">
                <span wire:loading.remove>
                    {{ $this->canCheckout ? 'Buka Halaman Pembayaran' : $this->checkoutDisabledReason }}
                </span>
                <span wire:loading class="flex items-center justify-center gap-2">
                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                    </svg>
                    Memproses...
                </span>
            </button>

            {{-- Security --}}
            <div class="mt-4 flex items-center justify-center gap-2 text-xs text-[#8b6f5c]">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                Pembayaran aman & terenkripsi
            </div>
        </div>
    </aside>
</div>
