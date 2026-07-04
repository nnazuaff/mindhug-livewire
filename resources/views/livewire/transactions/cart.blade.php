<div class="grid gap-5 sm:gap-8 lg:grid-cols-[1.8fr_1fr]">
    <div class="space-y-4">
        @if (empty($cartItems))
            <div
                class="rounded-[1.75rem] border border-stone-200 bg-white p-7 sm:p-10 text-center shadow-[0_24px_60px_rgba(34,25,17,0.08)]">
                <div
                    class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-[#f7ede0]/80 text-[#a47551]">
                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6h15l-1.5 9h-12z" />
                        <path d="M6 6 4 3H1" />
                        <circle cx="9" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-[#2b1d12]">Keranjangmu masih sepi hari ini...</h2>
                <p class="mt-2 text-sm leading-7 text-[#6a5a4f]">Jangan khawatir, kamu bisa cari produk favorit dan
                    kembali ke sini kapan saja.</p>
                <div class="mt-6">
                    <a href="{{ route('shop') }}"
                        class="inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:scale-[1.01] duration-200">
                        Jelajahi Shop
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($cartItems as $item)
                    <article
                        class="group overflow-hidden rounded-3xl border border-stone-200/60 bg-white p-4 sm:p-5 shadow-sm shadow-[#a47551]/5 transition duration-200"
                        wire:loading.class="opacity-50"
                        wire:target="increment({{ $item['id'] }}), decrement({{ $item['id'] }}), removeItem({{ $item['id'] }})">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex gap-3 sm:gap-4">
                                <div
                                    class="h-24 w-24 sm:h-28 sm:w-28 overflow-hidden rounded-3xl bg-[#f7f2ed] shadow-inner shadow-[#a47551]/5 shrink-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                        class="h-full w-full object-cover" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-semibold text-[#2b1d12] line-clamp-2">{{ $item['name'] }}
                                    </h3>
                                    <p class="mt-2 text-sm text-[#6a5a4f]">Varian: Default</p>
                                    <p class="mt-3 text-lg font-semibold text-[#a47551]">Rp
                                        {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-3 sm:gap-4 lg:items-end">
                                <div
                                    class="flex items-center rounded-2xl border border-stone-200 bg-[#f8f2e9] px-2 py-1 text-sm">
                                    @if ($item['quantity'] === 1)
                                        <x-confirmation-dialog action="removeItem" :actionParams="[$item['id']]"
                                            title="Hapus produk"
                                            message="Yakin ingin menghapus produk ini dari keranjang?"
                                            confirmText="Hapus" cancelText="Batal">
                                            <button type="button"
                                                class="h-9 w-9 rounded-2xl text-[#7a5d45] transition hover:bg-[#e9d6be] hover:text-[#8f6243]">−</button>
                                        </x-confirmation-dialog>
                                    @else
                                        <button type="button" wire:click="decrement({{ $item['id'] }})"
                                            class="h-9 w-9 rounded-2xl text-[#7a5d45] transition hover:bg-[#e9d6be] hover:text-[#8f6243]">−</button>
                                    @endif
                                    <span
                                        class="mx-4 min-w-8 text-center font-semibold text-[#2b1d12]">{{ $item['quantity'] }}</span>
                                    <button type="button" wire:click="increment({{ $item['id'] }})"
                                        class="h-9 w-9 rounded-2xl text-[#7a5d45] transition hover:bg-[#e9d6be] hover:text-[#8f6243]">+</button>
                                </div>
                                <x-confirmation-dialog action="removeItem" :actionParams="[$item['id']]" title="Hapus produk"
                                    message="Yakin ingin menghapus produk ini dari keranjang?" confirmText="Hapus"
                                    cancelText="Batal">
                                    <button type="button"
                                        class="inline-flex items-center gap-2 rounded-2xl border border-stone-200 bg-white px-3 py-2 text-xs font-semibold text-[#7a5d45] transition hover:border-rose-300 hover:bg-rose-50 hover:text-rose-600">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18" />
                                            <path d="M8 6v14c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2V6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M9 6V4h6v2" />
                                        </svg>
                                        Hapus
                                    </button>
                                </x-confirmation-dialog>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <div class="lg:sticky lg:top-24">
        <div class="rounded-3xl border border-stone-200 bg-white p-5 sm:p-6 shadow-[0_24px_50px_rgba(34,25,17,0.06)]">
            <h2 class="text-lg font-semibold text-[#2b1d12]">Ringkasan Belanja</h2>
            <div class="mt-6 space-y-4 text-sm text-[#6a5a4f]">
                <div class="flex items-center justify-between">
                    <span>Subtotal</span>
                    <span class="font-semibold text-[#2b1d12]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Diskon</span>
                    <span class="font-semibold text-[#2b1d12]">Rp
                        {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
                <div class="h-px bg-stone-200/60"></div>
                <div class="flex items-center justify-between text-base font-semibold text-[#1f1f1f]">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <label class="block text-sm font-medium text-[#3d2b1c]">Kode Voucher / Promo</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input wire:model.defer="promoCode" type="text" placeholder="Masukkan kode promo"
                        class="flex-1 rounded-xl border border-stone-200 bg-[#f9f4ee] px-4 py-3 text-sm text-[#2b1d12] outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    <button type="button" wire:click="applyPromo"
                        class="rounded-2xl bg-[#a47551] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#8f6243] hover:scale-[1.01] duration-200 sm:w-auto w-full">
                        Terapkan
                    </button>
                </div>
                @if ($promoMessage)
                    <p class="text-sm text-[#5f4a3f]">{{ $promoMessage }}</p>
                @endif
            </div>

            @if (count($cartItems) > 0)
                <a href="{{ route('checkout') }}" wire:navigate
                    class="mt-6 inline-flex w-full items-center justify-center rounded-3xl bg-[#a47551] px-5 py-4 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:scale-[1.01] duration-200">
                    Lanjutkan
                </a>
            @else
                <button type="button" disabled
                    class="mt-6 inline-flex w-full cursor-not-allowed items-center justify-center rounded-3xl bg-stone-300 px-5 py-4 text-sm font-semibold text-white">
                    Keranjang Masih Kosong
                </button>
            @endif
        </div>
    </div>
</div>
