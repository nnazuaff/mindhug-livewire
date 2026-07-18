<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.32em] text-[#8b6f5c]/70">Alamat</p>
                <h1 class="mt-2 text-3xl font-semibold text-[#1f1f1f]">Kelola alamat pengiriman</h1>
            </div>
            <button wire:click="openForm"
                class="inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:bg-[#8f6243]">
                + Tambah Alamat
            </button>
        </div>

        <div class="mt-8 space-y-4">
            @if (empty($addresses))
                <div class="rounded-3xl border border-stone-200 bg-[#fbf6f1] p-8 text-center">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <p class="mt-4 font-semibold text-[#2b1d12]">Belum ada alamat</p>
                    <p class="mt-1 text-sm text-[#6a5a4f]">Tambahkan alamat pertama kamu untuk checkout lebih cepat.</p>
                </div>
            @else
                <div class="grid gap-4 lg:grid-cols-2">
                    @foreach ($addresses as $address)
                        <div class="rounded-3xl border border-stone-200 bg-[#fbf6f1] p-5 shadow-sm shadow-[#a47551]/5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-[#3d2b1c]">
                                        {{ ucfirst($address['label']) }}{{ $address['is_primary'] ? ' • Utama' : '' }}
                                    </p>
                                    <p class="mt-1 text-sm text-[#6a5a4f]">{{ $address['recipient_name'] }} •
                                        {{ $address['phone'] }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @unless ($address['is_primary'])
                                        <button wire:click.prevent="setPrimaryAddress({{ $address['id'] }})" type="button"
                                            class="rounded-2xl border border-[#e1c7aa] bg-white px-3 py-2 text-xs font-semibold text-[#7a5d45] transition hover:bg-[#f9efe3]">Jadikan
                                            utama</button>
                                    @endunless
                                    <div x-data="{ showConfirm: false }">
                                        <button @click="showConfirm = true" type="button"
                                            class="rounded-2xl border border-[#f1c0b0] bg-[#fff2f0] px-3 py-2 text-xs font-semibold text-[#9a3f34] transition hover:bg-[#ffe6e3]">Hapus</button>
                                        <div x-show="showConfirm" x-cloak
                                            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <p class="font-semibold text-stone-800">Hapus alamat?</p>
                                                <p class="text-sm text-stone-500 mt-1">Alamat yang dihapus tidak bisa
                                                    dikembalikan.</p>
                                                <div class="flex gap-2 mt-4">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                    <button wire:click.prevent="deleteAddress({{ $address['id'] }})"
                                                        @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2 text-sm text-[#5f4a3f]">
                                <p>{{ $address['street'] }}, {{ $address['region'] }}</p>
                                @if ($address['detail'])
                                    <p>{{ $address['detail'] }}</p>
                                @endif
                                @if (!empty($address['postal_code']))
                                    <p class="text-xs text-stone-400">Kode Pos: {{ $address['postal_code'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Modal Tambah Alamat --}}
    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeForm">
            <div class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-stone-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <h2 class="text-lg font-semibold text-stone-800">Tambah Alamat Baru</h2>
                    <button wire:click="closeForm" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="saveAddress" class="p-6 space-y-5">
                    {{-- Label --}}
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-[#3d2b1c]">Label Alamat</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="$set('address_label', 'home')"
                                class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $address_label === 'home' ? 'border-amber-500 bg-amber-100 text-[#7a4e24]' : 'border-stone-200 bg-white text-[#6a5a4f] hover:bg-stone-50' }}">Rumah</button>
                            <button type="button" wire:click="$set('address_label', 'office')"
                                class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $address_label === 'office' ? 'border-amber-500 bg-amber-100 text-[#7a4e24]' : 'border-stone-200 bg-white text-[#6a5a4f] hover:bg-stone-50' }}">Kantor</button>
                            <button type="button" wire:click="$set('address_label', 'other')"
                                class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $address_label === 'other' ? 'border-amber-500 bg-amber-100 text-[#7a4e24]' : 'border-stone-200 bg-white text-[#6a5a4f] hover:bg-stone-50' }}">Lainnya</button>
                        </div>
                        @if ($address_label === 'other')
                            <input wire:model.defer="address_label" type="text" placeholder="Tulis label custom"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_label') border-rose-300 bg-rose-50/50 @enderror" />
                        @endif
                        @error('address_label')
                            <p class="text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Penerima --}}
                    <div>
                        <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Nama Penerima</label>
                        <input wire:model.defer="address_recipient_name" type="text" placeholder="Nama penerima"
                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_recipient_name') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('address_recipient_name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div>
                        <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Telepon</label>
                        <input wire:model.defer="address_phone" type="tel" placeholder="0812xxxxxxx" maxlength="20"
                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_phone') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('address_phone')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Wilayah dengan Search --}}
                    @if ($regionDataReady)
                        <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
                            <p class="text-sm font-semibold text-[#6a4c32] mb-1">Pilih Wilayah Tujuan</p>
                            <p class="text-xs text-[#876349] mb-4">Pilih berurutan dari provinsi sampai kelurahan/desa.
                            </p>
                            <div class="grid gap-4 sm:grid-cols-2">
                                {{-- Provinsi --}}
                                <div x-data="{ search: '', open: false }" class="relative">
                                    <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Provinsi</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari provinsi..." autocomplete="off"
                                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 pr-10 text-sm focus:outline-none focus:border-amber-400 @error('selectedProvinceCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-stone-200 bg-white shadow-lg">
                                        @foreach ($provinces as $province)
                                            <button type="button"
                                                @click="$wire.set('selectedProvinceCode', '{{ $province['code'] }}'); search = '{{ $province['name'] }}'; open = false"
                                                x-show="search === '' || '{{ strtolower($province['name']) }}'.includes(search.toLowerCase())"
                                                class="w-full text-left px-4 py-2.5 text-sm hover:bg-amber-50 transition-colors {{ $selectedProvinceCode === $province['code'] ? 'bg-amber-100 font-medium text-[#7a4e24]' : 'text-stone-700' }}">
                                                {{ $province['name'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('selectedProvinceCode')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kota --}}
                                <div x-data="{ search: '', open: false }" class="relative">
                                    <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Kota /
                                        Kabupaten</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari kota..." autocomplete="off"
                                            @disabled(blank($selectedProvinceCode))
                                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 pr-10 text-sm focus:outline-none focus:border-amber-400 disabled:bg-stone-100 disabled:cursor-not-allowed @error('selectedCityCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open && !@json(blank($selectedProvinceCode))" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-stone-200 bg-white shadow-lg">
                                        @foreach ($cities as $city)
                                            <button type="button"
                                                @click="$wire.set('selectedCityCode', '{{ $city['code'] }}'); search = '{{ $city['name'] }}'; open = false"
                                                x-show="search === '' || '{{ strtolower($city['name']) }}'.includes(search.toLowerCase())"
                                                class="w-full text-left px-4 py-2.5 text-sm hover:bg-amber-50 transition-colors {{ $selectedCityCode === $city['code'] ? 'bg-amber-100 font-medium text-[#7a4e24]' : 'text-stone-700' }}">
                                                {{ $city['name'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('selectedCityCode')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kecamatan --}}
                                <div x-data="{ search: '', open: false }" class="relative">
                                    <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Kecamatan</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari kecamatan..."
                                            autocomplete="off" @disabled(blank($selectedCityCode))
                                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 pr-10 text-sm focus:outline-none focus:border-amber-400 disabled:bg-stone-100 disabled:cursor-not-allowed @error('selectedDistrictCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open && !@json(blank($selectedCityCode))" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-stone-200 bg-white shadow-lg">
                                        @foreach ($districts as $district)
                                            <button type="button"
                                                @click="$wire.set('selectedDistrictCode', '{{ $district['code'] }}'); search = '{{ $district['name'] }}'; open = false"
                                                x-show="search === '' || '{{ strtolower($district['name']) }}'.includes(search.toLowerCase())"
                                                class="w-full text-left px-4 py-2.5 text-sm hover:bg-amber-50 transition-colors {{ $selectedDistrictCode === $district['code'] ? 'bg-amber-100 font-medium text-[#7a4e24]' : 'text-stone-700' }}">
                                                {{ $district['name'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('selectedDistrictCode')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kelurahan --}}
                                <div x-data="{ search: '', open: false }" class="relative">
                                    <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Kelurahan /
                                        Desa</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari kelurahan..."
                                            autocomplete="off" @disabled(blank($selectedDistrictCode))
                                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 pr-10 text-sm focus:outline-none focus:border-amber-400 disabled:bg-stone-100 disabled:cursor-not-allowed @error('selectedVillageCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-stone-400 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open && !@json(blank($selectedDistrictCode))" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-stone-200 bg-white shadow-lg">
                                        @foreach ($villages as $village)
                                            <button type="button"
                                                @click="$wire.set('selectedVillageCode', '{{ $village['code'] }}'); search = '{{ $village['name'] }}'; open = false"
                                                x-show="search === '' || '{{ strtolower($village['name']) }}'.includes(search.toLowerCase())"
                                                class="w-full text-left px-4 py-2.5 text-sm hover:bg-amber-50 transition-colors {{ $selectedVillageCode === $village['code'] ? 'bg-amber-100 font-medium text-[#7a4e24]' : 'text-stone-700' }}">
                                                {{ $village['name'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('selectedVillageCode')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Wilayah</label>
                            <input wire:model.defer="address_region" type="text"
                                placeholder="Provinsi / Kota / Kecamatan / Kelurahan"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_region') border-rose-300 bg-rose-50/50 @enderror" />
                            @error('address_region')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- Jalan --}}
                    <div>
                        <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Jalan / Kompleks</label>
                        <input wire:model.defer="address_street" type="text" placeholder="Alamat lengkap"
                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_street') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('address_street')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Detail --}}
                    <div>
                        <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Detail tambahan</label>
                        <input wire:model.defer="address_detail" type="text"
                            placeholder="Gedung / lantai / patokan"
                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_detail') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('address_detail')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kode Pos --}}
                    <div>
                        <label class="block text-sm font-medium text-[#3d2b1c] mb-1.5">Kode Pos</label>
                        <input wire:model.defer="address_postal_code" type="text" maxlength="10"
                            placeholder="12345"
                            class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm focus:outline-none focus:border-amber-400 @error('address_postal_code') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('address_postal_code')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Checkbox utama --}}
                    @if (count($addresses) > 0)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input wire:model="address_is_primary" type="checkbox"
                                class="h-4 w-4 rounded border-stone-300 text-amber-500 focus:ring-amber-500" />
                            <span class="text-sm text-[#5f4a3f]">Jadikan alamat utama</span>
                        </label>
                    @else
                        <p class="text-xs text-amber-600 bg-amber-50 rounded-xl px-4 py-3">Ini adalah alamat pertama
                            kamu, otomatis jadi alamat utama.</p>
                    @endif

                    <div class="flex gap-2 pt-2">
                        <button type="button" wire:click="closeForm"
                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243]">Simpan
                            Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
