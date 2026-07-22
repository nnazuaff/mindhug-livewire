<div class="max-w-2xl mx-auto px-4 py-6 sm:py-10" x-data="{ snapToken: @entangle('snapToken') }"
    x-on:snap-open.window="
        if (snapToken && window.snap) {
            window.snap.pay(snapToken, {
                onSuccess: function() { window.location.reload(); },
                onPending: function() { window.location.reload(); },
                onError: function() { location.reload(); },
                onClose: function() { window.location.reload(); }
            });
        }
    "
    x-init="$watch('snapToken', function(token) {
        if (token && window.snap) {
            window.snap.pay(token, {
                onSuccess: function() { window.location.reload(); },
                onPending: function() { window.location.reload(); },
                onError: function() { location.reload(); },
                onClose: function() { window.location.reload(); }
            });
        }
    });">
    <div class="space-y-4 sm:space-y-6">
        <a href="{{ route('plus.orders') }}" wire:navigate
            class="inline-flex items-center gap-1.5 text-sm text-[#6a5a4f] hover:text-[#a47551] transition">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="rounded-2xl sm:rounded-3xl border border-[#e8d5c4] bg-white p-4 sm:p-6">
            <p class="text-xs uppercase tracking-[0.3em] text-[#8b6f5c]/70">Detail Langganan</p>
            <h1 class="mt-1 text-xl sm:text-2xl font-semibold text-[#2b1d12] break-all">{{ $order->invoice_number }}
            </h1>
            <p class="text-sm text-[#6a5a4f] mt-1">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>

            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span
                    class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs sm:text-sm font-semibold {{ $this->getStatusColor($order->status) }}">
                    {{ $this->getStatusLabel($order->status) }}
                </span>

                @if ($order->status === 'awaiting_payment')
                    <button wire:click="openSnap" type="button"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-[#a47551] px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-sm hover:bg-[#8f6243] transition-colors">
                        Bayar Sekarang
                    </button>
                @endif
            </div>
        </div>

        <div class="rounded-2xl sm:rounded-3xl border border-[#e8d5c4] bg-white p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold text-[#2b1d12] mb-4">Paket Langganan</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-semibold text-[#2b1d12]">{{ $order->plan->name ?? 'MindHug Plus' }}</p>
                    <p class="text-sm text-[#6a5a4f] mt-0.5">{{ $order->plan->duration_days ?? 30 }} hari akses penuh
                    </p>
                </div>
                <p class="text-lg font-bold text-[#a47551]">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="rounded-2xl sm:rounded-3xl border border-[#e8d5c4] bg-white p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold text-[#2b1d12] mb-4">Status</h2>
            <div class="space-y-0">
                @php
                    $steps = [
                        [
                            'status' => 'awaiting_payment',
                            'label' => 'Menunggu Pembayaran',
                            'done' => in_array($order->status, [
                                'awaiting_payment',
                                'awaiting_confirmation',
                                'completed',
                            ]),
                        ],
                        [
                            'status' => 'awaiting_confirmation',
                            'label' => 'Konfirmasi Admin',
                            'done' => in_array($order->status, ['awaiting_confirmation', 'completed']),
                        ],
                        ['status' => 'completed', 'label' => 'Plus Aktif', 'done' => $order->status === 'completed'],
                    ];
                    if ($order->status === 'cancelled') {
                        $steps = [['status' => 'cancelled', 'label' => 'Dibatalkan', 'done' => true]];
                    }
                @endphp
                @foreach ($steps as $step)
                    <div class="relative flex gap-3 sm:gap-4 pb-5 sm:pb-6 last:pb-0">
                        @if (!$loop->last)
                            <div class="absolute left-[15px] sm:left-[19px] top-10 bottom-0 w-0.5 bg-[#ede0d4]"></div>
                        @endif
                        <div
                            class="relative z-10 flex h-8 w-8 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full border-2 {{ $step['done'] ? 'border-[#a47551] bg-[#a47551]/10' : 'border-[#ede0d4] bg-white' }}">
                            <div
                                class="h-2 w-2 sm:h-2.5 sm:w-2.5 rounded-full {{ $step['done'] ? 'bg-[#a47551]' : 'bg-[#d4c3b3]' }}">
                            </div>
                        </div>
                        <div class="pt-1 sm:pt-2">
                            <p class="font-semibold text-[#2b1d12] text-xs sm:text-sm">{{ $step['label'] }}</p>
                            @if ($step['status'] === 'completed' && $order->confirmed_at)
                                <p class="text-[0.65rem] sm:text-xs text-[#aaa] mt-1">
                                    {{ $order->confirmed_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</div>
