<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin - MindHug' }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-stone-50 text-stone-800 min-h-screen font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar Desktop --}}
        <aside class="hidden lg:flex w-60 bg-white border-r border-stone-200 flex-col shrink-0">
            <div class="p-5 border-b border-stone-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#a47551]/15">
                        <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-5 w-5 rounded">
                    </span>
                    <span class="font-semibold text-stone-800">MindHug</span>
                </a>
                <p class="text-xs text-stone-400 mt-1 ml-1">Admin Panel</p>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Pesanan --}}
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <span class="flex items-center gap-3">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 12h6M9 16h6M9 8h6" />
                            <path d="M6 21h12a2 2 0 0 0 2-2V7l-5-4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                        </svg>
                        <span>Pesanan</span>
                    </span>

                </a>

                {{-- Curhat --}}
                <a href="{{ route('admin.curhats') }}"
                    class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.curhats*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <span class="flex items-center gap-3">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        <span>Curhat</span>
                    </span>
                    <livewire:layouts.admin-curhat-badge />
                </a>
                {{-- Garis pemisah --}}
                <div class="pt-3 mt-1">
                    <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">Manage
                    </p>
                </div>
                {{-- Pengguna --}}
                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span>Pengguna</span>
                </a>

                {{-- Produk --}}
                <a href="{{ route('admin.products') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.products*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 7h12l1 14H5L6 7ZM9 7V5a3 3 0 0 1 6 0v2" />
                    </svg>
                    <span>Produk</span>
                </a>
                {{-- Kategori --}}
                <a href="{{ route('admin.categories') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                    <span>Kategori</span>
                </a>
                {{-- Pembayaran --}}
                <a href="{{ route('admin.payment-methods') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.payment-methods*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                    <span>Pembayaran</span>
                </a>
                <a href="{{ route('admin.promotions') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.promotions*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                    <span>Voucher</span>
                </a>
            </nav>
            <div class="p-4 border-t border-stone-200">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile Sidebar --}}
        <div x-data="{ open: false }" class="lg:hidden">
            <button @click="open = true"
                class="fixed top-3 left-3 z-40 p-2.5 rounded-xl bg-white border border-stone-200 shadow-sm hover:bg-stone-50 active:scale-95 transition-all duration-150">
                <svg class="h-5 w-5 text-stone-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>

            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex">
                <div @click="open = false" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-250"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative w-72 bg-white h-full shadow-2xl flex flex-col">

                    <div class="p-5 border-b border-stone-200 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#a47551]/15"><img
                                    src="{{ asset('favicon.png') }}" alt="MindHug" class="h-5 w-5 rounded"></span>
                            <span class="font-semibold text-stone-800">MindHug</span>
                        </div>
                        <button @click="open = false"
                            class="p-1.5 rounded-lg text-stone-400 hover:bg-stone-100 active:scale-90 transition-all">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                        <a href="{{ route('admin.dashboard') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Dashboard</span></a>
                        <a href="{{ route('admin.orders') }}" @click="open = false"
                            class="flex items-center justify-between gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Pesanan</span>

                        </a>
                        <a href="{{ route('admin.curhats') }}" @click="open = false"
                            class="flex items-center justify-between gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.curhats*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                            <span>Curhat</span>
                            <livewire:layouts.admin-curhat-badge />
                        </a>
                        {{-- Garis pemisah --}}
                        <div class="pt-3 mt-1">
                            <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">
                                Manage</p>
                        </div>
                        <a href="{{ route('admin.users') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Pengguna</span></a>
                        <a href="{{ route('admin.products') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.products*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Produk</span></a>
                        <a href="{{ route('admin.categories') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                            <span>Kategori</span>
                        </a>
                        <a href="{{ route('admin.payment-methods') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.payment-methods*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                            <span>Pembayaran</span>
                        </a>
                    </nav>

                    <div class="p-4 border-t border-stone-200">
                        <div class="flex items-center gap-3 px-3 py-2 mb-3">
                            <div
                                class="w-8 h-8 rounded-full bg-[#a47551]/15 flex items-center justify-center text-[#a47551] text-xs font-bold">
                                {{ strtoupper(substr(auth('admin')->user()->full_name ?? 'A', 0, 1)) }}</div>
                            <div>
                                <p class="text-sm font-medium text-stone-700">
                                    {{ auth('admin')->user()->full_name ?? 'Admin' }}</p>
                                <p class="text-xs text-stone-400">{{ auth('admin')->user()->role }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-500 hover:bg-rose-50 hover:text-rose-600 transition-colors"><span>Keluar</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-14 bg-white border-b border-stone-200 flex items-center justify-between px-4 lg:px-6">
                <span class="text-sm font-medium text-stone-500 lg:ml-0 ml-12">
                    {{ auth('admin')->user()->full_name ?? 'Admin' }}
                    <span class="text-xs text-stone-400 ml-1">({{ auth('admin')->user()->role }})</span>
                </span>
            </header>
            <main class="flex-1 p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
