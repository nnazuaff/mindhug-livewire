<div wire:poll.1s>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Pesanan</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola semua pesanan pelanggan</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-1 max-w-xs">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari invoice..."
                class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
        </div>
        <select wire:model.live="statusFilter"
            class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
            <option value="">Semua Status</option>
            <option value="awaiting_payment">Menunggu Bayar</option>
            <option value="awaiting_confirmation">Menunggu Konfirmasi</option>
            <option value="cancel_requested">Request Batal</option>
            <option value="processing">Diproses</option>
            <option value="shipped">Dikirim</option>
            <option value="delivered">Selesai</option>
            <option value="cancelled">Dibatalkan</option>
        </select>
    </div>

    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Invoice</th>
                        <th class="px-5 py-3 font-medium">Pelanggan</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-stone-700">{{ $order->invoice_number }}</td>
                            <td class="px-5 py-3 text-stone-600">
                                {{ $order->user?->full_name ?? 'User #' . $order->user_id }}
                            </td>
                            <td class="px-5 py-3 text-stone-700">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="inline-flex text-xs px-2.5 py-1 rounded-full font-medium {{ $this->getStatusColor($order->status) }}">
                                    {{ $this->getStatusLabel($order->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-stone-500 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-5 py-3">
                                <button wire:click="viewOrder({{ $order->id }})"
                                    class="text-xs font-medium text-[#a47551] hover:text-[#8f6243]">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($orders->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada pesanan ditemukan.</div>
        @endif
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    {{-- Detail Modal --}}
    @if ($viewingOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeDetail">
            <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                    <h2 class="text-lg font-semibold text-stone-800">{{ $viewingOrder->invoice_number }}</h2>
                    <button wire:click="closeDetail"
                        class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Info --}}
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">Pelanggan</p>
                            <p class="font-medium text-stone-800">{{ $viewingOrder->user?->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Status</p>
                            <span
                                class="inline-flex text-xs px-2 py-0.5 rounded-full font-medium {{ $this->getStatusColor($viewingOrder->status) }}">
                                {{ $this->getStatusLabel($viewingOrder->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Total</p>
                            <p class="font-semibold text-[#a47551]">Rp
                                {{ number_format($viewingOrder->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Metode Bayar</p>
                            <p class="font-medium text-stone-800">{{ $viewingOrder->payment_method ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-stone-400 text-xs">Alamat</p>
                            <p class="text-stone-600">{{ $viewingOrder->shipping_address ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Request Cancel Badge --}}
                    @if ($viewingOrder->cancel_requested_at)
                        <div class="rounded-xl bg-orange-50 border border-orange-200 px-4 py-3">
                            <p class="text-xs font-medium text-orange-600 uppercase tracking-wider">User Request
                                Pembatalan</p>
                            <p class="text-sm text-orange-700 mt-1">{{ $viewingOrder->cancel_reason }}</p>
                            <p class="text-xs text-orange-500 mt-1">
                                {{ $viewingOrder->cancel_requested_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    @endif

                    {{-- Items --}}
                    <div>
                        <p class="text-sm font-medium text-stone-700 mb-2">Produk</p>
                        <div class="space-y-2">
                            @foreach ($viewingOrder->items as $item)
                                <div class="flex justify-between text-sm bg-stone-50 rounded-xl px-4 py-3">
                                    <span class="text-stone-700">{{ $item->product_name }}
                                        (x{{ $item->qty }})
                                    </span>
                                    <span class="text-stone-600">Rp
                                        {{ number_format($item->line_total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bukti Bayar --}}
                    @if ($viewingOrder->payment_proof)
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Bukti Pembayaran</p>
                            <a href="{{ Storage::url($viewingOrder->payment_proof) }}" target="_blank">
                                <img src="{{ Storage::url($viewingOrder->payment_proof) }}" alt="Bukti Bayar"
                                    class="w-48 rounded-xl border border-stone-200 hover:opacity-80 transition">
                            </a>
                        </div>
                    @endif

                    {{-- Tracking --}}
                    @if ($viewingOrder->trackingEvents->isNotEmpty())
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Riwayat</p>
                            <div class="space-y-2">
                                @foreach ($viewingOrder->trackingEvents as $event)
                                    <div class="flex gap-3 text-sm">
                                        <span
                                            class="text-stone-300 text-xs w-20 shrink-0">{{ $event->occurred_at->format('d/m H:i') }}</span>
                                        <div>
                                            <p class="font-medium text-stone-700">{{ $event->title }}</p>
                                            @if ($event->description)
                                                <p class="text-stone-500 text-xs">{{ $event->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2 pt-2 border-t border-stone-200">
                        {{-- Konfirmasi Pembayaran (normal) --}}
                        @if ($viewingOrder->status === 'awaiting_confirmation')
                            <button wire:click="confirmPayment({{ $viewingOrder->id }})"
                                class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600 transition">
                                Konfirmasi Pembayaran
                            </button>
                        @endif
                        {{-- Tolak Request Pembatalan --}}
                        @if ($viewingOrder->status === 'cancel_requested')
                            <div class="w-full space-y-2" x-data="{ showRejectForm: false }">
                                <button @click="showRejectForm = !showRejectForm"
                                    class="rounded-xl bg-amber-100 px-4 py-2 text-sm font-medium text-amber-700 hover:bg-amber-200 transition-colors">
                                    Tolak Pembatalan
                                </button>
                                <div x-show="showRejectForm" x-cloak class="space-y-2">
                                    <textarea wire:model="rejectReason" rows="2" placeholder="Tulis alasan penolakan..."
                                        class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-200/50"></textarea>
                                    <div class="flex gap-2">
                                        <button wire:click="rejectCancelRequest({{ $viewingOrder->id }})"
                                            class="rounded-xl bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600 transition-colors">
                                            Konfirmasi Penolakan
                                        </button>
                                        <button @click="showRejectForm = false; $wire.set('rejectReason', '')"
                                            class="rounded-xl bg-stone-100 px-4 py-2 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Konfirmasi Pembayaran (user request batal, tapi admin konfirmasi) --}}
                        @if ($viewingOrder->status === 'cancel_requested' && $viewingOrder->payment_proof)
                            <button wire:click="confirmPayment({{ $viewingOrder->id }})"
                                class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600 transition">
                                Konfirmasi Pembayaran (Abaikan Request Batal)
                            </button>
                        @endif

                        {{-- Dikirim --}}
                        @if ($viewingOrder->status === 'processing')
                            <button wire:click="updateStatus({{ $viewingOrder->id }}, 'shipped')"
                                class="rounded-xl bg-[#a47551] px-4 py-2 text-sm font-medium text-white hover:bg-[#8f6243] transition">
                                Tandai Dikirim
                            </button>
                        @endif

                        {{-- Selesai --}}
                        @if ($viewingOrder->status === 'shipped')
                            <button wire:click="updateStatus({{ $viewingOrder->id }}, 'delivered')"
                                class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600 transition">
                                Tandai Selesai
                            </button>
                        @endif

                        {{-- Batalkan Pesanan --}}
                        @if (!in_array($viewingOrder->status, ['delivered', 'cancelled']))
                            <div class="w-full space-y-2" x-data="{ showCancelForm: false }">
                                <button @click="showCancelForm = !showCancelForm"
                                    class="rounded-xl bg-rose-100 px-4 py-2 text-sm font-medium text-rose-700 hover:bg-rose-200 transition-colors">
                                    Batalkan Pesanan
                                </button>
                                <div x-show="showCancelForm" x-cloak class="space-y-2">
                                    <textarea wire:model="cancelReason" rows="2" placeholder="Tulis alasan pembatalan..."
                                        class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200/50"></textarea>
                                    <div class="flex gap-2">
                                        <button wire:click="cancelOrder({{ $viewingOrder->id }})"
                                            class="rounded-xl bg-rose-500 px-4 py-2 text-sm font-medium text-white hover:bg-rose-600 transition-colors">
                                            Konfirmasi Pembatalan
                                        </button>
                                        <button @click="showCancelForm = false; $wire.set('cancelReason', '')"
                                            class="rounded-xl bg-stone-100 px-4 py-2 text-sm font-medium text-stone-600 hover:bg-stone-200 transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
