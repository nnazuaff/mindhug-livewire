<header x-data="{ mobileMenuOpen: false, userDropdownOpen: false, isScrolled: false, mounted: false }" x-init="$nextTick(() => { mounted = true });
window.addEventListener('scroll', () => { isScrolled = window.scrollY > 20 })"
    :class="isScrolled
        ?
        'bg-[#5c3d21]/95 border-b border-[#c19a6b]/20 shadow-lg backdrop-blur-xl' :
        'bg-[#a47551]/90 border-b border-transparent shadow-none backdrop-blur-md'"
    class="sticky top-0 z-50 transition-all duration-500">
    <div :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-2'"
        class="max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between gap-4 transition-all duration-500">

        {{-- Logo --}}
        <a href="{{ url('/') }}"
            class="flex items-center gap-2.5 text-white font-semibold tracking-tight transition-all duration-300 hover:opacity-90 group">
            <span
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 ring-1 ring-white/30 group-hover:bg-white/25 transition duration-300">
                <img src="{{ asset('favicon.png') }}" alt="MindHug logo" class="h-7 w-7 rounded-lg" />
            </span>
            <span class="text-lg md:text-xl tracking-wide">MindHug</span>
        </a>

        {{-- Hamburger Mobile --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle navigation"
            class="md:hidden inline-flex items-center justify-center rounded-xl p-2 text-white/90 hover:text-white hover:bg-white/15 focus:outline-none transition duration-200">
            <svg x-show="!mobileMenuOpen" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
            <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        {{-- Desktop Nav --}}
        <nav class="hidden md:flex items-center gap-1">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm transition duration-200 {{ Request::is('/') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10.5 12 3l9 7.5" />
                    <path d="M5 10v10a2 2 0 0 0 2 2h3v-6h4v6h3a2 2 0 0 0 2-2V10" />
                </svg>
                Home
            </a>
            <a href="{{ url('/curhat') }}"
                class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm transition duration-200 {{ Request::is('curhat*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9 8.5 8.5 0 0 1 8.5 8.5Z" />
                </svg>
                Curhat
            </a>
            <a href="{{ url('/shop') }}"
                class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm transition duration-200 {{ Request::is('shop*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 7h12l1 14H5L6 7Z" />
                    <path d="M9 7V5a3 3 0 0 1 6 0v2" />
                </svg>
                Shop
            </a>
        </nav>

        {{-- CTA Area --}}
        <div class="hidden md:flex items-center gap-2">
            @auth
                <a href="{{ url('/transactions/cart') }}" aria-label="Keranjang"
                    class="relative inline-flex items-center justify-center rounded-full p-2.5 text-white/85 hover:text-white hover:bg-white/15 transition duration-200">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6h15l-1.5 9h-12z" />
                        <path d="M6 6 4 3H1" />
                        <circle cx="9" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>
                    @if (session()->has('cart') && count(session('cart')) > 0)
                        <span
                            class="absolute top-0.5 right-0.5 inline-flex items-center justify-center h-4 w-4 rounded-full bg-rose-500 text-white text-[10px] font-semibold">
                            {{ array_sum(session('cart')) }}
                        </span>
                    @endif
                </a>

                <div class="relative">
                    <button @click="userDropdownOpen = !userDropdownOpen" @click.away="userDropdownOpen = false"
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-2 text-white text-sm border border-white/20 hover:bg-white/20 transition duration-200">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-white/20">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21a8 8 0 1 0-16 0" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                        <span class="max-w-28 truncate">{{ auth()->user()->name }}</span>
                        <svg class="h-3.5 w-3.5 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div x-show="userDropdownOpen" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1" x-cloak
                        class="absolute right-0 top-full mt-2.5 w-52 rounded-2xl border border-[#e8d5c4] bg-white shadow-xl shadow-[#a47551]/10 overflow-hidden">
                        <a href="{{ url('/account/profile') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-[#2b2b2b] hover:bg-[#fdf5ef] transition duration-150">
                            <svg class="h-4 w-4 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21a8 8 0 1 0-16 0" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Akun Saya
                        </a>
                        <a href="{{ url('/transactions/orders') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-[#2b2b2b] hover:bg-[#fdf5ef] transition duration-150">
                            <svg class="h-4 w-4 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 12h6" />
                                <path d="M9 16h6" />
                                <path d="M9 8h6" />
                                <path d="M6 21h12a2 2 0 0 0 2-2V7l-5-4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                            </svg>
                            Pesanan Saya
                        </a>
                        <div class="h-px bg-[#ede4da]"></div>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-[#2b2b2b] hover:bg-[#fdf5ef] transition duration-150 text-left">
                                <svg class="h-4 w-4 text-[#a47551]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <path d="M16 17l5-5-5-5" />
                                    <path d="M21 12H9" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-white text-[#a47551] px-4 py-2 text-sm font-medium shadow-sm hover:bg-white/90 transition duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <path d="M10 17l5-5-5-5" />
                        <path d="M15 12H3" />
                    </svg>
                    Login
                </a>
            @endauth
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-180" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" x-cloak
        class="md:hidden border-t border-white/15 bg-[#8f6239]/95 backdrop-blur-xl">
        <nav class="max-w-6xl mx-auto px-4 py-4 space-y-1">
            <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition duration-200 hover:bg-white/10 {{ Request::is('/') ? 'bg-white/10 font-semibold text-white' : 'text-white/85' }}"
                href="{{ url('/') }}">Home</a>
            <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition duration-200 hover:bg-white/10 {{ Request::is('curhat*') ? 'bg-white/10 font-semibold text-white' : 'text-white/85' }}"
                href="{{ url('/curhat') }}">Curhat</a>
            <a class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition duration-200 hover:bg-white/10 {{ Request::is('shop*') ? 'bg-white/10 font-semibold text-white' : 'text-white/85' }}"
                href="{{ url('/shop') }}">Shop</a>

            @auth
                <div class="border-t border-white/15 pt-3 mt-1 space-y-1">
                    <a href="{{ url('/account/profile') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-white/85 hover:bg-white/10 transition duration-200">Akun
                        Saya</a>
                    <a href="{{ url('/transactions/orders') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-white/85 hover:bg-white/10 transition duration-200">Pesanan
                        Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-white/85 hover:bg-white/10 transition duration-200">Logout</button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-white/15 mt-1">
                    <a href="{{ url('/login') }}"
                        class="flex items-center justify-center rounded-xl bg-white text-[#a47551] px-4 py-3 text-sm font-medium hover:bg-white/90 transition duration-200">Login</a>
                </div>
            @endauth
        </nav>
    </div>
</header>
