<div x-data="{ distance: { range: 0, refresh_at: '' }, full_map: false }" @set_full_map.window.camel="full_map = $event.detail.state, toggleMapInteractivity(full_map)"
    @set_distance.window.camel="distance = $event.detail">
    {{-- Header --}}
    <nav class="relative w-full">
        <img src="{{ asset('assets/images/navbar.svg') }}"
            class="absolute left-0 top-0 md:-top-14 w-full object-cover h-28 md:h-44 z-10" alt="">
        <div class="relative z-20 px-4 sm:px-12 py-4 flex justify-between items-center">
            <div class="flex gap-3 flex-grow">
                <div
                    class="relative inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 overflow-hidden bg-gray-100 rounded-full border-2 border-ocean-50">
                    {{-- <span class="font-bold text-base sm:text-2xl text-gray-600">SH</span> --}}
                    <img class="object-cover h-full w-full"
                        src="{{ $employee->image ? API_storage($employee->image) : API_storage($company->image) }}"
                        alt="">
                </div>
                <div class="flex flex-col">
                    <p class="text-sm sm:text-base font-light">Selamat Datang,</p>
                    <p class="sm:text-lg font-semibold line-clamp-1">{{ $employee->full_name }}</p>
                </div>
            </div>
            <div>
                <div
                    class="relative hover-opacity-down rounded bg-ocean-500 text-white h-9 w-9 flex items-center justify-center">
                    <span
                        class="absolute -right-2 -top-2 bg-cinnabar-500 rounded w-6 h-6 text-xs p-1 flex items-center justify-center">10</span>
                    <i class="bi bi-bell text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

    </nav>
    {{-- End Header --}}
    <div class="mx-auto py-8 px-4 sm:px-12 text-all-wide">
        <div class="relative mb-5 p-4 min-h-48 rounded bg-gradient-ocean shadow">
            <img src="{{ API_storage($company->image) }}" class="absolute top-4 right-4 h-12" alt="">
            <div class="flex flex-col text-white">
                <div class="flex items-center gap-2 w-3/5">
                    <i class="bi bi-person-fill opacity-70 -ml-[2px] mr-[2px]"></i>
                    <span class="font-light text-sm md:text-base line-clamp-1">{{ $employee->full_name }}</span>
                </div>
                <div class="flex items-center gap-2 w-3/5">
                    <i
                        class="bi bi-circle-fill text-xs mr-1 {{ $employee->status == 'active' ? 'text-green-300' : '' }}"></i>
                    <span
                        class="font-light text-sm md:text-base line-clamp-1">{{ employee_status($employee->status) }}</span>
                </div>
                <div class="flex items-center justify-center mt-2 gap-2 mb-2">
                    <span
                        class="font-semibold text-sm md:text-base lg:text-lg">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                <div class="my-2 tracking-wide-all">
                    <div class="bg-ocean-700/40 rounded flex justify-around py-4 px-1 sm:py-6">
                        {{-- If its Vacation --}}
                        @if ($VACATION)
                            <div class="w-2/3 text-center mx-auto">
                                <p class="font-bold text-base xs:text-2xl md:text-3xl">Cuti</p>
                                <p class=" text-xs xs:text-base font-light">Kamu tidak perlu mengecek aplikasi selama
                                    masa cuti. Selamat menikmati hari cutimu :)
                                </p>
                            </div>
                            {{-- If its Holiday --}}
                        @elseif ($HOLIDAY)
                            <div class="w-2/3 text-center mx-auto">
                                <p class="font-bold text-base xs:text-2xl md:text-3xl">Libur Bersama</p>
                                <p class=" text-xs xs:text-base font-light">Kantormu menetapkan hari ini
                                    sebagai hari libur bersama "<span
                                        class="font-bold !opacity-100">{{ $HOLIDAY->name }}</span>", harap hubungi
                                    pihak terkait
                                    jika ada jam kerja di hari ini :)
                                </p>
                            </div>
                            {{-- If its day off of work --}}
                        @elseif ($DAY_OFF)
                            <div class="w-2/3 text-center mx-auto">
                                <p class="font-bold text-base xs:text-2xl md:text-3xl">Libur Kantor</p>
                                <p class=" text-xs xs:text-base font-light">Kantormu menetapkan hari ini
                                    sebagai hari libur kerja, harap hubungi pihak terkait jika ada jam kerja di hari ini
                                    :)
                                </p>
                            </div>
                            {{-- If its working day --}}
                        @else
                            {{-- If its attendance type are not kosong or sesuai, related to database, this is for checking if the employee are sick, absence or other --}}
                            @if (!in_array($today->type->name, ['kosong', 'sesuai', 'terlambat']))
                                <div class="w-full text-center mx-auto">
                                    <p class="opacity-70 text-base xs:text-xl md:text-2xl font-light">Tidak Hadir</p>
                                    <p class="font-bold text-base xs:text-2xl md:text-3xl">
                                        {{ ucfirst($today->type->name) }}</p>
                                </div>
                            @else
                                <div class="w-1/2 text-center mx-auto">
                                    <p class="opacity-70 text-base xs:text-xl md:text-2xl font-light">Clock In</p>
                                    <p class="font-bold text-base xs:text-2xl md:text-3xl">
                                        {{ $today->clock_in ? $today->clock_in : '-' }}</p>
                                </div>
                                <div class="w-[1px] border"></div>
                                <div class="w-1/2 text-center mx-auto">
                                    <p class="opacity-70 text-base xs:text-xl md:text-2xl font-light">Clock Out</p>
                                    <p class="font-bold text-base xs:text-2xl md:text-3xl">
                                        {{ $today->clock_out ? $today->clock_out : '-' }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="flex justify-center items-center gap-2">
                    <i class="bi bi-building-fill opacity-70"></i>
                    <span class="font-bold text-sm md:text-base line-clamp-1">{{ $company->ltd }}
                        ({{ $office->type }})</span>
                </div>
                <div class="flex justify-center gap-3 -ml-[2px]">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-brightness-alt-high-fill opacity-70"></i>
                        <span
                            class="font-light text-sm md:text-base">{{ \Carbon\Carbon::parse($office->clock_in)->isoFormat('HH:mm') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-moon-fill opacity-70 text-xs"></i>
                        <span
                            class="font-light text-sm md:text-base">{{ \Carbon\Carbon::parse($office->clock_out)->isoFormat('HH:mm') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-pin-map-fill opacity-70 text-xs"></i>
                        <span class="font-light text-sm md:text-base">{{ $office->radius }} m</span>
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
                    class="absolute text-white text-center left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-[999] hidden group-hover:block">
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
        <div class="mb-3 flex items-center gap-3 text-gray-500">
            <i class="bi bi-info-circle"></i>
            <span class="text-sm leading-tight">Gunakan <span class="italic font-bold">perangkat yang dilengkapi
                    GPS</span>
                untuk
                meningkatkan akurasi posisi.</span>
        </div>
        <div class="flex justify-between text-ocean-950/80 mb-2">
            <p class="font-bold text-base sm:text-xl">Aksi Lainnya</p>
            {{-- <a href="/history" class="font-light text-base sm:text-xl hover-opacity-down">Lihat semua</a> --}}
        </div>
        <div id="swiper-actions" class="swiper mb-2">
            <div class="swiper-wrapper">
                <div x-on:click="navigateToUrl('/vacation')"
                    class="swiper-slide p-4 text-sm text-ocean-800 border border-ocean-300 shadow rounded bg-gradient-ocean-soft h-20 text-center cursor-pointer hover:opacity-70">
                    <i class="bi bi-airplane-fill text-xl sm:text-2xl opacity-70"></i>
                    <p class="font-light text-xs xs:text-base">Ajukan Cuti</p>
                </div>
                <div
                    class="swiper-slide p-4 text-sm text-ocean-800 border border-ocean-300 shadow rounded bg-gradient-ocean-soft h-20 text-center opacity-50">
                    <i class="bi bi-info-circle-fill text-xl sm:text-2xl opacity-70"></i>
                    <p class="font-light text-xs xs:text-base">Soon</p>
                </div>
                <div
                    class="swiper-slide p-4 text-sm text-ocean-800 border border-ocean-300 shadow rounded bg-gradient-ocean-soft h-20 text-center opacity-50">
                    <i class="bi bi-info-circle-fill text-xl sm:text-2xl opacity-70"></i>
                    <p class="font-light text-xs xs:text-base">Soon</p>
                </div>
                <div
                    class="swiper-slide p-4 text-sm text-ocean-800 border border-ocean-300 shadow rounded bg-gradient-ocean-soft h-20 text-center opacity-50">
                    <i class="bi bi-info-circle-fill text-xl sm:text-2xl opacity-70"></i>
                    <p class="font-light text-xs xs:text-base">Soon</p>
                </div>
            </div>
        </div>
        <div class="flex justify-between text-ocean-950/80 mb-2">
            <p class="font-bold text-base sm:text-xl">Histori Kehadiran</p>
            {{-- <a href="/history" class="font-light text-base sm:text-xl hover-opacity-down">Lihat semua</a> --}}
        </div>
        <div class="relative flex justify-between items-center mb-5 p-4 text-white rounded bg-gradient-ocean">
            <div class="flex flex-col justify-center gap-1">
                <p class="font-light text-base xs:text-lg">Bulan ini</p>
                <p class="font-bold text-xl xs:text-3xl">Sebanyak {{ $total_attend }}</p>
                <p class="font-light text-base xs:text-lg">kehadiran dari total <span
                        class="font-bold">{{ $total_this_month }}</span> hari
                    kerja</p>
            </div>
            <a wire:navigate href="/history" class="hover:opacity-70 flex items-center">
                <i class="bi bi-chevron-double-right text-xl"></i>
            </a>
        </div>
        <div class="relative mb-5">
            <div class="flex flex-col gap-3">
                @foreach ($attendances as $attendance)
                    <div class="p-4 text-sm text-ocean-800 border border-ocean-300 rounded bg-gradient-ocean-soft">
                        <span class="sr-only">Info</span>
                        <div class="flex items-center justify-between">
                            <div class="rounded flex gap-3 sm:gap-7 px-1">
                                {{-- If absence --}}
                                @if (!in_array($attendance->type->name, ['kosong', 'sesuai']))
                                    <div class="w-full text-center mx-auto">
                                        <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Tidak Hadir
                                        </p>
                                        <p class="font-bold text-xs sm:text-base">
                                            {{ ucfirst($attendance->type->name) }}
                                        </p>
                                    </div>
                                @else
                                    {{-- If present --}}
                                    <div class="w-1/2 text-center mx-auto">
                                        <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Clock
                                            In</p>
                                        <p class="font-bold text-xs sm:text-base">
                                            {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->isoFormat('HH:mm:ss') : '-' }}
                                        </p>
                                    </div>
                                    <div class="w-[1px] border"></div>
                                    <div class="w-1/2 text-center mx-auto">
                                        <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Clock
                                            Out</p>
                                        <p class="font-bold text-xs sm:text-base">
                                            {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->isoFormat('HH:mm:ss') : '-' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-xl sm:text-3xl font-bold">
                                    {{ \Carbon\Carbon::parse($attendance->date)->isoFormat('DD') }}</p>
                                <p class="text-xs sm:text-base text-gray-500">
                                    {{ \Carbon\Carbon::parse($attendance->date)->isoFormat('MMM YYYY') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script data-navigate-once>
        window.navigateToUrl = function(url) {
            Livewire.navigate(url);
        }
        if (typeof autoSnap == 'undefined') {
            let office
            let officeRadius
            let autoSnap
            let geopt
        }
        office = [{{ $office->lat }}, {{ $office->lon }}];
        officeRadius = {{ $office->radius }};
        autoSnap = true
        geopt = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        };
        const refreshLocationHome = () => {
            navigator.geolocation.getCurrentPosition((e) => {
                latlong = [e.coords.latitude, e.coords.longitude]
                if (userMarker != null) {
                    map.removeLayer(userMarker);
                }
                if (officeIconMarker != null) {
                    map.removeLayer(officeIconMarker);
                }
                if (userPolyline != null) {
                    map.removeLayer(userPolyline);
                }
                // Create a new marker at the user's location
                userMarker = L.marker(latlong, {
                    icon: userIcon,
                }).addTo(map);
                officeIconMarker = L.marker(office, {
                    icon: officeIcon,
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
                        fillOpacity: 0.2,
                        radius: officeRadius,
                    }).addTo(map);
                } else {
                    officeMarker = L.circle(office, {
                        color: "red",
                        fillColor: "#f03",
                        fillOpacity: 0.2,
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
                refreshLocationHome()
            }, 1500)
        }
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
    </script>

    <script src="{{ asset('assets/js/home-initiate-dom.js') }}"></script>
@endpush
