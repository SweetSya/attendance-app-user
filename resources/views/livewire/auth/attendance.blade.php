<div id="data-wrapper" x-data="{ distance: { range: 0, refresh_at: '', position: [0, 0] }, drawer: { title: '', section: '' }, face: { scanning: false, last: '', height: '', loading: false, landmarker: false } }"
    @set_drawer.window.camel="drawer = $event.detail, drawerSection = $event.detail.section"
    @start_check_face.window.camel="face.height = document.querySelector('#verify-camera').clientHeight, face.loading = true, setTimeout(async () => {await $wire.clock_employee_face(JSON.stringify($event.detail.face), JSON.stringify(distance.position)), 1000})"
    @set_face_scanning.window.camel="$event.detail.scanning ? (face.scanning = true, face.last = $event.detail.last ?? '', face.loading = false) : (face.scanning = false, face.last = $event.detail.last ?? getBase64Face(), stopVideostream(), face.loading = false)"
    @set_distance.window.camel="distance = $event.detail"
    @set_landmarker.window.camel="face.landmarker = $event.detail.state" class="text-all-wide">
    <div wire:ignore class="h-screen">
        <div class="fixed w-full max-w-3xl h-screen">
            <div id="map" class="h-full w-full bg-gradient-ocean-soft z-10">
            </div>
        </div>
    </div>
    <div class="relative min-h-64 -mt-32 z-20 mx-auto py-5 px-4 sm:px-12 bg-white">
        <div class="flex items-center justify-between mb-10 text-nowrap">
            <p class="font-bold text-base sm:text-xl text-ocean-500">Kehadiran</p>
            <p class="font-light text-xs sm:text-base text-ocean-900/70">Selengkapnya <i
                    class="bi bi-chevron-double-down"></i></p>
        </div>
        <div class="flex justify-between gap-2 mb-4">
            <p class="">
                <span
                    class="text-base sm:text-lg text-ocean-900/80 font-bold">{{ \Carbon\Carbon::now()->isoFormat('DD MMMM YYYY') }},</span>
                <br>
                <span
                    class="text-base sm:text-lg text-ocean-900/80 font-normal">{{ \Carbon\Carbon::now()->isoFormat('dddd') }}</span>
            </p>
            <div class="text-right">
                <p class="text-base sm:text-lg text-ocean-900/80 font-bold">{{ $company->ltd }}</p>
                <p class="line-clamp-1 text-base sm:text-lg text-ocean-900/80">{{ $employee->full_name }}</p>
            </div>
        </div>
        <div class="w-full flex flex-col gap-2 text-ocean-800 mb-5">
            @if ($face_state == 0)
                <div class="w-full flex gap-2 text-ocean-800 mb-3">
                    <div
                        class="relative text-center flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded bg-gradient-warning-soft">
                        <p class="font-bold text-base xs:text-2xl md:text-3xl">Registrasi Biometrik</p>
                        <p class=" text-xs xs:text-base font-">Untuk melakukan presensi, kamu harus
                            melakukan registrasi biometrik wajah terlebih dahulu. Silakan <span
                                class="font-semibold">hubungi Administrasi</span> atau kunjungi
                            <a wire:navigate href="/settings/biometric-face" class="underline font-semibold">pengaturan
                                biometrik</a> untuk
                            melakukan
                            registrasi.
                        </p>
                    </div>
                </div>
            @elseif ($VACATION)
                <div class="w-full flex gap-2 text-ocean-800 mb-3">
                    <div
                        class="relative text-center flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded bg-gradient-ocean-soft">
                        <p class="font-bold text-base xs:text-2xl md:text-3xl">Cuti</p>
                        <p class=" text-xs xs:text-base font-">Kamu tidak perlu mengecek aplikasi selama
                            masa cuti. Selamat menikmati hari cutimu :)
                        </p>
                    </div>
                </div>
            @elseif ($HOLIDAY)
                <div class="w-full flex gap-2 text-ocean-800 mb-3">
                    <div
                        class="relative text-center flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded bg-gradient-ocean-soft">
                        <p class="font-bold text-base xs:text-2xl md:text-3xl">Libur Bersama</p>
                        <p class=" text-xs xs:text-base font-light">Kantormu menetapkan hari ini
                            sebagai hari libur bersama "<span
                                class="font-bold !opacity-100">{{ $HOLIDAY->name }}</span>",
                            harap hubungi
                            pihak terkait
                            jika ada jam kerja di hari ini :)
                        </p>
                    </div>
                </div>
            @elseif ($DAY_OFF)
                <div class="w-full flex gap-2 text-ocean-800 mb-3">
                    <div
                        class="relative text-center flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded bg-gradient-ocean-soft">
                        <p class="font-bold text-base xs:text-2xl md:text-3xl">Libur Kantor</p>
                        <p class=" text-xs xs:text-base font-">Kantormu menetapkan hari ini
                            sebagai hari libur kerja, harap hubungi pihak terkait jika ada jam kerja di hari ini
                            :)
                        </p>
                    </div>
                </div>
            @else
                {{-- If absence --}}
                @if (!in_array($today->type->name, ['kosong', 'sesuai']))
                    <div class="w-full flex gap-2 text-ocean-800 mb-3">
                        <div
                            class="relative text-center flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded bg-gradient-warning-soft">
                            <p class="font-bold text-base xs:text-2xl md:text-3xl">Tidak Hadir</p>
                            <p class=" text-xs xs:text-base font-">Kamu telah menetapkan hari ini tidak dapat hadir
                                dikarenakan <span class="font-bold">"{{ ucfirst($today->type->name) }}"</span>. Semoga
                                dapat bertemu di hari kerja
                                berikutnya :)
                            </p>
                        </div>
                    </div>
                @else
                    <div class="w-full flex gap-2 text-ocean-800 mb-3">
                        <div :class="distance.range <= officeRadius ? 'bg-gradient-ocean-soft' : 'bg-gradient-danger-soft'"
                            class="relative flex flex-col justify-center gap-1 w-full p-4 min-h-24 rounded">
                            <i class="bi bi-compass-fill absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                            <p class="font-light text-base xs:text-lg">Jarakmu</p>
                            <p class="font-bold text-xl xs:text-2xl sm:text-3xl"
                                x-text="distance.range == 0 ? 'Menghitung..' : formatDistance(distance.range)">
                            </p>
                            <p class="font-light text-base xs:text-lg">Dari kantor</p>
                        </div>
                    </div>
                    <div class="mb-4 flex items-center gap-3 text-gray-500">
                        <i class="bi bi-info-circle"></i>
                        <span class="text-sm leading-tight">Harap dipersiapkan karena<span class="font-bold"> kamera
                                akan
                                aktif</span> untuk melakukan clock in.</span>
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="relative flex flex-col justify-center gap-1 w-1/2 p-4 min-h-24 rounded bg-gradient-success-soft">
                            <i
                                class="bi bi-box-arrow-in-right absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                            <p class="font-light text-base xs:text-lg">Clock In</p>
                            <p class="font-bold text-xl xs:text-2xl sm:text-3xl">
                                {{ $today->clock_in ? $today->clock_in : '-' }}
                            </p>
                            <p class="font-light text-base xs:text-lg">dari
                                {{ \Carbon\Carbon::parse($office->clock_in)->isoFormat('HH:mm') }}</p>
                        </div>
                        <div
                            class="relative flex flex-col justify-center gap-1 w-1/2 p-4 min-h-24 rounded bg-gradient-warning-soft">
                            <i class="bi bi-box-arrow-right absolute right-2 top-2 text-2xl sm:text-4xl opacity-70"></i>
                            <p class="font-light text-base xs:text-lg">Clock Out</p>
                            <p class="font-bold text-xl xs:text-2xl sm:text-3xl">
                                {{ $today->clock_out ? $today->clock_out : '-' }}
                            </p>
                            <p class="font-light text-base xs:text-lg">dari
                                {{ \Carbon\Carbon::parse($office->clock_out)->isoFormat('HH:mm') }}</p>
                        </div>
                    </div>
                @endif
            @endif

        </div>
        <div class="mb-5 flex flex-wrap gap-2">
            @if (!$HOLIDAY && !$DAY_OFF && !$VACATION && $face_state != 0)
                @if (!$today->clock_in)
                    <button
                        :class="(distance.range >= officeRadius) && !face.landmarker ? 'pointer-events-none opacity-35' :
                            'pointer-events-auto opacity-100'"
                        @click="openDrawer({title: 'Verifikasi Kehadiran', 'section': 'checkin'})"
                        class="btn btn-outline-success flex-grow min-w-52 py-3">Clock In</button>
                @endif
                @if ($today->clock_in && !$today->clock_out)
                    <button @click="openDrawer({title: 'Verifikasi Clock Out', 'section': 'checkout'})"
                        class="btn btn-outline-ocean flex-grow min-w-52 py-3">Clock
                        Out</button>
                @endif

                @if (!$today->clock_in)
                    <button @click="openDrawer({title: 'Pengajuan Izin', 'section': 'absence'})"
                        class="btn btn-outline-warning flex-grow min-w-52 py-3">Izin</button>
                @endif

                @if ($today->clock_in && $today->clock_out)
                    <div class="mb-4 flex items-center gap-3 text-gray-500">
                        <i class="bi bi-check-circle"></i>
                        <div>
                            <p class="text-base sm:text-lg text-ocean-900/80 font-bold">Sudah selesai untuk hari ini.
                            </p>
                            <span class="text-sm leading-tight">Terima kasih untuk partisipasinya hari ini, selalu
                                semangat
                                dan
                                sampai jumpa di hari kerja berikutnya!
                                :)</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    {{-- Drawer --}}
    <!-- drawer component -->
    <div wire:ignore id="drawer-attendance"
        class="fixed bottom-0 !left-1/2 max-w-3xl !-translate-x-1/2 z-50 w-full p-4 overflow-y-auto transition-transform bg-white translate-y-full"
        tabindex="-1" aria-labelledby="drawer-bottom-label" aria-hidden="true">
        <h5 id="drawer-bottom-label"
            class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
            <i class="bi bi-question-circle-fill mr-3"></i><span x-text="drawer.title">Verifikasi</span>
        </h5>
        <button @click="closeDrawer()" type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
            <i class="bi bi-x-lg"></i>
            <span class="sr-only">Close menu</span>
        </button>
        <form @submit.prevent="await $wire.clock_employee_in(JSON.stringify(distance.position)), stopVideostream()"
            x-show="drawer.section === 'checkin'">
            <p class="mb-6 text-base sm:text-xl text-gray-500 text-center">Verifikasi Biometrik Wajah</p>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center">Arahkan wajah di posisi dalam box untuk
                memudahkan pemindaian</p>
            <div class="mx-auto rounded border relative max-w-96 aspect-square mb-4 overflow-hidden">
                <video x-show="face.scanning" :class="face.loading ? 'blur-sm brightness-75' : ''" muted autoplay
                    id="verify-camera" class="h-full -scale-x-[1] w-full rounded object-cover transition duration-150"
                    src="">
                </video>
                <div class="flex h-full w-full" x-transition x-show="face.last != '' && !face.scanning">
                    <img :src="face.last" :height="face.height"
                        class="h-full -scale-x-[1] w-full rounded object-cover blur-sm" alt="">
                    <div
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded px-4 py-4">
                        <div class="text-center mb-2">
                            <p class="text-xs sm:text-base text-gray-600 text-center mb-2">Verifikasi biometrik <span
                                    class="text-ocean-500 font-bold">Gagal</span>
                            </p>
                            <i class="bi bi-exclamation-circle-fill text-2xl md:text-4xl text-ocean-800"></i>
                        </div>
                        <div class="flex">
                            <button @click="face.loading = true,await prepareCheckedIn()" type="button"
                                class="btn btn-ocean flex w-full items-center justify-center gap-2 py-2"><span
                                    x-show="!face.loading">
                                    Ulangi</span>
                                <div x-show="face.loading" class="small-loader">
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div x-show="face.scanning && face.loading"
                    class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded px-4 py-2">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs md:text-base text-nowrap text-gray-600">Memverifikasi wajah..
                        </span>
                        <div class="small-loader">
                        </div>
                    </div>
                </div>
                <div x-show="face.scanning && !face.loading"
                    class="absolute left-1/2 bottom-2 -translate-x-1/2 bg-white rounded px-4 py-2">
                    <div class="flex items-center justify-between gap-2">
                        <i class="bi bi-info-circle"></i>
                        <p class="text-xs md:text-base text-gray-600">Kedipkan mata
                        </p>
                    </div>
                </div>
                <div x-show="face.scanning"
                    class="absolute w-36 h-36 sm:w-52 sm:h-52 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
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
            <p x-transition x-show="!face.scanning" class="mb-6 text-xs sm:text-base text-gray-500 text-center">
                Lanjutkan tanpa
                menggunakan verifikasi
                biometik? <button type="submit" class="font-bold underline hover-opacity-down text-ocean-500">ya,
                    lanjutkan</button></p>
            <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
        </form>
        <div x-show="drawer.section === 'checkedin'">
            <p class="mb-6 text-base sm:text-xl text-gray-500 text-center">Verifikasi Berhasil</p>
            <div class="mx-auto rounded relative w-fit mb-4">
                <i class="bi bi-check-circle-fill text-ocean-600 text-6xl"></i>
            </div>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center"> Otomatis melanjutkan dalam <span
                    class="font-bold underline hover-opacity-down text-ocean-500">5 detik</span></p>
        </div>
        <form wire:submit="clock_employee_out(JSON.stringify(distance.position))"
            x-show="drawer.section === 'checkout'">
            <p class="mb-6 text-base sm:text-xl text-gray-500 text-center">Ingin clock out sekarang?</p>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center">Pastikan kamu sudah selesai untuk hari ini
                karena jika melanjutkan tidak dapat dikembalikan</p>
            <div class="mx-auto rounded relative w-fit my-12">
                <i class="bi bi-question-circle-fill text-ocean-600 text-6xl"></i>
            </div>
            <button type="submit" class="btn btn-ocean flex w-full items-center justify-center gap-2 py-3"><span
                    wire:loading.remove wire:target="clock_employee_out">
                    Ya, clock out sekarang</span>
                <div wire:loading wire:target="clock_employee_out" class="small-loader">
                </div>
            </button>
        </form>
        <div x-show="drawer.section === 'checkedout'">
            <p class="mb-6 text-base sm:text-xl text-gray-500 text-center">Clock out Berhasil</p>
            <div class="mx-auto rounded relative w-fit mb-4">
                <i class="bi bi-check-circle-fill text-ocean-600 text-6xl"></i>
            </div>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center"> Otomatis melanjutkan dalam <span
                    class="font-bold underline hover-opacity-down text-ocean-500">5 detik</span></p>
        </div>
        <div x-show="drawer.section === 'absence'" class="pb-5">
            <p class="mb-6 text-base text-gray-500 text-center">Harap diisi sesuai dengan keadaan yang sebenarnya yaa
                <i class="bi bi-emoji-smile-fill ml-1"></i>
            </p>
            <form wire:submit="clock_employee_absence" class="flex flex-col gap-3">
                <select wire:model="absence_reason"
                    class="font-semibold bg-gray-50 border border-gray-300 text-gray-600 text-sm rounded-lg focus:ring-ocean-500 focus:border-ocean-500 block w-full p-2.5">
                    <option class="font-semibold" value="">IZIN KARENA.. (PILIH)</option>
                    <option class="font-semibold" value="sakit">SAKIT</option>
                    <option class="font-semibold" value="acara">ACARA</option>
                    <option class="font-semibold" value="others">LAINNYA</option>
                </select>
                <div>
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Tinggalkan pesan</label>
                    <textarea wire:model="absence_note" id="message" rows="4" required
                        class="block p-2.5 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500"></textarea>
                </div>
                <button type="submit" class="btn btn-ocean flex items-center justify-center gap-2 py-3"><span
                        wire:loading.remove wire:target="clock_employee_absence">
                        Kirimkan</span>
                    <div wire:loading wire:target="clock_employee_absence" class="small-loader">
                    </div>
                </button>
            </form>

        </div>
        <div x-show="drawer.section === 'absenced'">
            <p class="mb-6 text-base sm:text-xl text-gray-500 text-center">Permintaan Izin Dikirimkan</p>
            <div class="mx-auto rounded relative w-fit mb-4">
                <i class="bi bi-check-circle-fill text-ocean-600 text-6xl"></i>
            </div>
            <p class="mb-6 text-xs sm:text-base text-gray-500 text-center"> Otomatis melanjutkan dalam <span
                    class="font-bold underline hover-opacity-down text-ocean-500">5 detik</span></p>
        </div>
    </div>
