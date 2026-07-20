<div class="space-y-6">
    {{-- Header Section --}}
    <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[0.65rem] font-semibold uppercase tracking-[0.28em] text-[#8b6f5c]/70">Alamat</p>
                <h1 class="mt-2 text-2xl sm:text-3xl font-semibold text-[#1f1f1f]">Kelola alamat pengiriman</h1>
                <p class="mt-1.5 text-sm text-[#6a5a4f] max-w-md">Simpan alamat untuk checkout yang lebih cepat.</p>
            </div>

            @if (!empty($addresses))
                <button wire:click="openForm"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#a47551] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] transition-all duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Alamat
                </button>
            @endif
        </div>

        <div class="mt-8">
            @if (empty($addresses))
                <div class="rounded-3xl border border-[#e0d0c0] bg-[#fdfaf7] p-10 text-center">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#f5e9df] text-[#a47551]">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-[#2b1d12]">Belum ada alamat</h3>
                    <p class="mt-2 text-sm text-[#6a5a4f] max-w-sm mx-auto">Tambahkan alamat pertama kamu untuk
                        pengiriman yang lebih cepat saat checkout.</p>
                    <button wire:click="openForm"
                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#a47551] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] transition-all duration-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Sekarang
                    </button>
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($addresses as $address)
                        <div
                            class="group rounded-2xl border border-[#e8d5c4] bg-[#fefbf8] p-5 transition duration-200 hover:border-[#c19a6b]/50">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-xl {{ $address['is_primary'] ? 'bg-[#a47551]/10 text-[#a47551]' : 'bg-[#f0e5db] text-[#8b6f5c]' }}">
                                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                            <circle cx="12" cy="10" r="3" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#2b1d12]">
                                            {{ ucfirst($address['label']) }}
                                            @if ($address['is_primary'])
                                                <span
                                                    class="ml-1.5 text-[0.6rem] font-medium text-[#a47551] bg-[#f5e9df] px-2 py-0.5 rounded-full">Utama</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-[#6a5a4f] mt-0.5">{{ $address['recipient_name'] }} ·
                                            {{ $address['phone'] }}</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center gap-1.5 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-150">
                                    <button wire:click="editAddress({{ $address['id'] }})" type="button"
                                        class="rounded-xl border border-[#e0d0c0] bg-white px-3 py-1.5 text-[0.65rem] font-semibold text-[#6a5a4f] hover:bg-[#f5e9df] hover:border-[#c19a6b]/50 hover:text-[#a47551] transition-all duration-200">
                                        Edit
                                    </button>
                                    @unless ($address['is_primary'])
                                        <button wire:click.prevent="setPrimaryAddress({{ $address['id'] }})" type="button"
                                            class="rounded-xl border border-[#e0d0c0] bg-white px-3 py-1.5 text-[0.65rem] font-semibold text-[#6a5a4f] hover:bg-[#f5e9df] hover:border-[#c19a6b]/50 hover:text-[#a47551] transition-all duration-200">
                                            Utama
                                        </button>
                                    @endunless
                                    <div x-data="{ showConfirm: false }">
                                        <button @click="showConfirm = true" type="button"
                                            class="rounded-xl border border-[#f1c0b0] bg-[#fff2f0] px-3 py-1.5 text-[0.65rem] font-semibold text-[#9a3f34] hover:bg-[#ffe6e3] transition-all duration-200">
                                            Hapus
                                        </button>
                                        <div x-show="showConfirm" x-cloak
                                            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 ">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                <div
                                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-rose-500 mb-4">
                                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path d="M3 6h18" />
                                                        <path d="M8 6v14c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2V6" />
                                                    </svg>
                                                </div>
                                                <p class="font-semibold text-[#2b1d12]">Hapus alamat?</p>
                                                <p class="text-sm text-[#6a5a4f] mt-1">Alamat yang dihapus tidak bisa
                                                    dikembalikan.</p>
                                                <div class="flex gap-2 mt-5">
                                                    <button @click="showConfirm = false"
                                                        class="flex-1 rounded-xl border border-[#e0d0c0] bg-white px-4 py-2.5 text-sm font-medium text-[#6a5a4f] hover:bg-stone-50 transition-colors">Batal</button>
                                                    <button wire:click.prevent="deleteAddress({{ $address['id'] }})"
                                                        @click="showConfirm = false"
                                                        class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600 transition-colors">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-1.5 text-sm text-[#5f4a3f] leading-relaxed">
                                <p>{{ $address['street'] }}</p>
                                <p>{{ $address['region'] }}</p>
                                @if ($address['detail'])
                                    <p class="text-xs text-[#8b6f5c] mt-1">{{ $address['detail'] }}</p>
                                @endif
                                @if (!empty($address['postal_code']))
                                    <p class="text-xs text-[#b0a090] mt-1">Kode Pos: {{ $address['postal_code'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Modal Tambah / Edit Alamat --}}
    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 "
            wire:click.self="closeForm">
            <div class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-white border-b border-[#ede0d4] px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                    <h2 class="text-lg font-semibold text-[#2b1d12]">
                        {{ $isEditing ? 'Edit Alamat' : 'Tambah Alamat Baru' }}
                    </h2>
                    <button wire:click="closeForm"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-[#b0a090] hover:bg-stone-100 hover:text-[#2b1d12] transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
                <form wire:submit.prevent="saveAddress" class="p-6 space-y-5">
                    {{-- Label --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#3d2b1c] mb-2.5">Label Alamat</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ([['home', 'Rumah'], ['office', 'Kantor'], ['other', 'Lainnya']] as [$val, $label])
                                <button type="button" wire:click="$set('address_label', '{{ $val }}')"
                                    class="rounded-xl border px-4 py-2.5 text-sm font-medium transition-all duration-200
                                        {{ $address_label === $val
                                            ? 'border-amber-400 bg-amber-50 text-[#7a4e24]'
                                            : 'border-[#e0d0c0] bg-white text-[#6a5a4f] hover:border-[#c19a6b]/50 hover:bg-[#fdfaf7]' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                        @if ($address_label === 'other')
                            <input wire:model.defer="address_label" type="text" placeholder="Tulis label custom"
                                class="mt-2.5 w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_label') border-rose-300 bg-rose-50/50 @enderror" />
                        @endif
                        @error('address_label')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama + Telepon --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Nama Penerima</label>
                            <input wire:model.defer="address_recipient_name" type="text"
                                placeholder="Nama penerima"
                                class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_recipient_name') border-rose-300 bg-rose-50/50 @enderror" />
                            @error('address_recipient_name')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Telepon</label>
                            <input wire:model.defer="address_phone" type="tel" placeholder="0812xxxxxxx"
                                maxlength="20"
                                class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_phone') border-rose-300 bg-rose-50/50 @enderror" />
                            @error('address_phone')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Wilayah --}}
                    @if ($regionDataReady)
                        <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-4">
                            <p class="text-sm font-semibold text-[#6a4c32] mb-1">Pilih Wilayah Tujuan</p>
                            <p class="text-xs text-[#876349] mb-4">Pilih berurutan dari provinsi sampai kelurahan/desa.
                            </p>
                            <div class="grid gap-4 sm:grid-cols-2">
                                {{-- Provinsi --}}
                                <div x-data="{ search: '', open: false }" class="relative">
                                    <label class="block text-xs font-semibold text-[#5f4a3f] mb-1.5">Provinsi</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari provinsi..."
                                            autocomplete="off"
                                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 pr-10 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('selectedProvinceCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-[#b0a090] pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-[#e0d0c0] bg-white shadow-lg">
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
                                    <label class="block text-xs font-semibold text-[#5f4a3f] mb-1.5">Kota /
                                        Kabupaten</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari kota..." autocomplete="off"
                                            @disabled(blank($selectedProvinceCode))
                                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 pr-10 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 disabled:bg-stone-100 disabled:cursor-not-allowed @error('selectedCityCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-[#b0a090] pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open && !@json(blank($selectedProvinceCode))" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-[#e0d0c0] bg-white shadow-lg">
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
                                    <label class="block text-xs font-semibold text-[#5f4a3f] mb-1.5">Kecamatan</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari kecamatan..."
                                            autocomplete="off" @disabled(blank($selectedCityCode))
                                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 pr-10 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 disabled:bg-stone-100 disabled:cursor-not-allowed @error('selectedDistrictCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-[#b0a090] pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open && !@json(blank($selectedCityCode))" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-[#e0d0c0] bg-white shadow-lg">
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
                                    <label class="block text-xs font-semibold text-[#5f4a3f] mb-1.5">Kelurahan /
                                        Desa</label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @focus="open = true"
                                            @click.away="open = false" placeholder="Cari kelurahan..."
                                            autocomplete="off" @disabled(blank($selectedDistrictCode))
                                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 pr-10 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 disabled:bg-stone-100 disabled:cursor-not-allowed @error('selectedVillageCode') border-rose-300 bg-rose-50/50 @enderror">
                                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-[#b0a090] pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                    <div x-show="open && !@json(blank($selectedDistrictCode))" x-cloak
                                        class="absolute z-10 mt-1 w-full max-h-48 overflow-y-auto rounded-xl border border-[#e0d0c0] bg-white shadow-lg">
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
                            <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Wilayah</label>
                            <input wire:model.defer="address_region" type="text"
                                placeholder="Provinsi / Kota / Kecamatan / Kelurahan"
                                class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_region') border-rose-300 bg-rose-50/50 @enderror" />
                            @error('address_region')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- Jalan --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Jalan / Kompleks</label>
                        <input wire:model.defer="address_street" type="text" placeholder="Alamat lengkap"
                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_street') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('address_street')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Detail + Kode Pos --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Detail tambahan</label>
                            <input wire:model.defer="address_detail" type="text"
                                placeholder="Gedung / lantai / patokan"
                                class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_detail') border-rose-300 bg-rose-50/50 @enderror" />
                            @error('address_detail')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Kode Pos</label>
                            <input wire:model.defer="address_postal_code" type="text" maxlength="10"
                                placeholder="12345"
                                class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('address_postal_code') border-rose-300 bg-rose-50/50 @enderror" />
                            @error('address_postal_code')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Checkbox utama --}}
                    @if (count($addresses) > 0 && !$isEditing)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input wire:model="address_is_primary" type="checkbox"
                                class="h-4 w-4 rounded border-[#c19a6b]/50 text-[#a47551] focus:ring-[#a47551]/30 cursor-pointer" />
                            <span class="text-sm text-[#5f4a3f] group-hover:text-[#2b1d12] transition-colors">Jadikan
                                alamat utama</span>
                        </label>
                    @elseif (empty($addresses) && !$isEditing)
                        <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 flex items-start gap-2.5">
                            <svg class="h-4.5 w-4.5 shrink-0 mt-0.5 text-amber-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <p class="text-xs text-amber-700">Ini alamat pertamamu, otomatis jadi alamat utama.</p>
                        </div>
                    @endif

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeForm"
                            class="flex-1 rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm font-semibold text-[#6a5a4f] hover:bg-stone-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-3 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] transition-all duration-200">
                            {{ $isEditing ? 'Simpan Perubahan' : 'Simpan Alamat' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
