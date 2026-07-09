<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-stone-800">Metode Pembayaran</h1>
            <p class="text-sm text-stone-500 mt-1">Kelola metode pembayaran yang tersedia</p>
        </div>
        <button wire:click="openCreate"
            class="rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">
            + Tambah Metode
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}</div>
    @endif

    <div class="mb-6">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari metode pembayaran..."
            class="w-full max-w-md rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
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
                                    <img src="{{ Storage::url($method->icon) }}"
                                        class="h-10 w-10 rounded-lg object-contain border border-stone-200 bg-white p-0.5">
                                @else
                                    <div
                                        class="h-10 w-10 rounded-lg bg-stone-100 flex items-center justify-center text-stone-400 text-xs">
                                        -</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-medium text-stone-700">{{ $method->code }}</td>
                            <td class="px-5 py-3 text-stone-700">{{ $method->name }}</td>
                            <td class="px-5 py-3 text-stone-500 hidden sm:table-cell">{{ $method->subtitle ?: '-' }}
                            </td>
                            <td class="px-5 py-3 text-stone-600">{{ $method->sort_order }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium {{ $method->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-stone-100 text-stone-400' }}">
                                    {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="edit({{ $method->id }})"
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
                                            class="fixed inset-0 z-60 flex items-center justify-center p-4 bg-black/40">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <p class="font-semibold text-stone-800">Hapus metode?</p>
                                                <p class="text-sm text-stone-500 mt-1">Metode pembayaran akan dihapus
                                                    permanen.</p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click="delete({{ $method->id }})"
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
        @if ($methods->isEmpty())
            <div class="p-10 text-center text-stone-500 text-sm">Tidak ada metode pembayaran.</div>
        @endif
    </div>

    <div class="mt-4">{{ $methods->links() }}</div>

    {{-- Form Modal --}}
    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeForm">
            <div class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <h2 class="text-lg font-semibold text-stone-800">{{ $editingId ? 'Edit' : 'Tambah' }} Metode
                        Pembayaran</h2>
                    <button wire:click="closeForm" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Kode</label>
                        <input wire:model="code" type="text" placeholder="Contoh: bank_transfer"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('code')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama</label>
                        <input wire:model="name" type="text" placeholder="Contoh: Bank Transfer"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Subtitle</label>
                        <input wire:model="subtitle" type="text" placeholder="Contoh: Transfer antar bank"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Urutan</label>
                            <input wire:model="sortOrder" type="number" min="0"
                                class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">Status</label>
                            <label class="flex items-center gap-2 cursor-pointer mt-2.5">
                                <input wire:model="isActive" type="checkbox"
                                    class="rounded border-stone-300 text-[#a47551] focus:ring-[#a47551]/20">
                                <span class="text-sm text-stone-700">Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Icon / Gambar</label>
                        @if ($existingIcon)
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ Storage::url($existingIcon) }}"
                                    class="h-14 w-14 rounded-xl object-contain border border-stone-200 bg-white p-1">
                                <button type="button" wire:click="removeIcon"
                                    class="text-xs text-rose-500 hover:text-rose-600">Hapus</button>
                            </div>
                        @endif
                        <input type="file" wire:model="icon"
                            accept="image/jpeg,image/png,image/svg+xml,image/webp"
                            class="w-full rounded-xl border border-stone-200 px-4 py-3 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20 file:mr-4 file:rounded-xl file:border-0 file:bg-[#f5e9df] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#7a5d45] hover:file:bg-[#ead8c2]">
                        @error('icon')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                        @if ($icon && !$errors->has('icon'))
                            @php
                                $ext = strtolower($icon->getClientOriginalExtension());
                            @endphp
                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']))
                                <img src="{{ $icon->temporaryUrl() }}"
                                    class="mt-2 h-20 w-20 rounded-xl object-contain border border-stone-200 bg-white p-1">
                            @endif
                        @endif
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" wire:click="closeForm"
                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
