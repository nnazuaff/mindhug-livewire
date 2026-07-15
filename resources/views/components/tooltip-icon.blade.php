@props(['title', 'description'])

<div x-data="{ open: false }" class="relative inline-flex items-center" @mouseenter="open = true" @mouseleave="open = false">
    <span
        class="inline-flex items-center justify-center w-18 h-18 rounded-full bg-stone-200 text-stone-500 text-[0.6rem] font-bold cursor-help hover:bg-stone-300 hover:text-stone-700 transition-colors leading-none">?</span>
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-56 bg-white rounded-xl border border-stone-200 shadow-lg p-3 text-xs text-stone-600 z-50 pointer-events-none">
        <p class="font-semibold text-stone-800 mb-1">{{ $title }}</p>
        <p class="leading-relaxed">{{ $description }}</p>
    </div>
</div>
