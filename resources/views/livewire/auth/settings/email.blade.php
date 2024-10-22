<div class="py-7">
    <div>
        <div class="relative">
            <a href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Email
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Harap gunakan email yang aktif, karena akan digunakan
                    pada saat
                    login, mengirimkan notifikasi, dan keperluan lainnya.</p>
            </div>
            <form @submit.prevent="$wire.change_email()">
                <input wire:model="email" type="text" id="email"
                    class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">

                <div style="display: none;" class="text-right" x-transition
                    x-show="$wire.email != $wire.original.email">
                    <button type="button" @click="$wire.email = $wire.original.email"
                        class="btn btn-cinnabar flex-grow py-2"> <i class="bi bi-back"></i></button>
                    <button type="submit" class="btn btn-ocean flex-grow py-2 px-10"> <i
                            class="bi bi-check"></i></button>
                </div>

            </form>
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
