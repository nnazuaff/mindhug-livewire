<x-layouts.app title="Checkout - Mindhug">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="space-y-6">
            <div class="rounded-3xl border border-stone-200 bg-[#fff8f0] p-8 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
                <span
                    class="inline-flex rounded-full bg-[#f2e4d3] px-4 py-1 text-xs font-semibold uppercase tracking-[0.32em] text-[#8b6f5c]">Checkout</span>

                <p class="mt-3 max-w-3xl text-sm leading-7 text-[#6a5a4f]"
                    style="font-family: 'Plus Jakarta Sans', sans-serif;">Pastikan alamat dan metode pembayaran sudah
                    benar sebelum mengonfirmasi</p>
            </div>

            <livewire:checkout.index />
        </div>
    </div>
</x-layouts.app>
