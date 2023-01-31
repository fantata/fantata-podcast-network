<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://use.typekit.net/ckj2fys.css">

    <!-- audio player package -->
    <script type="module" src="/vendor/fantata/js/audioPlayer.js"></script>
    <link href="/vendor/fantata/css/audioPlayer.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class='font-sans leading-normal bg-yellow-200 text-blue-deep'>

    <header class='p-6 bg-fpn-red'>
        <img src="/img/logo.gif" class="w-[150px]" />
    </header>

    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>
</body>

</html>