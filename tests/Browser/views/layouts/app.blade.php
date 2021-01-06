<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <livewire:styles />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
</head>

<body>
    {{ $slot }}

    <livewire:scripts />
    <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/spruce@2.4.0/dist/spruce.umd.js"></script>
    <script src="/spruce-entangle.js"></script>
</body>

</html>
