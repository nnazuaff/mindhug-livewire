<header x-data="{ mobileMenuOpen: false, userDropdownOpen: false, isScrolled: false }" x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 8 })"
    :class="isScrolled ? 'bg-[#c19a6b]/80 border-b border-[#836c5a]/70 shadow' :
        'bg-[#c19a6b]/95 border-b border-[#836c5a]/70 shadow'"
    class="sticky top-0 z-50 backdrop-blur transition-colors duration-200">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">

        <!-- Logo -->
        <a href="{{ url('/') }}"
            class="flex items-center gap-2 text-white/95 text-xl md:text-2xl font-semibold tracking-tight select-none hover:text-white transition-colors">
            <img src="{{ asset('favicon.png') }}" alt="MindHug logo" class="h-9 md:h-10 rounded-md" />
            <span class="tracking-wide">MindHug</span>
        </a>

        <!-- Hamburger Button untuk Mobile -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle navigation"
            class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-white/90 hover:text-white hover:bg-[#836c5a]/30 focus:outline-none focus:ring-2 focus:ring-white/60">
            <svg x-show="!mobileMenuOpen" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
            <svg x-show="mobileMenuOpen" style="display: none;" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <!-- Menu Desktop -->
        <nav class="hidden md:block">
            <div class="md:flex md:items-center md:gap-6 text-white/95">
                <ul class="md:flex md:items-center md:gap-2 text-[15px]">
                    <li class="py-1 md:py-0">
                        <a href="{{ url('/') }}"
                            class="group inline-flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-200 ease-out hover:text-white hover:bg-white/5 md:border-b-2 {{ Request::is('/') ? 'border-white text-white font-semibold' : 'border-transparent text-white/90 hover:border-white/20' }}">
                            <svg class="h-5 w-5 opacity-90 group-hover:opacity-100" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10.5 12 3l9 7.5" />
                                <path d="M5 10v10a2 2 0 0 0 2 2h3v-6h4v6h3a2 2 0 0 0 2-2V10" />
                            </svg>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="py-1 md:py-0">
                        <a href="{{ url('/curhat') }}"
                            class="group inline-flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-200 ease-out hover:text-white hover:bg-white/5 md:border-b-2 {{ Request::is('curhat*') ? 'border-white text-white font-semibold' : 'border-transparent text-white/90 hover:border-white/20' }}">
                            <svg class="h-5 w-5 opacity-90 group-hover:opacity-100" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9 8.5 8.5 0 0 1 8.5 8.5Z" />
                            </svg>
                            <span>Curhat</span>
                        </a>
                    </li>
                    <li class="py-1 md:py-0">
                        <a href="{{ url('/shop') }}"
                            class="group inline-flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-200 ease-out hover:text-white hover:bg-white/5 md:border-b-2 {{ Request::is('shop*') ? 'border-white text-white font-semibold' : 'border-transparent text-white/90 hover:border-white/20' }}">
                            <svg class="h-5 w-5 opacity-90 group-hover:opacity-100" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 7h12l1 14H5L6 7Z" />
                                <path d="M9 7V5a3 3 0 0 1 6 0v2" />
                            </svg>
                            <span>Shop</span>
                        </a>
                    </li>
                </ul>

                @auth
                    <!-- Jika User Sudah Terautentikasi -->
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ url('/transactions/cart') }}" aria-label="Keranjang belanja"
                            class="relative inline-flex items-center justify-center rounded-md px-3 py-2 text-white/90 hover:text-white hover:bg-white/5">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 6h15l-1.5 9h-12z" />
                                <path d="M6 6 4 3H1" />
                                <circle cx="9" cy="20" r="1" />
                                <circle cx="18" cy="20" r="1" />
                            </svg>

                            <!-- State cart count bisa diambil dinamis (mengadaptasi cart_count()) -->
                            @if (session()->has('cart') && count(session('cart')) > 0)
                                <span
                                    class="absolute -top-1 -right-0.5 inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-600 text-white text-xs font-medium">
                                    {{ array_sum(session('cart')) }}
                                </span>
                            @endif
                        </a>

                        <!-- Dropdown Akun -->
                        <div class="relative">
                            <button @click="userDropdownOpen = !userDropdownOpen" @click.away="userDropdownOpen = false"
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-white/10 text-white px-4 py-2 border border-white/20 hover:bg-white/15 active:scale-[0.98] transition transform-gpu">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 border border-white/20">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21a8 8 0 1 0-16 0" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                </span>
                                <span class="max-w-36 truncate">{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4 opacity-90" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userDropdownOpen" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95" style="display: none;"
                                class="absolute right-0 top-full pt-2 w-56 rounded-xl border border-[#c19a6b]/30 bg-white shadow-lg overflow-hidden">
                                <a href="{{ url('/account/profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-[#1f1f1f] hover:bg-[#a47551]/10">
                                    <svg class="h-5 w-5 text-[#6a5a4f]" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 21a8 8 0 1 0-16 0" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <span>Akun Saya</span>
                                </a>
                                <a href="{{ url('/transactions/orders') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-[#1f1f1f] hover:bg-[#a47551]/10">
                                    <svg class="h-5 w-5 text-[#6a5a4f]" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M9 12h6" />
                                        <path d="M9 16h6" />
                                        <path d="M9 8h6" />
                                        <path d="M6 21h12a2 2 0 0 0 2-2V7l-5-4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                                    </svg>
                                    <span>Pesanan Saya</span>
                                </a>
                                <div class="h-px bg-[#c19a6b]/25"></div>

                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-[#1f1f1f] hover:bg-[#a47551]/10 text-left">
                                        <svg class="h-5 w-5 text-[#6a5a4f]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <path d="M16 17l5-5-5-5" />
                                            <path d="M21 12H9" />
                                        </svg>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Jika Belum Login -->
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ url('/login') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#a47551] text-white px-4 py-2 shadow-sm hover:bg-[#8f6243] active:scale-[0.98] transition transform-gpu">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <path d="M10 17l5-5-5-5" />
                                <path d="M15 12H3" />
                            </svg>
                            <span>Login</span>
                        </a>
                    </div>
                @endauth

            </div>
        </nav>
    </div>

    <!-- Menus Mobile Navbar (Alpine Controlled) -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4 max-h-0"
        x-transition:enter-end="opacity-100 translate-y-0 max-h-[60vh]"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 max-h-[60vh]"
        x-transition:leave-end="opacity-0 -translate-y-4 max-h-0" style="display: none;"
        class="md:hidden overflow-hidden border-t border-[#836c5a]/40 bg-[#c19a6b]">
        <nav class="max-w-6xl mx-auto px-4 py-3">
            <ul class="flex flex-col gap-1 text-white">
                <li>
                    <a class="flex items-center gap-3 rounded-md px-3 py-2 transition-colors hover:bg-[#836c5a]/30 {{ Request::is('/') ? 'bg-[#836c5a]/25 font-semibold' : '' }}"
                        href="{{ url('/') }}">
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 rounded-md px-3 py-2 transition-colors hover:bg-[#836c5a]/30 {{ Request::is('curhat*') ? 'bg-[#836c5a]/25 font-semibold' : '' }}"
                        href="{{ url('/curhat') }}">
                        <span>Curhat</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 rounded-md px-3 py-2 transition-colors hover:bg-[#836c5a]/30 {{ Request::is('shop*') ? 'bg-[#836c5a]/25 font-semibold' : '' }}"
                        href="{{ url('/shop') }}">
                        <span>Shop</span>
                    </a>
                </li>
            </ul>

            @auth
                <div class="border-t border-[#836c5a]/40 mt-3 pt-3 flex flex-col gap-1 text-white">
                    <a href="{{ url('/account/profile') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 transition-colors hover:bg-[#836c5a]/30">
                        <span>Akun Saya</span>
                    </a>
                    <a href="{{ url('/transactions/orders') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 transition-colors hover:bg-[#836c5a]/30">
                        <span>Pesanan Saya</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2 text-center">
                        @csrf
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-white/10 text-white px-4 py-2 border border-white/20 hover:bg-white/15">
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-[#836c5a]/40 mt-3">
                    <a href="{{ url('/login') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#a47551] text-white px-4 py-2 hover:bg-[#8f6243]">
                        <span>Login</span>
                    </a>
                </div>
            @endauth
        </nav>
    </div>
</header>
