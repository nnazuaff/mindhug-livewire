<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Admin</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola akun admin MindHug</p>
        </div>
        <button onclick="Livewire.dispatch('openCreateAdmin')"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Admin
        </button>
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

    {{-- Search --}}
    <div class="mb-6">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, email, atau username..."
            class="w-full max-w-md rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium hidden md:table-cell">Username</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Email</th>
                        <th class="px-5 py-3 font-medium">Role</th>
                        <th class="px-5 py-3 font-medium hidden lg:table-cell">Terdaftar</th>
                        <th class="px-5 py-3 font-medium w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($admins as $admin)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-8 w-8 rounded-full bg-[#a47551]/15 flex items-center justify-center text-[#a47551] text-xs font-bold">
                                        {{ strtoupper(substr($admin->full_name ?? $admin->username, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-stone-700">{{ $admin->full_name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-stone-500 hidden md:table-cell">{{ $admin->username }}</td>
                            <td class="px-5 py-3 text-stone-600 hidden sm:table-cell">{{ $admin->email }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="inline-flex text-xs px-2.5 py-1 rounded-full font-medium {{ $admin->role === 'dev' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $admin->role === 'dev' ? 'Dev' : 'Admin' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-stone-400 text-xs hidden lg:table-cell">
                                {{ $admin->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="viewAdmin({{ $admin->id }})"
                                        class="text-xs text-stone-400 hover:text-[#a47551]" title="Lihat">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                    <button
                                        onclick="Livewire.dispatch('openEditAdmin', { adminId: {{ $admin->id }} })"
                                        class="text-xs text-stone-400 hover:text-blue-500" title="Edit">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    @if ($admin->id !== auth('admin')->id())
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
                                                <div
                                                    class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                    <p class="font-semibold text-stone-800">Hapus admin?</p>
                                                    <p class="text-sm text-stone-500 mt-1">
                                                        {{ $admin->full_name ?? $admin->username }} akan dihapus
                                                        permanen.</p>
                                                    <div class="flex gap-2 mt-4">
                                                        <button @click="showConfirm = false"
                                                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                        <button wire:click="deleteAdmin({{ $admin->id }})"
                                                            @click="showConfirm = false"
                                                            class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($admins->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada admin ditemukan.</div>
        @endif
    </div>

    <div class="mt-4">{{ $admins->links() }}</div>

    {{-- Detail Modal --}}
    @if ($viewingAdmin)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeDetail">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-stone-800">Detail Admin</h2>
                    <button wire:click="closeDetail"
                        class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-16 w-16 rounded-2xl bg-[#a47551]/15 flex items-center justify-center text-[#a47551] text-xl font-bold">
                            {{ strtoupper(substr($viewingAdmin->full_name ?? $viewingAdmin->username, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-stone-800">{{ $viewingAdmin->full_name ?? '-' }}</p>
                            <p class="text-sm text-stone-500">{{ $viewingAdmin->username }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-stone-400 text-xs">Email</p>
                            <p class="font-medium text-stone-700">{{ $viewingAdmin->email }}</p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Role</p>
                            <span
                                class="inline-flex text-xs px-2.5 py-1 rounded-full font-medium {{ $viewingAdmin->role === 'dev' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ $viewingAdmin->role === 'dev' ? 'Dev' : 'Admin' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Terdaftar</p>
                            <p class="font-medium text-stone-700">
                                {{ $viewingAdmin->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-stone-400 text-xs">Diperbarui</p>
                            <p class="font-medium text-stone-700">
                                {{ $viewingAdmin->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <livewire:admin.admins.create />
    <livewire:admin.admins.edit />
</div>
