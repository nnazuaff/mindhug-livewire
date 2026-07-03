{{--
  NAVBAR — Floating Glassmorphism
  · sticky top-0 with padding → inner bar appears "floating"
  · Alpine reactive scroll state → shrink/opacity shift on scroll
  · Active nav: warm pill indicator
  · Desktop: pill-bar with transition-powered active state
  · Mobile: full-screen backdrop-blur overlay + right slide-out panel
--}}
<header x-data="{
    scrolled: false,
    menu: false,
    userDropdown: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 48;
        }, { passive: true });
    }
}" x-on:livewire:navigated.window="menu = false; userDropdown = false"
    class="sticky top-0 z-50 px-3 sm:px-5 pt-3 pb-2.5">

    {{-- ════════════════════════════════════════════
         FLOATING GLASS BAR
    ════════════════════════════════════════════ --}}
    <div :class="scrolled
        ?
        'bg-white/92 shadow-lg shadow-black/8 border-[#ddd0c0]/70 py-2' :
        'bg-white/72 border-white/55 shadow-md shadow-black/5 py-2.5'"
        class="max-w-5xl mx-auto rounded-2xl backdrop-blur-xl border transition-all duration-500 px-4">

        <div class="flex items-center justify-between gap-3">

            {{-- ── Logo ── --}}
            <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2.5 group flex-shrink-0 select-none">
                <span
                    class="h-9 w-9 flex items-center justify-center rounded-xl bg-[#a47551]/12 ring-1 ring-[#a47551]/20 group-hover:bg-[#a47551]/20 group-hover:ring-[#a47551]/35 transition-all duration-300">
                    <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-5.5 w-5.5 rounded-md" />
                </span>
                <span class="font-semibold text-[#2b1d12] text-[1.05rem] tracking-tight">MindHug</span>
            </a>

            {{-- ── Desktop Nav ── --}}
            <nav class="hidden md:flex items-center gap-0.5">
                @foreach ([['/', 'Home', Request::is('/')], ['/curhat', 'Curhat', Request::is('curhat*')], ['/shop', 'Shop', Request::is('shop*')], ['/kontak', 'Kontak', Request::is('kontak*')]] as [$href, $label, $active])
                    <a href="{{ url($href) }}" wire:navigate
                        class="relative px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 group
                          {{ $active ? 'text-[#a47551] bg-[#f5e9df]' : 'text-[#5a4035] hover:text-[#a47551] hover:bg-[#f5e9df]/70' }}">
                        {{ $label }}
                        @if ($active)
                            <span
                                class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-[#a47551]
                                 transition-all duration-300"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- ── Desktop CTA ── --}}
            <div class="hidden md:flex items-center gap-1.5 flex-shrink-0">
                @auth
                    {{-- Cart --}}
                    <a href="{{ url('/transactions/cart') }}" aria-label="Keranjang"
                        class="relative p-2 rounded-xl text-[#5a4035] hover:bg-[#f5e9df] hover:text-[#a47551] transition-all duration-200">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 6h15l-1.5 9h-12z" />
                            <path d="M6 6 4 3H1" />
                            <circle cx="9" cy="20" r="1" />
                            <circle cx="18" cy="20" r="1" />
                        </svg>
                        @if ($cartCount > 0)
                            <span
                                class="absolute top-0.5 right-0.5 h-4 w-4 rounded-full bg-rose-500 text-white text-[9px] font-bold flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative" x-data @click.away="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" type="button"
                            class="flex items-center gap-2 rounded-xl bg-[#f5e9df] hover:bg-[#edddd0] px-3 py-1.5 text-sm font-medium text-[#3d2b1c] transition-all duration-200 border border-transparent hover:border-[#e0cbb7]">
                            <span class="h-6 w-6 rounded-full bg-[#a47551]/20 flex items-center justify-center">
                                <svg class="h-3.5 w-3.5 text-[#a47551]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21a8 8 0 1 0-16 0" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <span
                                class="max-w-[110px] truncate">{{ auth()->user()->full_name ?? auth()->user()->name }}</span>
                            <svg class="h-3.5 w-3.5 text-[#a47551] transition-transform duration-200"
                                :class="userDropdown ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div x-show="userDropdown" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            class="absolute right-0 top-full mt-2 w-52 rounded-2xl border border-[#ede4da] bg-white/95 backdrop-blur-md shadow-xl shadow-[#a47551]/10 overflow-hidden">
                            <a href="{{ route('account.profile') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-[#2b2b2b] hover:bg-[#fdf5ef] transition-colors duration-150">
                                <svg class="h-4 w-4 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21a8 8 0 1 0-16 0" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Akun Saya
                            </a>
                            <a href="{{ url('/transactions/orders') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-[#2b2b2b] hover:bg-[#fdf5ef] transition-colors duration-150">
                                <svg class="h-4 w-4 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 12h6M9 16h6M9 8h6" />
                                    <path d="M6 21h12a2 2 0 0 0 2-2V7l-5-4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                                </svg>
                                Pesanan Saya
                            </a>
                            <div class="h-px bg-[#ede4da] mx-2"></div>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 transition-colors duration-150 text-left">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        <polyline points="16 17 21 12 16 7" />
                                        <line x1="21" y1="12" x2="9" y2="12" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ url('/login') }}" wire:navigate
                        class="inline-flex items-center gap-1.5 rounded-xl bg-[#a47551] text-white px-4 py-2 text-sm font-semibold shadow-sm shadow-[#a47551]/30 hover:bg-[#8f6243] hover:-translate-y-px active:translate-y-0 transition-all duration-200">
                        Masuk
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                    </a>
                @endauth
            </div>

            {{-- ── Mobile Hamburger ── --}}
            <button @click="menu = true" aria-label="Buka menu"
                class="md:hidden p-2 rounded-xl text-[#5a4035] hover:bg-[#f5e9df] hover:text-[#a47551] transition-all duration-200 active:scale-95">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="16" y2="12" />
                    <line x1="3" y1="18" x2="11" y2="18" />
                </svg>
            </button>

        </div>
    </div>

    {{-- ════════════════════════════════════════════
         MOBILE FULL-SCREEN OVERLAY + SLIDE PANEL
         (fixed → escapes sticky stacking context)
    ════════════════════════════════════════════ --}}
    <div x-show="menu" x-cloak class="fixed inset-0 z-[99] flex"
        x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Blurred backdrop --}}
        <div @click="menu = false" class="absolute inset-0 bg-[#1a0f08]/55 backdrop-blur-sm"></div>

        {{-- Slide-in panel from right --}}
        <div class="relative ml-auto h-full w-[82%] max-w-[320px] bg-[#fffafc] flex flex-col shadow-2xl shadow-black/20"
            x-transition:enter="transition duration-350 ease-[cubic-bezier(0.32,0.72,0,1)]"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition duration-250 ease-in" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            {{-- Panel header --}}
            <div class="flex items-center justify-between px-5 py-5 border-b border-[#ede0d4]">
                <div class="flex items-center gap-2.5">
                    <span class="h-8 w-8 flex items-center justify-center rounded-lg bg-[#a47551]/12">
                        <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-5 w-5 rounded-md" />
                    </span>
                    <span class="font-semibold text-[#2b1d12] text-[0.98rem] tracking-tight">MindHug</span>
                </div>
                <button @click="menu = false" aria-label="Tutup menu"
                    class="p-2 rounded-xl text-[#888] hover:bg-[#f5e9df] hover:text-[#a47551] transition-all duration-200 active:scale-90">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            {{-- Nav links --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                @foreach ([['/', 'Home', 'M3 10.5 12 3l9 7.5M5 10v10a2 2 0 0 0 2 2h3v-6h4v6h3a2 2 0 0 0 2-2V10', Request::is('/')], ['/curhat', 'Curhat', 'M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z', Request::is('curhat*')], ['/shop', 'Shop', 'M6 7h12l1 14H5L6 7ZM9 7V5a3 3 0 0 1 6 0v2', Request::is('shop*')], ['/kontak', 'Kontak', 'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.64 2h3a2 2 0 0 1 2 1.72 12 12 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l.81-.81a2 2 0 0 1 2.11-.45 12 12 0 0 0 2.81.7A2 2 0 0 1 22 17z', Request::is('kontak*')]] as [$href, $label, $iconPath, $active])
                    <a href="{{ url($href) }}" wire:navigate @click="menu = false"
                        class="flex items-center gap-3.5 px-4 py-3.5 rounded-2xl text-sm font-medium transition-all duration-200 group
                          {{ $active ? 'bg-[#f5e9df] text-[#a47551]' : 'text-[#3d2b1c] hover:bg-[#f5e9df]/60 hover:text-[#a47551]' }}">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-xl flex-shrink-0 transition-all duration-200
                                 {{ $active ? 'bg-[#a47551] text-white' : 'bg-[#f0e5db] text-[#a47551] group-hover:bg-[#a47551] group-hover:text-white' }}">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="{{ $iconPath }}" />
                            </svg>
                        </span>
                        <span class="font-semibold">{{ $label }}</span>
                        @if ($active)
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-[#a47551]"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Panel footer --}}
            <div class="px-3 py-5 border-t border-[#ede0d4] bg-[#fdf8f4] space-y-2">
                @auth
                    <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white border border-[#ede0d4]">
                        <div class="h-9 w-9 rounded-full bg-[#a47551]/15 flex items-center justify-center flex-shrink-0">
                            <svg class="h-4 w-4 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21a8 8 0 1 0-16 0" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs text-[#888]">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-[#2b1d12] truncate">
                                {{ auth()->user()->full_name ?? auth()->user()->name }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 rounded-2xl px-4 py-3 text-sm font-medium text-rose-600 border border-rose-100 hover:bg-rose-50 transition-colors duration-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" wire:navigate @click="menu = false"
                        class="flex items-center justify-center gap-2 rounded-2xl bg-[#a47551] text-white px-4 py-3.5 text-sm font-semibold shadow-md shadow-[#a47551]/25 hover:bg-[#8f6243] transition-colors duration-200">
                        Masuk ke MindHug
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                    </a>
                    <a href="{{ route('register') }}" wire:navigate @click="menu = false"
                        class="flex items-center justify-center rounded-2xl border border-[#c19a6b]/50 text-[#5a4035] px-4 py-3 text-sm font-medium hover:bg-[#f5e9df] transition-colors duration-200">
                        Daftar gratis
                    </a>
                @endauth
            </div>

        </div>
    </div>

</header>
