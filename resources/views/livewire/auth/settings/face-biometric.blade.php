<div class="py-7">
    <div>
        <div class="relative">
            <a href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Biometrik Wajah
        </h5>
    </div>
    <div x-data="{
        steps: [],
        camera: { permissiosn: '', status: 'offline', images: {} },
        camera_capturing: false,
        labelMap: {
            'netral-netral': 'Tengah',
            'top-netral': 'Atas',
            'bottom-netral': 'Bawah',
            'netral-right': 'Kanan',
            'netral-left': 'Kiri'
        },
        calibrated: false,
        err_message: ''
    }"
        @set_camera_status.window.camel="camera.status = $event.detail.status, camera.status == 'running' ? setTimeout(() => {steps.push('registering')}, 1500) : ''"
        @set_camera_capturing.window.camel="camera_capturing = $event.detail.state"
        @set_camera_capture.window.camel="camera.images = {}, camera.images = $event.detail.images, camera_capturing = false"
        class="px-5 relative">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Biometrik wajah akan dimanfaatkan untuk melakukan
                    presensi menggunakan biometrik</p>
            </div>
        </div>
        <div class="flex gap-2 items-center flex-wrap pb-2 mb-2 border-b rounded-t border-gray-600">
            <p class="text-base text-gray-500 font-bold">Status :</p>
            <p x-transition style="display: none;" x-show="$wire.face_recognition_status == 0"
                class="text-red-500 border-2 rounded px-2 py-1 text-xs border-red-500 font-bold">Belum
                Aktif
            </p>
            <p x-transition style="display: none;" x-show="$wire.face_recognition_status == 2"
                class="text-green-500 border-2 rounded px-2 py-1 text-xs border-green-500 font-bold">Aktif
            </p>
            <p x-transition style="display: none;" x-show="$wire.face_recognition_status == 1"
                class="text-yellow-500 border-2 rounded px-2 py-1 text-xs border-yellow-500 font-bold">Diproses
            </p>
        </div>
        <div class="flex items-center flex-wrap justify-between gap-1 mb-3">
            <div class="flex flex-col gap-.5">
                <p class="text-base text-gray-500 font-bold">Nama :</p>
                <p class="text-base text-gray-500" x-text="$wire.employee_name"></p>
            </div>
            <div class="flex flex-col gap-.5">
                <p class="text-base text-gray-500 font-bold">ID Akun:</p>
                <p class="text-base text-gray-500" x-text="$wire.employee_id"></p>
            </div>
        </div>
        <div style="display: none;" class="transition ease-in-out duration-1000" x-show="$wire.face_recognition_status == 0"
            x-transition:leave="animate__animated animate__fadeOutLeft absolute"
            x-transition:enter="animate__animated animate__fadeInRight" x-show="steps.length < 1">
            <button @click="steps.push('authentication')"
                class="my-3 btn btn-outline-ocean w-full min-w-32 py-2">Aktifkan Biometrik Wajah</button>
            <p class="md:text-base text-xs text-gray-500">* Izin kamera diperlukan untuk mendaftarkan biometrik wajah
                pada akun, dan harap dipersiapkan untuk melakukan pendaftaran biometrik</p>
        </div>
        <div style="display: none;" class="transition ease-in-out duration-1000" x-show="$wire.face_recognition_status == 1"
            x-transition:leave="animate__animated animate__fadeOutLeft absolute"
            x-transition:enter="animate__animated animate__fadeInRight" x-show="steps.length < 1">
            <p class="text-base btn-cinnabar py-1 text-center ">Biometrik muka sedang dalam proses verifikasi selanjutnya,
                harap ditunggu atau konfirmasi pada pihak terkait</p>
        </div>
        <div style="display: none;" class="transition ease-in-out duration-1000" x-show="$wire.face_recognition_status == 2"
            x-transition:leave="animate__animated animate__fadeOutLeft absolute"
            x-transition:enter="animate__animated animate__fadeInRight" x-show="steps.length < 1">
            <p class="text-base btn-ocean py-1 text-white pointer-events-none text-center">Biometrik muka sudah didaftarkan pada akun ini</p>
        </div>
        <div class="relative transition ease-in-out duration-1000"
            x-transition:leave="animate__animated animate__fadeOutLeft"
            x-transition:enter="animate__animated animate__fadeInRight" x-show="steps.length > 0">
            <ol class="mt-3 flex items-center w-full">
                <li :class="steps.length > 1 ? 'after:border-ocean-500' : 'after:border-gray-100 '"
                    class="border-ocean-500 flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b  after:border-4 after:inline-block">
                    <span :class="steps.length >= 1 ? 'bg-ocean-500' : 'bg-gray-100'"
                        class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="bi bi-key-fill" :class="steps.length >= 1 ? 'text-white' : 'text-gray-500'"></i>
                    </span>
                </li>
                <li :class="steps.length > 2 ? 'after:border-ocean-500' : 'after:border-gray-100'"
                    class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b  after:border-4 after:inline-block">
                    <span :class="steps.length >= 2 ? 'bg-ocean-500' : 'bg-gray-100'"
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="bi bi-camera-video-fill text-gray-500"
                            :class="steps.length >= 2 ? 'text-white' : 'text-gray-500'"></i>
                    </span>
                </li>
                <li :class="steps.length > 3 ? 'after:border-ocean-500' : 'after:border-gray-100'"
                    class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b  after:border-4 after:inline-block">
                    <span :class="steps.length >= 3 ? 'bg-ocean-500' : 'bg-gray-100'"
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="bi bi-person-bounding-box text-gray-500"
                            :class="steps.length >= 3 ? 'text-white' : 'text-gray-500'"></i>
                    </span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="bi bi-check-circle-fill text-gray-600"></i>
                    </span>
                </li>
            </ol>
            <div x-data="{ password_checking: false, password_match: false }" class="z-0 w-full group transition ease-in-out duration-1000"
                x-show="steps[steps.length - 1] == 'authentication'"
                x-transition:leave="animate__animated animate__fadeOutLeft absolute"
                x-transition:enter="animate__animated animate__fadeInRight">
                <p class="text-base font-bold text-gray-500 uppercase text-center my-4">Verifikasi Akun</p>
                <p class="text-xs md:text-base text-gray-500 text-center">Masukkan password yang saat ini digunakan untuk
                    melanjutkan</p>
                <div x-transition x-show="$wire.password != ''" :class="password_checking ? 'opacity-70' : ''"
                    style="display: none;" class="my-3 text-xs md:text-base flex justify-center w-full min-w-32 py-2">
                    <div x-show="!password_checking && password_match" class="flex gap-2">
                        <div class="text-green-600">Password sesuai,
                            mengarahkan..
                        </div>
                        <div class="small-loader"></div>
                    </div>
                    <span class="text-red-600" x-show="!password_checking && !password_match">Password tidak
                        sesuai</span>
                    <div x-show="password_checking" class="text-center small-loader"></div>
                </div>
                <div x-data="{ open: false }" class="relative my-2 text-left">
                    {{-- <label for="password" class="text-base text-ocean-600 font-semibold">Password Baru</label> --}}
                    <input
                        @input.debounce.1000ms="$wire.password = $el.value, password_checking = true ,$wire.match_password().then((res) => {password_checking = false, password_match = res, setTimeout(() => {document.getElementById('password').focus()}, 100), res == true ? setTimeout(() => {steps.push('permission')}, 1500) : '' })"
                        :type="open ? 'text' : 'password'" autocomplete="new-password" id="password" required
                        placeholder="Password" :disabled="(password_checking || password_match) ? true: false"
                        class="block p-2.5 mb-3 mt-1 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500 pe-8">
                    <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                        class="bi absolute z-10 right-3 top-2 text-ocean-900 hover-opacity-down"></i>
                </div>
            </div>
            <div x-show="steps[steps.length - 1] == 'permission'"
                x-transition:leave="animate__animated animate__fadeOutLeft absolute"
                x-transition:enter="animate__animated animate__fadeInRight"
                class="z-0 w-full group transition ease-in-out duration-1000">
                <p class="text-base font-bold text-gray-500 uppercase text-center my-4">Mempersiapkan Kamera</p>
                <p class="text-xs md:text-base text-gray-500 text-center">Klik tombol berikut untuk mengaktifkan kamera</p>
                <div x-transition x-show="err_message != ''" style="display: none;"
                    class="my-3 text-xs md:text-base flex justify-center w-full min-w-32 py-2">
                    <span class="text-red-600" x-text="err_message"></span>
                </div>
                <div x-show="camera.status == 'running'" style="display: none" x-transition
                    class="flex flex-col items-center justify-center">
                    <div class="flex gap-2 my-2 text-xs md:text-base">
                        <div class="text-green-600"> Kamera telah siap,
                            mengarahkan..
                        </div>
                        <div class="small-loader"></div>
                    </div>
                </div>
                <button x-show="camera.status != 'running'"
                    @click="camera.status = 'preparing', res = await requestUserCamera(), res.status != 'error' ? (err_message = '') : (err_message = res.message, camera.status = 'offline')"
                    class="my-3 btn btn-outline-ocean w-full min-w-32 py-2 flex gap-2 items-center justify-center"
                    :class="camera.status == 'preparing' ? 'pointer-events-none bg-transparent' : ''">
                    <div x-show="camera.status == 'offline'">Aktifkan
                        Kamera</div>
                    <div x-show="camera.status == 'preparing'" class="text-center small-loader"></div>
                </button>
            </div>
            <div x-show="steps[steps.length - 1] == 'registering'"
                x-transition:leave="animate__animated animate__fadeOutLeft absolute"
                x-transition:enter="animate__animated animate__fadeInRight"
                class="z-0 w-full transition ease-in-out duration-1000">
                <div class="z-0 w-full group">
                    <p class="text-base font-bold text-gray-500 uppercase text-center my-4">Mendaftarkan Biometrik
                        Wajah
                    </p>
                    <p class="text-xs md:text-base text-center text-gray-500 mb-3">Harap mengikuti petunjuk yang diberikan</p>
                </div>
                <div class="relative flex justify-center items-center h-fit">
                    <div id="webcam-wrapper" class="relative w-full md:w-[520px] h-fit" style="display: hidden;"
                        x-transition.opacity x-show="camera.status == 'running'">
                        <video :class="!calibrated ? 'brightness-[.25] blur-sm' : ''" id="webcam"
                            class="-scale-x-[1]" autoplay muted playsinline></video>
                        <canvas :class="!calibrated ? 'brightness-[.25] blur-sm' : ''" id="output_canvas"
                            class="-scale-x-[1] absolute top-0"></canvas>
                        <p x-show="!calibrated"
                            class="absolute flex gap-2 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 btn btn-outline-ocean text-xs pointer-events-none text-white border-white">
                            <span class="mt-1">
                                <i class="bi bi-exclamation-circle"></i>
                            </span>
                            <span class="flex-grow">Harap lakukan
                                kalibrasi
                                terlebih dahulu,
                                dengan menekan tombol pada kanan bawah</span>
                        </p>
                        <button type="button" @click="setCalibrateInitialFace(true), calibrated = true"
                            class="absolute bottom-1 right-1 bg-white btn btn-outline-ocean text-xs">
                            Kalibrasi <i class="bi bi-arrow-repeat"></i>
                        </button>
                        <div
                            class="absolute top-1 left-1 text-white bg-black/50 border-2 border-ocean-600 rounded-sm p-1 text-xs">
                            <p><i class="bi bi-arrows-expand"></i> <span id="pitch">-</span></p>
                            <p><i class="bi bi-arrows-expand-vertical"></i> <span id="yaw">-</span></p>
                        </div>
                        <div x-show="calibrated && !Object.values(camera.images).every(v => v !== '')"
                            class="absolute bottom-1 left-1 text-white bg-black/50 border-2 border-ocean-600 rounded-sm p-1 text-xs">
                            <template x-for="(value, index) in camera.images">
                                <p><span x-text="labelMap[index] ?? index"></span> <i class="bi"
                                        :class="value == '' ? 'bi-question text-cinnabar-300' : 'bi-check text-green-300'"></i>
                                </p>
                            </template>
                        </div>
                        <p x-show="calibrated && Object.values(camera.images).every(v => v !== '')"
                            class="absolute bottom-2 left-2 me-32 text-white bg-black/50 border-2 border-ocean-600 rounded-sm p-1 text-xs">
                            <span class="mt-1">
                                <i class="bi bi-exclamation-circle"></i>
                            </span>
                            <span class="flex-grow">Kedipkan mata untuk melanjutkan.</span>
                        </p>
                    </div>
                </div>
            </div>
            <div id="preview" x-transition.opacity x-show="camera.status == 'offline'" class="flex flex-col">
                <template x-for="(value, index) in camera.images">
                    <div>
                        <p x-text="index"></p>
                        <img :src="value" alt="" class="w-full">
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="module" src="{{ asset('assets\js\biometric-face.js') }}"></script>
@endpush
