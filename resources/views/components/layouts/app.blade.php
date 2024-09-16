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
                <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium">
                    <a href="/home"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'home' ? 'bi-house-door-fill' : 'bi-house-door' }} text-xl {{ $route == 'home' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ $route == 'home' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Beranda</span>
                    </a>
                    <a href="/attendance"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'attendance' ? 'bi-fingerprint' : 'bi-fingerprint' }} text-xl {{ $route == 'attendance' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ $route == 'attendance' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Absensi</span>
                    </a>
                    <a href="/settings"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'settings' ? 'bi-gear-fill' : 'bi-gear' }} text-xl {{ $route == 'settings' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ $route == 'settings' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Pengaturan</span>
                    </a>
                    <span x-data="" @click="LogoutConfirmationDrawer.show()"
                        class="cursor-pointer inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ $route == 'logout' ? 'bi-box-arrow-right' : 'bi-box-arrow-right' }} text-xl {{ $route == 'logout' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ $route == 'logout' ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Keluar</span>
                    </span>
                </div>
            </div>
            {{-- End Footer --}}
            <div id="logout-confirmation"
                class="fixed bottom-0 !left-1/2 max-w-3xl !-translate-x-1/2 z-50 w-full p-4 overflow-y-auto transition-transform bg-white translate-y-full"
                tabindex="-1" aria-labelledby="drawer-bottom-label" aria-hidden="true">
                <h5 id="drawer-bottom-label"
                    class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
                    <i class="bi bi-question-circle-fill mr-3"></i><span>Keluar</span>
                </h5>
                <button data-drawer-hide="logout-confirmation" aria-controls="logout-confirmation" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <i class="bi bi-x-lg"></i>
                    <span class="sr-only">Close menu</span>
                </button>
                <div class="mb-4">
                    <p class="mb-3 font-bold text-xl sm:text-2xl text-ocean-700">Ingin keluar?</p>
                    <p class="mb-6 text-base sm:text-lg text-gray-500">Pastikan kamu sudah selesai ya, dan
                        selamat berkativitas :)</p>
                    <a href="/" class="flex justify-center w-full btn btn-outline-ocean py-3">
                       Ya, Checkout sekarang
                    </a>
                </div>
            </div>
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
