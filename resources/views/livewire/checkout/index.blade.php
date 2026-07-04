<div class="grid gap-8 xl:grid-cols-[1.9fr_1fr]">
    <div class="space-y-6">
        <section class="rounded-2xl border border-stone-200/60 bg-white p-6 shadow-[0_24px_50px_rgba(34,25,17,0.08)]">
            <div class="flex flex-col gap-2">
                <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70">Alamat Pengiriman</p>
                <h2 class="text-2xl font-semibold text-[#2b1d12]" style="font-family: 'Quicksand', 'Nunito', sans-serif;">
                    1. Alamat tujuan</h2>
                <p class="text-sm text-[#6a5a4f]" style="font-family: 'Plus Jakarta Sans', sans-serif;">Alamat utama kamu
                    akan digunakan untuk mengirimkan pesanan. Pastikan sudah lengkap dan benar.</p>
            </div>

            @if (empty($selectedAddress))
                <div class="mt-6 rounded-2xl border border-amber-200/80 bg-amber-50/70 p-5 text-sm text-[#8f5d34]">
                    <p class="font-semibold">Silakan lengkapi alamat pengiriman Anda terlebih dahulu untuk melanjutkan
                        pembayaran.</p>
                    <p class="mt-2">Belum ada alamat utama yang tersimpan. Tambahkan alamat utama di menu <a
                            href="{{ route('account.addresses') }}"
                            class="font-semibold text-[#a47551] underline hover:text-[#8f6243]">Alamat</a>.</p>
                </div>
            @else
                <div class="mt-6 rounded-2xl border border-stone-200/60 bg-[#fff7ed] p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm uppercase tracking-[0.24em] text-[#8b6f5c]/70">Alamat Utama</p>
                            <h3 class="mt-2 text-lg font-semibold text-[#2b1d12]">
                                {{ ucfirst($selectedAddress['label']) }}</h3>
                        </div>
                        <a href="{{ route('account.addresses') }}"
                            class="text-sm font-semibold text-[#a47551] hover:text-[#8f6243]">Ubah</a>
                    </div>
                    <div class="mt-4 space-y-2 text-sm text-[#5f4a3f]"
                        style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <p class="font-semibold text-[#3d2b1c]">{{ $selectedAddress['recipient_name'] }} •
                            {{ $selectedAddress['phone'] }}</p>
                        <p>{{ $selectedAddress['street'] }}, {{ $selectedAddress['region'] }}</p>
                        @if ($selectedAddress['detail'])
                            <p>{{ $selectedAddress['detail'] }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        <section class="rounded-2xl border border-stone-200/60 bg-white p-6 shadow-[0_24px_50px_rgba(34,25,17,0.08)]">
            <div class="flex flex-col gap-2">
                <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70">Metode Pembayaran</p>
                <h2 class="text-2xl font-semibold text-[#2b1d12]"
                    style="font-family: 'Quicksand', 'Nunito', sans-serif;">2. Pilih cara bayar</h2>
                <p class="text-sm text-[#6a5a4f]" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pilih metode
                    pembayaran yang paling nyaman untuk Anda.</p>
            </div>

            @if ($paymentNotice && empty($selectedAddress))
                <div class="mt-6 rounded-2xl border border-amber-200/80 bg-amber-50/70 p-4 text-sm text-[#8f5d34]">
                    {{ $paymentNotice }}
                </div>
            @endif

            <div
                class="mt-6 grid gap-4 sm:grid-cols-3 {{ empty($selectedAddress) ? 'opacity-50 pointer-events-none' : '' }}">
                @foreach ($paymentMethods as $method)
                    <button type="button" wire:click="selectPayment({{ $method['id'] }})"
                        class="group flex flex-col justify-between rounded-3xl border bg-white p-5 text-left transition-all duration-200 focus:outline-none
                            {{ $selectedPayment === $method['id'] ? 'border-amber-600/70 bg-amber-50 shadow-sm shadow-amber-200/60' : 'border-stone-200 hover:border-amber-300 hover:bg-[#ffefda]' }}">
                        <div class="flex items-center justify-between gap-4">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#f7e7d8] text-[#a05d2c]">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="{{ $method['icon'] ?? 'M6 8h12M6 12h12M6 16h12' }}" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-[#2b1d12]">{{ $method['label'] }}</p>
                                <p class="text-xs text-[#6a5a4f]">{{ $method['subtitle'] }}</p>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-2 text-sm font-semibold text-[#6a5a4f]">
                            <span
                                class="inline-flex h-3 w-3 rounded-full {{ $selectedPayment === $method['id'] ? 'bg-amber-600' : 'bg-stone-300' }}"></span>
                            <span>{{ $selectedPayment === $method['id'] ? 'Dipilih' : 'Pilih metode ini' }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </section>
    </div>

    <aside class="lg:sticky lg:top-24">
        <div class="rounded-3xl border border-stone-200/60 bg-white p-6 shadow-[0_24px_50px_rgba(34,25,17,0.06)]">
            <h2 class="text-lg font-semibold text-[#2b1d12]" style="font-family: 'Quicksand', 'Nunito', sans-serif;">
                Ringkasan Pesanan</h2>
            <div class="mt-6 space-y-4 text-sm text-[#6a5a4f]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                @foreach ($cartItems as $item)
                    <div
                        class="flex items-center justify-between rounded-3xl border border-stone-200/60 bg-[#fff7ed] p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="h-14 w-14 rounded-xl object-cover border border-stone-200">
                            <div class="space-y-1">
                                <p class="font-semibold text-[#2b1d12]">{{ $item['name'] }}</p>
                                <p class="text-xs text-[#7a5a4f]">x{{ $item['quantity'] }}</p>
                            </div>
                        </div>
                        <p class="font-semibold text-[#8b6f5c]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach

                <div class="rounded-3xl border border-stone-200/60 bg-[#faf5ef] p-4">
                    <div class="flex items-center justify-between text-sm">
                        <span>Subtotal</span>
                        <span class="font-semibold text-[#2b1d12]">Rp
                            {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <span>Ongkos kirim</span>
                        <span class="font-semibold text-[#2b1d12]">Rp
                            {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <span>Diskon</span>
                        <span class="font-semibold text-[#2b1d12]">- Rp
                            {{ number_format($discountAmount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-base font-semibold text-[#2b1d12]">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <button type="button" wire:click="placeOrder" wire:loading.attr="disabled" @disabled(!$this->canCheckout)
                class="mt-6 w-full rounded-3xl px-5 py-4 text-sm font-semibold text-white shadow-lg transition-all duration-200
               {{ $this->canCheckout
                   ? 'bg-[#a47551] shadow-[#a47551]/20 hover:scale-[1.01]'
                   : 'bg-stone-300 cursor-not-allowed shadow-none hover:scale-100' }}"
                title="{{ $this->checkoutDisabledReason }}">
                <span wire:loading.remove>
                    @if ($this->canCheckout)
                        Selesaikan Pesanan
                    @else
                        {{ $this->checkoutDisabledReason }}
                    @endif
                </span>
                <span wire:loading>Memproses...</span>
            </button>

            <p class="mt-4 text-xs text-[#6a5a4f]">🔒 Pembayaran Anda dienkripsi dengan aman dan data pribadi Anda 100%
                terlindungi.</p>
        </div>
    </aside>
</div>
