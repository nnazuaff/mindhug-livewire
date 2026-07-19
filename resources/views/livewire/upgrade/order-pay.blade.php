<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="space-y-6">
        <a href="{{ route('plus.orders.show', $order->invoice_number) }}" wire:navigate
            class="inline-flex items-center gap-1.5 text-sm text-[#6a5a4f] hover:text-[#a47551] transition">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Kembali ke detail
        </a>

        @if ($uploaded)
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-10 text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100">
                    <svg class="h-10 w-10 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-[#2b1d12]">Bukti pembayaran terkirim!</h2>
                <p class="mt-2 text-sm text-[#6a5a4f]">Langganan kamu akan segera dikonfirmasi oleh admin.</p>
                <a href="{{ route('plus.orders.show', $order->invoice_number) }}" wire:navigate
                    class="mt-6 inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors">
                    Lihat Detail
                </a>
            </div>
        @else
            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70">Pembayaran</p>
                <h1 class="mt-2 text-2xl font-semibold text-[#2b1d12]">{{ $order->invoice_number }}</h1>
                <p class="text-sm text-[#6a5a4f] mt-1">
                    Total: <span class="font-bold text-[#a47551]">Rp
                        {{ number_format($order->amount, 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-[#2b1d12] mb-2">Upload Bukti Pembayaran</h2>
                <p class="text-sm text-[#6a5a4f] mb-4">Format: JPG atau PNG. Maksimal 5MB.</p>

                <form wire:submit.prevent="uploadProof" class="space-y-4">
                    <input type="file" wire:model="paymentProof" accept="image/jpeg,image/png"
                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 file:mr-4 file:rounded-xl file:border-0 file:bg-[#f5e9df] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#7a5d45] hover:file:bg-[#ead8c2]">

                    @error('paymentProof')
                        <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                    @enderror

                    @if ($paymentProof && !$errors->has('paymentProof'))
                        <div class="mt-4">
                            <p class="text-xs text-[#6a5a4f] mb-2">Preview:</p>
                            <img src="{{ $paymentProof->temporaryUrl() }}" alt="Preview"
                                class="w-full max-w-xs rounded-2xl border border-stone-200">
                        </div>
                    @endif

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full rounded-2xl bg-[#a47551] px-5 py-4 text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                        <span wire:loading.remove>Kirim Bukti Pembayaran</span>
                        <span wire:loading class="flex items-center justify-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Mengunggah...
                        </span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
