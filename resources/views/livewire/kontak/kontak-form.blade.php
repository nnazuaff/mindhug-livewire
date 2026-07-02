{{-- Contact page — clean grid layout --}}
<div class="page-enter">

    {{-- Page header --}}
    <div class="border-b border-[#ede0d4] bg-white">
        <div class="max-w-5xl mx-auto px-4 py-10 md:py-14">
            <p class="text-xs font-medium tracking-widest uppercase text-[#836c5a] mb-3">Kontak</p>
            <h1 class="font-baloo font-bold text-[#1a1a1a] text-3xl md:text-4xl leading-snug">
                Ada yang ingin<br />kamu sampaikan?
            </h1>
            <p class="mt-3 text-[#666] text-base max-w-md leading-relaxed">
                Kami baca setiap pesan. Tidak ada pertanyaan yang terlalu kecil.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-10 md:py-14 grid md:grid-cols-5 gap-10 md:gap-14 items-start">

        {{-- ══ LEFT — Form ══ --}}
        <div class="md:col-span-3">

            {{-- Success state --}}
            @if ($sent)
                <div class="rounded-3xl bg-emerald-50 border border-emerald-100 px-6 py-8 text-center" x-data
                    x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'nearest' })">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="h-7 w-7 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <h3 class="font-baloo font-bold text-[#1a1a1a] text-xl">Pesan terkirim!</h3>
                    <p class="mt-2 text-[#666] text-sm leading-relaxed">
                        Terima kasih sudah menghubungi kami. Kami akan membalas dalam 1–2 hari kerja.
                    </p>
                    <button wire:click="$set('sent', false)"
                        class="mt-5 inline-flex items-center gap-1.5 rounded-full border border-[#c19a6b]/50 text-[#a47551] px-5 py-2 text-sm font-medium hover:bg-[#f7ede3] transition duration-200">
                        Kirim pesan lain
                    </button>
                </div>
            @else
                <form wire:submit.prevent="kirim" class="space-y-5">

                    {{-- Name + Email side by side on sm+ --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="k-name" class="block text-sm font-medium text-[#3d2b1c] mb-2">Nama</label>
                            <input id="k-name" wire:model.defer="name" type="text" placeholder="Namamu"
                                class="w-full rounded-2xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3.5 text-sm placeholder-[#b0a090] outline-none transition-all duration-200 focus:border-[#a47551] focus:ring-4 focus:ring-[#a47551]/10 @error('name') border-red-300 bg-red-50/50 @enderror" />
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="k-email" class="block text-sm font-medium text-[#3d2b1c] mb-2">Email</label>
                            <input id="k-email" wire:model.defer="email" type="email" placeholder="email@kamu.com"
                                class="w-full rounded-2xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3.5 text-sm placeholder-[#b0a090] outline-none transition-all duration-200 focus:border-[#a47551] focus:ring-4 focus:ring-[#a47551]/10 @error('email') border-red-300 bg-red-50/50 @enderror" />
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Message --}}
                    <div>
                        <label for="k-pesan" class="block text-sm font-medium text-[#3d2b1c] mb-2">Pesan</label>
                        <textarea id="k-pesan" wire:model.defer="pesan" rows="6" placeholder="Tuliskan pesanmu di sini…"
                            class="w-full rounded-2xl border border-[#e0d0c0] bg-[#fdfaf7] px-4 py-3.5 text-sm placeholder-[#b0a090] outline-none transition-all duration-200 focus:border-[#a47551] focus:ring-4 focus:ring-[#a47551]/10 resize-none @error('pesan') border-red-300 bg-red-50/50 @enderror"></textarea>
                        @error('pesan')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl bg-[#a47551] text-white px-7 py-3.5 font-semibold text-sm shadow-md shadow-[#a47551]/20 hover:bg-[#8f6243] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200"
                        wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                        <span wire:loading.remove>Kirim Pesan</span>
                        <span wire:loading class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Mengirim...
                        </span>
                    </button>
                </form>
            @endif
        </div>

        {{-- ══ RIGHT — Info Cards ══ --}}
        <div class="md:col-span-2 space-y-3">

            <p class="text-xs font-medium tracking-widest uppercase text-[#aaa] mb-4">Cara lain untuk menghubungi kami
            </p>

            @foreach ([
        [
            'label' => 'Instagram',
            'value' => '@mindhug.id',
            'href' => 'https://instagram.com/mindhug.id',
            'color' => '#e1306c',
            'icon' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
        ],
        [
            'label' => 'Email',
            'value' => 'halo@mindhug.id',
            'href' => 'mailto:halo@mindhug.id',
            'color' => '#a47551',
            'icon' => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        ],
        [
            'label' => 'Darurat?',
            'value' => 'Into The Light 119 ext. 8',
            'href' => 'tel:119',
            'color' => '#e05252',
            'icon' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.64 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l.81-.81a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 17z"/>',
        ],
    ] as $card)
                <a href="{{ $card['href'] }}" target="{{ str_starts_with($card['href'], 'http') ? '_blank' : '_self' }}"
                    rel="{{ str_starts_with($card['href'], 'http') ? 'noopener noreferrer' : '' }}"
                    class="group flex items-center gap-4 rounded-2xl border border-[#ede0d4] bg-white px-5 py-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#f7ede3] group-hover:scale-105 transition-transform duration-200">
                        <svg class="h-5 w-5" style="color: {{ $card['color'] }}" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            {!! $card['icon'] !!}
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-[#999] uppercase tracking-wider leading-none mb-1">
                            {{ $card['label'] }}</p>
                        <p class="text-sm font-semibold text-[#2b2b2b] truncate">{{ $card['value'] }}</p>
                    </div>
                    <svg class="h-4 w-4 text-[#ccc] ml-auto flex-shrink-0 group-hover:text-[#a47551] group-hover:translate-x-0.5 transition-all duration-200"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            @endforeach


        </div>

    </div>
</div>
