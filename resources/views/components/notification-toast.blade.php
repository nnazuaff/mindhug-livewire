<div x-data="{
    toasts: [],
    maxToasts: 5,
    add(e) {
        const id = Date.now() + Math.random();
        this.toasts.push({
            id,
            type: e.detail?.type || 'info',
            message: e.detail?.message || '',
            show: true,
        });
        if (this.toasts.length > this.maxToasts) {
            this.remove(this.toasts[0].id);
        }
        setTimeout(() => {
            this.remove(id);
        }, 4500);
    },
    remove(id) {
        const toast = this.toasts.find(t => t.id === id);
        if (toast) {
            toast.show = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 350);
        }
    }
}" @notify.window="add($event)"
    class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-[9999] flex flex-col-reverse gap-3 w-[calc(100%-2rem)] sm:max-w-sm pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show" x-transition:enter="transition duration-500 ease-out"
            x-transition:enter-start="translate-y-8 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition duration-300 ease-in"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-8 opacity-0 scale-90" @click="remove(toast.id)"
            :class="{
                'bg-emerald-500 text-white': toast.type === 'success',
                'bg-rose-500 text-white': toast.type === 'error',
                'bg-amber-500 text-white': toast.type === 'warning',
                'bg-stone-800 text-white': toast.type === 'info'
            }"
            class="rounded-2xl px-5 py-3.5 shadow-2xl flex items-center gap-3 text-sm font-medium cursor-pointer pointer-events-auto select-none backdrop-blur-sm bg-opacity-95">
            <svg x-show="toast.type === 'success'" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <svg x-show="toast.type === 'error'" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <svg x-show="toast.type === 'warning'" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
            <svg x-show="toast.type === 'info'" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="16" x2="12" y2="12" />
                <line x1="12" y1="8" x2="12.01" y2="8" />
            </svg>
            <span class="flex-1" x-text="toast.message"></span>
        </div>
    </template>
</div>
