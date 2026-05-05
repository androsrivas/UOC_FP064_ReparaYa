<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'ReparaYa' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    {{ $styles ?? '' }}
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

    <div class="min-h-screen bg-gray-50">

    <div class="lg:pl-64 flex flex-col min-h-screen">
        <x-navbar :breadcrumbItems="$breadcrumbItems ?? []">
            {{ $navbar_extra ?? '' }}
        </x-navbar>

        <main class="p-6 flex-1">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>