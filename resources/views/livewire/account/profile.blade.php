<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                {{-- Avatar --}}
                <div class="group relative shrink-0">
                    <div class="h-24 w-24 rounded-[1.75rem] overflow-hidden border-2 border-stone-200 bg-[#f5e9df]">
                        <img src="{{ $this->user->avatar_url }}" alt="{{ $this->user->full_name }}"
                            class="h-full w-full object-cover">
                    </div>

                    {{-- Upload overlay --}}
                    <label for="avatar-upload"
                        class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-[1.75rem] opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                    </label>
                    <input id="avatar-upload" type="file" wire:model="avatar" accept="image/*" class="hidden">
                </div>

                <div>
                    <h1 class="text-3xl font-semibold text-[#1f1f1f]">{{ $user->full_name }}</h1>
                </div>
            </div>

            <span
                class="inline-flex items-center rounded-2xl border border-[#f0d6bb] bg-[#fff1e3] px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-[#7a5d45] shadow-sm shadow-[#a47551]/5">
                Status: {{ ucfirst($role) }}
            </span>
        </div>

        {{-- Avatar loading & preview --}}
        @if ($avatar)
            <div class="mt-4 flex items-center gap-3">
                <p class="text-sm text-[#6a5a4f]">Pratinjau:</p>
                <img src="{{ $avatar->temporaryUrl() }}"
                    class="h-16 w-16 rounded-2xl object-cover border border-stone-200">
                <button wire:click="$set('avatar', null)"
                    class="text-xs text-rose-500 hover:text-rose-600">Batal</button>
            </div>
        @endif

        @error('avatar')
            <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
        @enderror

        {{-- Hapus foto --}}
        @if ($user->avatar)
            <button wire:click="removeAvatar" wire:loading.attr="disabled"
                class="mt-3 text-xs text-stone-400 hover:text-rose-500 transition-colors">
                Hapus foto profil
            </button>
        @endif
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
