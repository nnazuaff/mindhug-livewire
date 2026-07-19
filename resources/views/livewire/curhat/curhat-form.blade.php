{{-- Curhat Interface - Fixed Height, Responsive --}}
<div wire:poll.2s class="h-[calc(100vh-72px)] flex flex-col bg-[#fdfaf7]" x-data="{
    lastCount: 0,
    scroll() {
        const el = document.getElementById('chat-container');
        if (el) el.scrollTop = el.scrollHeight;
    },
    scrollIfNew() {
        const el = document.getElementById('chat-container');
        if (!el) return;
        const currentCount = el.querySelectorAll('.message-bubble').length;
        if (currentCount > this.lastCount || this.lastCount === 0) {
            el.scrollTop = el.scrollHeight;
        }
        this.lastCount = currentCount;
    }
}" x-init="scroll()"
    @conversation-loaded.window="scrollIfNew()">

    {{-- Header --}}
    <div class="border-b border-[#ede0d4] bg-white/80 backdrop-blur-sm shrink-0">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-full bg-[#a47551] flex items-center justify-center shadow-sm shadow-[#a47551]/30">
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-[#1a1a1a] text-sm leading-none">Ruang Curhat</p>
                    <p class="text-xs text-[#888] leading-none">Aman &amp; privat</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs text-[#888] hidden sm:inline">Tim siap mendengar</span>
                @if (auth()->user()->role === 'free')
                    <a href="{{ route('plus') }}" wire:navigate
                        class="text-[0.6rem] px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold hover:bg-amber-200 transition-colors ml-2">
                        Upgrade ✨
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="flex-1 max-w-2xl w-full mx-auto px-4 py-4 flex flex-col min-h-0">

        @if ($submitted)
            <div class="flex flex-col items-center justify-center text-center flex-1">
                <div class="relative mb-6">
                    <div class="absolute inset-0 rounded-full bg-emerald-100 scale-150 blur-xl opacity-60"></div>
                    <div
                        class="relative w-16 h-16 rounded-full bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center">
                        <svg class="h-8 w-8 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                </div>
                <h2 class="font-bold text-[#1a1a1a] text-xl">Curhatanmu sudah terkirim.</h2>
                <p class="mt-2 text-[#666] text-sm max-w-xs">Terima kasih sudah berani berbagi. Tim MindHug akan
                    membalasnya.</p>
                <button wire:click="resetForm"
                    class="mt-6 inline-flex items-center gap-2 rounded-full border border-[#c19a6b]/50 text-[#a47551] px-5 py-2.5 text-sm font-medium hover:bg-[#f7ede3] transition-colors">
                    Curhat lagi
                </button>
            </div>
        @else
            {{-- Messages - scrollable --}}
            <div id="chat-container"
                class="flex-1 overflow-y-auto space-y-3 mb-3 scroll-smooth overscroll-contain pr-5">
                @if ($messages->isNotEmpty())
                    <p class="text-xs font-medium text-[#aaa] uppercase tracking-wider text-center py-2">Percakapan
                        sebelumnya</p>
                    @foreach ($messages as $msg)
                        @php $isProductRec = isset($msg->metadata['type']) && $msg->metadata['type'] === 'product_recommendation'; @endphp

                        <div
                            class="flex gap-3 message-bubble {{ $msg->sender_role === 'user' ? 'flex-row-reverse' : '' }}">
                            <div
                                class="w-8 h-8 rounded-full shrink-0 overflow-hidden {{ $msg->sender_role === 'user' ? 'bg-[#a47551]' : 'bg-emerald-500' }}">
                                @if ($msg->sender_role === 'user')
                                    <img src="{{ auth()->user()->avatar_url }}" alt="You"
                                        class="h-full w-full object-cover">
                                @else
                                    <div
                                        class="h-full w-full flex items-center justify-center text-white text-[0.65rem] font-bold">
                                        MH</div>
                                @endif
                            </div>

                            @if ($isProductRec)
                                <div
                                    class="max-w-[75%] rounded-2xl bg-white border border-amber-200 shadow-sm overflow-hidden">
                                    <img src="{{ $msg->metadata['image'] }}" alt="{{ $msg->metadata['name'] }}"
                                        class="w-full h-32 object-cover">
                                    <div class="p-3">
                                        <p class="text-xs font-semibold text-stone-800">{{ $msg->metadata['name'] }}</p>
                                        <p class="text-sm font-bold text-[#a47551] mt-1">Rp
                                            {{ number_format($msg->metadata['price'], 0, ',', '.') }}</p>
                                        <a href="{{ $msg->metadata['url'] }}" target="_blank"
                                            class="mt-2 block text-center rounded-xl bg-[#a47551] text-white text-xs py-2 font-medium hover:bg-[#8f6243] transition-colors">Lihat
                                            Produk</a>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="max-w-[75%] rounded-2xl px-4 py-2.5 text-sm leading-relaxed
                                    {{ $msg->sender_role === 'user' ? 'bg-[#a47551] text-white rounded-br-md' : 'bg-white border border-[#ede0d4] text-[#2b2b2b] rounded-bl-md shadow-sm' }}">
                                    <p>{{ $msg->message }}</p>
                                    <p
                                        class="text-[0.6rem] mt-1 {{ $msg->sender_role === 'user' ? 'text-white/50' : 'text-[#aaa]' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-10">
                        <div class="w-12 h-12 rounded-full bg-[#f7ede3] flex items-center justify-center mx-auto mb-3">
                            <svg class="h-5 w-5 text-[#a47551]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-[#2b2b2b] text-sm">Halo, {{ auth()->user()->full_name ?? 'kamu' }}
                            👋</p>
                        <p class="text-[#888] text-xs mt-1 max-w-xs mx-auto">Ceritakan apa yang ada di pikiranmu.</p>
                    </div>
                @endif
            </div>

            {{-- Input --}}
            <div class="shrink-0">
                <form wire:submit.prevent="send" class="flex gap-2">
                    <input wire:model.live.debounce.300ms="message" type="text" maxlength="1000"
                        placeholder="Tulis ceritamu..."
                        class="flex-1 rounded-full border border-[#ede0d4] bg-white px-5 py-3 text-sm text-[#2b2b2b] placeholder-[#b0a090] outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20" />
                    <button type="submit" @disabled($charCount < 5 || $charCount > 1000)
                        class="shrink-0 w-11 h-11 flex items-center justify-center rounded-full bg-[#a47551] text-white hover:bg-[#8f6243] transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="send">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13" />
                                <polygon points="22 2 15 22 11 13 2 9 22 2" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="send">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                        </span>
                    </button>
                </form>
                @error('message')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="text-center text-[0.6rem] text-[#bbb] mt-2">Aman & hanya dibaca tim MindHug</p>
            </div>
        @endif
    </div>
</div>
