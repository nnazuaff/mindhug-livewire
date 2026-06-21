<div class="max-w-md mx-auto py-12">
    <div class="rounded-3xl border border-[#c19a6b]/25 bg-white/85 backdrop-blur p-6 md:p-8 shadow-sm">
        <span
            class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">Akun</span>
        <h1 class="text-2xl font-semibold leading-tight text-[#1f1f1f]">Daftar MindHug</h1>
        <p class="mt-2 text-sm text-[#4b4b4b]">Buat akun untuk login dan menyimpan sesi kamu.</p>

        <form wire:submit.prevent="register" class="mt-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-[#4b4b4b]" for="full_name">Nama Lengkap</label>
                <input id="full_name" wire:model.defer="full_name" type="text"
                    class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                    autocomplete="name" />
                @error('full_name')
                    <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#4b4b4b]" for="username">Username</label>
                    <input id="username" wire:model.defer="username" type="text"
                        class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                        autocomplete="username" />
                    @error('username')
                        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#4b4b4b]" for="email">Email</label>
                    <input id="email" wire:model.defer="email" type="email"
                        class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                        autocomplete="email" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#4b4b4b]" for="phone">No HP</label>
                    <input id="phone" wire:model.defer="phone" type="tel"
                        class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                        autocomplete="tel" />
                    @error('phone')
                        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#4b4b4b]" for="birth_date">Tanggal Lahir</label>
                    <input id="birth_date" wire:model.defer="birth_date" type="date"
                        class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30" />
                    @error('birth_date')
                        <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#4b4b4b]" for="password">Password</label>
                <input id="password" wire:model.defer="password" type="password"
                    class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                    autocomplete="new-password" />
                @error('password')
                    <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full inline-flex items-center justify-center rounded-xl bg-[#a47551] text-white px-5 py-3 shadow-sm hover:bg-[#8f6243] transition">
                Daftar
            </button>

            <p class="text-center text-sm text-[#6a5a4f]">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium underline">Login</a>
            </p>
        </form>
    </div>
</div>
