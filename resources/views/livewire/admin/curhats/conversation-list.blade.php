<div wire:poll.1s class="bg-white rounded-2xl border border-stone-200 flex flex-col overflow-hidden h-full">

    {{-- Header --}}
    <div class="p-4 border-b border-stone-100 shrink-0">
        <h2 class="text-sm font-semibold text-stone-800">Percakapan</h2>
        <div class="flex gap-1.5 mt-3">
            <button wire:click="$set('statusFilter', 'open')"
                class="relative text-xs px-3.5 py-2 rounded-full font-medium transition-all duration-200
                {{ $statusFilter === 'open'
                    ? 'bg-[#a47551] text-white shadow-sm shadow-[#a47551]/20'
                    : 'bg-stone-100 text-stone-500 hover:bg-stone-200 hover:text-stone-700' }}">
                Aktif
                @php $openCount = App\Models\Conversation::where('status', 'open')->count(); @endphp
                @if ($openCount > 0)
                    <span
                        class="absolute -top-1 -right-1 h-4 min-w-[1rem] rounded-full bg-rose-500 text-white text-[0.5rem] font-bold flex items-center justify-center px-1">{{ $openCount > 99 ? '99+' : $openCount }}</span>
                @endif
            </button>
            <button wire:click="$set('statusFilter', 'closed')"
                class="text-xs px-3.5 py-2 rounded-full font-medium transition-all duration-200
                {{ $statusFilter === 'closed'
                    ? 'bg-stone-500 text-white shadow-sm'
                    : 'bg-stone-100 text-stone-500 hover:bg-stone-200 hover:text-stone-700' }}">
                Ditutup
            </button>
        </div>
    </div>

    {{-- List --}}
    <div class="flex-1 overflow-y-auto divide-y divide-stone-50" style="min-height: 0;">
        @forelse ($conversations as $conv)
            <button wire:click="openConversation({{ $conv->id }})"
                class="w-full text-left p-4 hover:bg-stone-50/70 transition-all duration-150
                {{ $activeConversationId === $conv->id ? 'bg-[#fdf8f3]' : '' }}">

                {{-- Top Row --}}
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <div class="w-9 h-9 rounded-full shrink-0 overflow-hidden bg-stone-200">
                            <img src="{{ $conv->user?->avatar_url ?? 'https://ui-avatars.com/api/?name=User&background=a47551&color=fff&size=64' }}"
                                alt="" class="h-full w-full object-cover">
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-stone-800 truncate">
                                {{ $conv->user?->full_name ?? 'Anonim' }}
                            </p>
                            <p class="text-[0.65rem] text-stone-400 mt-0.5 flex items-center gap-2">
                                <span>{{ $conv->messages_count }} pesan</span>
                                <span>·</span>
                                <span>{{ $conv->updated_at->diffForHumans() }}</span>
                            </p>
                        </div>
                    </div>

                    @if ($conv->status === 'closed')
                        <span
                            class="text-[0.55rem] px-1.5 py-0.5 rounded-full bg-stone-100 text-stone-400 font-medium shrink-0">
                            Ditutup
                        </span>
                    @endif
                </div>

                <div class="mt-2 flex items-center gap-2">
                    @if ($conv->assigned_to)
                        @php $listRole = $conv->assignedAdmin->role ?? 'admin'; @endphp
                        <span
                            class="text-[0.6rem] px-2 py-0.5 rounded-full font-medium flex items-center gap-1
                            {{ $listRole === 'dev' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path d="M20 21a8 8 0 1 0-16 0" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            {{ $conv->assignedAdmin->full_name ?? 'Admin #' . $conv->assigned_to }}
                            <span class="text-[0.5rem] opacity-70">({{ $listRole === 'dev' ? 'Dev' : 'Admin' }})</span>
                        </span>
                    @else
                        <span class="text-[0.6rem] text-stone-400 flex items-center gap-1">
                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            Belum ditangani
                        </span>
                    @endif
                </div>

                @php $lastMsg = $conv->messages->last(); @endphp
                @if ($lastMsg)
                    <p class="text-[0.65rem] text-stone-400 mt-1.5 truncate">
                        {{ Str::limit($lastMsg->message, 50) }}
                    </p>
                @endif
            </button>
        @empty
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <div class="w-14 h-14 rounded-full bg-stone-100 flex items-center justify-center mb-3">
                    <svg class="h-6 w-6 text-stone-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-stone-400">
                    {{ $statusFilter === 'closed' ? 'Tidak ada percakapan ditutup' : 'Tidak ada percakapan aktif' }}
                </p>
                <p class="text-xs text-stone-300 mt-1">
                    {{ $statusFilter === 'closed' ? 'Percakapan yang ditutup akan muncul di sini' : 'Percakapan baru dari user akan muncul di sini' }}
                </p>
            </div>
        @endforelse
    </div>
</div>
