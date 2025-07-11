<footer class="wh-footer md:mt-16 mt-10" style="background-color: black; color: white;">
    <div class="container">
        <div class="wh-footer-link pt-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- Company Info -->
            <div class="footer-single-item text-md text-center">
                {{-- <div class="logo-wrap mb-5">
                    <a href="/">
                        <img src="{{ env('IMAGE_LINK') . $logo }}" alt="footerLogo" style="max-width: 70px;">
                    </a>
                </div> --}}
                <div class="mb-3">
                    <span class="text-lg font-bold block">{{ $company_name ?? 'Metasoft BD' }}</span>
                    <a href="{{ $website ?? url('/') }}" class="text-sm text-gray-300 hover:text-white block"
                        target="_blank">
                        <i class="bi bi-globe"></i> {{ $website ?? 'www.metasoftbd.net' }}
                    </a>
                </div>
                <div class="mb-2 flex justify-center gap-2">
                    <i class="bi bi-envelope"></i>
                    <span class="font-bold">{{ $support_email ?? 'admin@metasoftbd.net' }}</span>
                </div>
                <div class="mb-2 flex justify-center gap-2">
                    <i class="bi bi-telephone"></i>
                    <span class="font-bold">{{ $phone_number ?? '+880123456789' }}</span>
                </div>
                <div class="mb-2 flex justify-center gap-2">
                    <i class="bi bi-geo-alt"></i>
                    <span class="font-bold">{{ $address ?? 'Dhaka, Bangladesh' }}</span>
                </div>
            </div>

            <!-- Get in Touch -->
            <div class="footer-single-item text-md text-center">
                <div class="mb-8">
                    <h2 class="md:text-xl text-sm font-semibold mb-5" style="color: white;">Get in Touch</h2>
                    <div class="wh-footer-social-icon mb-10 flex justify-center gap-4">
                        @if ($tiktok)
                            <a href="{{ $tiktok }}" target="_blank"
                                class="text-white hover:text-gray-400 text-lg">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        @endif
                        @if ($whatsapp)
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank"
                                class="text-white hover:text-gray-400 text-lg">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                        @if ($instagram)
                            <a href="{{ $instagram }}" target="_blank"
                                class="text-white hover:text-gray-400 text-lg">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($facebook)
                            <a href="{{ $facebook }}" target="_blank"
                                class="text-white hover:text-gray-400 text-lg">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($youtube)
                            <a href="{{ $youtube }}" target="_blank"
                                class="text-white hover:text-gray-400 text-lg">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Page -->
            <div class="footer-single-item text-md text-center">
                <h3 class="mb-5 md:text-xl text-sm font-bold" style="color: white;">Related Page</h3>
                <div class="grid grid-cols-1">
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('policies') }}">Returns & Refunds Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('conditions') }}">Terms & Condition</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="border border-gray-800 my-4">
        <div class="text-center py-4 stx-copyright-wrap">
            <span class="text-sm stx-copyright-text">Copyright © 2025 Metasoft BD. All Rights Reserved.</span>
            <span class="mx-1 stx-copyright-power-by-divider">|</span>
            <span class="text-sm stx-copyright-power-by">Powered by <a class="font-bold rounded-2xl text-[#FFBE2F]"
                    href="#" target="_blank"
                    title="Superfast Complete E-Commerce Solution first time in bangladesh">Metasoftbd</a></span>
        </div>
    </div>
</footer>
