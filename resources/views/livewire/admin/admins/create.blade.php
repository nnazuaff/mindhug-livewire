<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl">
                <div class="px-6 py-4 border-b border-stone-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-stone-800">Tambah Admin</h2>
                    <button wire:click="closeModal" class="text-stone-400 hover:text-stone-600 text-xl">&times;</button>
                </div>
                <form wire:submit.prevent="save" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Nama Lengkap</label>
                        <input wire:model="fullName" type="text" placeholder="Nama lengkap"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('fullName')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Username</label>
                        <input wire:model="username" type="text" placeholder="Username"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('username')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Email</label>
                        <input wire:model="email" type="email" placeholder="email@mindhug.id"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Password</label>
                        <input wire:model="password" type="password" placeholder="Minimal 6 karakter"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/20">
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">Role</label>
                        <select wire:model="role"
                            class="w-full rounded-xl border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-[#a47551]">
                            <option value="admin">Admin</option>
                            <option value="dev">Dev</option>
                        </select>
                        @error('role')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
