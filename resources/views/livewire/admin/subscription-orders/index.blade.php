<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Riwayat Upgrade</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola upgrade akun pengguna</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-1 max-w-xs">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari invoice atau user..."
                class="w-full rounded-xl border border-stone-200 bg-white pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
        </div>
        <select wire:model.live="statusFilter"
            class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
            <option value="">Semua Status</option>
            <option value="awaiting_payment">Menunggu Bayar</option>
            <option value="awaiting_confirmation">Menunggu Konfirmasi</option>
            <option value="completed">Selesai</option>
            <option value="cancelled">Dibatalkan</option>
        </select>
    </div>

    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Invoice</th>
                        <th class="px-5 py-3 font-medium">User</th>
                        <th class="px-5 py-3 font-medium">Paket</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Tanggal</th>
                        <th class="px-5 py-3 font-medium w-10"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-stone-700 text-xs">{{ $order->invoice_number }}</td>
                            <td class="px-5 py-3 text-sm">{{ $order->user?->full_name ?? '-' }}</td>
                            <td class="px-5 py-3 text-sm">{{ $order->plan?->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-sm">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3">
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
                            </td>
                            <td class="px-5 py-3 text-xs text-stone-400 hidden sm:table-cell">
                                {{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3">
                                <button
                                    onclick="Livewire.dispatch('openSubscriptionDetail', { orderId: {{ $order->id }} })"
                                    class="text-xs text-stone-400 hover:text-[#a47551] transition-colors"
                                    title="Lihat Detail">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($orders->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada data upgrade.</div>
        @endif
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>

    <livewire:admin.subscription-orders.detail />
</div>
