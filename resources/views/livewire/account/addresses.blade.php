<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.32em] text-[#8b6f5c]/70">Alamat</p>
                <h1 class="mt-2 text-3xl font-semibold text-[#1f1f1f]">Kelola alamat pengiriman</h1>
                {{-- <p class="mt-3 max-w-2xl text-sm leading-7 text-[#6a5a4f]">Simpan alamat rumah atau kantor untuk checkout
                    yang lebih cepat.</p> --}}
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mt-6 rounded-3xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 space-y-8">
            <div class="grid gap-4 lg:grid-cols-2">
                @foreach ($addresses as $address)
                    <div class="rounded-3xl border border-stone-200 bg-[#fbf6f1] p-5 shadow-sm shadow-[#a47551]/5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-[#3d2b1c]">
                                    {{ ucfirst($address['label']) }}{{ $address['is_primary'] ? ' • Utama' : '' }}</p>
                                <p class="mt-1 text-sm text-[#6a5a4f]">{{ $address['recipient_name'] }} •
                                    {{ $address['phone'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @unless ($address['is_primary'])
                                    <button wire:click.prevent="setPrimaryAddress({{ $address['id'] }})" type="button"
                                        class="rounded-2xl border border-[#e1c7aa] bg-white px-3 py-2 text-xs font-semibold text-[#7a5d45] transition hover:bg-[#f9efe3]">Jadikan
                                        utama</button>
                                @endunless
                                <button wire:click.prevent="deleteAddress({{ $address['id'] }})" type="button"
                                    class="rounded-2xl border border-[#f1c0b0] bg-[#fff2f0] px-3 py-2 text-xs font-semibold text-[#9a3f34] transition hover:bg-[#ffe6e3]">Hapus</button>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2 text-sm text-[#5f4a3f]">
                            <p>{{ $address['street'] }}, {{ $address['region'] }}</p>
                            @if ($address['detail'])
                                <p>{{ $address['detail'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="rounded-3xl border border-stone-200 bg-[#fbf6f1] p-6">
                <p class="text-sm font-semibold text-[#3d2b1c]">Tambah Alamat Baru</p>
                {{-- <p class="mt-2 text-sm leading-6 text-[#6a5a4f]">Isi detail alamat sekali, nanti checkout tinggal pilih.
                    Alur wilayah sudah otomatis berantai seperti marketplace.</p> --}}

                <form wire:submit.prevent="saveAddress" class="mt-6 space-y-6">
                    {{-- @if ($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                            <p class="font-semibold">Mohon perbaiki beberapa kolom berikut:</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <div class="space-y-3">
                        <p class="text-sm font-medium text-[#3d2b1c]">Label Alamat</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="$set('address_label', 'home')"
                                class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $address_label === 'home' ? 'border-amber-500 bg-amber-100 text-[#7a4e24]' : 'border-stone-200 bg-white text-[#6a5a4f] hover:bg-stone-50' }}">
                                Rumah
                            </button>
                            <button type="button" wire:click="$set('address_label', 'office')"
                                class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $address_label === 'office' ? 'border-amber-500 bg-amber-100 text-[#7a4e24]' : 'border-stone-200 bg-white text-[#6a5a4f] hover:bg-stone-50' }}">
                                Kantor
                            </button>
                            <button type="button" wire:click="$set('address_label', 'other')"
                                class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $address_label === 'other' ? 'border-amber-500 bg-amber-100 text-[#7a4e24]' : 'border-stone-200 bg-white text-[#6a5a4f] hover:bg-stone-50' }}">
                                Lainnya
                            </button>
                        </div>
                        @if ($address_label === 'other')
                            <input wire:model.defer="address_label" type="text" placeholder="Tulis label custom"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                        @endif
                        @error('address_label')
                            <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Nama Penerima</span>
                            <input wire:model.defer="address_recipient_name" type="text" placeholder="Nama penerima"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                            @error('address_recipient_name')
                                <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Telepon</span>
                            <input wire:model.defer="address_phone" type="tel" placeholder="0812xxxxxxx"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                            @error('address_phone')
                                <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    @if ($regionDataReady)
                        <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
                            <p class="text-sm font-semibold text-[#6a4c32]">Pilih Wilayah Tujuan</p>
                            <p class="mt-1 text-xs text-[#876349]">Pilih berurutan dari provinsi sampai kelurahan/desa.
                            </p>

                            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Provinsi</span>
                                    <select wire:model.live="selectedProvinceCode"
                                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                                        <option value="">Pilih provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province['code'] }}">{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedProvinceCode')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Kota / Kabupaten</span>
                                    <select wire:model.live="selectedCityCode" @disabled(blank($selectedProvinceCode))
                                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition disabled:cursor-not-allowed disabled:bg-stone-100 focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                                        <option value="">Pilih kota/kabupaten</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city['code'] }}">{{ $city['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedCityCode')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Kecamatan</span>
                                    <select wire:model.live="selectedDistrictCode" @disabled(blank($selectedCityCode))
                                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition disabled:cursor-not-allowed disabled:bg-stone-100 focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                                        <option value="">Pilih kecamatan</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district['code'] }}">{{ $district['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedDistrictCode')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Kelurahan / Desa</span>
                                    <select wire:model.live="selectedVillageCode" @disabled(blank($selectedDistrictCode))
                                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition disabled:cursor-not-allowed disabled:bg-stone-100 focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                                        <option value="">Pilih kelurahan/desa</option>
                                        @foreach ($villages as $village)
                                            <option value="{{ $village['code'] }}">{{ $village['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedVillageCode')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                        </div>
                    @else
                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Wilayah</span>
                            <input wire:model.defer="address_region" type="text"
                                placeholder="Provinsi / Kota / Kecamatan / Kelurahan"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                            @error('address_region')
                                <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    @endif

                    <div class="grid gap-4 lg:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Jalan / Kompleks</span>
                            <input wire:model.defer="address_street" type="text" placeholder="Alamat lengkap"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                            @error('address_street')
                                <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Detail tambahan</span>
                            <input wire:model.defer="address_detail" type="text"
                                placeholder="Gedung / lantai / patokan"
                                class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                            @error('address_detail')
                                <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <div class="flex items-center gap-3">
                        <input wire:model="address_is_primary" id="address_is_primary" type="checkbox"
                            class="h-4 w-4 rounded border-stone-300 text-amber-500 focus:ring-amber-500" />
                        <label for="address_is_primary" class="text-sm text-[#5f4a3f]">Jadikan alamat ini
                            utama</label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:bg-[#8f6243] disabled:cursor-not-allowed disabled:opacity-60">
                            <span wire:loading.remove>Simpan Alamat</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
