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
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">Dashboard</a>
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600 hover:bg-stone-100' }}">Pesanan</a>
            </nav>
            <div class="p-4 border-t border-stone-200">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-stone-500 hover:bg-rose-50 hover:text-rose-600">Keluar</button>
                </form>
            </div>
        </aside>

        <div x-data="{ open: false }" class="lg:hidden">
            <button @click="open = true"
                class="fixed top-4 left-4 z-40 p-2 rounded-xl bg-white border border-stone-200 shadow-sm">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>
            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex">
                <div @click="open = false" class="absolute inset-0 bg-black/40"></div>
                <div class="relative w-60 bg-white h-full shadow-xl p-5">
                    <button @click="open = false" class="absolute top-4 right-4 text-stone-400 text-xl">&times;</button>
                    <div class="mt-8 space-y-2">
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600' }}">Dashboard</a>
                        <a href="{{ route('admin.orders') }}"
                            class="block px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'bg-[#f5e9df] text-[#a47551]' : 'text-stone-600' }}">Pesanan</a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-3 py-2.5 rounded-xl text-sm font-medium text-rose-600 hover:bg-rose-50">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-14 bg-white border-b border-stone-200 flex items-center justify-between px-4 lg:px-6">
                <span class="text-sm font-medium text-stone-500">
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