</div>

@push('scripts')
    <script data-navigate-once>
        if (typeof autoSnap == 'undefined') {
            let office
            let officeRadius
            let autoSnap
            let geopt
            let targetDrawer
            let attendanceDrawer
            let drawerSection
            let videostream
            let capturing
        }
        office = [{{ $office->lat }}, {{ $office->lon }}];
        officeRadius = {{ $office->radius }};
        autoSnap = true
        geopt = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        };
        capturing = false;
        /* Setting up the constraint */
        var facingMode = "user"; // Can be 'user' or 'environment' to access back or front camera
    </script>
    <script data-navigate-once type="module" src="{{ asset('assets\js\attendance-module.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/js/attendance.js') }}"></script>
    <script src="{{ asset('assets/js/attendance-initiate-dom.js') }}"></script>
    <script data-navigate-once>
        document.addEventListener('livewire:navigated', () => {
            if (window.location.pathname === '/attendance') {
                const inititateAttendanceBiometric = () => {
                    if (typeof attendanceCreateFaceLandmarker === 'function') {
                        attendanceCreateFaceLandmarker()
                    } else {
                        setTimeout(() => {
                            inititateAttendanceBiometric()
                        }, 1000);
                    }
                }
                inititateAttendanceBiometric()
            }
        });
        document.addEventListener('livewire:navigate', () => {
            if (window.location.pathname === '/attendance') {
                attendanceRemoveAnimationFrame()
            }
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('stop_face_recog', (payload) => {
                stopVideostream()
            });
            Livewire.on('clear_after_error', () => {
                closeDrawer();
            });
            Livewire.on('clear_after_done', () => {
                closeDrawer(5000);
            });
        });
    </script>
@endpush
