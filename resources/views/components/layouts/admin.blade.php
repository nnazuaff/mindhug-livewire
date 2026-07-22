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
    @include('components.notification-toast')

    <div class="flex min-h-screen">
        {{-- SIDEBAR DESKTOP --}}
        <aside class="hidden lg:flex w-60 bg-white border-r border-stone-200 flex-col shrink-0">
            {{-- Brand --}}
            <div class="p-5 border-b border-stone-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#a47551]/15">
                        <img src="{{ asset('favicon.png') }}" alt="MindHug" class="h-5 w-5 rounded">
                    </span>
                    <span class="font-semibold text-stone-800">MindHug</span>
                </a>
                <p class="text-xs text-stone-400 mt-1 ml-1">Admin Panel</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <div class="mb-3">
                    <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">Utama</p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                            <path d="M2 17l10 5 10-5" />
                            <path d="M2 12l10 5 10-5" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.orders') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            <line x1="2" y1="10" x2="11" y2="10" />
                            <line x1="2" y1="14" x2="7" y2="14" />
                        </svg>
                        <span>Pesanan</span>
                    </a>

                    <a href="{{ route('admin.curhats') }}"
                        class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.curhats*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <span class="flex items-center gap-3">
                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z" />
                            </svg>
                            <span>Curhat</span>
                        </span>
                        <livewire:layouts.admin-curhat-badge />
                    </a>
                </div>

                {{--  PELANGGAN  --}}
                <div class="pt-2 mb-3">
                    <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">Pelanggan
                    </p>

                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span>Pengguna</span>
                    </a>

                    <a href="{{ route('admin.subscription-orders') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.subscription-orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <span>Langganan</span>
                    </a>
                </div>

                {{--  PRODUK  --}}
                <div class="pt-2 mb-3">
                    <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">Produk
                    </p>

                    <a href="{{ route('admin.products') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.products*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>
                        <span>Produk</span>
                    </a>

                    <a href="{{ route('admin.categories') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4 shrink-0">
                            <polygon points="22 3 2 3 10 13.46 10 19 14 21 14 13.46 22 3" />
                        </svg>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('admin.promotions') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.promotions*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                            <line x1="7" y1="7" x2="7.01" y2="7" />
                        </svg>
                        <span>Voucher</span>
                    </a>
                    <a href="{{ route('admin.subscription-plans') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.subscription-plans*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4 shrink-0">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <span>Paket Plus</span>
                    </a>
                </div>


                {{--  KEUANGAN  --}}
                <div class="pt-2 mb-3">
                    <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">Keuangan
                    </p>
                    <a href="{{ route('admin.income-expenses') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.income-expenses*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-4 w-4 shrink-0">
                            <rect x="2" y="6" width="20" height="12" rx="2" />
                            <circle cx="12" cy="12" r="2" />
                            <path d="M6 12h.01M18 12h.01" />
                        </svg>
                        <span>Keuangan</span>
                    </a>
                </div>

                {{--  SISTEM  --}}
                @if (auth('admin')->user()?->role === 'dev')
                    <div class="pt-2 mb-3">
                        <p class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2">
                            Sistem</p>

                        <a href="{{ route('admin.admins') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.admins*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-4 w-4 shrink-0">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path d="M12 8v4" />
                                <path d="M12 16h.01" />
                            </svg>
                            <span>Admin</span>
                        </a>
                    </div>
                @endif
            </nav>

            {{-- Logout --}}
            <div class="p-4 border-t border-stone-200">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ================================================================ --}}
        {{-- SIDEBAR MOBILE --}}
        {{-- ================================================================ --}}
        <div x-data="{ open: false }" class="lg:hidden">
            <button @click="open = true"
                class="fixed top-3 left-3 z-40 p-2.5 rounded-xl bg-white border border-stone-200 shadow-sm hover:bg-stone-50 active:scale-95 transition-all duration-150">
                <svg class="h-5 w-5 text-stone-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

                    {{-- Header --}}
                    <div class="p-5 border-b border-stone-200 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#a47551]/15"><img
                                    src="{{ asset('favicon.png') }}" alt="MindHug" class="h-5 w-5 rounded"></span>
                            <span class="font-semibold text-stone-800">MindHug</span>
                        </div>
                        <button @click="open = false"
                            class="p-1.5 rounded-lg text-stone-400 hover:bg-stone-100 active:scale-90 transition-all">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>

                    {{-- Nav --}}
                    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                        {{-- Utama --}}
                        <p
                            class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2 mt-1">
                            Utama</p>
                        <a href="{{ route('admin.dashboard') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Dashboard</span></a>
                        <a href="{{ route('admin.orders') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Pesanan</span></a>
                        <a href="{{ route('admin.curhats') }}" @click="open = false"
                            class="flex items-center justify-between gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.curhats*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Curhat</span><livewire:layouts.admin-curhat-badge /></a>

                        {{-- Pelanggan --}}
                        <p
                            class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2 mt-4">
                            Pelanggan</p>
                        <a href="{{ route('admin.users') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Pengguna</span></a>
                        <a href="{{ route('admin.subscription-orders') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.subscription-orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Langganan</span></a>

                        {{-- Produk --}}
                        <p
                            class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2 mt-4">
                            Produk</p>
                        <a href="{{ route('admin.products') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.products*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Produk</span></a>
                        <a href="{{ route('admin.categories') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Kategori</span></a>
                        <a href="{{ route('admin.promotions') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.promotions*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Voucher</span></a>
                        <a href="{{ route('admin.subscription-plans') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.subscription-plans*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Paket
                                Plus</span></a>

                        {{-- Keuangan --}}

                        <a href="{{ route('admin.income-expenses') }}" @click="open = false"
                            class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.income-expenses*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Keuangan</span></a>

                        {{-- Sistem --}}
                        @if (auth('admin')->user()?->role === 'dev')
                            <p
                                class="px-3 text-[0.6rem] font-semibold uppercase tracking-[0.2em] text-stone-400 mb-2 mt-4">
                                Sistem</p>
                            <a href="{{ route('admin.admins') }}" @click="open = false"
                                class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.admins*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}"><span>Admin</span></a>
                        @endif
                    </nav>

                    {{-- Footer --}}
                    <div class="p-4 border-t border-stone-200">
                        <div class="flex items-center gap-3 px-3 py-2 mb-3">
                            <div
                                class="w-8 h-8 rounded-full bg-[#a47551]/15 flex items-center justify-center text-[#a47551] text-xs font-bold">
                                {{ strtoupper(substr(auth('admin')->user()->full_name ?? 'A', 0, 1)) }}
                            </div>
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
