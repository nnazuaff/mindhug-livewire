<x-layouts.app title="Keamanan Akun">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid gap-8 xl:grid-cols-[280px_1fr]">
            @include('account._sidebar')
            <div class="space-y-6">
                <livewire:account.security />
            </div>
        </div>
    </div>
</x-layouts.app>
