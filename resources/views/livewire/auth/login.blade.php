{{-- Split-screen Login — left: visual+quotes, right: form --}}
<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ══ LEFT PANEL — Visual & Quotes ══ --}}
    <div class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative overflow-hidden bg-[#2e1f12] flex-col justify-between p-10 xl:p-14"
         x-data="{
             quotes: [
                 { text: 'Kamu tidak perlu kuat setiap saat.', sub: 'MindHug hadir saat kamu butuh sandaran.' },
                 { text: 'Perasaanmu valid. Selalu.', sub: 'Tidak ada yang perlu dibuktikan di sini.' },
                 { text: 'Satu hari pada satu waktu.', sub: 'Langkah kecil tetaplah langkah maju.' },
             ],
             idx: 0,
             init() { setInterval(() => this.idx = (this.idx + 1) % this.quotes.length, 5000) }
         }">

        {{-- Ambient shapes --}}
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none" aria-hidden="true">
            <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-[#a47551]/15 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-[#c19a6b]/8 blur-3xl translate-x-1/3 translate-y-1/3"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-[#a47551]/6 blur-3xl"></div>
        </div>

        {{-- Logo --}}
        <a href="{{ url('/') }}" wire:navigate class="relative flex items-center gap-2.5 group self-start">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/15">
                <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-7 w-7 rounded-lg" />
            </span>
            <span class="text-white font-semibold text-lg tracking-wide">MindHug</span>
        </a>

        {{-- Rotating Quote --}}
        <div class="relative flex-1 flex items-center justify-center py-16">
            <div class="w-full max-w-sm">
                <div class="mb-8">
                    <svg class="h-10 w-10 text-[#a47551]/60" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <div class="relative min-h-[5rem]">
                    <template x-for="(q, i) in quotes" :key="i">
                        <div x-show="idx === i"
                             x-transition:enter="transition duration-700 ease-out"
                             x-transition:enter-start="opacity-0 translate-y-3"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition duration-400 ease-in"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             x-cloak>
                            <p class="font-baloo font-bold text-white text-2xl xl:text-3xl leading-snug" x-text="q.text"></p>
                            <p class="mt-3 text-white/55 text-sm leading-relaxed" x-text="q.sub"></p>
                        </div>
                    </template>
                </div>
                <div class="flex gap-1.5 mt-6">
                    <template x-for="(q, i) in quotes" :key="i">
                        <button @click="idx = i"
                                :class="idx === i ? 'bg-[#a47551] w-5' : 'bg-white/20 w-1.5'"
                                class="h-1.5 rounded-full transition-all duration-300">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        {{-- Bottom tagline --}}
        <p class="relative text-white/35 text-xs">
            © {{ date('Y') }} MindHug. Ruang aman untuk hatimu.
        </p>
    </div>

    {{-- ══ RIGHT PANEL — Login Form ══ --}}
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 sm:px-10 lg:px-16 bg-white">

        {{-- Mobile logo --}}
        <div class="lg:hidden mb-8 flex items-center gap-2.5">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#a47551]/10">
                <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-7 w-7 rounded-lg" />
            </span>
            <span class="text-[#2b2b2b] font-semibold text-lg tracking-wide">MindHug</span>
        </div>

        <div class="w-full max-w-md"
             x-data="{ showPassword: false }">

            {{-- Heading --}}
            <div class="mb-8">
                <h1 class="font-baloo font-bold text-[#1a1a1a] text-3xl">Selamat datang<br/>kembali.</h1>
                <p class="mt-2 text-[#666] text-sm">Masuk untuk melanjutkan perjalananmu bersama MindHug.</p>
            </div>

            {{-- Flash error toast --}}
            @if ($errors->any())
            <div class="mb-5 flex items-start gap-3 rounded-2xl bg-red-50 border border-red-100 px-4 py-3.5"
                 x-data="{ show: true }" x-show="show"
                 x-transition:enter="transition duration-300 ease-out"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <svg class="h-4 w-4 text-red-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div class="flex-1">
                    <p class="text-red-700 text-sm font-medium">Login gagal</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-xs mt-0.5">{{ $error }}</p>
                    @endforeach
                </div>
                <button @click="show = false" class="text-red-400 hover:text-red-600 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            @endif

            {{-- Form --}}
            <form wire:submit.prevent="login" class="space-y-5">

                {{-- Identifier --}}
                <div>
                    <label for="identifier" class="block text-sm font-medium text-[#3d2b1c] mb-2">
                        Username atau Email
                    </label>
                    <input id="identifier"
                           wire:model.defer="identifier"
                           type="text"
                           autocomplete="username"
                           placeholder="contoh@email.com"
                           class="w-full rounded-2xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3.5 text-sm text-[#2b2b2b] placeholder-[#b0a090] outline-none transition-all duration-200 focus:border-[#a47551] focus:ring-4 focus:ring-[#a47551]/10 @error('identifier') border-red-300 bg-red-50/50 @enderror" />
                </div>

                {{-- Password with Alpine show/hide (no Livewire re-render) --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-[#3d2b1c]">Password</label>
                        <a href="#" class="text-xs text-[#a47551] hover:text-[#8f6243] transition">Lupa password?</a>
                    </div>
                    <div class="relative">
                        <input id="password"
                               wire:model.defer="password"
                               :type="showPassword ? 'text' : 'password'"
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full rounded-2xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3.5 pr-12 text-sm text-[#2b2b2b] placeholder-[#b0a090] outline-none transition-all duration-200 focus:border-[#a47551] focus:ring-4 focus:ring-[#a47551]/10 @error('password') border-red-300 bg-red-50/50 @enderror" />
                        {{-- Toggle button — pure Alpine, zero Livewire interaction --}}
                        <button type="button"
                                @click.prevent="showPassword = !showPassword"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#b0a090] hover:text-[#a47551] transition-colors duration-150 p-1"
                                :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">
                            <svg x-show="!showPassword" class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                    <input wire:model.defer="remember" type="checkbox"
                           class="rounded border-[#c19a6b]/50 text-[#a47551] focus:ring-[#a47551]/30 w-4 h-4 cursor-pointer" />
                    <span class="text-sm text-[#555]">Ingat saya</span>
                </label>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-[#a47551] text-white px-5 py-3.5 font-semibold text-sm shadow-md shadow-[#a47551]/20 hover:bg-[#8f6243] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-80 cursor-not-allowed">
                    <span wire:loading.remove>Masuk ke MindHug</span>
                    <span wire:loading class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Memproses...
                    </span>
                </button>

            </form>

            {{-- Divider & register link --}}
            <div class="mt-7 text-center">
                <p class="text-sm text-[#666]">
                    Belum punya akun?
                    <a href="{{ route('register') }}" wire:navigate class="font-semibold text-[#a47551] hover:text-[#8f6243] transition">
                        Daftar gratis
                    </a>
                </p>
            </div>

            {{-- Back to home --}}
            <div class="mt-5 text-center">
                <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-1.5 text-xs text-[#999] hover:text-[#555] transition">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke beranda
                </a>
            </div>

        </div>
    </div>

</div>
