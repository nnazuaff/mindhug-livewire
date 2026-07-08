<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                {{-- Avatar --}}
                <div x-data="avatarCropper()" class="group relative shrink-0">
                    <div class="h-24 w-24 rounded-[1.75rem] overflow-hidden border-2 border-stone-200 bg-[#f5e9df]">
                        <img src="{{ $croppedAvatar ?? $user->avatar_url }}" alt="{{ $user->full_name }}"
                            class="h-full w-full object-cover">
                    </div>

                    <label for="avatar-upload"
                        class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-[1.75rem] opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                    </label>
                    <input id="avatar-upload" type="file" accept="image/*" @change="onFileSelect($event)"
                        class="hidden">

                    {{-- Cropper Modal --}}
                    <div x-show="showCropper" x-cloak
                        class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-black/60"
                        @click.self="showCropper = false; if(cropper) cropper.destroy()">
                        <div class="bg-white rounded-2xl p-6 max-w-lg w-full shadow-xl">
                            <h3 class="text-sm font-semibold text-stone-800 mb-4">Crop Foto Profil (1:1)</h3>
                            <div class="flex justify-center mb-4">
                                <img x-ref="cropperImage" class="max-w-full max-h-[350px] rounded-xl">
                            </div>
                            <div class="flex gap-2">
                                <button type="button" @click="showCropper = false; cropper.destroy()"
                                    class="flex-1 rounded-xl bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-200">Batal</button>
                                <button type="button" @click="cropAndSave"
                                    class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243]">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h1 class="text-3xl font-semibold text-[#1f1f1f]">{{ $user->full_name }}</h1>
                </div>
            </div>

            <span
                class="inline-flex items-center rounded-2xl border border-[#f0d6bb] bg-[#fff1e3] px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-[#7a5d45]">Status:
                {{ ucfirst($role) }}</span>
        </div>

        @error('avatar')
            <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
        @enderror

        @if ($user->avatar)
            <button wire:click="removeAvatar" wire:loading.attr="disabled"
                class="mt-3 text-xs text-stone-400 hover:text-rose-500 transition-colors">Hapus foto profil</button>
        @endif
    </section>

    @if (session()->has('success'))
        <section class="rounded-[1.75rem] border border-green-200 bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}</section>
    @endif

    <section class="rounded-[1.75rem] border border-stone-200 bg-white p-6 shadow-[0_32px_60px_rgba(34,25,17,0.08)]">
        <div class="mb-6">
            <p class="text-sm font-semibold uppercase tracking-[0.32em] text-[#8b6f5c]/80">Edit Profil</p>
            <h2 class="mt-2 text-2xl font-bold text-[#1f1f1f]">Ubah informasi dasar</h2>
        </div>

        <form wire:submit.prevent="updateProfile" class="space-y-6">
            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Nama Lengkap</span>
                    <input wire:model.blur="full_name" type="text" placeholder="Nama lengkap"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                    @error('full_name')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Username</span>
                    <input wire:model.blur="username" type="text" placeholder="Username"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                    @error('username')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Email</span>
                    <input wire:model.blur="email" type="email" placeholder="email@kamu.com"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                    @error('email')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Telepon</span>
                    <input wire:model.blur="phone" type="tel" placeholder="0812xxxxxxx"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                    @error('phone')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-[#3d2b1c]">Tanggal Lahir</span>
                    <input wire:model.blur="birth_date" type="date"
                        class="w-full rounded-2xl border border-stone-200 bg-[#fbf6f1] px-4 py-3 text-sm text-[#2b1d12] outline-none transition focus:border-amber-400 focus:ring-2 focus:ring-amber-200/70">
                    @error('birth_date')
                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-2xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#a47551]/20 transition hover:bg-[#8f6243] disabled:cursor-not-allowed disabled:opacity-60">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Memperbarui...</span>
                </button>
            </div>
        </form>
    </section>
</div>

<script>
    function avatarCropper() {
        return {
            showCropper: false,
            cropper: null,
            onFileSelect(e) {
                const file = e.target.files[0];
                if (!file) return;
                if (file.size > 2048000) {
                    alert('Ukuran maksimal 2MB');
                    return;
                }
                const reader = new FileReader();
                reader.onload = (ev) => {
                    this.$refs.cropperImage.src = ev.target.result;
                    this.showCropper = true;
                    this.$nextTick(() => {
                        if (this.cropper) this.cropper.destroy();
                        this.cropper = new Cropper(this.$refs.cropperImage, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                        });
                    });
                };
                reader.readAsDataURL(file);
                e.target.value = '';
            },
            cropAndSave() {
                const canvas = this.cropper.getCroppedCanvas({
                    width: 300,
                    height: 300
                });
                const base64 = canvas.toDataURL('image/webp', 0.85);
                @this.setCroppedAvatar(base64);
                this.cropper.destroy();
                this.showCropper = false;
            }
        }
    }
</script>
