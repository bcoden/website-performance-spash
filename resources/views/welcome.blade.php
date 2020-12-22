<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="User experience is the difference between your success and failure on the web. Use our tool to evaluate your websites user experience.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ env('APP_URL') }}" />

    <title>Website Performance Score</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <livewire:styles />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl+ '&gtm_auth={{ config('app.tagmanager.auth') }}&gtm_preview=env-{{ config('app.tagmanager.environment-id') }}&gtm_cookies_win=x';f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ config('app.tagmanager.id') }}');</script>
    <!-- End Google Tag Manager -->
</head>
<body class="h-screen antialiased leading-none font-sans">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('app.tagmanager.id') }}&gtm_auth=_uomAzkv_X_b6owbjkkkAg&gtm_preview=env-{{ config('app.tagmanager.environment-id') }}&gtm_cookies_win=x"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="p-8 bg-white">
        <livewire:website-analytics />
        <livewire:contact-form />
    </div>
    <livewire:scripts />
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
