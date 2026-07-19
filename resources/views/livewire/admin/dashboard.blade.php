<div wire:poll.3s>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Dashboard</h1>
            <p class="text-sm text-stone-500 mt-1">Selamat datang, {{ auth('admin')->user()->full_name }}.</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <div class="rounded-2xl border border-amber-200 bg-amber-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-8 w-8 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <p class="text-xs text-amber-600 uppercase tracking-wider">Menunggu Bayar</p>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-amber-600">{{ $pendingPayments }}</p>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <p class="text-xs text-blue-600 uppercase tracking-wider">Konfirmasi</p>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $pendingConfirm }}</p>
        </div>
        <div class="rounded-2xl border border-indigo-200 bg-indigo-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-8 w-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9z" />
                    </svg>
                </div>
                <p class="text-xs text-indigo-600 uppercase tracking-wider">Diproses</p>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-indigo-600">{{ $processing }}</p>
        </div>
        <div class="rounded-2xl border border-purple-200 bg-purple-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="1" y="3" width="15" height="13" />
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                </div>
                <p class="text-xs text-purple-600 uppercase tracking-wider">Dikirim</p>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $shipped }}</p>
        </div>
        <div
            class="rounded-2xl border border-emerald-200 bg-emerald-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-8 w-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <p class="text-xs text-emerald-600 uppercase tracking-wider">Selesai</p>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-emerald-600">{{ $delivered }}</p>
        </div>
        <div class="rounded-2xl border border-purple-200 bg-purple-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <p class="text-xs text-purple-600 uppercase tracking-wider">Curhat Aktif</p>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $openConversations }}</p>
        </div>
    </div>

    {{-- Pemasukan & Pengeluaran --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mt-4">
        <div
            class="rounded-2xl border border-emerald-200 bg-emerald-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <p class="text-xs text-emerald-600 uppercase tracking-wider">Pemasukan</p>
            <p class="text-xl sm:text-2xl font-bold text-emerald-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </p>
        </div>
        <div class="rounded-2xl border border-rose-200 bg-rose-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <p class="text-xs text-rose-600 uppercase tracking-wider">Pengeluaran</p>
            <p class="text-xl sm:text-2xl font-bold text-rose-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </p>
        </div>
        <div class="rounded-2xl border border-amber-200 bg-amber-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <p class="text-xs text-amber-600 uppercase tracking-wider">Upgrade Pending</p>
            <p class="text-xl sm:text-2xl font-bold text-amber-600">{{ $pendingUpgrades }}</p>
        </div>
        <div class="rounded-2xl border border-purple-200 bg-purple-50/30 p-4 sm:p-5 hover:shadow-sm transition-shadow">
            <p class="text-xs text-purple-600 uppercase tracking-wider">Pemasukan</p>
            <p class="text-xl sm:text-2xl font-bold text-purple-600">Rp
                {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="rounded-2xl bg-white border border-stone-200 mt-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-stone-200 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-stone-800">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders') }}" class="text-xs font-medium text-[#a47551] hover:text-[#8f6243]">Lihat
                semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs">Invoice</th>
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs hidden sm:table-cell">User</th>
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs">Total</th>
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($recentOrders as $order)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-4 sm:px-5 py-3 text-xs sm:text-sm font-medium text-stone-700">
                                {{ $order->invoice_number }}</td>
                            <td class="px-4 sm:px-5 py-3 text-xs sm:text-sm text-stone-600 hidden sm:table-cell">
                                {{ $order->user?->full_name ?? '-' }}</td>
                            <td class="px-4 sm:px-5 py-3 text-xs sm:text-sm text-stone-700">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 sm:px-5 py-3">
                                @php
                                    $statusColors = [
                                        'awaiting_payment' => 'bg-amber-100 text-amber-700',
                                        'awaiting_confirmation' => 'bg-blue-100 text-blue-700',
                                        'cancel_requested' => 'bg-orange-100 text-orange-700',
                                        'processing' => 'bg-indigo-100 text-indigo-700',
                                        'shipped' => 'bg-purple-100 text-purple-700',
                                        'delivered' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-rose-100 text-rose-700',
                                    ];
                                    $statusLabels = [
                                        'awaiting_payment' => 'Menunggu Bayar',
                                        'awaiting_confirmation' => 'Konfirmasi',
                                        'processing' => 'Diproses',
                                        'cancel_requested' => 'Request Batal',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $statusColors[$order->status] ?? 'bg-stone-100 text-stone-600' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
