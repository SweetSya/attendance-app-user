<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>{{ $title ?? 'Page Title' }}</title>

    <link rel="manifest" href="/manifest.json" />

    @vite('resources/css/app.css')

</head>

<body>
    <main class="w-full bg-no-repeat bg-cover bg-[rgba(0,0,0,.5)] bg-blend-darken bg-center"
        style="background-image: url('{{ asset('assets/images/authentication-bg.png') }}')">
        <div class="min-h-screen max-w-xl container mx-auto">
            {{ $slot }}
        </div>
    </main>
    {{-- Flowbite --}}
    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>
    <script>
        initFlowbite()
    </script>
</body>

</html>
