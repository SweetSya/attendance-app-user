<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite('resources/css/app.css')

    <link rel="manifest" href="/manifest.json" />

    {{-- LeafletJS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    
</head>

<body>

    <?php
    $route = Route::currentRouteName();
    ?>

    <main class="w-full bg-no-repeat bg-cover bg-[rgba(0,0,0,.5)] bg-blend-darken bg-center bg-fixed">
        {{-- Drawer hamburger --}}
        <div class="min-h-screen max-w-3xl container mx-auto border-x bg-white">

            <div class="pb-10">
                {{ $slot }}
            </div>

            <div class="fixed container-bottom-max-3xl z-40 w-full h-16 bg-white border-t border-gray-200">
                <div class="grid h-full max-w-lg grid-cols-3 mx-auto font-medium">
                    <a href="/home"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'home' ? 'bi-house-door-fill' : 'bi-house-door' }} text-xl {{ $route == 'home' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-sm {{ $route == 'home' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Beranda</span>
                    </a>
                    <a href="/attendance"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'attendance' ? 'bi-fingerprint' : 'bi-fingerprint' }} text-xl {{ $route == 'attendance' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-sm {{ $route == 'attendance' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Absensi</span>
                    </a>
                    <a href="/settings"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'settings' ? 'bi-gear-fill' : 'bi-gear' }} text-xl {{ $route == 'settings' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-sm {{ $route == 'settings' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Pengaturan</span>
                    </a>
                </div>
            </div>

            {{-- End Footer --}}
        </div>
    </main>

    {{-- Flowbite --}}
    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <script src="{{ asset('assets/js/media-device.js') }}"></script>
    <script src="{{ asset('assets/js/alpine-extend.js') }}"></script>
    {{-- LeafletJS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @stack('scripts')
    <script>
        initFlowbite()
    </script>
</body>

</html>
