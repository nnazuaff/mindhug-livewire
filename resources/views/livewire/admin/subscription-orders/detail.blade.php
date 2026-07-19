<div>
    @if ($showModal && $order)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-stone-800">{{ $order->invoice_number }}</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">User</p>
                            <p class="font-medium">{{ $order->user?->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Paket</p>
                            <p class="font-medium">{{ $order->plan?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Jumlah</p>
                            <p class="font-semibold text-[#a47551]">Rp {{ number_format($order->amount, 0, ',', '.') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Status</p>
                            <span
                                class="text-xs px-2.5 py-1 rounded-full font-medium
                                {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                {{ $order->status === 'awaiting_confirmation' ? 'bg-blue-50 text-blue-600' : '' }}
                                {{ $order->status === 'awaiting_payment' ? 'bg-amber-50 text-amber-600' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}">
                                {{ match ($order->status) {
                                    'awaiting_payment' => 'Menunggu Bayar',
                                    'awaiting_confirmation' => 'Menunggu Konfirmasi',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    default => $order->status,
                                } }}
                            </span>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Metode Bayar</p>
                            <p class="font-medium">{{ $order->payment_method ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Tanggal</p>
                            <p class="text-xs text-stone-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($order->payment_proof)
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Bukti Pembayaran</p>
                            <img src="{{ Storage::url($order->payment_proof) }}"
                                class="w-full rounded-xl border border-stone-200">
                        </div>
                    @endif

                    @if ($order->status === 'awaiting_confirmation')
                        <div class="flex gap-2 pt-2 border-t border-stone-200">
                            <button wire:click="confirmOrder"
                                class="flex-1 rounded-xl bg-emerald-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-emerald-600 transition-colors">Konfirmasi</button>
                            <button wire:click="rejectOrder"
                                class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600 transition-colors">Tolak</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
