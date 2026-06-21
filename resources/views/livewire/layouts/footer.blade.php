<footer class="bg-[#f7ede3] border-t border-[#e8d5c4]">
    <div class="max-w-6xl mx-auto px-4 pt-12 pb-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">

            {{-- Brand --}}
            <div class="sm:col-span-1">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 group">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#a47551]/15">
                        <img src="{{ asset('favicon.png') }}" alt="MindHug" class="w-7 h-7 rounded-lg" />
                    </span>
                    <span class="text-lg font-semibold text-[#3d2b1c] tracking-tight">MindHug</span>
                </a>
                <p class="mt-3 text-sm text-[#6a5448] leading-relaxed max-w-xs">
                    Gak harus kuat sendirian. Kadang cukup ada yang mau dengerin—itu sudah cukup.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-[#9a7a6a] mb-4">Explore</p>
                <ul class="space-y-2.5">
                    <li><a href="{{ url('/') }}"
                            class="text-sm text-[#4a3728] hover:text-[#a47551] transition duration-200">Home</a></li>
                    <li><a href="{{ url('/curhat') }}"
                            class="text-sm text-[#4a3728] hover:text-[#a47551] transition duration-200">Curhat</a></li>
                    <li><a href="{{ url('/shop') }}"
                            class="text-sm text-[#4a3728] hover:text-[#a47551] transition duration-200">Shop</a></li>
                </ul>
            </div>

            {{-- Connect --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-[#9a7a6a] mb-4">Connect</p>
                <ul class="space-y-2.5">
                    <li>
                        <a href="#"
                            class="inline-flex items-center gap-2 text-sm text-[#4a3728] hover:text-[#a47551] transition duration-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="mailto:support@mindhug.com"
                            class="inline-flex items-center gap-2 text-sm text-[#4a3728] hover:text-[#a47551] transition duration-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            support@mindhug.com
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="mt-10 pt-6 border-t border-[#e0cdc0] flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-[#9a7a6a]">
            <p>&copy; {{ date('Y') }} MindHug. Dibuat dengan hangat untuk kamu.</p>
            <p class="flex items-center gap-1">
                Semua hati diterima di sini
                <svg class="h-3.5 w-3.5 text-[#c19a6b]" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                </svg>
            </p>
        </div>
    </div>
</footer>
