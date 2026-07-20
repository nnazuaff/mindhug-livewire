<div class="space-y-6">
    {{-- Header --}}
    <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
        <div>
            <p class="text-[0.65rem] font-semibold uppercase tracking-[0.28em] text-[#8b6f5c]/70">Keamanan</p>
            <h1 class="mt-2 text-2xl sm:text-3xl font-semibold text-[#1f1f1f]">Jaga akun tetap aman</h1>
            <p class="mt-1.5 text-sm text-[#6a5a4f]">Kelola password dan akses akun kamu.</p>
        </div>

        {{-- Success --}}
        @if (session()->has('success'))
            <div
                class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50/70 px-5 py-4 text-sm text-emerald-700 flex items-start gap-3">
                <svg class="h-5 w-5 shrink-0 mt-0.5 text-emerald-500" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Change Password --}}
        <div class="mt-6 rounded-2xl border border-[#e8d5c4] bg-[#fdfaf7] p-5 sm:p-6">
            <h3 class="text-base font-semibold text-[#2b1d12] mb-1">Ubah Password</h3>
            <p class="text-sm text-[#6a5a4f] mb-5">Gunakan password yang kuat dan belum pernah dipakai sebelumnya.</p>

            <form wire:submit.prevent="updatePassword" class="space-y-4">
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Password saat ini</label>
                        <input wire:model.blur="current_password" type="password" placeholder="••••••••"
                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('current_password') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('current_password')
                            <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Password baru</label>
                        <input wire:model.blur="new_password" type="password" placeholder="••••••••"
                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('new_password') border-rose-300 bg-rose-50/50 @enderror" />
                        @error('new_password')
                            <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Konfirmasi</label>
                        <input wire:model.blur="new_password_confirmation" type="password" placeholder="••••••••"
                            class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200">
                        <span wire:loading.remove>Perbarui Password</span>
                        <span wire:loading class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Memperbarui...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Delete Account --}}
        <div class="mt-6 rounded-2xl border border-rose-200 bg-[#fff8f5] p-5 sm:p-6">
            <h3 class="text-base font-semibold text-[#2b1d12] mb-1">Hapus Akun</h3>
            <p class="text-sm text-[#6a5a4f] mb-5">Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus
                permanen.</p>

            <form wire:submit.prevent="deleteAccount" class="space-y-4">
                <div class="max-w-xs">
                    <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Password konfirmasi</label>
                    <input wire:model.blur="delete_password" type="password" placeholder="••••••••"
                        class="w-full rounded-xl border border-[#e0d0c0] bg-white px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-rose-400 focus:ring-2 focus:ring-rose-200/50 @error('delete_password') border-rose-300 bg-rose-50/50 @enderror" />
                    @error('delete_password')
                        <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-500 px-6 py-3 text-sm font-semibold text-white hover:bg-rose-600 active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200">
                        <span wire:loading.remove>Hapus Akun</span>
                        <span wire:loading class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
