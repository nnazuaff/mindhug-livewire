<div wire:poll.1s class="flex flex-col lg:flex-row h-[calc(100vh-7rem)] gap-4" x-data="{ collapsed: false, view: 'list' }"
    id="curhat-container">

    {{-- Mobile Toggle --}}
    <div class="lg:hidden flex items-center gap-2 px-1 shrink-0">
        <button @click="view = 'list'" class="text-xs px-4 py-2 rounded-full font-medium transition-all duration-200"
            :class="view === 'list' ? 'bg-[#a47551] text-white' : 'bg-stone-100 text-stone-600'">
            Percakapan
        </button>
        <button @click="view = 'chat'" class="text-xs px-4 py-2 rounded-full font-medium transition-all duration-200"
            :class="view === 'chat' ? 'bg-[#a47551] text-white' : 'bg-stone-100 text-stone-600'">
            Chat
        </button>
    </div>

    {{-- Conversation List --}}
    <div class="lg:shrink-0 transition-all duration-300 flex"
        :class="collapsed ? 'w-0 opacity-0 overflow-hidden' : 'w-full lg:w-80'"
        x-show="view === 'list' || window.innerWidth >= 1024">
        <div class="w-full lg:w-80">
            <livewire:admin.curhats.conversation-list :activeConversationId="$activeConversationId" :statusFilter="$statusFilter" />
        </div>
    </div>

    {{-- Toggle Button (Desktop only) --}}
    <button @click="collapsed = !collapsed"
        class="hidden lg:block self-start mt-3 p-1.5 rounded-lg bg-white border border-stone-200 text-stone-400 hover:bg-stone-50 transition-colors shrink-0">
        <svg class="h-4 w-4 transition-transform duration-300" :class="collapsed ? 'rotate-180' : ''"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6" />
        </svg>
    </button>

    {{-- Chat Panel --}}
    <div class="flex-1 bg-white rounded-2xl border border-stone-200 flex flex-col overflow-hidden transition-all duration-300"
        x-show="view === 'chat' || window.innerWidth >= 1024">
        @if ($activeConversationId)
            <livewire:admin.curhats.chat-panel :conversationId="$activeConversationId" :key="$activeConversationId" />
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

        // Auto switch ke chat view saat pilih percakapan di mobile
        Livewire.on('switch-to-chat-mobile', () => {
            if (window.innerWidth < 1024) {
                const container = document.getElementById('curhat-container');
                if (container && container.__x) {
                    container.__x.$data.view = 'chat';
                }
            }
        });
    });
</script>
