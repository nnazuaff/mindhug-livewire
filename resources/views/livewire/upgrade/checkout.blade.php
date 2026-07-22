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
            <div class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
                <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70 mb-1">Upgrade ke</p>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-[#2b1d12]">{{ $plan['name'] }}</h1>
                        <p class="text-sm text-[#6a5a4f] mt-1">{{ $plan['duration_days'] }} hari akses penuh</p>
                    </div>
                    <p class="text-2xl font-bold text-[#a47551]">Rp {{ number_format($plan['price'], 0, ',', '.') }}</p>
                </div>
            </div>

            <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
                <div class="flex items-start gap-4 mb-4">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                        <svg class="h-5.5 w-5.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <line x1="2" y1="10" x2="22" y2="10" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-[#2b1d12]">Pembayaran</h2>
                        <p class="mt-1 text-sm text-[#6a5a4f]">Bayar aman melalui Midtrans. Pilih metode di popup
                            pembayaran.</p>
                    </div>
                </div>

                @if ($paymentNotice)
                    <div class="mb-4 rounded-2xl border border-amber-200 bg-amber-50/70 p-4 text-sm text-[#8f5d34]">
                        {{ $paymentNotice }}</div>
                @endif

                <button wire:click="placeOrder" wire:loading.attr="disabled"
                    class="w-full rounded-2xl bg-[#a47551] px-5 py-4 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200">
                    <span wire:loading.remove>Bayar Sekarang</span>
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
