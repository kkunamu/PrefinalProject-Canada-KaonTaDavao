<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao Cañada's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fafafa] text-neutral-800 min-h-screen flex flex-col antialiased">
    @include('partials.nav')

    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 py-8 flex-1">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="border-t border-neutral-300 bg-white py-5 text-center text-xs text-neutral-500">
        Kaon Ta! Davao Cañada's Food Guide &middot; Davao City Carinderia &amp; Eatery Archive
    </footer>
</body>
</html>