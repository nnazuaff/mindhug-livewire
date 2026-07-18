<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Pengguna</h1>
            <p class="text-sm text-stone-500 mt-1">Daftar pengguna terdaftar di MindHug</p>
        </div>
        <button onclick="Livewire.dispatch('openCreateUser')"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Pengguna
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-1 max-w-xs">
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Cari ID, nama, email, username, atau HP..."
                class="w-full rounded-xl border border-stone-200 bg-white pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
        <select wire:model.live="statusFilter"
            class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
        <select wire:model.live="orderFilter"
            class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
            <option value="">Urutkan: Terbaru</option>
            <option value="most">Order Terbanyak</option>
            <option value="least">Order Tersedikit</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium w-12">ID</th>
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium hidden md:table-cell">Username</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Email</th>
                        <th class="px-5 py-3 font-medium">Nomor HP</th>
                        <th class="px-5 py-3 font-medium">Orders</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium hidden lg:table-cell">Terdaftar</th>
                        <th class="px-5 py-3 font-medium w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3 text-xs text-stone-400 font-mono">#{{ $user->id }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}"
                                        class="h-8 w-8 rounded-full object-cover">
                                    <span class="font-medium text-stone-700">{{ $user->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-500 hidden md:table-cell">{{ $user->username }}</td>
                            <td class="px-5 py-3 text-stone-600 hidden sm:table-cell">{{ $user->email }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $user->phone ?? '-' }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $user->orders_count }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    {{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-stone-400 text-xs hidden lg:table-cell">
                                {{ $user->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="viewUser({{ $user->id }})"
                                        class="text-xs text-stone-400 hover:text-[#a47551]" title="Lihat">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="Livewire.dispatch('openEditUser', { userId: {{ $user->id }} })"
                                        class="text-xs text-stone-400 hover:text-blue-500" title="Edit">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <div x-data="{ showConfirm: false }">
                                        <button @click="showConfirm = true"
                                            class="text-xs text-stone-400 hover:text-rose-500" title="Hapus">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                        <div x-show="showConfirm" x-cloak
                                            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <p class="font-semibold text-stone-800">Hapus pengguna?</p>
                                                <p class="text-sm text-stone-500 mt-1">Semua data pengguna akan dihapus
                                                    permanen.</p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click="deleteUser({{ $user->id }})"
                                                        @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($users->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada pengguna ditemukan.</div>
        @endif
    </div>

    <div class="mt-4">{{ $users->links() }}</div>

    {{-- Detail Modal --}}
    @if ($viewingUser)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40"
            wire:click.self="closeDetail">
            <div class="bg-white rounded-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
                    <h2 class="text-lg font-semibold text-stone-800">Detail Pengguna</h2>
                    <button wire:click="closeDetail"
                        class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <div class="p-6 space-y-5">
                    <div class="flex items-center gap-4">
                        <img src="{{ $viewingUser->avatar_url }}"
                            class="h-16 w-16 rounded-2xl object-cover border-2 border-stone-200">
                        <div>
                            <p class="text-lg font-semibold text-stone-800">{{ $viewingUser->full_name }} <span
                                    class="text-xs text-stone-400 font-mono">#{{ $viewingUser->id }}</span></p>
                            <p class="text-sm text-stone-500">{{ $viewingUser->username }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">Email</p>
                            <p class="font-medium text-stone-700">{{ $viewingUser->email }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Telepon</p>
                            <p class="font-medium text-stone-700">{{ $viewingUser->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Role</p>
                            <p class="font-medium text-stone-700">{{ ucfirst($viewingUser->role) }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Status</p>
                            <span
                                class="inline-flex text-xs px-2.5 py-1 rounded-full font-medium {{ $viewingUser->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                {{ $viewingUser->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Terdaftar</p>
                            <p class="font-medium text-stone-700">
                                {{ $viewingUser->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if ($viewingUser->addresses->isNotEmpty())
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Alamat</p>
                            @foreach ($viewingUser->addresses as $address)
                                <div class="bg-stone-50 rounded-xl px-4 py-3 text-sm mb-2">
                                    <p class="font-medium text-stone-700">{{ $address->label }}
                                        {{ $address->is_primary ? '(Utama)' : '' }}</p>
                                    <p class="text-stone-500 text-xs">{{ $address->recipient_name }} -
                                        {{ $address->phone }}</p>
                                    <p class="text-stone-500 text-xs">{{ $address->street }}, {{ $address->region }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($viewingUser->orders->isNotEmpty())
                        <div>
                            <p class="text-sm font-medium text-stone-700 mb-2">Pesanan Terakhir</p>
                            @foreach ($viewingUser->orders as $order)
                                <a href="{{ route('admin.orders') }}" wire:navigate
                                    class="bg-stone-50 rounded-xl px-4 py-3 text-sm flex justify-between items-center hover:bg-stone-100 transition-colors mb-2">
                                    <div>
                                        <p class="font-medium text-stone-700">{{ $order->invoice_number }}</p>
                                        <p class="text-xs text-stone-400">{{ $order->status }} -
                                            {{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <p class="text-[#a47551]">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <livewire:admin.users.create />
    <livewire:admin.users.edit />
</div>
