@php
    $accountUser = auth()->user();
    $role = $accountUser?->role;
    $isTrialActive = $accountUser?->is_trial_active;
@endphp

<aside
    class="space-y-6 rounded-[1.75rem] border border-stone-200 bg-[#fbf6f1] p-6 shadow-[0_26px_80px_rgba(34,25,17,0.08)]">
    <div>
        <p class="text-xs uppercase tracking-[0.32em] text-[#8b6f5c]/70">Akun</p>
        <h2 class="mt-3 text-2xl font-semibold text-[#1f1f1f]">Pengaturan</h2>

    </div>

    <nav class="grid gap-2">
        <a href="{{ route('account.profile') }}"
            class="block rounded-2xl px-4 py-3 text-sm font-semibold transition duration-200 {{ request()->routeIs('account.profile') ? 'bg-[#f5e9df] text-[#5d4738] shadow-sm shadow-[#a47551]/10' : 'text-[#5f4a3f] hover:bg-white/80 hover:border-stone-200' }}">
            Edit Profil
        </a>
        <a href="{{ route('account.security') }}"
            class="block rounded-2xl px-4 py-3 text-sm font-semibold transition duration-200 {{ request()->routeIs('account.security') ? 'bg-[#f5e9df] text-[#5d4738] shadow-sm shadow-[#a47551]/10' : 'text-[#5f4a3f] hover:bg-white/80 hover:border-stone-200' }}">
            Keamanan
        </a>
        <a href="{{ route('account.addresses') }}"
            class="block rounded-2xl px-4 py-3 text-sm font-semibold transition duration-200 {{ request()->routeIs('account.addresses') ? 'bg-[#f5e9df] text-[#5d4738] shadow-sm shadow-[#a47551]/10' : 'text-[#5f4a3f] hover:bg-white/80 hover:border-stone-200' }}">
            Alamat
        </a>
    </nav>

    <div class="space-y-4">
        <div
            class="rounded-3xl border border-stone-200 bg-white p-4 text-sm text-[#5f4a3f] shadow-sm shadow-[#a47551]/5">
            <p class="text-xs uppercase tracking-[0.24em] text-[#8b6f5c]/80">Status Akun</p>
            <p class="mt-2 font-semibold text-[#2b1d12]">{{ ucfirst($role ?: 'pelanggan') }}</p>
        </div>
        <div
            class="rounded-3xl border border-stone-200 bg-white p-4 text-sm text-[#5f4a3f] shadow-sm shadow-[#a47551]/5">
            <p class="text-xs uppercase tracking-[0.24em] text-[#8b6f5c]/80">Trial aktif</p>
            <p class="mt-2 font-semibold text-[#2b1d12]">{{ $isTrialActive ? 'Aktif' : 'Tidak aktif' }}</p>
        </div>
    </div>
</aside>
