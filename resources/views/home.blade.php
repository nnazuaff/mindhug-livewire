<x-layouts.app>
    <main class="pt-0">
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 bg-linear-to-b from-[#f5ebe1] via-[#fffaf6] to-white"></div>
            <div class="relative max-w-6xl mx-auto px-4 py-14 md:py-20 grid md:grid-cols-2 gap-10 items-center">
                <div class="reveal">
                    <span
                        class="inline-block text-xs tracking-widest uppercase text-[#836c5a]/80 bg-[#c19a6b]/10 px-3 py-1 rounded-full mb-4">Ruang
                        aman untuk hatimu</span>
                    <h1 class="text-3xl md:text-5xl font-semibold leading-tight text-[#1f1f1f]">
                        Peluk Emosi, Tenangkan Hati,<br class="hidden md:block" /> Bersama <span
                            class="text-[#a47551]">MindHug</span>
                    </h1>
                    <p class="mt-4 md:mt-6 text-[#4b4b4b] md:text-lg">
                        Curhat tanpa penilaian, dukungan yang hangat, dan produk self-care yang menenangkan. Satu
                        langkah kecil untuk dirimu hari ini.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="<?= e(url('/curhat')) ?>"
                            class="inline-flex items-center justify-center rounded-lg bg-[#a47551] text-white px-5 py-3 shadow-sm hover:bg-[#8f6243] transition focus:outline-none focus:ring-2 focus:ring-[#a47551]/40">
                            Mulai Curhat
                        </a>
                        <a href="<?= e(url('/shop')) ?>"
                            class="inline-flex items-center justify-center rounded-lg border border-[#a47551]/40 text-[#2b2b2b] px-5 py-3 hover:border-[#a47551] hover:bg-[#a47551]/10 transition focus:outline-none focus:ring-2 focus:ring-[#a47551]/20">
                            Jelajahi Shop
                        </a>
                    </div>
                    <p class="italic text-sm text-[#5b5b5b] mt-6" id="motivationalQuote">“You are stronger than
                        yesterday.”</p>
                </div>
                <div class="relative reveal flex justify-center">
                    <div class="relative w-full max-w-md">
                        <!-- Decorative Background -->
                        <div
                            class="absolute -inset-4 bg-linear-to-br from-[#a47551]/20 to-[#c19a6b]/10 rounded-[2rem] blur-2xl opacity-60">
                        </div>

                        <!-- Image Container -->
                        <div
                            class="relative aspect-square md:aspect-4/5 overflow-hidden rounded-3xl border-4 border-white shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                            <img src="https://images.unsplash.com/photo-1518398046578-8cca57782e17?q=80&w=800&auto=format&fit=crop"
                                alt="Relaxing tea and journaling" class="w-full h-full object-cover">

                            <!-- Overlay Text/Element -->
                            <div
                                class="absolute bottom-4 left-4 right-4 bg-white/80 backdrop-blur-md p-3 rounded-xl border border-white/40 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-[#a47551] flex items-center justify-center text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-[#2b2b2b]">You deserve to be heard.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-4 py-14 md:py-20">
            <div class="text-center reveal">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#1f1f1f]">Kenapa MindHug?</h2>
                <p class="mt-3 text-[#525252] max-w-2xl mx-auto">Terkadang kamu tidak butuh nasihat. Kamu hanya butuh
                    pelukan yang lembut, tempat yang tenang, dan teman yang mau mendengar.</p>
            </div>

            <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="reveal rounded-2xl bg-white/80 border border-[#c19a6b]/20 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
                    <div class="text-[#a47551]">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path
                                d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 font-semibold text-[#2b2b2b]">Hangat & Tanpa Penilaian</h3>
                    <p class="mt-2 text-[#595959] text-sm">Curhat bebas, aman, dan diterima. Kami ada untuk
                        mendengarkan—bukan menghakimi.</p>
                </div>
                <div
                    class="reveal rounded-2xl bg-white/80 border border-[#c19a6b]/20 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
                    <div class="text-[#a47551]">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M9.5 10h.01" />
                            <path d="M14.5 10h.01" />
                            <path d="M8.5 14.5c1.2 1.2 2.7 1.8 3.5 1.8s2.3-.6 3.5-1.8" />
                        </svg>
                    </div>
                    <h3 class="mt-3 font-semibold text-[#2b2b2b]">Teman Nyaman</h3>
                    <p class="mt-2 text-[#595959] text-sm">Squishy lucu & produk self-care untuk menenangkan
                        hari-harimu.</p>
                </div>
                <div
                    class="reveal rounded-2xl bg-white/80 border border-[#c19a6b]/20 p-6 hover:shadow-md hover:-translate-y-0.5 transition">
                    <div class="text-[#a47551]">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 7h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                            <path d="M16 7V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v1" />
                            <path d="M22 12h-6a2 2 0 0 0 0 4h6" />
                            <path d="M16 14h.01" />
                        </svg>
                    </div>
                    <h3 class="mt-3 font-semibold text-[#2b2b2b]">Ringan di Hati & Dompet</h3>
                    <p class="mt-2 text-[#595959] text-sm">Solusi yang lembut, aksesibel, dan ramah untuk semua.</p>
                </div>
            </div>
        </section>

        <section class="relative">
            <div class="absolute inset-0 bg-linear-to-t from-[#f5ebe1] to-transparent"></div>
            <div class="relative max-w-6xl mx-auto px-4 py-12 md:py-16">
                <div
                    class="reveal rounded-3xl border border-[#c19a6b]/20 bg-white/70 backdrop-blur px-6 py-8 md:px-10 md:py-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h3 class="text-xl md:text-2xl font-semibold text-[#1f1f1f]">Ingin curhat sekarang?</h3>
                        <p class="mt-2 text-[#545454]">Ambil jeda, tarik napas, dan izinkan kami menemanimu.</p>
                    </div>
                    <a href="<?= e(url('/curhat')) ?>"
                        class="inline-flex items-center justify-center rounded-lg bg-[#a47551] text-white px-5 py-3 shadow-sm hover:bg-[#8f6243] transition focus:outline-none focus:ring-2 focus:ring-[#a47551]/40">Mulai
                        Curhat</a>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function() {
            const quotes = [
                '“You are stronger than yesterday.”',
                '“Pelan-pelan, kamu sedang bertumbuh.”',
                '“Hari ini cukup bertahan, itu sudah hebat.”',
                '“Tarik napas. Kamu aman.”'
            ];
            const el = document.getElementById('motivationalQuote');
            if (!el) return;
            el.textContent = quotes[Math.floor(Math.random() * quotes.length)];
        })();
    </script>
</x-layouts.app>
