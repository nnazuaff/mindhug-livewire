<x-layouts.app title="Keranjang Belanja">
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="flex flex-col gap-6 lg:gap-10">
            <div>
                <span
                    class="inline-block text-xs font-semibold uppercase tracking-[0.24em] text-[#8b6f5c] mb-2">Keranjang</span>
                <h1 class="text-2xl sm:text-3xl font-semibold text-[#1f1f1f]">Belanjaan Kamu</h1>
            </div>

            <livewire:transactions.cart />
        </div>
    </div>
</x-layouts.app>
