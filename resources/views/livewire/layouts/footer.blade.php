<footer class="bg-[#f4eadf] text-[#2b2b2b] border-t border-[#c19a6b]/50">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('favicon.png') }}" alt="MindHug logo" class="w-10 h-10 rounded-md" />
                    <span class="text-lg font-semibold tracking-tight text-[#a47551]">MindHug</span>
                </div>
                <p class="mt-3 text-sm text-[#5b4a3f]">
                    Gak harus ngobrol, kadang cukup peluk yang lembut
                    <svg class="inline-block w-4 h-4 align-[-2px] ml-1 text-[#a47551]" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M12 21s-7-4.6-9.2-8.5C1 9.1 2.6 6 5.8 6c1.8 0 3.1 1 4 2.2C10.7 7 12 6 13.8 6c3.2 0 4.8 3.1 3 6.5C19 16.4 12 21 12 21Z" />
                    </svg>
                </p>
            </div>

            <div>
                <h4 class="text-[#5b4a3f] font-medium mb-3">Explore</h4>
                <ul class="space-y-2 text-[15px]">
                    <li><a href="{{ url('/') }}" class="text-[#2b2b2b]/80 hover:text-[#2b2b2b]">Home</a></li>
                    <li><a href="{{ url('/curhat') }}" class="text-[#2b2b2b]/80 hover:text-[#2b2b2b]">Curhat</a></li>
                    <li><a href="{{ url('/shop') }}" class="text-[#2b2b2b]/80 hover:text-[#2b2b2b]">Shop</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#5b4a3f] font-medium mb-3">Connect</h4>
                <ul class="space-y-2 text-[15px]">
                    <li>
                        <a href="#" class="inline-flex items-center gap-2 text-[#2b2b2b]/80 hover:text-[#2b2b2b]">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="mailto:support@mindhug.com"
                            class="inline-flex items-center gap-2 text-[#2b2b2b]/80 hover:text-[#2b2b2b]">
                            Email
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-10 border-t border-[#c19a6b]/30 pt-6 text-center text-sm text-[#6a5a4f]">
            <p>&copy; {{ date('Y') }} MindHug — All rights reserved.</p>
        </div>
    </div>
</footer>
