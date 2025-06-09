<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite('resources/css/app.css')

    <link rel="manifest" href="/manifest.json" />
    {{-- Loading --}}
    <link rel="stylesheet" href="{{ asset('assets\css\loading.css') }}">
    {{-- Lightpick --}}
    <link rel="stylesheet" href="{{ asset('assets\css\lightpick.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('build\assets\app-Dqu-JKAo.css') }}"> --}}
    {{-- Notfys --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    {{-- LeafletJS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    {{-- SwiperJS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>

<body class="overflow-x-hidden overscroll-y-none">

    <?php
    $route = Route::currentRouteName();
    ?>

    <main class="w-full bg-no-repeat bg-cover bg-black/50 bg-blend-darken bg-center bg-fixed">
        {{-- Drawer hamburger --}}
        <div class="min-h-screen max-w-3xl container mx-auto bg-white overflow-hidden">
            <div x-data="" id="wrapper-click-to-refresh"
                class="hidden fixed top-0 h-0 max-w-3xl z-40 w-full bg-white">
                <button @click="clickToRefresh()" id="click-to-refresh"
                    class="bg-white px-1.5 py-1 ml-2 md:-ml-10 mt-1 rounded border-2 text-xs border-ocean-500 text-ocean-500">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
            <div id="main-page" class="pb-10">
                {{ $slot }}
            </div>

            <div class="fixed container-bottom-max-3xl z-40 w-full h-16 bg-white border-t border-gray-200">
                <div class="relative grid h-full max-w-lg grid-cols-4 mx-auto font-medium">
                    <a wire:navigate href="/home"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ in_array('home', explode('/', $route)) ? 'bi-house-door-fill' : 'bi-house-door' }} text-xl {{ in_array('home', explode('/', $route)) ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ in_array('home', explode('/', $route)) ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Beranda</span>
                    </a>
                    <a wire:navigate href="/attendance"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ in_array('attendance', explode('/', $route)) ? 'bi-fingerprint' : 'bi-fingerprint' }} text-xl {{ in_array('attendance', explode('/', $route)) ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ in_array('attendance', explode('/', $route)) ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Presensi</span>
                    </a>
                    <a wire:navigate href="/settings"
                        class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group">
                        <i
                            class="bi {{ in_array('settings', explode('/', $route)) ? 'bi-gear-fill' : 'bi-gear' }} text-xl {{ in_array('settings', explode('/', $route)) ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}"></i>
                        <span
                            class="text-xs xs:text-sm {{ in_array('settings', explode('/', $route)) ? 'text-ocean-600' : 'text-gray-500 group-hover:text-ocean-600' }}">Pengaturan</span>
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
            @persist('logout')
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
                    <form class="mb-4" action="/logout" method="POST">
                        @csrf
                        <p class="mb-3 font-bold text-xl sm:text-2xl text-ocean-700">Ingin keluar?</p>
                        <p class="mb-6 text-base sm:text-lg text-gray-500">Pastikan kamu sudah selesai ya, dan
                            selamat beraktivitas :)</p>
                        <div class="flex items-center mb-4">
                            <input id="wipe-session" type="checkbox" name="wipe_session" value=""
                                class="w-4 h-4 rounded bg-glass border-white focus:ring-0 accent-ocean-600">
                            <label for="wipe-session" class="ms-2 text-base sm:text-lg font-medium text-ocean-600">Hapus
                                seluruh ingatan pada
                                perangkat</label>
                        </div>
                        <button type="submit" class="flex justify-center w-full btn btn-outline-ocean py-3">
                            Ya, Keluar sekarang
                        </button>
                    </form>
                </div>
            @endpersist
        </div>
        {{-- Screen Laoding --}}
        @persist('loading')
            <div id="loading-screen"
                class="loading flex fixed z-[35] top-0 left-1/2 -translate-x-1/2 w-screen h-screen max-w-3xl justify-center items-center flex-col bg-white animate__animated">
                <div class="loader"></div>
                <p class="mt-4 text-ocean-600">Memuat..</p>
                {{-- <p class=" text-ocean-600">Harap tunggu sesaat</p>

            <p class="absolute bottom-2 text-gray-600">Teralalu lama? <button
                    class="refresh-when-loading text-ocean-600 underline">refresh
                    disini</button></p> --}}
            </div>
        @endpersist

    </main>
    {{-- <script src="{{ asset('build\assets\app-DdQ1e7RN.js') }}"></script> --}}
    {{-- Notfy --}}
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    {{-- Flowbite --}}
    <script data-navigate-once src="{{ asset('assets/js/flowbite.min.js') }}"></script>
    {{-- SwiperJS --}}
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- Layouting --}}
    <script data-navigate-once src="{{ asset('assets/js/layout.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/js/media-device.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/js/alpine-extend.js') }}"></script>
    {{-- Toastr --}}
    <script data-navigate-once src="{{ asset('assets/vendor/toastrjs/toastr.min.js') }}"></script>
    {{-- Moment --}}
    <script data-navigate-once src="{{ asset('assets/vendor/momentjs/moment-with-locales.min.js') }}"></script>
    {{-- Lightpick --}}
    <script data-navigate-once src="{{ asset('assets/vendor/lightpick/lightpick.js') }}"></script>
    {{-- LeafletJS --}}
    <script data-navigate-once src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- Touch emulator --}}
    <script src="//unpkg.com/hammer-touchemulator@0.0.2/touch-emulator.js"></script>
    {{-- Pull to refresh --}}
    <script data-navigate-once src="{{ asset('assets/vendor/pull-to-refresh/index.umd.min.js') }}"></script>

    <script data-navigate-once>
        navigator.serviceWorker.register("/sw.js", {
            scope: "/",
        });
        // Set locale for Moment.js
        moment.locale('id');

        let sendNotfy;
        let clickToRefresh;
        let isMobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent
            .match(/iPad/i) ? true : false;
        if (!isMobile) {
            const clickToRefreshElement = document.getElementById('click-to-refresh');
            // Initialize the clikk to refresh element
            let topScrollY = 40;
            window.addEventListener('scroll', (e) => {
                if (clickToRefreshElement) {

                }
            });
        }
        // Loading Handler
        const loadingWrapper = document.querySelector('.loading')
        // document.querySelector('.refresh-when-loading').addEventListener('click', () => {
        //     location.reload();
        // })
        const toogleLoadingState = (state = true) => {
            if (state) {
                document.body.classList.add('pointer-events-none', 'overflow-hidden')
                loadingWrapper.classList.remove('hidden');
                loadingWrapper.classList.add('flex');

            } else {
                document.body.classList.remove('pointer-events-none', 'overflow-hidden')
                loadingWrapper.classList.remove('flex');
                loadingWrapper.classList.add('hidden');
            }
        }
        document.addEventListener('livewire:navigate', (event) => {
            const loadingPage = document.getElementById('loading-screen');
            if (loadingPage) {
                // Remove previous animation classes
                loadingPage.classList.remove('animate__fadeOut', 'animate__faster'); // or any previous class
                // Force reflow (restart animation)
                void loadingPage.offsetWidth;
                // Add desired animation
                loadingPage.classList.add('animate__fadeIn', 'animate__faster');
            }
            toogleLoadingState(true)
        })
        document.addEventListener('livewire:navigating', () => {})
        document.addEventListener('livewire:navigated', () => {
            const loadingPage = document.getElementById('loading-screen');
            if (loadingPage) {
                // Remove previous animation classes
                loadingPage.classList.remove('animate__fadeIn', 'animate__faster'); // or any previous class
                // Force reflow (restart animation)
                void loadingPage.offsetWidth;
                // Add desired animation
                loadingPage.classList.add('animate__fadeOut', 'animate__faster');
            }
            initFlowbite()
            setTimeout(() => {

                toogleLoadingState(false)
            }, 500);
        })
        document.addEventListener('livewire:init', () => {
            Livewire.on('invalidate-force-logout', (payload) => {
                window.location.href = '/?force-logout=true&message=' + encodeURIComponent(payload.message);
            });
            Livewire.on('notify', (payload) => {
                sendNotfy.dismissAll()
                let notification
                switch (payload.type) {
                    case 'success':
                        notification = sendNotfy.success(payload.message);
                        break;
                    case 'error':
                        notification = sendNotfy.error(payload.message)
                        break;
                    case 'info':
                        notification = sendNotfy.open({
                            type: 'info',
                            message: payload.message
                        });
                        break;
                    default:
                        notification = sendNotfy.open({
                            type: 'default',
                            message: 'Something went wrong'
                        });
                        break;
                }
                notification.on('click', ({
                    target,
                    event
                }) => {
                    sendNotfy.dismiss(notification);
                })
            });
        });

        // window.addEventListener('beforeunload', function(e) {
        //     // You can call a Livewire event or do something here
        //     console.log('Leaving the page');
        //     // If you want to show a confirmation dialog
        //     Livewire.dispatch('hard-refresh');
        // });
    </script>
    {{-- Run every time page changes --}}
    <script>
        sendNotfy = new Notyf({
            duration: 3000,
            position: {
                x: 'center',
                y: 'bottom',
            },
            types: [{
                type: 'info',
                className: 'bg-ocean-600',
                icon: false
            }, {
                type: 'default',
                className: 'bg-gray-600',
                icon: false
            }]
        });
        // check if user accesing from phone using user agent
        if (isMobile) {
            // Initialize Pull to Refresh
            const ptr = PullToRefresh.init({
                instructionsPullToRefresh: "Tarik untuk memperbarui",
                instructionsReleaseToRefresh: "Lepaskan untuk memperbarui",
                instructionsRefreshing: "Memuat...",
                mainElement: 'body',
                onRefresh() {
                    fetch('/add-session-page-refresh?name={{ $route }}', {
                        method: 'GET',
                    }).then(response => {
                        if (response.ok) {
                            sendNotfy.success('Halaman diperbarui');
                            setTimeout(() => {
                                Livewire.navigate('{{ url()->current() }}');
                            }, 100);
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    }).catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
                }
            });
        } else {
            document.querySelector('#wrapper-click-to-refresh').classList.remove('hidden');
            // If not mobile, just use a click to refresh
            clickToRefresh = () => {
                fetch('/add-session-page-refresh?name={{ $route }}', {
                    method: 'GET',
                }).then(response => {
                    if (response.ok) {
                        sendNotfy.success('Halaman akan direfresh');
                        setTimeout(() => {
                            Livewire.navigate('{{ url()->current() }}');
                        }, 100);
                    } else {
                        throw new Error('Network response was not ok');
                    }
                }).catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        }
    </script>
    {{-- Map --}}
    <script data-navigate-once src="{{ asset('assets/js/map.js') }}"></script>
    @stack('scripts')
</body>

</html>
