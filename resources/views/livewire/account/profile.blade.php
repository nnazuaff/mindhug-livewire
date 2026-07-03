<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="group relative overflow-hidden rounded-[1.75rem] border border-stone-200 bg-[#fff6f0] p-2 shadow-sm shadow-[#a47551]/10">
                    <div
                        class="flex h-24 w-24 items-center justify-center rounded-[1.5rem] bg-[#fff8f2] text-4xl font-semibold text-[#a47551]">
                        {{ strtoupper(substr($user->full_name, 0, 1)) }}</div>
                    <button type="button"
                        class="absolute inset-x-0 bottom-0 mx-auto mb-3 hidden rounded-full border border-[#e8d2b5] bg-white/95 px-3 py-1 text-[0.72rem] font-semibold text-[#7a5d45] shadow-sm transition duration-200 group-hover:inline-flex">
                        Ubah Foto
                    </button>
                </div>
                <div>

                    <h1 class="mt-3 text-3xl font-semibold text-[#1f1f1f]">{{ $user->full_name }}</h1>
                    <p class="mt-2 max-w-xl text-sm leading-7 text-[#6a5a4f]">Perbarui data profil dasar dengan
                        halaman yang ringan dan fokus.</p>
                </div>
            </div>
            <span
                class="inline-flex items-center rounded-2xl border border-[#f0d6bb] bg-[#fff1e3] px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-[#7a5d45] shadow-sm shadow-[#a47551]/5">Status:
                {{ ucfirst($role) }}</span>
        </div>
    </section>

    @if (session()->has('success'))
        <section
            class="rounded-[1.75rem] border border-green-200 bg-green-50 p-4 text-sm text-green-800 shadow-sm shadow-green-100/70">
            {{ session('success') }}
        </section>
    @endif

    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-[0.32em] text-[#8b6f5c]/80">Edit Profil</p>
            <h2 class="mt-2 text-2xl font-bold text-[#1f1f1f]">Ubah informasi dasar</h2>
        </div>

        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Nama Lengkap</span>
                    <input wire:model.blur="full_name" type="text" placeholder="Nama lengkap"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('full_name')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Username</span>
                    <input wire:model.blur="username" type="text" placeholder="Username"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('username')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Email</span>
                    <input wire:model.blur="email" type="email" placeholder="email@kamu.com"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('email')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Telepon</span>
                    <input wire:model.blur="phone" type="tel" placeholder="0812xxxxxxx"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('phone')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Tanggal Lahir</span>
                    <input wire:model.blur="birth_date" type="date"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70" />
                    @error('birth_date')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

            </div>

            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:bg-[#8f6243] disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Memperbarui...</span>
                </button>
            </div>
        </form>
    </section>
</div>
