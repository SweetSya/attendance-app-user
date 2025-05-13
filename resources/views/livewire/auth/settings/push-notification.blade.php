<div class="py-7">
    <!-- Main modal -->
    <div id="tutorial-notification-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-600 dark:text-white">
                        Membuka blokir Notifikasi
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-600 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="tutorial-notification-modal">
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
                                <li>Klik tombol <i class="bi bi-box-arrow-up"></i> (share atau sejenisnya) pada
                                    toolbar</li>
                                <li>Klik "Tambahkan pada Layar Utama"</li>
                                <li>Kunjungi "Pengaturan".</li>
                                <li>Kemudian "Notifikasi".</li>
                                <li>Pada bagian notifikasi, pilih "Izinkan"</li>
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
                                <li>Kemudian "Notifikasi".</li>
                                <li>Pada bagian notifikasi, pilih "Izinkan"</li>
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
                                <li>Klik "Pengaturan Halaman".</li>
                                <li>Pada bagian notifikasi, pilih "Izinkan"</li>
                            </ul>
                        </li>
                    </ol>
                    <button data-modal-toggle="tutorial-notification-modal"
                        class="text-white inline-flex w-full justify-center bg-ocean-700 hover:bg-ocean-800 focus:ring-4 focus:outline-none focus:ring-ocean-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-ocean-600 dark:hover:bg-ocean-700 dark:focus:ring-ocean-800">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="relative">
            <a href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Push Notifikasi
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Dengan mengaktifkan push notifikasi, pengguna akan
                    mendapatkan notifikasi dari aplikasi seperti progress cuti, pengingat, dll.
                </p>
            </div>
        </div>
        <div>
            <div class="flex justify-start gap-1 items-center border-b border-gray-500 pb-2 mb-2">
                <p class="text-base text-gray-500 font-bold">Perangkat ini</p>
                <p class="text-base text-gray-500 font-bold">:</p>
                @if (!$registered)
                    <p class="text-red-500 border-2 rounded px-2 py-1 text-xs border-red-500 font-bold">Belum
                        Aktif
                    </p>
                @else
                    <p class="text-green-500 border-2 rounded px-2 py-1 text-xs border-green-500 font-bold">Sudah
                        Aktif
                    </p>
                @endif
            </div>
            <div>
                <ul class="w-full space-y-1 text-gray-500 list-inside dark:text-gray-400">
                    <li class="flex items-center">
                        <i class="bi bi-check-circle-fill text-xs mr-2"
                            :class="Notification.permission == 'default' ? 'text-gray-500' : Notification.permission ==
                                'denied' ? 'text-red-500' : 'text-green-500'"></i>
                        <div class="flex ml-1">
                            <p> Mengizinkan pengiriman notifikasi pada perangkat.&nbsp;
                                <span style="display: none;" x-show="Notification.permission == 'default'"
                                    @click="requestNotificationAccess()"
                                    class="underline text-gray-500 font-semibold cursor-pointer">(Izinkan
                                    notifikasi)</span>
                                <span style="display: none;" x-show="Notification.permission == 'denied'"
                                    data-modal-target="tutorial-notification-modal"
                                    data-modal-toggle="tutorial-notification-modal"
                                    class="underline text-gray-500 font-semibold cursor-pointer">(Diblokir. Cek cara
                                    membuka
                                    blokir.)</span>
                            </p>
                        </div>
                    </li>
                    <li class="flex items-center">
                        @if ($total <= 5)
                            <div>
                                <i class="bi bi-check-circle-fill text-xs text-green-500 mr-2"></i>
                                Tidak lebih dari 5 perangkat
                            </div>
                        @elseif($total > 5)
                            <div>
                                <i class="bi bi-check-circle-fill text-xs text-red-500 mr-2"></i>
                                Tidak lebih dari 5 perangkat
                            </div>
                        @else
                            <div>
                                <i class="bi bi-check-circle-fill text-xs text-gray-500 mr-2"></i>
                                Tidak lebih dari 5 perangkat
                            </div>
                        @endif
                    </li>
                </ul>

            </div>
            <br>
            <form @submit.prevent="sub = await pushNotificationPermission(), $wire.sub = sub, $wire.save_subscription()"
                class="flex justify-center mb-6">
                @if (!$registered)
                    <button type="submit" class="btn btn-outline-ocean py-2"
                        wire:loading.class="pointer-events-none opacity-80">
                        <div><i class="bi bi-checkmark mr-2"></i>Aktifkan Sekarang</div>
                    </button>
                @else
                    <button @click=" await $wire.test_push_notification(JSON.stringify('{{ $registered->id }}')) "
                        type="button" class="btn btn-outline-ocean py-2"
                        wire:loading.class="pointer-events-none opacity-80">
                        <div><i class="bi bi-checkmark mr-2"></i>Test Notifikasi</div>
                    </button>
                @endif
            </form>
            <p class="text-base font-bold text-gray-500 uppercase text-center mb-3">List Perangkat Aktif</p>
            <div class="shadow-md relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-nowrap">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-nowrap">
                                UUID Perangkat
                            </th>
                            <th scope="col" class="px-6 py-3 text-nowrap">
                                Detail Perangkat
                            </th>
                            <th scope="col" class="px-6 py-3 text-nowrap">
                                Tanggal Ditambahkan
                            </th>
                            <th scope="col" class="px-6 py-3 text-nowrap">
                                Hapus
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 @if ($registered && $item->id == $registered->id) bg-ocean-600/20 @endif">
                                <td class="px-6 py-4">
                                    {{ $key + 1 }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-600 whitespace-nowrap dark:text-white">
                                    {{ $item->device_remember_id }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-600 whitespace-nowrap dark:text-white">
                                    {{ $item->device }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-600 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD MMM YYYY, HH:mm:ss') }}
                                </td>
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-600 whitespace-nowrap dark:text-white">
                                    <button wire:loading.class="pointer-events-none opacity-80" type="button"
                                        @click=" await $wire.delete_subscription(JSON.stringify('{{ $item->id }}')) "
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const PUSH_PUBLIC_KEY = "{{ env('VAPID_PUBLIC_KEY') }}";
        // Function to request notification permission
        function requestNotificationAccess() {
            // Check if the Notifications API is supported
            if (!("Notification" in window)) {
                console.error("This browser does not support desktop notifications.");
                return;
            }

            // Request permission from the user
            Notification.requestPermission().then(function(permission) {
                if (permission === "granted") {
                    console.log("Notification permission granted.");
                    location.reload()
                } else if (permission === "denied") {
                    console.warn("Notification permission denied.");
                    location.reload()
                } else {
                    console.info("Notification permission closed or not decided.");
                }
            }).catch(function(error) {
                console.error("Error requesting notification permission:", error);
            });
        }

        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (var i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
        const pushNotificationPermission = async () => {
            return new Promise((resolve, reject) => {
                Notification.requestPermission().then((permission) => {
                    if (permission === "granted") {
                        navigator.serviceWorker.ready
                            .then(function(serviceWorkerRegistration) {
                                return serviceWorkerRegistration.pushManager.subscribe({
                                    userVisibleOnly: true,
                                    applicationServerKey: urlBase64ToUint8Array(
                                        PUSH_PUBLIC_KEY
                                    )
                                });
                            })
                            .then(function(subscription) {
                                subs = JSON.stringify(subscription);
                                Livewire.dispatch('notify', {
                                    type: 'info',
                                    message: 'sedang mendaftarkan perangkat..'
                                })
                                resolve(subs);
                            });
                    } else {
                        sendNotfy.error(
                            'Notifikasi belum diizinkan pada perangkat, harap untuk diaktifkan terlebih dahulu'
                        )
                        denied()
                    }
                });
            })
        };
    </script>
@endpush
