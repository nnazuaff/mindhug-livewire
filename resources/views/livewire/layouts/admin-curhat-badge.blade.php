<div wire:poll.1s>
    @if ($openChats > 0)
        <span
            class="inline-flex items-center justify-center h-5 min-w-5 rounded-full bg-blue-500 text-white text-[0.6rem] font-bold px-1.5">
            {{ $openChats }}
        </span>
    @endif
</div>
