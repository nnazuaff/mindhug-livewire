<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.32em] text-[#8b6f5c]/70">Keamanan Akun</p>
                <h1 class="mt-2 text-3xl font-semibold text-[#1f1f1f]">Jaga akun tetap aman</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-[#6a5a4f]">Ubah password dan kelola penghapusan akun
                    dengan aman di sini.</p>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mt-6 rounded-3xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="updatePassword"
            class="mt-8 space-y-6 rounded-[1.75rem] border border-stone-200 bg-[#fbf6f1] p-6">
            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Password saat ini</span>
                    <input wire:model.blur="current_password" type="password" placeholder="Password saat ini"
                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('current_password')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Password baru</span>
                    <input wire:model.blur="new_password" type="password" placeholder="Password baru"
                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('new_password')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Konfirmasi password</span>
                    <input wire:model.blur="new_password_confirmation" type="password" placeholder="Konfirmasi password"
                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:bg-[#8f6243] disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove>Perbarui Password</span>
                    <span wire:loading>Memperbarui...</span>
                </button>
            </div>
        </form>

        <div class="mt-8 rounded-[1.75rem] border border-stone-200 bg-[#fff1e3] p-6 shadow-sm shadow-[#a47551]/10">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold text-[#3d2b1c]">Hapus Akun</p>
                    <p class="mt-2 text-sm leading-6 text-[#6a5a4f]">Menghapus akun akan menghapus semua data. Masukkan
                        password untuk konfirmasi.</p>
                </div>
            </div>

            <form wire:submit.prevent="deleteAccount" class="mt-6 space-y-4">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Password konfirmasi</span>
                    <input wire:model.blur="delete_password" type="password" placeholder="Password"
                        class="w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('delete_password')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <div class="flex justify-end">
                    <button type="submit" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center rounded-2xl bg-[#ad4d2f] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#ad4d2f]/20 transition hover:bg-[#913f24] disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove>Hapus Akun</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
