<x-layouts.app>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Quicksand:wght@500;600;700&display=swap');

        .mh-soft {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.005em;
        }

        .mh-soft h1,
        .mh-soft h2,
        .mh-soft h3,
        .mh-soft .mh-head {
            font-family: 'Quicksand', sans-serif;
            letter-spacing: -0.01em;
        }

        .mh-breathe-orb {
            animation: mh-breathe 8s ease-in-out infinite;
            transform-origin: center;
        }

        .mh-soft-card {
            transition: transform 260ms ease, box-shadow 260ms ease;
        }

        .mh-soft-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 44px rgba(102, 75, 56, 0.14);
        }

        @keyframes mh-breathe {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(193, 154, 107, 0.24);
            }

            50% {
                transform: scale(1.06);
                box-shadow: 0 0 0 24px rgba(193, 154, 107, 0.05);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(193, 154, 107, 0.24);
            }
        }
    </style>

    <main class="mh-soft page-enter bg-[#fdfaf7] text-[#4f4034]">

        <section class="relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                <div class="absolute -top-24 -left-20 w-[420px] h-[420px] rounded-full bg-[#f3dfc8]/55 blur-3xl"></div>
                <div class="absolute top-36 -right-20 w-[380px] h-[380px] rounded-full bg-[#ead8cd]/55 blur-3xl"></div>
                <div class="absolute inset-0 opacity-[0.03]"
                    style="background-image: radial-gradient(#a98467 1px, transparent 1px); background-size: 28px 28px;">
                </div>
            </div>

            <div
                class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-16 pb-14 md:pt-24 md:pb-20 grid lg:grid-cols-[1.08fr_0.92fr] gap-8 md:gap-12 items-center">
                <div>
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-[#e7d3be] bg-white/75 px-4 py-2 text-[0.76rem] font-semibold tracking-[0.12em] uppercase text-[#8a6a53]">
                        <span class="h-2 w-2 rounded-full bg-[#c39069] animate-pulse"></span>
                        Tempat tenang untukmu
                    </span>

                    <h1
                        class="mh-head mt-6 text-[2.35rem] sm:text-[2.8rem] md:text-[3.5rem] leading-[1.08] font-bold text-[#33241c]">
                        Tarik napas pelan,
                        <span class="block text-[#8c664d]">lepaskan yang berat.</span>
                    </h1>

                    <p class="mt-5 max-w-[56ch] text-[1rem] md:text-[1.08rem] leading-relaxed text-[#644f3f]">
                        MindHug hadir sebagai ruang aman untuk curhat tanpa dihakimi. Kamu boleh datang dengan hati
                        berantakan,
                        lalu pulang sedikit lebih ringan, satu langkah kecil dalam satu waktu.
                    </p>

                    <div class="mt-9 flex flex-wrap items-center gap-3">
                        <a href="{{ url('/curhat') }}" wire:navigate
                            class="inline-flex items-center gap-2.5 rounded-full bg-[#a87956] text-white px-7 py-3.5 text-sm font-semibold shadow-[0_10px_30px_rgba(168,121,86,0.35)] hover:shadow-[0_14px_38px_rgba(168,121,86,0.4)] hover:-translate-y-0.5 transition-all duration-300">
                            Mulai Curhat Sekarang
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ url('/kontak') }}" wire:navigate
                            class="inline-flex items-center text-sm font-semibold text-[#7e624f] hover:text-[#a87956] transition-colors duration-200">
                            Butuh bantuan cepat?
                        </a>
                    </div>
                </div>

                <div x-data="{
                    ventText: '',
                    releasedText: '',
                    showReleased: false,
                    release() {
                        if (!this.ventText.trim()) return;
                        this.releasedText = this.ventText.trim();
                        this.showReleased = true;
                        this.ventText = '';
                        setTimeout(() => {
                            this.showReleased = false;
                            this.releasedText = '';
                        }, 2200);
                    }
                }"
                    class="rounded-[2rem] border border-[#ead9c9] bg-white/88 backdrop-blur-sm shadow-[0_20px_55px_rgba(118,86,63,0.14)] p-5 sm:p-6 md:p-7">

                    <p class="text-xs uppercase tracking-[0.14em] text-[#9c7b62] font-semibold">Breath Sync</p>
                    <h2 class="mh-head mt-2 text-2xl leading-tight text-[#3b2a20] font-bold">Ikuti ritme napas ini</h2>
                    <p class="mt-2 text-sm text-[#6d5645] leading-relaxed">Tarik 4 detik, hembuskan 4 detik. Ulang
                        perlahan sampai badanmu terasa lebih hadir.</p>

                    <div
                        class="mt-6 flex flex-col items-center justify-center rounded-3xl bg-[#f9f2ea] border border-[#efdfd0] py-8 px-4">
                        <div
                            class="mh-breathe-orb relative h-36 w-36 rounded-full bg-gradient-to-br from-[#d7b292] via-[#c49572] to-[#ab7652]">
                            <div class="absolute inset-3 rounded-full border border-white/35"></div>
                            <div class="absolute -inset-4 rounded-full bg-[#d7b292]/25 blur-xl"></div>
                        </div>
                        <p class="mt-5 text-xs tracking-[0.12em] uppercase text-[#8f6f58]">Tarik napas 4s • Buang napas
                            4s</p>
                    </div>

                    <div class="mt-6">
                        <label for="vent-word" class="sr-only">Tulis emosi yang ingin dilepas</label>
                        <textarea id="vent-word" rows="1" x-model="ventText"
                            placeholder="Tulis satu kata yang membebani hatimu saat ini..."
                            class="w-full resize-none rounded-2xl border border-[#e8d6c5] bg-[#fffdfa] px-4 py-3 text-sm text-[#5f4a39] placeholder:text-[#b49884] focus:border-[#c79571] focus:ring-2 focus:ring-[#c79571]/20 outline-none transition-all duration-200"></textarea>

                        <div class="mt-3 flex items-center justify-between gap-3">
                            <p class="text-xs text-[#9b7f69]">Simpan yang menenangkan, lepaskan yang menguras.</p>
                            <button type="button" @click="release()"
                                class="rounded-full bg-[#b38361] text-white text-sm font-semibold px-5 py-2.5 shadow-[0_8px_24px_rgba(179,131,97,0.3)] hover:bg-[#9c6f50] transition-colors duration-200">
                                Lepaskan
                            </button>
                        </div>

                        <div class="mt-4 min-h-8">
                            <p x-show="showReleased" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-900"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="text-sm text-[#8f6a50] italic">
                                <span class="font-semibold" x-text="releasedText"></span> sudah kamu lepaskan
                                pelan-pelan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 md:py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="max-w-2xl">
                    <p class="text-xs uppercase tracking-[0.14em] text-[#9b7b63] font-semibold">Kenapa MindHug?</p>
                    <h2 class="mh-head mt-3 text-[2rem] md:text-[2.45rem] leading-tight font-bold text-[#3a291f]">
                        Karena cerita pribadi butuh tempat yang benar-benar aman.
                    </h2>
                    <p class="mt-3 text-[#665141] leading-relaxed">
                        Kami membangun pengalaman yang lembut agar kamu merasa dipeluk, bukan diinterogasi.
                    </p>
                </div>

                <div class="mt-8 grid md:grid-cols-3 gap-4 md:gap-5">
                    <article
                        class="mh-soft-card rounded-3xl border border-[#ead8c8] bg-gradient-to-b from-white to-[#fdf6ee] p-6">
                        <div class="h-11 w-11 rounded-2xl bg-[#f3e5d6] text-[#9a7358] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V6l-8-4-8 4v6c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <h3 class="mh-head mt-4 text-xl font-bold text-[#3e2c21]">Privasi 100% Aman</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#6c5645]">
                            Isi curhatanmu terlindungi dan hanya bisa diakses oleh tim pendamping. Tidak dipublikasikan.
                        </p>
                    </article>

                    <article
                        class="mh-soft-card rounded-3xl border border-[#ead8c8] bg-gradient-to-b from-white to-[#fbf3ea] p-6">
                        <div class="h-11 w-11 rounded-2xl bg-[#f3e5d6] text-[#9a7358] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                        </div>
                        <h3 class="mh-head mt-4 text-xl font-bold text-[#3e2c21]">Bahasa yang Empatik</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#6c5645]">
                            Kamu akan menerima respons manusiawi dan hangat, dengan kalimat yang menenangkan hati.
                        </p>
                    </article>

                    <article
                        class="mh-soft-card rounded-3xl border border-[#ead8c8] bg-gradient-to-b from-white to-[#fcf5ed] p-6">
                        <div class="h-11 w-11 rounded-2xl bg-[#f3e5d6] text-[#9a7358] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <h3 class="mh-head mt-4 text-xl font-bold text-[#3e2c21]">Ritme Pelan & Tenang</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#6c5645]">
                            Alur sederhana, tanpa distraksi berlebihan, agar kamu fokus ke proses pulihmu sendiri.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="pb-16 md:pb-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div
                    class="rounded-[2.2rem] border border-[#ead7c7] bg-gradient-to-r from-[#f5e4d4] via-[#f7ede3] to-[#f8f1ea] p-7 sm:p-9 md:p-11 flex flex-col md:flex-row md:items-center md:justify-between gap-6 shadow-[0_24px_55px_rgba(120,86,62,0.14)]">
                    <div class="max-w-xl">
                        <p class="text-xs uppercase tracking-[0.14em] font-semibold text-[#8f6e57]">Langkah kecil hari
                            ini</p>
                        <h3
                            class="mh-head mt-2 text-[1.85rem] md:text-[2.2rem] leading-tight font-bold text-[#3a291f]">
                            Kalau hati terasa penuh,
                            biarkan kami menemanimu.
                        </h3>
                        <p class="mt-3 text-[#6a5342] leading-relaxed">Mulai dari satu kalimat sederhana. Kamu tidak
                            harus menanggung semuanya sendirian.</p>
                    </div>

                    <a href="{{ url('/curhat') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2.5 rounded-full bg-[#ad7c59] text-white px-8 py-3.5 text-sm font-semibold shadow-[0_12px_34px_rgba(173,124,89,0.4)] hover:shadow-[0_16px_42px_rgba(173,124,89,0.46)] hover:-translate-y-0.5 transition-all duration-300 whitespace-nowrap">
                        Mulai Curhat Sekarang
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

    </main>
</x-layouts.app>
