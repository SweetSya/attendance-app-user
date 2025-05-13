<div class="py-7">
    <div>
        <div class="relative">
            <a href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Biometrik Wajah
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Biometrik wajah akan dimanfaatkan untuk melakukan
                    presensi menggunakan biometrik</p>
            </div>
        </div>
        <div class="flex gap-2 items-center flex-wrap pb-2 mb-2 border-b rounded-t border-gray-600">
            <p class="text-base text-gray-500 font-bold">Status :</p>
            <p class="text-red-500 border-2 rounded px-2 py-1 text-xs border-red-500 font-bold">Belum
                Aktif
            </p>
            <p class="text-green-500 border-2 rounded px-2 py-1 text-xs border-green-500 font-bold">Aktif
            </p>
            <p class="text-yellow-500 border-2 rounded px-2 py-1 text-xs border-yellow-500 font-bold">Diproses
            </p>
        </div>
        <div class="flex items-center flex-wrap justify-between gap-1 mb-3">
            <div class="flex flex-col gap-.5">
                <p class="text-base text-gray-500 font-bold">Username :</p>
                <p class="text-base text-gray-500">Employee 1</p>
            </div>
            <div class="flex flex-col gap-.5">
                <p class="text-base text-gray-500 font-bold">ID Akun:</p>
                <p class="text-base text-gray-500">9f5805f4-9269-422c-8c4d-9df0200c3b82</p>
            </div>
        </div>
        <div>
            <button class="my-3 btn btn-outline-ocean w-full min-w-32 py-2">Aktifkan Biometrik Wajah</button>
            <p class="md:text-base text-xs text-gray-500">* Izin kamera diperlukan untuk mendaftarkan biometrik wajah
                pada akun, dan harap dipersiapkan untuk melakukan pendaftaran biometrik</p>
        </div>
        <div x-data="{ step: [] }">
            <ol class="mt-3 flex items-center w-full">
                <li
                    class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block dark:after:border-gray-700">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                        <i class="bi bi-key-fill text-gray-600"></i>
                    </span>
                </li>
                <li
                    class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block dark:after:border-gray-700">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                        <i class="bi bi-camera-video-fill text-gray-600"></i>
                    </span>
                </li>
                <li
                    class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block dark:after:border-gray-700">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                        <i class="bi bi-person-bounding-box text-gray-600"></i>
                    </span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0">
                        <i class="bi bi-check-circle-fill text-gray-600"></i>
                    </span>
                </li>
            </ol>
            <div x-data="{ password_checking: false, password_match: false }" class="relative z-0 w-full group">
                <p class="text-base font-bold text-gray-500 uppercase text-center my-4">Verifikasi Akun</p>
                <p class="text-xs md:text-base text-gray-500">Masukkan password yang saat ini digunakan untuk
                    melanjutkan :</p>
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
                        @input.debounce.500ms="$wire.password = $el.value, console.log($wire.password), password_checking = true ,$wire.match_password().then((res) => {password_checking = false, password_match = res})"
                        :type="open ? 'text' : 'password'" id="password" required placeholder="Password"
                        class="block p-2.5 mb-3 mt-1 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500 pe-8">
                    <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                        class="bi absolute z-10 right-3 top-2 text-ocean-900 hover-opacity-down"></i>
                </div>
            </div>
            <div x-data="{ camera: { permissiosn: '', status: 'offline' }, err_message: '' }" class="relative z-0 w-full group">
                <p class="text-base font-bold text-gray-500 uppercase text-center my-4">Mempersiapkan Kamera</p>
                <p class="text-xs md:text-base text-gray-500">Klik tombol berikut untuk mengaktifkan kamera</p>
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
                    @set_camera_status.window.camel="camera.status = $event.detail.status"
                    @click="camera.status = 'preparing', res = await requestUserCamera(), res.status != 'error' ? (err_message = '', camera) : (err_message = res.message, camera.status = 'offline')"
                    class="my-3 btn btn-outline-ocean w-full min-w-32 py-2 flex gap-2 items-center justify-center"
                    :class="camera.status == 'preparing' ? 'pointer-events-none' : ''">
                    <div x-show="camera.status == 'offline'">Aktifkan
                        Kamera</div>
                    <div x-show="camera.status == 'preparing'" class="text-center small-loader"></div>
                </button>
            </div>
            <div x-data="{ camera: { permissiosn: '', status: 'offline' }, err_message: '' }" class="relative z-0 w-full group">
                <p class="text-base font-bold text-gray-500 uppercase text-center my-4">Mendaftarkan Biometrik Wajah</p>
                <p class="text-xs md:text-base text-gray-500">Harap mengikuti petunjuk yang diberikan</p>
            </div>
            <div class="relative">
                <video id="webcam" class="-scale-x-[1]" autoplay muted playsinline></video>
                <canvas id="output_canvas" class="-scale-x-[1] absolute top-0"></canvas>
                <ul id="video-blend-shapes" class="blend-shapes-list"></ul>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="module" src="{{ asset('assets\js\biometric-face.js') }}"></script>
@endpush
