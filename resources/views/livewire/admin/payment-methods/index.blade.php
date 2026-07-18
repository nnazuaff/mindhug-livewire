<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Metode Pembayaran</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola metode pembayaran yang tersedia</p>
        </div>
        <button onclick="Livewire.dispatch('openCreatePaymentMethod')"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Metode
        </button>
    </div>

    <div class="mb-6">
        <div class="relative max-w-md">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari metode pembayaran..."
                class="w-full rounded-xl border border-stone-200 bg-white pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
        </div>
    </div>

    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Icon</th>
                        <th class="px-5 py-3 font-medium">Kode</th>
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Subtitle</th>
                        <th class="px-5 py-3 font-medium">Urutan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($methods as $method)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3">
                                @if ($method->icon)
                                    <img src="{{ Storage::url($method->icon) }}" class="h-10 w-10 rounded-lg object-contain border border-stone-200 bg-white p-0.5">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-stone-100 flex items-center justify-center text-stone-400 text-xs">-</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium text-stone-700 text-xs">{{ $method->code }}</td>
                            <td class="px-5 py-3 text-stone-700">{{ $method->name }}</td>
                            <td class="px-5 py-3 text-stone-500 text-xs hidden sm:table-cell">{{ $method->subtitle ?: '-' }}</td>
                            <td class="px-5 py-3 text-stone-600">{{ $method->sort_order }}</td>
                            <td class="px-5 py-3">
                                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $method->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">
                                    {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button onclick="Livewire.dispatch('openEditPaymentMethod', { methodId: {{ $method->id }} })"
                                        class="text-xs text-stone-400 hover:text-blue-500" title="Edit">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <div x-data="{ showConfirm: false }">
                                        <button @click="showConfirm = true" class="text-xs text-stone-400 hover:text-rose-500" title="Hapus">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                        <div x-show="showConfirm" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <p class="font-semibold text-stone-800">Hapus metode?</p>
                                                <p class="text-sm text-stone-500 mt-1">Metode pembayaran akan dihapus permanen.</p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false" class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click="deleteMethod({{ $method->id }})" @click="showConfirm = false" class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
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
        @if ($methods->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada metode pembayaran.</div>
        @endif
    </div>
    <div class="mt-4">{{ $methods->links() }}</div>

    <livewire:admin.payment-methods.create />
    <livewire:admin.payment-methods.edit />
</div>
