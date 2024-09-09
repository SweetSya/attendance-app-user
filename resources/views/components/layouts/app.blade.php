<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite('resources/css/app.css')

</head>

<body>
    <main x-data="{ hamburger: false }" class="w-full bg-no-repeat bg-cover bg-[rgba(0,0,0,.5)] bg-blend-darken bg-center"
        style="background-image: url('{{ asset('assets/images/authentication-bg.png') }}')"
        @toggle_hamburger.window.camel="hamburger = ! hamburger">
        {{-- Drawer hamburger --}}
        <div id="drawer-hamburger"
            class="fixed top-0 right-0 z-40 h-screen py-4 overflow-y-auto transition-transform translate-x-full bg-white w-full sm:w-96"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <div class="text-center">
                <h5 id="drawer-right-label"
                    class="inline-flex items-center mb-4 text-xl font-semibold text-gray-500 dark:text-gray-400">
                    Pengaturan
                </h5>
            </div>
            <button type="button" data-drawer-hide="drawer-hamburger" aria-controls="drawer-hamburger"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-3.5 start-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <i class="bi bi-chevron-left"></i>
            </button>
            <ul class="w-full flex flex-col px-4 border-b-4">
                <li class="mt-3 mx-2 font-normal text-gray-500">Akun</li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-envelope text-ocean-500 mr-4"></i>Email
                    </div>
                </li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-person-vcard text-ocean-500 mr-4"></i>Data Diri
                    </div>
                </li>
            </ul>
            <ul class="w-full flex flex-col px-4 border-b-4">
                <li class="mt-3 mx-2 font-normal text-gray-500">Absensi & Keamanan</li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-person-bounding-box text-ocean-500 mr-4"></i>Biometrik Wajah
                    </div>
                </li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-align-start text-ocean-500 mr-4"></i>PIN
                    </div>
                </li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-lock text-ocean-500 mr-4"></i>Password
                    </div>
                </li>
            </ul>
            <ul class="w-full flex flex-col px-4 border-b-4">
                <li class="mt-3 mx-2 font-normal text-gray-500">Perangkat</li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-key text-ocean-500 mr-4"></i>UUID
                    </div>
                </li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-bell text-ocean-500 mr-4"></i>Push Notifikasi
                    </div>
                </li>
            </ul>
            <ul class="w-full flex flex-col px-4 border-b-4">
                <li class="mt-3 mx-2 font-normal text-gray-500">Informasi</li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-question-circle text-ocean-500 mr-4"></i>FAQ
                    </div>
                </li>
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-gray-700">
                        <i class="bi bi-person-workspace text-ocean-500 mr-4"></i>Bantuan Developer
                    </div>
                </li>
            </ul>
            <ul class="w-full flex flex-col px-4">
                <li class="border-b py-4 px-3 hover-ocean-300">
                    <div class="font-semibold text-cinnabar-500">
                        <i class="bi bi-box-arrow-right  mr-4"></i>Log Out
                    </div>
                </li>
            </ul>
        </div>
        {{-- Drawer hamburger end --}}

        <div class=" min-h-screen max-w-3xl container mx-auto border-x bg-white">
            {{-- Header --}}
            <nav class="relative w-full">
                <img src="{{ asset('assets/images/navbar.svg') }}"
                    class="absolute left-0 top-0 md:-top-14 w-full object-cover h-28 md:h-36 z-10" alt="">
                <div class="relative z-20 p-4 flex justify-between">
                    <div class="flex gap-3 flex-grow">
                        <div
                            class="relative inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-gray-100 rounded-full border-2 border-gray-300">
                            <span class="font-medium text-gray-600">SH</span>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm font-light">Selamat Datang,</p>
                            <p class="font-semibold line-clamp-1">Sultan Hakim Herrysan</p>
                        </div>
                    </div>
                    {{-- Hamburger --}}
                    <div>
                        <button class="text-gray-500 w-10 h-10 relative"
                            @click="hamburger ? humbergerDrawer.hide() : hamburgerDrawer.show()">
                            <div
                                class="block w-5 absolute left-1/2 top-1/2   transform  -translate-x-1/2 -translate-y-1/2">
                                <span aria-hidden="true"
                                    class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out"
                                    :class="{ 'rotate-45': hamburger, ' -translate-y-1.5': !hamburger }"></span>
                                <span aria-hidden="true"
                                    class="block absolute  h-0.5 w-5 bg-current   transform transition duration-500 ease-in-out"
                                    :class="{ 'opacity-0': hamburger }"></span>
                                <span aria-hidden="true"
                                    class="block absolute  h-0.5 w-5 bg-current transform  transition duration-500 ease-in-out"
                                    :class="{ '-rotate-45': hamburger, ' translate-y-1.5': !hamburger }"></span>
                            </div>
                        </button>
                    </div>
                    {{-- End Hamburger --}}
                </div>

            </nav>
            {{-- End Header --}}
            {{ $slot }}
            {{-- Footer --}}

            {{-- End Footer --}}
        </div>
    </main>
    {{-- Flowbite --}}
    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>
    <script src="{{ asset('assets/js/layout.js') }}"></script>

</body>

</html>
