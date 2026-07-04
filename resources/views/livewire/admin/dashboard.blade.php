<div>
    <h1 class="text-xl font-bold text-stone-800">Dashboard</h1>
    <p class="text-sm text-stone-500 mt-1">Selamat datang, {{ auth('admin')->user()->full_name }}.</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mt-6">
        <div class="rounded-2xl bg-white border border-stone-200 p-4 sm:p-5">
            <p class="text-xs text-stone-400 uppercase tracking-wider">Users</p>
            <p class="text-2xl sm:text-3xl font-bold text-stone-800 mt-1">{{ $totalUsers }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-stone-200 p-4 sm:p-5">
            <p class="text-xs text-stone-400 uppercase tracking-wider">Orders</p>
            <p class="text-2xl sm:text-3xl font-bold text-stone-800 mt-1">{{ $totalOrders }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-stone-200 p-4 sm:p-5">
            <p class="text-xs text-stone-400 uppercase tracking-wider">Bayar</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-500 mt-1">{{ $pendingPayments }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-stone-200 p-4 sm:p-5">
            <p class="text-xs text-stone-400 uppercase tracking-wider">Konfirmasi</p>
            <p class="text-2xl sm:text-3xl font-bold text-blue-500 mt-1">{{ $pendingConfirm }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-stone-200 p-4 sm:p-5">
            <p class="text-xs text-stone-400 uppercase tracking-wider">Curhat</p>
            <p class="text-2xl sm:text-3xl font-bold text-purple-500 mt-1">{{ $openConversations }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white border border-stone-200 mt-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-stone-200">
            <h2 class="text-sm font-semibold text-stone-800">Pesanan Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs">Invoice</th>
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs hidden sm:table-cell">User</th>
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs">Total</th>
                        <th class="px-4 sm:px-5 py-2.5 font-medium text-xs hidden sm:table-cell">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($recentOrders as $order)
                        <tr class="hover:bg-stone-50/50">
                            <td class="px-4 sm:px-5 py-3 text-xs sm:text-sm font-medium text-stone-700">
                                {{ $order->invoice_number }}</td>
                            <td class="px-4 sm:px-5 py-3 text-xs sm:text-sm text-stone-600 hidden sm:table-cell">
                                {{ $order->user?->full_name ?? '-' }}</td>
                            <td class="px-4 sm:px-5 py-3 text-xs sm:text-sm text-stone-700">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 sm:px-5 py-3 hidden sm:table-cell">
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full bg-stone-100 text-stone-600">{{ $order->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
