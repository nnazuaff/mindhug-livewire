<div class="max-w-5xl mx-auto px-4 py-10 sm:py-14">
    @if (session()->has('pending'))
        <div class="max-w-md mx-auto mb-6">
            <div class="rounded-2xl bg-amber-50 border border-amber-200 px-5 py-4 text-sm text-amber-700 text-center">
                {{ session('pending') }}
            </div>
        </div>
    @endif

    @if (session()->has('already_plus'))
        <div class="max-w-md mx-auto mb-6">
            <div
                class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-700 text-center">
                ✅ {{ session('already_plus') }}
            </div>
        </div>
    @endif

    @if ($plan)
        <div class="max-w-md mx-auto">
            <div
                class="rounded-[1.75rem] border-2 border-[#e9ddd2] bg-white p-8 sm:p-10 shadow-[0_32px_60px_rgba(34,25,17,0.08)] text-center">
                <span
                    class="inline-flex rounded-full bg-[#f5e9df] text-[#a47551] px-3.5 py-1.5 text-xs font-semibold tracking-[0.08em] uppercase">
                    {{ $plan->name }}
                </span>

                <div class="mt-6">
                    <span class="text-5xl font-extrabold text-[#2b1d12]">Rp
                        {{ number_format($plan->price, 0, ',', '.') }}</span>
                    <span class="text-[#6a5a4f] text-base">/bulan</span>
                </div>

                <p class="mt-2 text-xs text-[#8b6f5c]">Rp {{ number_format($plan->price / 30, 0, ',', '.') }} / hari</p>

                <div class="mt-8 space-y-3 text-left">
                    @foreach ($plan->features as $feature)
                        <div class="flex items-start gap-3">
                            <div
                                class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mt-0.5">
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </div>
                            <span class="text-sm text-[#5f4a3f] leading-relaxed">{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="h-px bg-[#ede0d4] my-6"></div>

                @auth
                    @if (auth()->user()->role === 'plus' && auth()->user()->plus_expires_at && auth()->user()->plus_expires_at > now())
                        <div
                            class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-700 text-center">
                            ✅ Kamu sudah berlangganan <strong class="text-emerald-800">MindHug Plus</strong> sampai
                            <strong>{{ auth()->user()->plus_expires_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</strong>.
                            Tidak perlu upgrade lagi. 🎉
                        </div>
                    @elseif ($pendingUpgrade)
                        <div class="rounded-2xl bg-amber-50 border border-amber-200 px-5 py-4 text-sm text-amber-700">
                            ⏳ Kamu sudah mengajukan upgrade. Status:
                            <strong>{{ $pendingUpgrade->status === 'awaiting_payment' ? 'Menunggu Pembayaran' : 'Menunggu Konfirmasi' }}</strong>.
                            @if ($pendingUpgrade->status === 'awaiting_payment')
                                <a href="{{ route('plus.orders.pay', $pendingUpgrade->invoice_number) }}"
                                    class="underline font-semibold text-amber-800 block mt-1">Lanjutkan pembayaran →</a>
                            @else
                                <span class="block mt-1">Tunggu konfirmasi dari admin ya.</span>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('plus.start') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#a47551] text-white px-6 py-3.5 text-sm font-semibold shadow-md shadow-[#a47551]/30 hover:bg-[#8f6243] hover:-translate-y-0.5 transition-all duration-200 w-full">
                                Upgrade Sekarang
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#a47551] text-white px-6 py-3.5 text-sm font-semibold shadow-md shadow-[#a47551]/30 hover:bg-[#8f6243] hover:-translate-y-0.5 transition-all duration-200 w-full">
                        Masuk untuk Upgrade
                    </a>
                @endauth

                <p class="mt-4 text-center text-[0.7rem] text-[#aaa]">
                    🔒 Pembayaran aman &bullet; Butuh bantuan? <a href="{{ route('kontak') }}"
                        class="text-[#a47551] underline">Hubungi kami</a>
                </p>
            </div>
        </div>
    @else
        <div class="text-center text-stone-500 py-12">Paket upgrade belum tersedia.</div>
    @endif
</div>
