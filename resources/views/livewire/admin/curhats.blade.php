<div wire:poll.1s class="flex h-[calc(100vh-7rem)] gap-4">
    {{-- Left: Conversation List --}}
    <div class="w-80 shrink-0 bg-white rounded-2xl border border-stone-200 flex flex-col overflow-hidden">
        <div class="p-4 border-b border-stone-200">
            <h2 class="text-sm font-semibold text-stone-800">Percakapan</h2>
            <div class="flex gap-2 mt-3">
                <button wire:click="$set('statusFilter', 'open')"
                    class="text-xs px-3 py-1.5 rounded-full font-medium transition-colors {{ $statusFilter === 'open' ? 'bg-[#a47551] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">Aktif</button>
                <button wire:click="$set('statusFilter', 'closed')"
                    class="text-xs px-3 py-1.5 rounded-full font-medium transition-colors {{ $statusFilter === 'closed' ? 'bg-[#a47551] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">Ditutup</button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto divide-y divide-stone-100">
            @foreach ($conversations as $conv)
                <button wire:click="openConversation({{ $conv->id }})"
                    class="w-full text-left p-4 hover:bg-stone-50 transition-colors {{ $activeConversationId === $conv->id ? 'bg-[#f5e9df] border-l-2 border-[#a47551]' : '' }}">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-stone-800 truncate">
                            {{ $conv->user?->full_name ?? 'Anonim' }}</p>
                        <span class="text-xs text-stone-400">{{ $conv->messages_count }}</span>
                    </div>
                    <div class="flex items-center gap-2 mt-0.5">
                        @if ($conv->assigned_to)
                            <span class="text-[0.6rem] px-1.5 py-0.5 rounded-full bg-blue-50 text-blue-600 font-medium">
                                {{ $conv->assignedAdmin->full_name ?? 'Admin #' . $conv->assigned_to }}
                            </span>
                        @else
                            <span class="text-[0.6rem] text-stone-400">Belum diambil</span>
                        @endif
                        <span class="text-[0.6rem] text-stone-400">{{ $conv->updated_at->diffForHumans() }}</span>
                    </div>
                </button>
            @endforeach
            @if ($conversations->isEmpty())
                <div class="p-6 text-center text-sm text-stone-400">Tidak ada percakapan.</div>
            @endif
        </div>
    </div>

    {{-- Right: Chat Area --}}
    <div class="flex-1 bg-white rounded-2xl border border-stone-200 flex flex-col overflow-hidden">
        @if ($activeConversation)
            {{-- Header --}}
            <div class="p-4 border-b border-stone-200 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-stone-800">
                        {{ $activeConversation->user?->full_name ?? 'Anonim' }}</p>
                    <p class="text-xs text-stone-400">
                        @if ($activeConversation->assigned_to)
                            Ditangani oleh: <span
                                class="font-medium text-stone-600">{{ $activeConversation->assignedAdmin->full_name ?? 'Admin' }}</span>
                        @else
                            Belum ada yang menangani
                        @endif
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    @if ($activeConversation->status === 'open' && !$activeConversation->assigned_to)
                        <button wire:click="takeConversation({{ $activeConversation->id }})"
                            class="text-xs px-3 py-1.5 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors font-medium">
                            Ambil Alih
                        </button>
                    @endif
                    @if ($activeConversation->status === 'open' && $activeConversation->assigned_to === auth('admin')->id())
                        <div x-data="{ showConfirm: false }">
                            <button @click="showConfirm = true"
                                class="text-xs px-3 py-1.5 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors font-medium">Tutup</button>
                            <div x-show="showConfirm" x-cloak
                                class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                                <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                    <svg class="h-10 w-10 mx-auto text-rose-400 mb-3" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    <p class="font-semibold text-stone-800">Tutup percakapan?</p>
                                    <p class="text-sm text-stone-500 mt-1">Percakapan yang ditutup tidak bisa dibalas
                                        lagi.</p>
                                    <div class="flex gap-2 mt-4">
                                        <button @click="showConfirm = false"
                                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                        <button wire:click="closeConversation({{ $activeConversation->id }})"
                                            @click="showConfirm = false"
                                            class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($activeConversation->status === 'closed')
                        <span
                            class="text-xs px-3 py-1.5 rounded-full bg-stone-100 text-stone-500 font-medium">Ditutup</span>
                    @endif
                </div>
            </div>

            {{-- Messages --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3" id="chat-messages">
                @foreach ($activeConversation->messages as $msg)
                    @php
                        $avatarUrl =
                            $msg->sender_role === 'user'
                                ? $activeConversation->user?->avatar_url ??
                                    'https://ui-avatars.com/api/?name=User&background=a47551&color=fff&size=64'
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode($activeConversation->assignedAdmin->full_name ?? 'Admin') .
                                    '&background=3b82f6&color=fff&size=64';
                        $isProductRec =
                            isset($msg->metadata['type']) && $msg->metadata['type'] === 'product_recommendation';
                    @endphp

                    <div class="flex gap-3 {{ $msg->sender_role === 'user' ? '' : 'flex-row-reverse' }}">
                        <div class="w-8 h-8 rounded-full shrink-0 overflow-hidden bg-stone-200">
                            <img src="{{ $avatarUrl }}" alt="" class="h-full w-full object-cover">
                        </div>
                        <div class="max-w-[65%]">
                            @if ($isProductRec)
                                <div class="rounded-2xl bg-white border border-amber-200 shadow-sm overflow-hidden">
                                    <img src="{{ $msg->metadata['image'] }}" alt="{{ $msg->metadata['name'] }}"
                                        class="w-full h-32 object-cover">
                                    <div class="p-3">
                                        <p class="text-xs font-semibold text-stone-800">{{ $msg->metadata['name'] }}
                                        </p>
                                        <p class="text-sm font-bold text-[#a47551] mt-1">Rp
                                            {{ number_format($msg->metadata['price'], 0, ',', '.') }}</p>
                                        <a href="{{ $msg->metadata['url'] }}" target="_blank"
                                            class="mt-2 block text-center rounded-xl bg-[#a47551] text-white text-xs py-2 font-medium hover:bg-[#8f6243] transition-colors">
                                            Lihat Produk
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="rounded-2xl px-4 py-2.5 text-sm
                                    {{ $msg->sender_role === 'admin' ? 'bg-[#a47551] text-white rounded-br-md' : 'bg-stone-100 text-stone-800 rounded-bl-md' }}">
                                    @if ($msg->sender_role === 'admin')
                                        <p class="text-[0.6rem] text-white/60 mb-0.5">
                                            {{ $activeConversation->assignedAdmin->full_name ?? 'Admin' }}</p>
                                    @endif
                                    <p>{{ $msg->message }}</p>
                                    <p
                                        class="text-[0.6rem] mt-1 {{ $msg->sender_role === 'admin' ? 'text-white/50' : 'text-stone-400' }}">
                                        {{ $msg->created_at->format('d/m H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Reply + Rekomendasi --}}
            @if ($activeConversation->status === 'open')
                <div class="p-4 border-t border-stone-200 space-y-3">
                    @if ($activeConversation->assigned_to === auth('admin')->id())
                        {{-- ✅ Tombol Rekomendasi via Popup --}}
                        <button @click="$dispatch('openProductSearch')"
                            class="text-xs px-3 py-1.5 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors font-medium">
                            + Rekomendasi Produk
                        </button>

                        {{-- Reply Form --}}
                        <form wire:submit.prevent="sendReply" class="flex gap-2">
                            <input wire:model="replyMessage" type="text" placeholder="Tulis balasan..."
                                class="flex-1 rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                            <button type="submit"
                                class="rounded-xl bg-[#a47551] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#8f6243] transition-colors">
                                Kirim
                            </button>
                        </form>
                    @else
                        <p class="text-center text-sm text-stone-400">⚠️ Ambil alih percakapan ini untuk membalas.</p>
                    @endif
                </div>
            @endif
        @else
            <div class="flex-1 flex items-center justify-center text-stone-400 text-sm">
                <div class="text-center">
                    <svg class="h-12 w-12 mx-auto mb-3 text-stone-200" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    <p>Pilih percakapan untuk memulai</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Popup Rekomendasi Produk --}}
    <livewire:curhat.product-recommendation />
</div>

<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('message-sent', () => {
            setTimeout(() => {
                const el = document.getElementById('chat-messages');
                if (el) el.scrollTop = el.scrollHeight;
            }, 100);
        });
    });
</script>
