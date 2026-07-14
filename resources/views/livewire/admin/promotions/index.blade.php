<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Voucher & Promo</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola kode voucher dan promo</p>
        </div>
        <button onclick="Livewire.dispatch('openCreatePromotion')"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Voucher
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari kode voucher..."
            class="w-full max-w-md rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
    </div>

    <div class="rounded-2xl bg-white border border-stone-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-stone-500 bg-stone-50 border-b border-stone-200">
                        <th class="px-5 py-3 font-medium">Kode</th>
                        <th class="px-5 py-3 font-medium">Tipe</th>
                        <th class="px-5 py-3 font-medium">Nilai</th>
                        <th class="px-5 py-3 font-medium">Min. Order</th>
                        <th class="px-5 py-3 font-medium">Terpakai</th>
                        <th class="px-5 py-3 font-medium hidden sm:table-cell">Berlaku</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($promotions as $promo)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-5 py-3 font-medium text-stone-700">{{ $promo->code }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ $promo->type === 'fixed' ? 'Rp' : '%' }}</td>
                            <td class="px-5 py-3 text-stone-700">
                                {{ $promo->type === 'fixed' ? 'Rp ' . number_format($promo->value) : $promo->value . '%' }}
                            </td>
                            <td class="px-5 py-3 text-stone-500">Rp {{ number_format($promo->min_order) }}</td>
                            <td class="px-5 py-3 text-stone-500">{{ $promo->used_count }}/{{ $promo->max_uses ?? '∞' }}
                            </td>
                            <td class="px-5 py-3 text-stone-500 text-xs hidden sm:table-cell">
                                @if ($promo->starts_date)
                                    {{ $promo->starts_date->format('d/m/Y') }}
                                    {{ $promo->starts_time ? substr($promo->starts_time, 0, 5) : '' }}
                                @else
                                    -
                                @endif
                                <br>s/d
                                @if ($promo->ends_date)
                                    {{ $promo->ends_date->format('d/m/Y') }}
                                    {{ $promo->ends_time ? substr($promo->ends_time, 0, 5) : '' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $promo->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">{{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        onclick="Livewire.dispatch('openEditPromotion', { promotionId: {{ $promo->id }} })"
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
                                                <p class="font-semibold text-stone-800">Hapus voucher?</p>
                                                <p class="text-sm text-stone-500 mt-1">Voucher akan dihapus permanen.
                                                </p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click="delete({{ $promo->id }})"
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
        @if ($promotions->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada voucher.</div>
        @endif
    </div>

    <div class="mt-4">{{ $promotions->links() }}</div>

    <livewire:admin.promotions.create />
    <livewire:admin.promotions.edit />
</div>
