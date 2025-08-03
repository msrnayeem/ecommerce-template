<head>

    <!-- Google Tag Manager -->
    @if (isset($marketingIntegration) && $marketingIntegration->google_tag_manager_id)
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $marketingIntegration->google_tag_manager_id }}');
        </script>
    @endif
    <!-- End Google Tag Manager -->

    <!-- Meta Pixel Code -->
    @if (isset($marketingIntegration) && $marketingIntegration->meta_pixel_id)
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $marketingIntegration->meta_pixel_id }}');
            fbq('track', 'PageView');
        </script>
    @endif
    <!-- End Meta Pixel Code -->

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="Metasoft BD ,usb water patten light,01680847204‬" />
    <meta name="description" content="Online Store " />
    <meta property="og:title" content="Online Store" />
    <meta property="og:description" content="Online Store " />


    <meta property="og:url" content="index.html" />
    <meta property="og:type" content="website" />
    <title>{{ app()->bound('currentTenant') ? app('currentTenant')->name : 'Default Store' }} -Online Shop
    </title>


    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- theme related css -->
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/theme.css') }}" />

    <!-- Common CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/animation.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/global-utilities.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/splide.min.css') }}" />

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/custom.css') }}" />
    <!-- Select2 CSS -->

</head>
