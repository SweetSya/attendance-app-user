<div id="data-wrapper" x-data="{ distance: { range: 0, refresh_at: '' }, drawer: { title: '', section: '' } }"
    @set_drawer.window.camel="drawer = $event.detail, drawerSection = $event.detail.section"
    @set_distance.window.camel="distance = $event.detail" class="text-all-wide">
    <div class="h-screen">
        <div class="fixed w-full max-w-3xl h-screen">
            <div id="map" class="h-full w-full bg-gradient-ocean-soft z-10">
            </div>
        </div>
    </div>
    <div class="relative min-h-64 -mt-32 z-20 mx-auto py-5 px-4 sm:px-12 bg-white">
        <div class="flex items-center justify-between mb-10 text-nowrap">
            <p class="font-bold text-base sm:text-xl text-ocean-500">Absensi Kehadiran</p>
            <p class="font-light text-xs sm:text-base text-ocean-900/70">Selengkapnya <i
                    class="bi bi-chevron-double-down"></i></p>
        </div>
        <div class="flex justify-between gap-2 mb-4">
            <p class="">
                <span class="text-base sm:text-lg text-ocean-900/80 font-bold">27 Januari 2025,</span>
                <br>
                <span class="text-base sm:text-lg text-ocean-900/80 font-normal">Senin</span>
            </p>
            <div class="text-right">
                <p class="text-base sm:text-lg text-ocean-900/80 font-bold">1113060001</p>
                <p class="line-clamp-1 text-base sm:text-lg text-ocean-900/80">Sultan Hakim Herrysan</p>
            </div>
        </div>
        <div class="w-full flex gap-2 text-ocean-800 mb-3">
            <div :class="distance.range <= officeRadius ? 'bg-gradient-ocean-soft' : 'bg-gradient-danger-soft'"
                class="relative flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded">
                <i class="bi bi-compass-fill absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                <p class="font-light text-base xs:text-lg">Jarakmu</p>
                <p class="font-bold text-xl xs:text-2xl sm:text-3xl"
                    x-text="distance.range == 0 ? 'Menghitung' : formatDistance(distance.range)">
                </p>
                <p class="font-light text-base xs:text-lg">Dari kantor</p>
            </div>
        </div>
        <div class="mb-4 flex items-center gap-3 text-gray-500">
            <i class="bi bi-info-circle"></i>
            <span class="text-sm leading-tight">Harap dipersiapkan karena<span class="font-bold"> kamera akan
                    aktif</span> untuk melakukan check in.</span>
        </div>
        <div class="w-full flex gap-2 text-ocean-800 mb-5">
            <div
                class="relative flex flex-col justify-center gap-1 w-1/2 p-4 min-h-24 rounded bg-gradient-success-soft">
                <i class="bi bi-box-arrow-in-right absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                <p class="font-light text-base xs:text-lg">Check In</p>
                <p class="font-bold text-xl xs:text-2xl sm:text-3xl">10:16:11</p>
                <p class="font-light text-base xs:text-lg">dari 08:30</p>
            </div>
            <div
                class="relative flex flex-col justify-center gap-1 w-1/2 p-4 min-h-24 rounded bg-gradient-warning-soft">
                <i class="bi bi-box-arrow-right absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                <p class="font-light text-base xs:text-lg">Check Out</p>
                <p class="font-bold text-xl xs:text-2xl sm:text-3xl">-</p>
                <p class="font-light text-base xs:text-lg">dari 17.30</p>
            </div>
        </div>
        <div class="mb-5 flex flex-wrap gap-2">
            <button @click="openDrawer({title: 'Verifikasi Kehadiran', 'section': 'checkin'})"
                class="btn btn-outline-success flex-grow min-w-52 py-3">Check In</button>
            <button @click="openDrawer({title: 'Pengajuan Izin', 'section': 'absence'})"
                class="btn btn-outline-warning flex-grow min-w-52 py-3">Izin</button>
        </div>
    </div>
    {{-- Drawer --}}
    <!-- drawer component -->
    <div id="drawer-attendance"
        class="fixed bottom-0 !left-1/2 max-w-3xl !-translate-x-1/2 z-50 w-full p-4 overflow-y-auto transition-transform bg-white translate-y-full"
        tabindex="-1" aria-labelledby="drawer-bottom-label" aria-hidden="true">
        <h5 id="drawer-bottom-label"
            class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
            <i class="bi bi-question-circle-fill mr-3"></i><span x-text="drawer.title">Verifikasi</span>
        </h5>
        <button data-drawer-hide="drawer-attendance" aria-controls="drawer-attendance" type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
            <i class="bi bi-x-lg"></i>
            <span class="sr-only">Close menu</span>
        </button>
        <div x-show="drawer.section === 'checkin'">
            <p class="mb-6 text-base sm:text-xl text-gray-500 text-center">Verifikasi Biometrik Wajah</p>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center">Arahkan wajah di posisi dalam box untuk
                memudahkan pemindaian</span></p>
            <div class="mx-auto rounded border relative w-fit mb-4">
                <video muted autoplay id="verify-camera" class="max-h-96 rounded" src=""></video>
                <div class="absolute w-36 h-36 sm:w-52 sm:h-52 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="h-1/2 flex justify-between items-start">
                        <div class="w-8 h-8 sm:w-16 sm:h-16 border-t-4 border-l-4 border-white shadow-inner">

                        </div>
                        <div class="w-8 h-8 sm:w-16 sm:h-16 border-t-4 border-r-4 border-white shadow-inner">

                        </div>
                    </div>
                    <div class="h-1/2 flex justify-between items-end">
                        <div class="w-8 h-8 sm:w-16 sm:h-16 border-b-4 border-l-4 border-white shadow-inner">

                        </div>
                        <div class="w-8 h-8 sm:w-16 sm:h-16 border-b-4 border-r-4 border-white shadow-inner">

                        </div>
                    </div>
                </div>
            </div>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center"> Lanjutkan tanpa menggunakan verifikasi
                biometik? <span class="font-bold underline hover-opacity-down">ya, lanjutkan</span></p>
        </div>
        <div x-show="drawer.section === 'absence'" class="pb-5">
            <p class="mb-6 text-base text-gray-500 text-center">Harap diisi sesuai dengan keadaan yang sebenarnya yaa <i
                    class="bi bi-emoji-smile-fill ml-1"></i></p>
            <form @submit.prevent="console.log('x')" class="flex flex-col gap-3">
                <select id="countries"
                    class="font-semibold bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-ocean-500 focus:border-ocean-500 block w-full p-2.5">
                    <option class="font-semibold" value="">IZIN KARENA.. (PILIH)</option>
                    <option class="font-semibold" value="sick">SAKIT</option>
                    <option class="font-semibold" value="acara">ACARA</option>
                    <option class="font-semibold" value="others">LAINNYA</option>
                </select>
                <div>
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Tinggalkan pesan</label>
                    <textarea id="message" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500"
                        placeholder="Leave a comment..."></textarea>
                </div>
                <button type="submit" class="btn btn-ocean py-3">Kirimkan</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let office = [-6.255456838933905, 106.61991532354212];
        let officeRadius = 300;
        let autoSnap = true
        let drawerSection = ''
        var videoStream = document.querySelector('#verify-camera');
        videoStream.setAttribute('playsinline', '');

        /* Setting up the constraint */
        var facingMode = "user"; // Can be 'user' or 'environment' to access back or front camera
    </script>
    <script src="{{ asset('assets/js/map.js') }}"></script>
    <script src="{{ asset('assets/js/attendance.js') }}"></script>
@endpush
