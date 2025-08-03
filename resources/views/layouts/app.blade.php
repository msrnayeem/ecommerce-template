<!DOCTYPE html>
<html lang="en" data-theme="default">
@include('layouts.includes.head')

<body class="home-page">
    <!-- Google Tag Manager (noscript) -->
    @if (isset($marketingIntegration) && $marketingIntegration->google_tag_manager_id)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $marketingIntegration->google_tag_manager_id }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endif
    <!-- End Google Tag Manager (noscript) -->

    <!-- Meta Pixel (noscript) -->
    @if (isset($marketingIntegration) && $marketingIntegration->meta_pixel_id)
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $marketingIntegration->meta_pixel_id }}&ev=PageView&noscript=1" />
        </noscript>
    @endif
    <!-- End Meta Pixel (noscript) -->
    @include('layouts.includes.header')

    <div class="main-body-wrapper">
        @yield('content')
    </div>

    @include('layouts.includes.footer')
    <div class="offcanvas-overaly"></div>
    @include('layouts.includes.scripts')
</body>
