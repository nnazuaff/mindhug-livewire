<x-layouts.app>
    <main class="page-enter bg-white text-[#2b2b2b]">

        {{-- Hero Section --}}
        <section class="bg-white">
            <div
                class="max-w-6xl mx-auto px-4 sm:px-6 py-14 md:py-20 grid lg:grid-cols-[1fr_0.95fr] gap-9 lg:gap-12 items-center">
                <div>
                    <p
                        class="inline-flex items-center gap-2 rounded-full bg-[#f5e9df] text-[#a47551] px-3.5 py-1.5 text-xs font-semibold tracking-[0.08em] uppercase">
                        anomim • cepet • gak ribet
                    </p>

                    <h1
                        class="mt-5 text-[2.15rem] sm:text-[2.75rem] md:text-[3.25rem] leading-[1.05] font-bold text-[#2b1d12]">
                        Tulis aja, biarin lega.
                        <span class="block text-[#a47551]">Sisanya urusan belakang.</span>
                    </h1>

                    <p class="mt-5 max-w-[58ch] text-[1.02rem] leading-8 text-[#5f493d]">
                        Gak perlu daftar ribet atau takut ketahuan. Ketik apa yang bikin pusing hari ini,
                        tutup aplikasinya, terus lanjutin hidup tanpa bawa beban sendirian.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ url('/curhat') }}" wire:navigate
                            class="inline-flex items-center gap-2.5 rounded-xl bg-[#a47551] text-white px-6 py-3.5 text-sm font-semibold shadow-md shadow-[#a47551]/30 hover:bg-[#8f6243] hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15 4H8a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V9Z" />
                                <path d="M14 4v5h5" />
                                <path d="M10 14l4-4" />
                            </svg>
                            Tulis Bebanmu
                        </a>

                        <a href="{{ url('/kontak') }}" wire:navigate
                            class="inline-flex items-center gap-2 rounded-xl border border-[#e2cbb6] text-[#6b4f41] px-5 py-3.5 text-sm font-semibold hover:bg-[#f9f2ec] transition-colors duration-200">
                            Butuh respon cepat?
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="overflow-hidden rounded-3xl border border-[#e7d8ca] bg-white shadow-lg shadow-[#a47551]/12">
                        <img src="https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=800&q=80"
                            alt="Orang sedang menulis fokus di meja kerja"
                            class="h-[320px] md:h-[430px] w-full object-cover">
                    </div>
                    <div
                        class="absolute -bottom-5 left-4 right-4 md:left-6 md:right-auto md:w-[72%] rounded-2xl bg-white border border-[#eadccf] px-4 py-3.5 shadow-lg shadow-[#a47551]/10">
                        <p class="text-sm font-medium text-[#4a382d]">"Nulis 5 menit doang, tapi rasanya kepala langsung
                            turun volumenya."</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- How it Works --}}
        <section id="cara-kerja" class="bg-[#fcf8f5] border-y border-[#ede0d4]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 md:py-16">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#a47551]">cara kerja</p>
                    <h2 class="mt-2 text-[1.9rem] md:text-[2.25rem] leading-tight font-bold text-[#2b1d12]">3 langkah,
                        selesai. Gak pakai muter-muter.</h2>
                </div>

                <div class="mt-8 grid md:grid-cols-3 gap-4 md:gap-5">
                    <article class="rounded-2xl bg-white border border-[#e9ddd2] p-6 shadow-sm">
                        <span class="h-10 w-10 rounded-xl bg-[#f5e9df] text-[#a47551] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15 4H8a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V9Z" />
                                <path d="M14 4v5h5" />
                            </svg>
                        </span>
                        <h3 class="mt-4 text-lg font-semibold text-[#2b1d12]">1. Tulis sejujurnya</h3>
                        <p class="mt-2 text-sm leading-7 text-[#624d42]">Ketik apa yang lagi numpuk. Gak usah pakai
                            bahasa bagus, yang penting keluar.</p>
                    </article>

                    <article class="rounded-2xl bg-white border border-[#e9ddd2] p-6 shadow-sm">
                        <span class="h-10 w-10 rounded-xl bg-[#f5e9df] text-[#a47551] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M13 2 3 14h7l-1 8 10-12h-7z" />
                            </svg>
                        </span>
                        <h3 class="mt-4 text-lg font-semibold text-[#2b1d12]">2. Kirim langsung</h3>
                        <p class="mt-2 text-sm leading-7 text-[#624d42]">Satu klik beres. Gak ada form panjang yang
                            bikin makin capek.</p>
                    </article>

                    <article class="rounded-2xl bg-white border border-[#e9ddd2] p-6 shadow-sm">
                        <span class="h-10 w-10 rounded-xl bg-[#f5e9df] text-[#a47551] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="M12 2a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-5-5z" />
                            </svg>
                        </span>
                        <h3 class="mt-4 text-lg font-semibold text-[#2b1d12]">3. Aman tersimpan</h3>
                        <p class="mt-2 text-sm leading-7 text-[#624d42]">Privat dan anonim. Ceritamu bukan konsumsi
                            publik, titik.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- Features / Benefits
        <section id="fitur" class="bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 md:py-16">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#a47551]">fitur inti</p>
                    <h2 class="mt-2 text-[1.9rem] md:text-[2.25rem] leading-tight font-bold text-[#2b1d12]">Dibikin buat
                        ngelepas beban, bukan nambah drama.</h2>
                </div>

                <div class="mt-8 grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                    <article class="rounded-2xl border border-[#e9ddd2] p-6">
                        <div class="h-10 w-10 rounded-xl bg-[#f5e9df] text-[#a47551] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path
                                    d="M12 2a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-5-5z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-[#2b1d12]">Privasi ketat</h3>
                        <p class="mt-2 text-sm leading-7 text-[#624d42]">Fokus utama: kamu bisa nulis tanpa takut
                            identitas bocor.</p>
                    </article>

                    <article class="rounded-2xl border border-[#e9ddd2] p-6">
                        <div class="h-10 w-10 rounded-xl bg-[#f5e9df] text-[#a47551] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M13 2 3 14h7l-1 8 10-12h-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-[#2b1d12]">Cepat dipakai</h3>
                        <p class="mt-2 text-sm leading-7 text-[#624d42]">Buka halaman, ketik, kirim. Gak perlu ritual
                            panjang.</p>
                    </article>

                    <article class="rounded-2xl border border-[#e9ddd2] p-6">
                        <div class="h-10 w-10 rounded-xl bg-[#f5e9df] text-[#a47551] flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path
                                    d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-[#2b1d12]">Bahasanya manusia</h3>
                        <p class="mt-2 text-sm leading-7 text-[#624d42]">Gak kaku, gak nggurui. Lebih ke “gue dengerin
                            lo” vibe.</p>
                    </article>
                </div>
            </div>
        </section> --}}

        {{-- Final CTA --}}
        <section class="bg-[#2f1f15]">
            <div
                class="max-w-6xl mx-auto px-4 sm:px-6 py-14 md:py-16 flex flex-col md:flex-row md:items-center md:justify-between gap-7">
                <div class="max-w-2xl">
                    <p class="text-xs uppercase tracking-[0.12em] font-semibold text-white/70">udah kebanyakan disimpen
                        sendiri?</p>
                    <h2 class="mt-2 text-[1.95rem] md:text-[2.3rem] leading-tight font-bold text-white">Lepasin
                        sekarang. Biar malam ini kepalamu gak seberisik biasanya.</h2>
                    <p class="mt-3 text-sm md:text-base leading-7 text-white/75">Ketik sebisamu. Habis itu, tutup
                        aplikasi, tarik napas, lanjut hidup.</p>
                </div>

                <a href="{{ url('/curhat') }}" wire:navigate
                    class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-[#a47551] text-white px-7 py-3.5 text-sm font-semibold shadow-lg shadow-black/20 hover:bg-[#b07a55] hover:-translate-y-0.5 transition-all duration-200 whitespace-nowrap">
                    Lepasin Di Sini
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </section>

    </main>
</x-layouts.app>
