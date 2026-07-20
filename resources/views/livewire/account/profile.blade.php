<div class="space-y-6">
    {{-- Avatar Section --}}
    <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-5">
                {{-- Avatar --}}
                <div x-data="avatarCropper()" class="group relative shrink-0">
                    <div class="h-24 w-24 rounded-2xl overflow-hidden border-2 border-[#e8d5c4] bg-[#f5e9df]">
                        <img src="{{ $croppedAvatar ?? $user->avatar_url }}" alt="{{ $user->full_name }}"
                            class="h-full w-full object-cover">
                    </div>
                    <label for="avatar-upload"
                        class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
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
                        class="fixed inset-0 z-[80] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                        @click.self="showCropper = false; if(cropper) cropper.destroy()">
                        <div class="bg-white rounded-2xl p-6 max-w-lg w-full shadow-xl">
                            <h3 class="text-sm font-semibold text-[#2b1d12] mb-4">Sesuaikan Foto Profil</h3>
                            <div class="flex justify-center mb-4">
                                <img x-ref="cropperImage" class="max-w-full max-h-[350px] rounded-xl">
                            </div>
                            <div class="flex gap-3">
                                <button type="button" @click="showCropper = false; cropper.destroy()"
                                    class="flex-1 rounded-xl border border-[#e0d0c0] bg-white px-4 py-2.5 text-sm font-medium text-[#6a5a4f] hover:bg-stone-50 transition-colors">Batal</button>
                                <button type="button" @click="cropAndSave"
                                    class="flex-1 rounded-xl bg-[#a47551] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#8f6243] transition-colors">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-[0.65rem] font-semibold uppercase tracking-[0.28em] text-[#8b6f5c]/70">Profil</p>
                    <h1 class="mt-1.5 text-2xl sm:text-3xl font-semibold text-[#1f1f1f]">{{ $user->full_name }}</h1>
                    <p class="mt-1 text-sm text-[#6a5a4f]">{{ '@' . $user->username }}</p>
                </div>
            </div>
        </div>

        @error('avatar')
            <p class="mt-3 text-xs text-rose-500">{{ $message }}</p>
        @enderror

        @if ($user->avatar)
            <button wire:click="removeAvatar" wire:loading.attr="disabled"
                class="mt-4 text-xs font-medium text-[#8b6f5c] hover:text-rose-500 transition-colors">
                Hapus foto profil
            </button>
        @endif
    </section>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <section
            class="rounded-2xl border border-emerald-200 bg-emerald-50/70 px-5 py-4 text-sm text-emerald-700 flex items-start gap-3">
            <svg class="h-5 w-5 shrink-0 mt-0.5 text-emerald-500" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span>{{ session('success') }}</span>
        </section>
    @endif

    {{-- Edit Form --}}
    <section class="rounded-[1.75rem] border border-[#e8d5c4] bg-white p-6 sm:p-8">
        <div class="mb-6">
            <p class="text-[0.65rem] font-semibold uppercase tracking-[0.28em] text-[#8b6f5c]/70">Edit Profil</p>
            <h2 class="mt-2 text-xl font-semibold text-[#1f1f1f]">Informasi dasar</h2>
            <p class="mt-1 text-sm text-[#6a5a4f]">Perbarui data diri yang ditampilkan di akun kamu.</p>
        </div>

        <form wire:submit.prevent="updateProfile" class="space-y-5">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Nama Lengkap</label>
                    <input wire:model.blur="full_name" type="text" placeholder="Nama lengkap"
                        class="w-full rounded-xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('full_name') border-rose-300 bg-rose-50/50 @enderror">
                    @error('full_name')
                        <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Username</label>
                    <input wire:model.blur="username" type="text" placeholder="Username"
                        class="w-full rounded-xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('username') border-rose-300 bg-rose-50/50 @enderror">
                    @error('username')
                        <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Email</label>
                    <input wire:model.blur="email" type="email" placeholder="email@kamu.com"
                        class="w-full rounded-xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('email') border-rose-300 bg-rose-50/50 @enderror">
                    @error('email')
                        <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Telepon</label>
                    <input wire:model.blur="phone" type="tel" placeholder="0812xxxxxxx"
                        class="w-full rounded-xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('phone') border-rose-300 bg-rose-50/50 @enderror">
                    @error('phone')
                        <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#3d2b1c] mb-2">Tanggal Lahir</label>
                <input wire:model.blur="birth_date" type="date"
                    class="w-full sm:max-w-xs rounded-xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3 text-sm placeholder-[#b0a090] outline-none transition duration-200 focus:border-[#a47551] focus:ring-2 focus:ring-[#a47551]/15 @error('birth_date') border-rose-300 bg-rose-50/50 @enderror">
                @error('birth_date')
                    <span class="mt-1.5 block text-xs text-rose-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#a47551] px-6 py-3 text-sm font-semibold text-white hover:bg-[#8f6243] active:scale-[0.98] disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                        </svg>
                        Memperbarui...
                    </span>
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
