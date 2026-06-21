<x-layouts.app>
    <main>
        {{-- Hero --}}
        <section class="relative overflow-hidden bg-gradient-to-b from-[#f7ede3] via-[#fdf8f4] to-white">
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[400px] rounded-full bg-[#c19a6b]/10 blur-3xl pointer-events-none">
            </div>
            <div
                class="relative max-w-6xl mx-auto px-4 pt-16 pb-20 md:pt-24 md:pb-28 grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <span
                        class="inline-block text-xs tracking-widest uppercase text-[#836c5a] bg-[#c19a6b]/12 px-3 py-1.5 rounded-full mb-5 font-medium">
                        Ruang aman untuk hatimu
                    </span>
                    <h1 class="text-3xl md:text-5xl font-semibold leading-tight text-[#1a1a1a]">
                        Peluk Emosi,<br />Tenangkan Hati,<br />
                        <span class="text-[#a47551]">Bersama MindHug</span>
                    </h1>
                    <p class="mt-5 text-[#555] md:text-lg leading-relaxed max-w-md">
                        Curhat tanpa penilaian, dukungan yang hangat, dan produk self-care yang menenangkan. Satu
                        langkah kecil untuk dirimu hari ini.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ url('/curhat') }}"
                            class="inline-flex items-center gap-2 rounded-full bg-[#a47551] text-white px-6 py-3 font-medium shadow-md shadow-[#a47551]/25 hover:bg-[#8f6243] hover:-translate-y-0.5 transition duration-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9 8.5 8.5 0 0 1 8.5 8.5Z" />
                            </svg>
                            Mulai Curhat
                        </a>
                        <a href="{{ url('/shop') }}"
                            class="inline-flex items-center gap-2 rounded-full border border-[#c19a6b]/50 text-[#3d2b1c] px-6 py-3 font-medium hover:bg-[#f7ede3] hover:border-[#a47551]/60 hover:-translate-y-0.5 transition duration-200">
                            Lihat Shop
                        </a>
                    </div>
                    <p class="italic text-sm text-[#7a6457] mt-7" id="motivationalQuote">"You are stronger than
                        yesterday."</p>
                </div>

                <div class="flex justify-center">
                    <div class="relative w-full max-w-sm">
                        <div
                            class="absolute -inset-6 bg-gradient-to-br from-[#a47551]/15 to-[#c19a6b]/8 rounded-[2rem] blur-2xl">
                        </div>
                        <div
                            class="relative overflow-hidden rounded-3xl border-4 border-white shadow-2xl shadow-[#a47551]/15 rotate-1 hover:rotate-0 transition-transform duration-500">
                            <img src="https://images.unsplash.com/photo-1518398046578-8cca57782e17?q=80&w=800&auto=format&fit=crop"
                                alt="Self-care moment" class="w-full aspect-[4/5] object-cover" />
                            <div
                                class="absolute bottom-4 left-4 right-4 bg-white/85 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/50 shadow-sm">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-[#a47551] flex items-center justify-center text-white flex-shrink-0">
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

        {{-- Kenapa MindHug --}}
        <section class="max-w-6xl mx-auto px-4 py-16 md:py-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#1a1a1a]">Kenapa MindHug?</h2>
                <p class="mt-3 text-[#555] max-w-xl mx-auto leading-relaxed">
                    Terkadang kamu tidak butuh nasihat. Kamu hanya butuh pelukan yang lembut, tempat yang tenang, dan
                    teman yang mau mendengar.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div
                    class="rounded-2xl bg-white border border-[#ede0d4] p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-250">
                    <div
                        class="w-11 h-11 rounded-2xl bg-[#f7ede3] flex items-center justify-center text-[#a47551] mb-4">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-[#2b2b2b]">Hangat & Tanpa Penilaian</h3>
                    <p class="mt-2 text-[#666] text-sm leading-relaxed">Curhat bebas, aman, dan diterima. Kami ada untuk
                        mendengarkan—bukan menghakimi.</p>
                </div>

                <div
                    class="rounded-2xl bg-white border border-[#ede0d4] p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-250">
                    <div
                        class="w-11 h-11 rounded-2xl bg-[#f7ede3] flex items-center justify-center text-[#a47551] mb-4">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M9.5 10h.01" />
                            <path d="M14.5 10h.01" />
                            <path d="M8.5 14.5c1.2 1.2 2.7 1.8 3.5 1.8s2.3-.6 3.5-1.8" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-[#2b2b2b]">Teman Nyaman</h3>
                    <p class="mt-2 text-[#666] text-sm leading-relaxed">Squishy lucu & produk self-care untuk
                        menenangkan hari-harimu.</p>
                </div>

                <div
                    class="rounded-2xl bg-white border border-[#ede0d4] p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-250">
                    <div
                        class="w-11 h-11 rounded-2xl bg-[#f7ede3] flex items-center justify-center text-[#a47551] mb-4">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" />
                            <path d="M16 7V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v1" />
                            <path d="M22 12h-6a2 2 0 0 0 0 4h6" />
                            <path d="M16 14h.01" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-[#2b2b2b]">Ringan di Hati & Dompet</h3>
                    <p class="mt-2 text-[#666] text-sm leading-relaxed">Solusi yang lembut, aksesibel, dan ramah untuk
                        semua kalangan.</p>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="bg-gradient-to-br from-[#f7ede3] to-[#fdf8f4]">
            <div class="max-w-6xl mx-auto px-4 py-14 md:py-18">
                <div
                    class="rounded-3xl bg-white border border-[#e8d5c4] px-7 py-10 md:px-12 md:py-12 flex flex-col md:flex-row md:items-center md:justify-between gap-7 shadow-sm">
                    <div>
                        <h3 class="text-xl md:text-2xl font-semibold text-[#1a1a1a]">Ingin curhat sekarang?</h3>
                        <p class="mt-2 text-[#666] leading-relaxed">Ambil jeda, tarik napas, dan izinkan kami
                            menemanimu.</p>
                    </div>
                    <a href="{{ url('/curhat') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#a47551] text-white px-7 py-3.5 font-medium shadow-md shadow-[#a47551]/20 hover:bg-[#8f6243] hover:-translate-y-0.5 transition duration-200 whitespace-nowrap">
                        Mulai Curhat
                    </a>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function() {
            const quotes = [
                '"You are stronger than yesterday."',
                '"Pelan-pelan, kamu sedang bertumbuh."',
                '"Hari ini cukup bertahan, itu sudah hebat."',
                '"Tarik napas. Kamu aman."',
                '"Kamu tidak sendirian."',
            ];
            const el = document.getElementById('motivationalQuote');
            if (el) el.textContent = quotes[Math.floor(Math.random() * quotes.length)];
        })();
    </script>
</x-layouts.app>
