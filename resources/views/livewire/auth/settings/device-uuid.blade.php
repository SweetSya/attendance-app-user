<div class="px-2 py-7">
    <div class="mx-3">
        <div class="relative">
            <a href="/settings" class="absolute"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            UUID Perangkat
        </h5>
    </div>
    <div class="px-7">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-base text-gray-500">UUID perangkat digunakan untuk identifikasi perangkat yang
                    digunakan. Hal ini digunakan untuk login menggunakan pin, push notifikasi, dan lainnya.</p>
            </div>
            <div>
                <input disabled wire:model="device_uuid" type="text" id="device_uuid"
                    class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">

            </div>
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
