<x-layouts.app title="Keranjang Belanja">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex flex-col gap-6 lg:gap-10">
            <div class="space-y-2">
                <span
                    class="inline-block rounded-full bg-[#f3e5d5] px-4 py-1 text-[0.8rem] font-semibold uppercase tracking-[0.24em] text-[#8c6a4b]">Keranjang</span>

            </div>

            <livewire:transactions.cart />
        </div>
    </div>
</x-layouts.app>
