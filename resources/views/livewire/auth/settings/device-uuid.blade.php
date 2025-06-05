<div class="py-7">
    <div>
        <div class="relative">
            <a wire:navigate href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            UUID Perangkat
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">UUID perangkat digunakan untuk identifikasi perangkat
                    yang
                    digunakan. Hal ini digunakan untuk login menggunakan pin, push notifikasi, dan lainnya.</p>
            </div>
            <div class="text-left">
                <div>
                    <label for="device_uuid" class="text-xs md:text-base text-gray-500 ">UUID perangkat ini</label>
                    <input disabled wire:model="device_uuid_by_cookie" type="text" id="device_uuid_by_cookie"
                        class="mt-2 block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>
                <div>
                    <label for="device_uuid" class="text-xs md:text-base text-gray-500 ">UUID perangkat yang terpaut
                        pada
                        akun ini</label>
                    <input disabled wire:model="device_uuid" type="text" id="device_uuid"
                        class="mt-2 block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>

            </div>
            <div class="mt-2 border p-3 rounded text-left flex items-center gap-3 bg-gray-50">
                <i class="bi bi-info-circle text-ocean-500 text-lg md:text-2xl"></i>
                <p class="text-xs md:text-base text-gray-500">Jika UUID perangkat saat ini tidak sesuai dengan UUID
                    terpaut pada akun, <br>
                    <span class="text-ocean-500">"Logout"</span> kemudian saat akan melakukan login, centang <span
                        class="text-ocean-500">"Ingat pada perangkat"</span>
                    dan cek
                    kembali pada halaman ini, atau klik tombol berikut untuk menyesuaikan UUID perangkat.
                </p>
            </div>
            <button wire:click="change_device_uuid"
                class="my-3 btn btn-outline-ocean w-full min-w-32 py-2 flex gap-2 items-center justify-center">
                <div wire:loading.remove wire:target="change_device_uuid">Perbaharui UUID perangkat pada akun</div>
                <div wire:loading wire:target="change_device_uuid" class="text-center small-loader"></div>
            </button>
        </div>
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
</div>
