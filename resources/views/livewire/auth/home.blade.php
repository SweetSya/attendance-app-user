<div x-data="{ distance: { range: 0, refresh_at: '' }, full_map: false }" @set_full_map.window.camel="full_map = $event.detail.state, toggleMapInteractivity(full_map)"
    @set_distance.window.camel="distance = $event.detail">
    {{-- Header --}}
    <nav class="relative w-full">
        <img src="{{ asset('assets/images/navbar.svg') }}"
            class="absolute left-0 top-0 md:-top-14 w-full object-cover h-28 md:h-44 z-10" alt="">
        <div class="relative z-20 px-4 sm:px-12 py-4 flex justify-between items-center">
            <div class="flex gap-3 flex-grow">
                <div
                    class="relative inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 overflow-hidden bg-gray-100 rounded-full border-2 border-gray-300">
                    <span class="font-bold text-base sm:text-2xl text-gray-600">SH</span>
                </div>
                <div class="flex flex-col">
                    <p class="text-sm sm:text-base font-light">Selamat Datang,</p>
                    <p class="sm:text-lg font-semibold line-clamp-1">Sultan Hakim Herrysan</p>
                </div>
            </div>
            <div>
                <div
                    class="relative hover-opacity-down rounded-full bg-ocean-500 text-white h-9 w-9 flex items-center justify-center">
                    <span
                        class="absolute -right-2 -top-2 bg-cinnabar-500 rounded-full w-6 h-6 text-xs p-1 flex items-center justify-center">10</span>
                    <i class="bi bi-bell text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

    </nav>
    {{-- End Header --}}
    <div class="mx-auto py-8 px-4 sm:px-12 text-all-wide">
        <div class="relative mb-5 p-4 min-h-48 rounded bg-gradient-ocean shadow">
            <img src="{{ asset('logo.svg') }}" class="absolute top-4 right-4 w-28 xs:w-36 sm:w-48" alt="">
            <div class="flex flex-col text-white">
                <div class="flex items-center gap-2">
                    <i class="bi bi-person opacity-70"></i>
                    <span class="font-light text-sm sm:text-2xl">Karyawan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class=" opacity-70 font-light">ID</span>
                    <span class="font-bold text-lg xs:text-xl sm:text-3xl">1113060001</span>
                </div>
                <div class="my-2 tracking-wide-all">
                    <h3 class="text-end mb-2 text-xs xs:text-base md:text-lg">Kamis, <span class="font-semibold">12
                            Oktober 2024</span></h3>
                    <div class="bg-ocean-700/40 rounded flex justify-around py-4 px-1 sm:py-6">
                        <div class="w-1/2 text-center mx-auto">
                            <p class="opacity-70 text-xs xs:text-base font-light">08:30</p>
                            <p class="opacity-70 text-base xs:text-xl md:text-2xl font-light">Check In</p>
                            <p class="font-bold text-base xs:text-2xl md:text-3xl text-lime-400">08:29:12</p>
                        </div>
                        <div class="w-[1px] border"></div>
                        <div class="w-1/2 text-center mx-auto">
                            <p class="opacity-70 text-xs xs:text-base font-light">17:30</p>
                            <p class="opacity-70 text-base xs:text-xl md:text-2xl font-light">Check Out</p>
                            <p class="font-bold text-base xs:text-2xl md:text-3xl text-red-300">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 flex gap-2 text-ocean-800 mb-5">
            <div :class="distance.range <= officeRadius ? 'bg-gradient-ocean-soft' : 'bg-gradient-danger-soft'"
                class="relative flex flex-col justify-center gap-1 w-1/2 p-4 min-h-24 rounded shadow">
                <i class="bi bi-compass-fill absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                <p class="font-light text-base xs:text-lg">Jarakmu</p>
                <p class="font-bold text-xl xs:text-2xl sm:text-3xl"
                    x-text="distance.range == 0 ? 'Menghitung' : formatDistance(distance.range)">
                </p>
                <p class="font-light text-base xs:text-lg">Dari kantor</p>
            </div>
            <div @click="$dispatch('set_full_map', {state: true})"
                class="relative w-1/2 min-h-24 rounded bg-gradient-ocean cursor-pointer group shadow">
                <div :class="full_map ? '!hidden' : ''"
                    class="absolute text-white text-center left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20 hidden group-hover:block">
                    <i class="bi bi-fullscreen"></i>
                    <p class="text-nowrap">Layar penuh</p>
                </div>
                <div id="map"
                    :class="full_map ?
                        '!z-[999] !fixed container-center-max-3xl  min-h-72 !h-2/3' :
                        'group-hover:brightness-75'"
                    class="w-full h-full rounded border z-10 filter">
                </div>
            </div>
            <div @click="$dispatch('set_full_map', {state: false})" id="map-backdrop" :class="full_map ? '!block' : ''"
                class="hidden text-white fixed container-center-max-3xl  w-full h-screen bg-black/50 z-[998]">
                <div class="relative h-2/3 top-1/2 -translate-y-1/2">
                    <div @click="$dispatch('set_full_map', {state: false})"
                        class=" absolute z-[1000] -top-12 right-2 hover-opacity-down bg-gradient-ocean rounded px-3 py-2">
                        <i class="bi bi-x-lg"></i>
                        <span>Tutup</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="mb-5 flex items-center gap-3 text-gray-500">
            <i class="bi bi-emoji-smile"></i>
            <span class="text-sm leading-tight">Hari ini kamu hadir tepat waktu, jangan lupa untuk
                dipertahankan besok
                ya</span>
        </div> --}}
        <div class="mb-5 flex items-center gap-3 text-gray-500">
            <i class="bi bi-info-circle"></i>
            <span class="text-sm leading-tight">Gunakan <span class="italic">handphone & jaringan data</span> untuk
                meningkatkan akurasi posisi.</span>
        </div>
        <div class="relative mb-5 p-4 text-white rounded bg-gradient-ocean">
            <div class="flex flex-col justify-center gap-1">
                <p class="font-light text-base xs:text-lg">Bulan ini</p>
                <p class="font-bold text-xl xs:text-3xl">Sebanyak 22</p>
                <p class="font-light text-base xs:text-lg">kehadiran dari total <span class="font-bold">28</span> hari
                    kerja</p>
            </div>
        </div>
        <div class="relative mb-5">
            <div class="flex justify-between text-ocean-950 mb-2">
                <p class="font-bold text-base sm:text-xl">Histori Kehadiran</p>
                <a href="/history" class="font-light text-base sm:text-xl hover-opacity-down">Lihat semua</a>
            </div>
            <div class="flex flex-col gap-3">
                <div class="p-4 text-sm text-ocean-800 border border-ocean-300 rounded bg-gradient-ocean-soft">
                    <span class="sr-only">Info</span>
                    <div class="flex items-center justify-between">
                        <div class="rounded flex gap-3 sm:gap-7 px-1">
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check In</p>
                                <p class="font-bold text-xs sm:text-base">08:29:12</p>
                            </div>
                            <div class="w-[1px] border"></div>
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check Out</p>
                                <p class="font-bold text-xs sm:text-base">17:31:25</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl sm:text-3xl font-bold">31</p>
                            <p class="text-xs sm:text-base text-gray-500">Sep, 2024</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 text-sm text-ocean-800 border border-ocean-300 rounded bg-gradient-ocean-soft">
                    <span class="sr-only">Info</span>
                    <div class="flex items-center justify-between">
                        <div class="rounded flex gap-3 sm:gap-7 px-1">
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check In</p>
                                <p class="font-bold text-xs sm:text-base">08:29:12</p>
                            </div>
                            <div class="w-[1px] border"></div>
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check Out</p>
                                <p class="font-bold text-xs sm:text-base">17:31:25</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl sm:text-3xl font-bold">31</p>
                            <p class="text-xs sm:text-base text-gray-500">Sep, 2024</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 text-sm text-ocean-800 border border-ocean-300 rounded bg-gradient-ocean-soft">
                    <span class="sr-only">Info</span>
                    <div class="flex items-center justify-between">
                        <div class="rounded flex gap-3 sm:gap-7 px-1">
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check In</p>
                                <p class="font-bold text-xs sm:text-base">08:29:12</p>
                            </div>
                            <div class="w-[1px] border"></div>
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check Out</p>
                                <p class="font-bold text-xs sm:text-base">17:31:25</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl sm:text-3xl font-bold">31</p>
                            <p class="text-xs sm:text-base text-gray-500">Sep, 2024</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 text-sm text-ocean-800 border border-ocean-300 rounded bg-gradient-ocean-soft">
                    <span class="sr-only">Info</span>
                    <div class="flex items-center justify-between">
                        <div class="rounded flex gap-3 sm:gap-7 px-1">
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check In</p>
                                <p class="font-bold text-xs sm:text-base">08:29:12</p>
                            </div>
                            <div class="w-[1px] border"></div>
                            <div class="w-1/2 text-center mx-auto">
                                <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Check Out</p>
                                <p class="font-bold text-xs sm:text-base">17:31:25</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl sm:text-3xl font-bold">31</p>
                            <p class="text-xs sm:text-base text-gray-500">Sep, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        let office = [-6.255456838933905, 106.61991532354212];
        let officeRadius = 300;
        let autoSnap = true
    </script>
    <script src="{{ asset('assets/js/map.js') }}"></script>
    <script>
        const geopt = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        };
        const refreshLocation = () => {
            navigator.geolocation.getCurrentPosition((e) => {
                latlong = [e.coords.latitude, e.coords.longitude]
                if (userMarker != null) {
                    map.removeLayer(userMarker);
                }
                if (userPolyline != null) {
                    map.removeLayer(userPolyline);
                }
                // Create a new marker at the user's location
                userMarker = L.marker(latlong, {
                    icon: userIcon,
                }).addTo(map);
                userPolyline = L.polyline([latlong, office], {
                    color: "#30beff ",
                }).addTo(map);
                if (autoSnap) {
                    let bounds = map.fitBounds([latlong, office], {
                        maxZoom: 15
                    });
                }
                distance = getDistance(latlong, office);
                if (officeMarker != null) {
                    map.removeLayer(officeMarker);
                }
                if (distance <= officeRadius) {
                    officeMarker = L.circle(office, {
                        color: "green",
                        fillColor: "#00ff61",
                        fillOpacity: 0.5,
                        radius: officeRadius,
                    }).addTo(map);
                } else {
                    officeMarker = L.circle(office, {
                        color: "red",
                        fillColor: "#f03",
                        fillOpacity: 0.5,
                        radius: officeRadius,
                    }).addTo(map);
                }
                dispatchEvent(
                    new CustomEvent("set_distance", {
                        detail: {
                            range: distance,
                            refresh_at: new Date().toLocaleTimeString(),
                        },
                    })
                );
            }, (e) => {

            }, geopt);
            setTimeout(() => {
                refreshLocation()
            }, 1500)
        }
        refreshLocation()
        const toggleMapInteractivity = (bool) => {
            if (bool) {
                map._handlers.forEach(function(handler) {
                    handler.enable();
                });
                setTimeout(() => {
                    map.invalidateSize();
                }, 100)
                autoSnap = false
            } else {
                map._handlers.forEach(function(handler) {
                    handler.disable();
                });
                setTimeout(() => {
                    map.invalidateSize();
                }, 100)
                autoSnap = true
            }
        }
        toggleMapInteractivity(false)
    </script>
@endpush
