<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'MindHug - Peluk Emosi, Tenangkan Hati' }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS & JS Assets via Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-[#fffafc] text-[#2b2b2b] min-h-screen flex flex-col font-sans">

    <!-- Render Header Navigasi -->
    <livewire:layouts.header />

    <!-- Slot Konten Utama Livewire -->
    <div class="flex-1">
        {{ $slot }}
    </div>

    <!-- Render Footer -->
    @include('livewire.layouts.footer')

    @livewireScripts
</body>

</html>
