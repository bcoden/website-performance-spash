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

</head>
<body class="h-screen antialiased leading-none font-sans">
    <div class="p-8 bg-white">
        <livewire:website-analytics />
        <livewire:contact-form />
    </div>
    <livewire:scripts />
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
