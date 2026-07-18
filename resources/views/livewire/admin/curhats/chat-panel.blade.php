<div wire:poll.1s class="flex-1 flex flex-col min-h-0">
    @if ($conversation)
        {{-- Header --}}
        <div class="p-4 border-b border-stone-200 flex items-center justify-between shrink-0">
            <div>
                <p class="text-sm font-semibold text-stone-800">{{ $conversation->user?->full_name ?? 'Anonim' }}</p>
                <p class="text-xs text-stone-400">
                    @if ($conversation->assigned_to)
                        Ditangani oleh: <span
                            class="font-medium text-stone-600">{{ $conversation->assignedAdmin->full_name ?? 'Admin' }}</span>
                        @if ($conversation->assigned_to !== auth('admin')->id())
                            <span class="text-amber-600 font-medium">(bukan Anda)</span>
                        @endif
                    @else
                        Belum ada yang menangani
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Belum ada yang menangani --}}
                @if ($conversation->status === 'open' && !$conversation->assigned_to)
                    <button wire:click="takeConversation"
                        class="text-xs px-3 py-1.5 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors font-medium">Ambil
                        Alih</button>
                @endif

                {{-- Dipegang admin lain → tombol ambil alih paksa --}}
                @if (
                    $conversation->status === 'open' &&
                        $conversation->assigned_to &&
                        $conversation->assigned_to !== auth('admin')->id())
                    <div x-data="{ showConfirm: false }">
                        <button @click="showConfirm = true"
                            class="text-xs px-3 py-1.5 rounded-full bg-amber-500 text-white hover:bg-amber-600 transition-colors font-medium">Ambil
                            Alih Paksa</button>
                        <div x-show="showConfirm" x-cloak
                            class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/40"
                            @click.self="showConfirm = false">
                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                <p class="font-semibold text-stone-800">Ambil alih percakapan?</p>
                                <p class="text-sm text-stone-500 mt-1">
                                    Percakapan sedang ditangani oleh
                                    <strong>{{ $conversation->assignedAdmin->full_name ?? 'Admin' }}</strong>. Anda akan
                                    mengambil alih.
                                </p>
                                <div class="flex gap-2 mt-4">
                                    <button @click="showConfirm = false"
                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                    <button wire:click="takeOver" @click="showConfirm = false"
                                        class="flex-1 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-amber-600">Ambil
                                        Alih</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Dipegang sendiri → tombol Tutup --}}
                @if ($conversation->status === 'open' && $conversation->assigned_to === auth('admin')->id())
                    <div x-data="{ showConfirm: false }">
                        <button @click="showConfirm = true"
                            class="text-xs px-3 py-1.5 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors font-medium">Tutup</button>
                        <div x-show="showConfirm" x-cloak
                            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40">
                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                <p class="font-semibold text-stone-800">Tutup percakapan?</p>
                                <p class="text-sm text-stone-500 mt-1">Percakapan yang ditutup tidak bisa dibalas lagi.
                                </p>
                                <div class="flex gap-2 mt-4">
                                    <button @click="showConfirm = false"
                                        class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                    <button wire:click="closeConversation" @click="showConfirm = false"
                                        class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($conversation->status === 'closed')
                    <span
                        class="text-xs px-3 py-1.5 rounded-full bg-stone-100 text-stone-500 font-medium">Ditutup</span>
                @endif
            </div>
        </div>

        {{-- Messages --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3" id="chat-messages" x-data="{ scroll() { $el.scrollTop = $el.scrollHeight } }"
            x-init="scroll()" @message-sent.window="scroll()" @conversation-loaded.window="scroll()">
            @foreach ($conversation->messages as $msg)
                @php
                    $avatarUrl =
                        $msg->sender_role === 'user'
                            ? $conversation->user?->avatar_url ??
                                'https://ui-avatars.com/api/?name=User&background=a47551&color=fff&size=64'
                            : 'https://ui-avatars.com/api/?name=' .
                                urlencode($conversation->assignedAdmin->full_name ?? 'Admin') .
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
                                    <p class="text-xs font-semibold text-stone-800">{{ $msg->metadata['name'] }}</p>
                                    <p class="text-sm font-bold text-[#a47551] mt-1">Rp
                                        {{ number_format($msg->metadata['price'], 0, ',', '.') }}</p>
                                    <a href="{{ $msg->metadata['url'] }}" target="_blank"
                                        class="mt-2 block text-center rounded-xl bg-[#a47551] text-white text-xs py-2 font-medium hover:bg-[#8f6243]">Lihat
                                        Produk</a>
                                </div>
                            </div>
                        @else
                            <div
                                class="group relative rounded-2xl px-4 py-2.5 text-sm {{ $msg->sender_role === 'admin' ? 'bg-[#a47551] text-white rounded-br-md' : 'bg-stone-100 text-stone-800 rounded-bl-md' }}">
                                @if ($msg->sender_role === 'admin')
                                    <p class="text-[0.6rem] text-white/60 mb-0.5">
                                        {{ $conversation->assignedAdmin->full_name ?? 'Admin' }}</p>
                                @endif
                                <p>{{ $msg->message }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <p
                                        class="text-[0.6rem] {{ $msg->sender_role === 'admin' ? 'text-white/50' : 'text-stone-400' }}">
                                        {{ $msg->created_at->format('d/m H:i') }}</p>
                                    @if (
                                        $msg->sender_role === 'admin' &&
                                            $msg->sender_id === auth('admin')->id() &&
                                            $conversation->assigned_to === auth('admin')->id())
                                        <div x-data="{ showConfirm: false }">
                                            <button @click="showConfirm = true"
                                                class="opacity-0 group-hover:opacity-100 transition-opacity text-white/40 hover:text-rose-300 sm:opacity-0 sm:group-hover:opacity-100 opacity-100">
                                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                            </button>
                                            <div x-show="showConfirm" x-cloak
                                                class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/40"
                                                @click.self="showConfirm = false">
                                                <div
                                                    class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl text-center">
                                                    <p class="font-semibold text-stone-800">Hapus pesan?</p>
                                                    <p class="text-sm text-stone-500 mt-1">Pesan yang dihapus tidak bisa
                                                        dikembalikan.</p>
                                                    <div class="flex gap-2 mt-4">
                                                        <button @click="showConfirm = false"
                                                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                                        <button wire:click="deleteMessage({{ $msg->id }})"
                                                            @click="showConfirm = false"
                                                            class="flex-1 rounded-xl bg-rose-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-rose-600">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Reply + Rekomendasi --}}
        @if ($conversation->status === 'open')
            <div class="p-4 border-t border-stone-200 space-y-3 shrink-0">
                @if ($conversation->assigned_to === auth('admin')->id())
                    <button @click="$dispatch('openProductSearch')"
                        class="text-xs px-3 py-1.5 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors font-medium">+
                        Rekomendasi Produk</button>
                    <form wire:submit.prevent="sendReply" class="flex gap-2">
                        <input wire:model="replyMessage" type="text" placeholder="Tulis balasan..."
                            class="flex-1 rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        <button type="submit"
                            class="rounded-xl bg-[#a47551] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#8f6243] transition-colors">Kirim</button>
                    </form>
                @else
                    <p class="text-center text-sm text-stone-400">Ambil alih percakapan ini untuk membalas.</p>
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
