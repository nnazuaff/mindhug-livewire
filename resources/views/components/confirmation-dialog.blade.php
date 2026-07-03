@props([
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin ingin melanjutkan?',
    'confirmText' => 'Ya, lanjutkan',
    'cancelText' => 'Batal',
    'action' => null,
    'actionParams' => [],
])

@php
    $actionParamsJson = json_encode($actionParams);
@endphp

<div x-data="{ open: false }" x-cloak class="inline-block">
    <div @click.stop.prevent="open = true">
        {{ $slot }}
    </div>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
        style="display: none;">
        <div @click="open = false" class="absolute inset-0 bg-slate-900/45 backdrop-blur-sm transition-opacity"></div>

        <div class="relative w-full max-w-md overflow-hidden rounded-3xl bg-white p-6 shadow-2xl shadow-slate-900/10">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#f8e7d6] text-[#a66133]">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 11h4" />
                            <path d="M12 7v4" />
                            <path d="M5 6h14" />
                            <path d="M6 6 5 20h14l-1-14" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-[#2b1d12]">{{ $title }}</p>
                        <p class="mt-1 text-sm text-[#6a5a4f]">{{ $message }}</p>
                    </div>
                </div>

                <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" @click="open = false"
                        class="rounded-2xl border border-stone-200 bg-white px-4 py-3 text-sm font-semibold text-[#6a5a4f] transition hover:border-stone-300 hover:bg-stone-50">
                        {{ $cancelText }}
                    </button>
                    <button type="button"
                        @click="open = false; if (typeof $wire !== 'undefined' && '{{ $action }}') { let params = {{ $actionParamsJson }}; if (Array.isArray(params)) { $wire.call('{{ $action }}', ...params); } else { $wire.call('{{ $action }}', params); } }"
                        class="rounded-2xl bg-[#a47551] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/15 transition hover:bg-[#8f6243] hover:scale-[1.01] duration-200">
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
