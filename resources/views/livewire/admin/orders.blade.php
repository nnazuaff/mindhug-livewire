<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Pesanan</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola semua pesanan pelanggan.</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6 flex-wrap">
        <div class="relative flex-1 max-w-xs">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari invoice..."
                class="w-full rounded-xl border border-stone-200 bg-white pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
        <input wire:model.live.debounce.300ms="customerSearch" type="text" placeholder="Nama/email customer..."
            class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 sm:w-56">
        <select wire:model.live="statusFilter"
            class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 sm:w-44">
            <option value="">Semua Status</option>
            <option value="awaiting_payment">Menunggu Bayar</option>
            <option value="cancel_requested">Request Batal</option>
            <option value="processing">Diproses</option>
            <option value="shipped">Dikirim</option>
            <option value="delivered">Selesai</option>
            <option value="cancelled">Dibatalkan</option>
        </select>
        <input wire:model.live="dateFrom" type="date"
            class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 sm:w-40">
        <input wire:model.live="dateTo" type="date"
            class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 sm:w-40">
        <button wire:click="clearFilters"
            class="text-sm font-medium text-[#a47551] hover:text-[#8f6243] transition-colors py-2.5">
            Clear
        </button>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Invoice</th>
                        <th class="px-5 py-3 font-medium">Customer</th>
                        <th class="px-5 py-3 font-medium">Total</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-stone-700">{{ $order->invoice_number }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $order->user->full_name ?? 'N/A' }}</td>
                            <td class="px-5 py-3 font-semibold text-stone-700">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $this->getStatusColor($order->status) }}">
                                    {{ $this->getStatusLabel($order->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-stone-500 text-xs">{{ $order->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="viewOrder({{ $order->id }})"
                                        class="text-xs text-stone-400 hover:text-[#a47551]" title="Detail">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
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

    <div class="mt-4">{{ $orders->links() }}</div>

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
                    {{-- Info Ringkas --}}
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">Customer</p>
                            <p class="font-medium text-stone-700">{{ $viewingOrder->user->full_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Status</p>
                            <span
                                class="inline-flex text-xs px-2.5 py-1 rounded-full font-medium {{ $this->getStatusColor($viewingOrder->status) }}">
                                {{ $this->getStatusLabel($viewingOrder->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Total</p>
                            <p class="font-medium text-stone-700">Rp
                                {{ number_format($viewingOrder->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Tanggal</p>
                            <p class="font-medium text-stone-700">{{ $viewingOrder->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        @if ($viewingOrder->payment_type)
                            <div>
                                <p class="text-stone-400 text-xs">Metode Bayar</p>
                                <p class="font-medium text-stone-700">{{ strtoupper($viewingOrder->payment_type) }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Items --}}
                    <div>
                        <p class="text-sm font-medium text-stone-700 mb-2">Produk</p>
                        <div class="space-y-2">
                            @foreach ($viewingOrder->items as $item)
                                <div class="flex justify-between text-sm border-b border-stone-100 pb-2">
                                    <span class="text-stone-700">{{ $item->product_name }} x{{ $item->qty }}</span>
                                    <span class="font-medium text-stone-700">Rp
                                        {{ number_format($item->line_total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Alamat --}}
                    @if ($viewingOrder->shipping_address)
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-1">Alamat</p>
                            <p class="text-sm text-stone-600">{{ $viewingOrder->shipping_address }}</p>
                        </div>
                    @endif

                    {{-- Tracking --}}
                    @if ($viewingOrder->trackingEvents->isNotEmpty())
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Riwayat</p>
                            <div class="space-y-2">
                                @foreach ($viewingOrder->trackingEvents as $event)
                                    <div class="text-sm flex gap-2">
                                        <span
                                            class="text-stone-400 text-xs w-16 shrink-0">{{ $event->occurred_at->format('d/m H:i') }}</span>
                                        <span class="font-medium text-stone-700">{{ $event->title }}</span>
                                        @if ($event->description)
                                            <span class="text-stone-500">- {{ $event->description }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-stone-200">
                        @if (in_array($viewingOrder->status, ['processing']))
                            <button wire:click="updateStatus({{ $viewingOrder->id }}, 'shipped')"
                                class="rounded-xl bg-blue-500 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-600 transition-colors">
                                Tandai Dikirim
                            </button>
                        @endif
                        @if (in_array($viewingOrder->status, ['shipped']))
                            <button wire:click="updateStatus({{ $viewingOrder->id }}, 'delivered')"
                                class="rounded-xl bg-emerald-500 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-600 transition-colors">
                                Tandai Selesai
                            </button>
                        @endif
                        @if (in_array($viewingOrder->status, ['awaiting_payment']))
                            <button wire:click="updateStatus({{ $viewingOrder->id }}, 'processing')"
                                class="rounded-xl bg-indigo-500 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-600 transition-colors">
                                Proses Manual
                            </button>
                        @endif

                        {{-- Cancel Request --}}
                        @if ($viewingOrder->status === 'cancel_requested')
                            <div class="w-full flex gap-2 items-center mt-2">
                                <input wire:model="rejectReason" type="text"
                                    placeholder="Alasan tolak pembatalan..."
                                    class="flex-1 rounded-xl border border-stone-200 bg-white px-3 py-2 text-xs focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                                <button wire:click="rejectCancelRequest({{ $viewingOrder->id }})"
                                    class="rounded-xl bg-amber-500 px-4 py-2 text-xs font-semibold text-white hover:bg-amber-600 transition-colors">
                                    Tolak Pembatalan
                                </button>
                            </div>
                        @endif

                        {{-- Cancel Order --}}
                        @if (!in_array($viewingOrder->status, ['delivered', 'cancelled']))
                            <div class="w-full flex gap-2 items-center mt-2">
                                <input wire:model="cancelReason" type="text" placeholder="Alasan pembatalan..."
                                    class="flex-1 rounded-xl border border-stone-200 bg-white px-3 py-2 text-xs focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                                <button wire:click="cancelOrder({{ $viewingOrder->id }})"
                                    class="rounded-xl bg-rose-500 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-600 transition-colors">
                                    Batalkan Pesanan
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
