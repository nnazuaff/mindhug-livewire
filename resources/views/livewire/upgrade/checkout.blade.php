<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('plus') }}" wire:navigate
        class="inline-flex items-center gap-1.5 text-sm text-[#6a5a4f] hover:text-[#a47551] transition mb-6">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    @if (empty($plan))
        <div class="text-center text-stone-500 py-12">Paket upgrade tidak ditemukan.</div>
    @else
        <div class="space-y-6">
            {{-- Ringkasan Plan --}}
            <div class="rounded-[1.75rem] border border-stone-200 bg-white p-6 sm:p-8 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70 mb-1">Upgrade ke</p>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-[#2b1d12]">{{ $plan['name'] }}</h1>
                        <p class="text-sm text-[#6a5a4f] mt-1">{{ $plan['duration_days'] }} hari akses penuh</p>
                    </div>
                    <p class="text-2xl font-bold text-[#a47551]">Rp {{ number_format($plan['price'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <section class="rounded-[1.75rem] border border-stone-200/60 bg-white p-6 sm:p-8 shadow-sm">
                <h2 class="text-lg font-semibold text-[#2b1d12] mb-4">Metode Pembayaran</h2>

                @if ($paymentNotice)
                    <div class="mb-4 rounded-2xl border border-amber-200/80 bg-amber-50/70 p-4 text-sm text-[#8f5d34]">
                        {{ $paymentNotice }}</div>
                @endif

                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach ($paymentMethods as $method)
                        <button type="button" wire:click="selectPayment({{ $method['id'] }})"
                            class="group relative flex flex-col justify-between rounded-2xl border bg-white p-5 text-left transition-all duration-200
                                {{ $selectedPayment === $method['id'] ? 'border-[#a47551] bg-[#fdf8f3] shadow-sm' : 'border-stone-200 hover:border-[#c19a6b]/50 hover:bg-[#fefbf8]' }}">
                            @if ($selectedPayment === $method['id'])
                                <div class="absolute top-3 right-3">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-[#a47551]">
                                        <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="3">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $selectedPayment === $method['id'] ? 'bg-[#a47551]/10' : 'bg-[#f7ede0]' }}">
                                    @if ($method['icon'])
                                        <img src="{{ $method['icon'] }}" alt="{{ $method['label'] }}"
                                            class="h-5 w-5 object-contain">
                                    @else
                                        <div
                                            class="h-5 w-5 rounded bg-stone-200 flex items-center justify-center text-[0.5rem] text-stone-400">
                                            QR</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-[#2b1d12]">{{ $method['label'] }}</p>
                                    <p class="text-xs text-[#6a5a4f] mt-0.5">{{ $method['subtitle'] }}</p>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>

                <button type="button" wire:click="placeOrder" wire:loading.attr="disabled"
                    class="mt-6 w-full rounded-2xl px-5 py-4 text-sm font-semibold transition-colors duration-200
                        {{ $selectedPayment ? 'bg-[#a47551] text-white shadow-sm hover:bg-[#8f6243]' : 'bg-stone-200 text-stone-400 cursor-not-allowed' }}"
                    @disabled(!$selectedPayment)>
                    <span wire:loading.remove>Lanjut ke Pembayaran</span>
                    <span wire:loading class="flex items-center justify-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                        </svg>
                        Memproses...
                    </span>
                </button>
            </section>
        </div>
    @endif
</div>
