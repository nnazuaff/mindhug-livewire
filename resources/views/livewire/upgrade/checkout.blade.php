<div class="max-w-2xl mx-auto px-4 py-10 sm:py-14">
    <a href="{{ route('upgrade') }}" wire:navigate
        class="inline-flex items-center gap-1.5 text-sm text-[#6a5a4f] hover:text-[#a47551] transition mb-8">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    @if ($uploaded)
        <div class="rounded-[1.75rem] border border-emerald-200 bg-emerald-50 p-10 text-center shadow-sm">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100">
                <svg class="h-8 w-8 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <h2 class="mt-6 text-xl font-bold text-[#2b1d12]">Bukti pembayaran terkirim!</h2>
            <p class="mt-2 text-sm leading-7 text-[#6a5a4f]">Tim kami akan mengonfirmasi pembayaran kamu dalam 1x24 jam.
                Status akun akan otomatis berubah setelah dikonfirmasi.</p>
            <a href="{{ route('home') }}"
                class="mt-6 inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors">Kembali
                ke Beranda</a>
        </div>
    @else
        {{-- Ringkasan --}}
        <div
            class="rounded-[1.75rem] border border-stone-200 bg-white p-6 sm:p-8 shadow-[0_24px_50px_rgba(34,25,17,0.06)]">
            <p class="text-xs uppercase tracking-[0.32em] text-[#8b6f5c]/70 mb-1">Checkout Upgrade</p>
            <h1 class="text-2xl font-semibold text-[#1f1f1f]">{{ $plan->name }}</h1>
            <p class="mt-3 text-3xl font-extrabold text-[#a47551]">Rp
                {{ number_format($plan->price, 0, ',', '.') }}<span
                    class="text-base font-normal text-[#6a5a4f]">/bulan</span></p>
            <p class="mt-1 text-sm text-[#6a5a4f]">Durasi: {{ $plan->duration_days }} hari</p>
        </div>

        {{-- Metode Pembayaran --}}
        <div
            class="mt-6 rounded-[1.75rem] border border-stone-200 bg-white p-6 sm:p-8 shadow-[0_24px_50px_rgba(34,25,17,0.06)]">
            <h2 class="text-lg font-semibold text-[#2b1d12] mb-4">Metode Pembayaran</h2>

            <div class="grid gap-3 sm:grid-cols-3">
                @foreach ($paymentMethods as $method)
                    <button type="button" wire:click="selectPayment({{ $method['id'] }})"
                        class="group relative flex flex-col items-center justify-center rounded-2xl border p-4 text-center transition-all duration-200 focus:outline-none
                            {{ $selectedPayment === $method['id'] ? 'border-[#a47551] bg-[#fdf8f3] shadow-sm' : 'border-[#e9ddd2] hover:border-[#c19a6b]/50 hover:bg-[#fefbf8]' }}">
                        @if ($selectedPayment === $method['id'])
                            <div class="absolute top-2 right-2">
                                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-[#a47551]">
                                    <svg class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $selectedPayment === $method['id'] ? 'bg-[#a47551]/10' : 'bg-[#f7ede0]' }}">
                            @if ($method['icon'])
                                <img src="{{ $method['icon'] }}" alt="{{ $method['label'] }}"
                                    class="h-5 w-5 object-contain">
                            @else
                                <svg class="h-5 w-5 text-[#a47551]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <line x1="2" y1="10" x2="22" y2="10" />
                                </svg>
                            @endif
                        </div>
                        <p class="mt-2 text-sm font-semibold text-[#2b1d12]">{{ $method['label'] }}</p>
                        <p class="text-xs text-[#6a5a4f] mt-0.5">{{ $method['subtitle'] }}</p>
                    </button>
                @endforeach
            </div>
            @error('selectedPayment')
                <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload Bukti (muncul setelah pilih metode) --}}
        @if ($selectedPayment)
            <div
                class="mt-6 rounded-[1.75rem] border border-stone-200 bg-white p-6 sm:p-8 shadow-[0_24px_50px_rgba(34,25,17,0.06)]">
                <h2 class="text-lg font-semibold text-[#2b1d12] mb-2">Upload Bukti Pembayaran</h2>
                <p class="text-sm text-[#6a5a4f] mb-4">Silakan transfer sesuai nominal di atas, lalu unggah bukti
                    pembayaran. Format: JPG atau PNG. Maksimal 5MB.</p>
                <form wire:submit.prevent="uploadProof" class="space-y-4">
                    <input type="file" wire:model="paymentProof" accept="image/jpeg,image/png"
                        class="w-full rounded-2xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3 text-sm placeholder-[#b0a090] focus:outline-none focus:border-[#a47551] focus:ring-4 focus:ring-[#a47551]/10 file:mr-4 file:rounded-xl file:border-0 file:bg-[#f5e9df] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#7a5d45] hover:file:bg-[#ead8c2] transition">
                    @error('paymentProof')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror

                    @if ($paymentProof && !$errors->has('paymentProof'))
                        <img src="{{ $paymentProof->temporaryUrl() }}"
                            class="w-full max-w-xs rounded-2xl border border-stone-200 mt-2">
                    @endif

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#a47551] text-white px-5 py-3.5 font-semibold text-sm shadow-md shadow-[#a47551]/20 hover:bg-[#8f6243] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
                        <span wire:loading.remove>Kirim Bukti Pembayaran</span>
                        <span wire:loading class="inline-flex items-center gap-2">
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
    @endif
</div>
