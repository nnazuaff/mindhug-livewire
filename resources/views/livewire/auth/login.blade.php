<div class="max-w-md mx-auto py-12">
    <div class="rounded-3xl border border-[#c19a6b]/25 bg-white/85 backdrop-blur p-6 md:p-8 shadow-sm">
        <span
            class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">Akun</span>
        <h1 class="text-2xl font-semibold leading-tight text-[#1f1f1f]">Login ke MindHug</h1>
        <p class="mt-2 text-sm text-[#4b4b4b]">Masuk menggunakan akun yang sudah terdaftar.</p>

        <form wire:submit.prevent="login" class="mt-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-[#4b4b4b]" for="identifier">Username / Email</label>
                <input id="identifier" wire:model.defer="identifier" type="text"
                    class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                    autocomplete="username" />
                @error('identifier')
                    <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#4b4b4b]" for="password">Password</label>
                <input id="password" wire:model.defer="password" type="password"
                    class="mt-2 w-full rounded-xl border border-[#c19a6b]/35 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#a47551]/30"
                    autocomplete="current-password" />
                @error('password')
                    <p class="mt-2 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full inline-flex items-center justify-center rounded-xl bg-[#a47551] text-white px-5 py-3 shadow-sm hover:bg-[#8f6243] transition">
                Login
            </button>

            <p class="text-center text-sm text-[#6a5a4f]">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium underline">Daftar</a>
            </p>
        </form>
    </div>
</div>
