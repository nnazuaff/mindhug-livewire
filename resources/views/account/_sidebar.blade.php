@php
    $accountUser = auth()->user();
    $role = $accountUser?->role;
    $isTrialActive = $accountUser?->is_trial_active;
@endphp

<aside class="space-y-5 rounded-[1.75rem] border border-[#e8d5c4] bg-[#fdfaf7] p-5 sm:p-6">
    {{-- Header --}}
    <div class="px-1">
        <p class="text-[0.65rem] font-semibold uppercase tracking-[0.28em] text-[#8b6f5c]/60">Akun</p>
        <h2 class="mt-2.5 text-xl font-semibold text-[#1f1f1f] leading-tight">Pengaturan</h2>
    </div>

    {{-- Navigation --}}
    <nav class="grid gap-1">
        <a href="{{ route('account.profile') }}" wire:navigate
            class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition-all duration-200
                {{ request()->routeIs('account.profile')
                    ? 'bg-[#f5e9df] text-[#5d4738]'
                    : 'text-[#5f4a3f] hover:bg-[#f5e9df]/50 hover:text-[#3d2b1c]' }}">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl transition-colors duration-200
                {{ request()->routeIs('account.profile') ? 'bg-[#a47551]/10 text-[#a47551]' : 'bg-[#f0e5db] text-[#8b6f5c] group-hover:bg-[#a47551]/10 group-hover:text-[#a47551]' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21a8 8 0 1 0-16 0" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </span>
            Edit Profil
        </a>

        <a href="{{ route('account.security') }}" wire:navigate
            class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition-all duration-200
                {{ request()->routeIs('account.security')
                    ? 'bg-[#f5e9df] text-[#5d4738]'
                    : 'text-[#5f4a3f] hover:bg-[#f5e9df]/50 hover:text-[#3d2b1c]' }}">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl transition-colors duration-200
                {{ request()->routeIs('account.security') ? 'bg-[#a47551]/10 text-[#a47551]' : 'bg-[#f0e5db] text-[#8b6f5c] group-hover:bg-[#a47551]/10 group-hover:text-[#a47551]' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
            </span>
            Keamanan
        </a>

        <a href="{{ route('account.addresses') }}" wire:navigate
            class="group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition-all duration-200
                {{ request()->routeIs('account.addresses')
                    ? 'bg-[#f5e9df] text-[#5d4738]'
                    : 'text-[#5f4a3f] hover:bg-[#f5e9df]/50 hover:text-[#3d2b1c]' }}">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl transition-colors duration-200
                {{ request()->routeIs('account.addresses') ? 'bg-[#a47551]/10 text-[#a47551]' : 'bg-[#f0e5db] text-[#8b6f5c] group-hover:bg-[#a47551]/10 group-hover:text-[#a47551]' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
            </span>
            Alamat
        </a>
    </nav>

    {{-- Divider --}}
    <div class="h-px bg-[#e8d5c4]/60 mx-1"></div>

    {{-- Status Cards --}}
    <div class="space-y-3">
        <div class="rounded-2xl border border-[#e8d5c4] bg-white p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-[#8b6f5c]/70">Akun</p>
                <span
                    class="inline-flex text-[0.6rem] px-2.5 py-1 rounded-full font-semibold {{ $role === 'plus' ? 'role-plus' : 'role-free' }}">
                    {{ $role === 'plus' ? 'Plus' : 'Free' }}
                </span>
            </div>
            @if ($role === 'free')
                <a href="{{ route('plus') }}" wire:navigate
                    class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-700 transition-colors">
                    Upgrade ke Plus
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            @endif
            @if ($role === 'plus' && $accountUser?->plus_expires_at)
                <p class="mt-2 text-[0.65rem] text-[#8b6f5c]">
                    Berlaku sampai {{ $accountUser->plus_expires_at->setTimezone('Asia/Jakarta')->format('d M Y') }}
                </p>
            @endif
        </div>

        <div class="rounded-2xl border border-[#e8d5c4] bg-white p-4">
            <p class="text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-[#8b6f5c]/70 mb-1.5">Trial</p>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full {{ $isTrialActive ? 'bg-emerald-400' : 'bg-stone-300' }}"></span>
                <span
                    class="text-sm font-semibold text-[#2b1d12]">{{ $isTrialActive ? 'Aktif' : 'Tidak aktif' }}</span>
            </div>
        </div>
    </div>
</aside>
