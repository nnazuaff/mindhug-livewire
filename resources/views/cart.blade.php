<x-layouts.app title="Keranjang Belanja">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex flex-col gap-6 lg:gap-10">
            <div class="space-y-2">
                <span
                    class="inline-block rounded-full bg-[#f3e5d5] px-4 py-1 text-[0.8rem] font-semibold uppercase tracking-[0.24em] text-[#8c6a4b]">Keranjang</span>
                <h1 class="text-3xl md:text-4xl font-semibold text-[#1f1f1f]">Siap checkout? Cek dulu pesananmu.</h1>
                <p class="max-w-3xl text-sm leading-7 text-[#6a5a4f]">Kelola item keranjang, ubah jumlah, dan lihat
                    ringkasan pembayaran sebelum melanjutkan ke pembayaran.</p>
            </div>

            <livewire:transactions.cart />
        </div>
    </div>
</x-layouts.app>
