<div class="py-7">
    <div>
        <div class="relative">
            <a wire:navigate href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Izin Perangkat
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Berisi perizinan yang kamu berikan untuk program
                    mengakses perangkatmu. Harap diaktifkan karena program membutuhkan izin untuk berjalan dengan baik.
                </p>
            </div>
        </div>

        <ul x-init="await getWebPermissions().then((res) => { permissions = res })" x-data="{ permissions: 'loading' }"
            @update_permissions.window="getWebPermissions().then((res) => { permissions = res })"
            class="w-full flex flex-col gap-4">
            <li>
                <div
                    class="inline-flex items-center gap-2 justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 ">

                    <div class="flex items-center gap-5">

                        <i class="bi bi-compass-fill text-3xl text-ocean-600/50"></i>
                        <div class="block">
                            <div class="w-full text-lg font-semibold text-ocean-600/80">Lokasi</div>
                            <div class="w-full text-sm">Status : <span
                                    :class="permissions.location === 'granted' ? 'text-green-600' :
                                        permissions.location === 'denied' ? 'text-cinnabar-600' : ''"
                                    x-text="
                                permissions === 'loading' ? 'Memuat..' :
                                permissions.location === 'granted' ? 'Aktif' :
                                permissions.location === 'denied' ? 'Diblokir' :
                                permissions.location === 'prompt' ? 'Belum Diaktifkan' :
                                permissions.location === 'unsupported' ? 'Tidak Support' :
                                'Tidak Diketahui'
                            "></span><span
                                    x-show="permissions.location === 'denied'" style="display:none;">
                                    (Untuk membuka blokir, cek
                                    <span data-modal-target="tutorial-permissions-modal"
                                        data-modal-toggle="tutorial-permissions-modal"
                                        class="tutorial-permissions underline cursor-pointer text-ocean-500">tauntan
                                        berikut</span>
                                    )</span>
                            </div>
                        </div>
                    </div>

                    <label class="inline-flex items-center cursor-pointer"
                        :class="['denied', 'granted'].includes(permissions.location) ? 'pointer-events-none opacity-50' : ''">
                        <input @change="togglePermissions" type="checkbox" value="location"
                            :checked="permissions.location == 'granted'" class="sr-only peer">
                        <div
                            class="relative mb-2 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-ocean-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ocean-600 ">
                        </div>
                    </label>
                </div>
            </li>
            <li>
                <div
                    class="inline-flex items-center gap-2 justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 ">

                    <div class="flex items-center gap-5">

                        <i class="bi bi-camera-fill text-3xl text-ocean-600/50"></i>
                        <div class="block">
                            <div class="w-full text-lg font-semibold text-ocean-600/80">Kamera</div>
                            <div class="w-full text-sm">Status : <span
                                    :class="permissions.camera === 'granted' ? 'text-green-600' :
                                        permissions.camera === 'denied' ? 'text-cinnabar-600' : ''"
                                    x-text="
                                permissions === 'loading' ? 'Memuat..' :
                                permissions.camera === 'granted' ? 'Aktif' :
                                permissions.camera === 'denied' ? 'Diblokir' :
                                permissions.camera === 'prompt' ? 'Belum Diaktifkan' :
                                permissions.camera === 'unsupported' ? 'Tidak Support' :
                                'Tidak Diketahui'
                            "></span><span
                                    x-show="permissions.camera === 'denied'" style="display:none;">
                                    (Untuk membuka blokir, cek
                                    <span data-modal-target="tutorial-permissions-modal"
                                        data-modal-toggle="tutorial-permissions-modal"
                                        class="tutorial-permissions underline cursor-pointer text-ocean-500">tauntan
                                        berikut</span>
                                    )</span>
                            </div>
                        </div>
                    </div>

                    <label class="inline-flex items-center cursor-pointer"
                        :class="['denied', 'granted'].includes(permissions.camera) ? 'pointer-events-none opacity-50' : ''">
                        <input @change="togglePermissions" type="checkbox" :checked="permissions.camera == 'granted'"
                            value="camera" class="sr-only peer">
                        <div
                            class="relative mb-2 w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-ocean-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ocean-600 ">
                        </div>
                    </label>
                </div>
            </li>
            <li>
                <div class="inline-flex items-center gap-2 justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer"
                    wire:navigate href="/settings/push-notification">

                    <div class="flex items-center gap-5">

                        <i class="bi bi-bell-fill text-3xl text-ocean-600/50"></i>
                        <div class="block">
                            <div class="w-full text-lg font-semibold text-ocean-600/80">Notifikasi</div>
                            <div class="w-full text-sm">Status : <span
                                    :class="permissions.notification === 'granted' ? 'text-green-600' :
                                        permissions.notification === 'denied' ? 'text-cinnabar-600' : ''"
                                    x-text="
                                permissions === 'loading' ? 'Memuat..' :
                                permissions.notification === 'granted' ? 'Aktif' :
                                permissions.notification === 'denied' ? 'Diblokir' :
                                permissions.notification === 'prompt' || 'default' ? 'Belum Diaktifkan' :
                                permissions.notification === 'unsupported' ? 'Tidak Support' :
                                'Tidak Diketahui'
                            "></span><span
                                    x-show="permissions.notification === 'denied'" style="display:none;">
                                    (Untuk membuka blokir, cek
                                    <span data-modal-target="tutorial-permissions-modal"
                                        data-modal-toggle="tutorial-permissions-modal"
                                        class="tutorial-permissions underline cursor-pointer text-ocean-500">tauntan
                                        berikut</span>
                                    )</span>
                            </div>
                        </div>
                    </div>

                    <div class="mx-2 text-ocean-500">
                        <i class="bi bi-box-arrow-in-up-right text-2xl"></i>
                    </div>
                </div>
            </li>
        </ul>

        {{-- <div class="flex items-center gap-4">
            <i class="bi bi-patch-check-fill text-ocean-600 text-3xl"></i>
            <div>
                <p class="text-base text-gray-500">Sudah <span class="font-bold">terverifikasi</span>
                    pada
                    tanggal 10 Juni 2024, Pukul
                    20:21:11.</p>
            </div>
        </div> --}}
    </div>
    <!-- Main modal -->
    <div id="tutorial-permissions-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-600 dark:text-white">
                        Membuka blokir izin perangkat
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-600 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="tutorial-permissions-modal">
                        <i class="bi bi-x"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">
                        <li class="mb-10 ms-8">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                <i class="bi bi-apple"></i>
                            </span>
                            <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-600 dark:text-white">
                                IOS
                            </h3>
                            <ul class="space-y-4 text-gray-500 list-disc list-inside dark:text-gray-400">
                                <li>Klik tombol <sub>A</sub>A (informasi atau sejenisnya) pada
                                    toolbar</li>
                                <li>Pilih "Pengaturan Web".</li>
                                <li>Kemudian cari izin perangkat.</li>
                                <li>Pada bagian kanan dari nilai, pilih "Izinkan"</li>
                            </ul>

                        </li>
                        <li class="mb-10 ms-8">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                <i class="bi bi-android"></i>
                            </span>
                            <h3 class="mb-1 text-lg font-semibold text-gray-600 dark:text-white">Android
                            </h3>
                            <ul class="space-y-4 text-gray-500 list-disc list-inside dark:text-gray-400">
                                <li>Klik tombol <i class="bi bi-info-circle"></i> (informasi halaman atau
                                    sejenisnya) pada toolbar.</li>
                                <li>Pilih "Perizinan".</li>
                                <li>Kemudian cari izin perangkat.</li>
                                <li>Pada bagian kanan dari nilai, pilih "Izinkan"</li>
                            </ul>
                        </li>
                        <li class="mb-10 ms-8">
                            <span
                                class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                <i class="bi bi-pc-display"></i>
                            </span>
                            <h3 class="mb-1 text-lg font-semibold text-gray-600 dark:text-white">Desktop
                            </h3>
                            <ul class="space-y-4 text-gray-500 list-disc list-inside dark:text-gray-400">
                                <li>Klik tombol <i class="bi bi-toggles2"></i> (pengaturan atau sejenisnya) pada
                                    toolbar.</li>
                                <li>Kemudian cari izin perangkat.</li>
                                <li>Pada bagian kanan dari nilai, pilih "Izinkan"</li>
                            </ul>
                        </li>
                    </ol>
                    <button data-modal-toggle="tutorial-permissions-modal"
                        class="text-white inline-flex w-full justify-center bg-ocean-700 hover:bg-ocean-800 focus:ring-4 focus:outline-none focus:ring-ocean-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-ocean-600 dark:hover:bg-ocean-700 dark:focus:ring-ocean-800">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const togglePermissions = async (e) => {
            const value = e.target.value

            if (value === 'location') {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        window.dispatchEvent(new CustomEvent('update_permissions'));
                        sendNotfy.success(
                            'Izin geolokasi berhasil diaktifkan'
                        )
                    },
                    error => {
                        e.target.checked = false
                        notification = sendNotfy.open({
                            type: 'info',
                            message: 'Geolokasi belum mendapat izin pengguna'
                        });
                    }
                );
            }
            if (value === 'camera') {
                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "user"
                        },
                    })
                    .then(stream => {
                        window.dispatchEvent(new CustomEvent('update_permissions'))
                        sendNotfy.success(
                            'Izin kamera berhasil diaktifkan'
                        )
                        // Immediately stop all tracks (camera/mic turns off)
                        stream.getTracks().forEach(track => track.stop());
                    })
                    .catch(error => {
                        console.log(error)
                        e.target.checked = false
                        notification = sendNotfy.open({
                            type: 'info',
                            message: 'Kamera belum mendapat izin pengguna'
                        });
                    });
            }
        }
        const getWebPermissions = async () => {

            const results = {
                camera: 'not supported',
                location: 'not supported',
                notification: 'not supported'
            };
            // Check compability
            if (navigator.permissions) {
                // Camera permission
                try {
                    const camPerm = await navigator.permissions.query({
                        name: 'camera'
                    });
                    results.camera = camPerm.state;
                } catch (e) {
                    results.camera = 'unsupported';
                }

                // Location permission
                try {
                    const locPerm = await navigator.permissions.query({
                        name: 'geolocation'
                    });
                    results.location = locPerm.state;
                } catch (e) {
                    results.location = 'unsupported';
                }

                // Notification permission (uses Notification API)
                try {
                    const notifPerm = await navigator.permissions.query({
                        name: 'notifications'
                    });

                    results.notification = notifPerm.state;
                } catch (e) {
                    results.notifPerm = 'unsupported';
                }
                // Set to local storage
                localStorage.setItem('permissions', JSON.stringify(results))
                return results;
            } else {
                // Legacy
                // try {
                //     navigator.mediaDevices.getUserMedia({
                //             video: {
                //                 facingMode: "user"
                //             }
                //         })
                //         .then(function(stream) {
                //             // camera is granted
                //             results.camera = 'granted'
                //         })
                //         .catch(function(error) {
                //             if (error === "NotAllowedError: Permission dismissed") {

                //             }
                //         });
                // } catch (e) {
                //     results.camera = 'unsupported';
                // }
            }
        }
    </script>
@endpush
