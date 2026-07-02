{{-- Distraction-free Curhat interface --}}
<div class="min-h-[calc(100vh-72px)] flex flex-col bg-[#fdfaf7]">

    {{-- ══ Header strip ══ --}}
    <div class="border-b border-[#ede0d4] bg-white/80 backdrop-blur-sm">
        <div class="max-w-2xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-full bg-[#a47551] flex items-center justify-center shadow-sm shadow-[#a47551]/30">
                    <svg class="h-4.5 w-4.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-[#1a1a1a] text-sm leading-none">Ruang Curhat</p>
                    <p class="text-xs text-[#888] mt-0.5 leading-none">Aman &amp; privat</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs text-[#888]">Tim siap mendengar</span>
            </div>
        </div>
    </div>

    {{-- ══ Main content ══ --}}
    <div class="flex-1 max-w-2xl w-full mx-auto px-4 py-6 flex flex-col gap-4">

        {{-- ── Success state ── --}}
        @if ($submitted)
            <div class="flex flex-col items-center justify-center text-center py-20" x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })">
                <div class="relative mb-6">
                    <div class="absolute inset-0 rounded-full bg-emerald-100 scale-150 blur-xl opacity-60"></div>
                    <div
                        class="relative w-20 h-20 rounded-full bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center">
                        <svg class="h-10 w-10 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                </div>
                <h2 class="font-baloo font-bold text-[#1a1a1a] text-2xl">Curhatanmu sudah terkirim.</h2>
                <p class="mt-3 text-[#666] text-sm leading-relaxed max-w-xs">
                    Terima kasih sudah berani berbagi. Tim MindHug akan membaca dan membalasnya dengan hangat.
                </p>
                <button wire:click="resetForm"
                    class="mt-7 inline-flex items-center gap-2 rounded-full border border-[#c19a6b]/50 text-[#a47551] px-6 py-2.5 text-sm font-medium hover:bg-[#f7ede3] hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    Curhat lagi
                </button>
            </div>
        @else
            {{-- ── Previous messages ── --}}
            @if ($messages->isNotEmpty())
                <div class="space-y-3 mb-2">
                    <p class="text-xs font-medium text-[#aaa] uppercase tracking-wider text-center py-2">Percakapanmu
                        sebelumnya</p>
                    @foreach ($messages as $msg)
                        <div class="flex @if ($msg->sender_role === 'user') justify-end @else justify-start @endif">
                            <div
                                class="max-w-[80%] rounded-2xl px-4 py-3 text-sm leading-relaxed
                    @if ($msg->sender_role === 'user') bg-[#a47551] text-white rounded-br-md
                    @else
                        bg-white border border-[#ede0d4] text-[#2b2b2b] rounded-bl-md shadow-sm @endif">
                                <p>{{ $msg->message }}</p>
                                <p
                                    class="text-[0.65rem] mt-1.5 @if ($msg->sender_role === 'user') text-white/60 @else text-[#aaa] @endif">
                                    {{ $msg->created_at->translatedFormat('d M Y, H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty state --}}
                <div class="text-center py-12">
                    <div class="w-14 h-14 rounded-full bg-[#f7ede3] flex items-center justify-center mx-auto mb-4">
                        <svg class="h-6 w-6 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-[#2b2b2b] text-sm">Halo,
                        {{ auth()->user()->full_name ?? (auth()->user()->name ?? 'kamu') }} 👋</p>
                    <p class="text-[#888] text-sm mt-1.5 max-w-xs mx-auto leading-relaxed">
                        Ini ruang amanmu. Ceritakan apa yang ada di pikiranmu — tidak ada yang akan menghakimi.
                    </p>
                </div>
            @endif

            {{-- ── Input form ── --}}
            <div class="mt-auto">
                <form wire:submit.prevent="send"
                    class="bg-white rounded-3xl border border-[#ede0d4] shadow-sm overflow-hidden">

                    <textarea wire:model.live.debounce.300ms="message" id="curhat-textarea" rows="4" maxlength="1000"
                        placeholder="Ceritakan apa yang ingin kamu bagikan hari ini…"
                        class="auto-grow w-full px-5 pt-5 pb-3 text-sm text-[#2b2b2b] placeholder-[#b0a090] bg-transparent outline-none resize-none leading-relaxed"></textarea>

                    <div class="px-5 pb-4 flex items-center justify-between gap-4">
                        {{-- Character counter --}}
                        <div class="flex items-center gap-1.5">
                            <span
                                class="text-xs tabular-nums @if ($charCount > 900) text-orange-500 @elseif($charCount > 980) text-red-500 @else text-[#aaa] @endif">
                                {{ $charCount }}<span class="text-[#ccc]">/1000</span>
                            </span>
                            @if ($charCount >= 10)
                                <span class="text-xs text-emerald-500 flex items-center gap-1" wire:key="counter-ready">
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Siap terkirim
                                </span>
                            @endif
                        </div>

                        <button type="submit" @disabled($charCount < 10 || $charCount > 1000)
                            class="inline-flex items-center gap-2 rounded-2xl bg-[#a47551] text-white px-5 py-2.5 text-sm font-semibold shadow-sm shadow-[#a47551]/20 hover:bg-[#8f6243] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:translate-y-0"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60">
                            <span wire:loading.remove wire:target="send">
                                Kirim
                                <svg class="h-4 w-4 inline-block" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="send" class="inline-flex items-center gap-1.5">
                                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </div>

                    {{-- Validation error --}}
                    @error('message')
                        <div class="px-5 pb-3">
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        </div>
                    @enderror

                </form>

                <p class="text-center text-xs text-[#bbb] mt-3 leading-relaxed">
                    Pesan dikirim dengan aman &amp; hanya dibaca oleh tim MindHug.
                </p>
            </div>

        @endif
    </div>
</div>
