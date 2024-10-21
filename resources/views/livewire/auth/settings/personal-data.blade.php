<div class="px-2 py-7">
    <div class="mx-3">
        <div class="relative">
            <a href="/settings" class="absolute"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Data Diri
        </h5>
    </div>
    <div class="px-7">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-base text-gray-500">Isikan data diri sesuai dengan identitias diri yang anda miliki
                    ya.</p>
            </div>
            <div>
                <div class="mb-2 text-left">
                    <label for="full_name" class="text-base text-ocean-400 font-semibold">Nama Lengkap</label>
                    <input wire:model="full_name" type="text" id="full_name"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>
                <div class="mb-2 text-left">
                    <label for="phone" class="text-base text-ocean-400 font-semibold">No. Telp</label>
                    <input wire:model="phone" type="text" id="phone"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>
                <div class="mb-2 text-left">
                    <label for="address" class="text-base text-ocean-400 font-semibold">Alamat Lengkap</label>
                    <textarea cols="30" rows="10" wire:model="address" id="address"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500"></textarea>
                </div>
                <div class="mb-2 text-left">
                    <label for="village_id" class="text-base text-ocean-400 font-semibold">Desa</label>
                    <input wire:model="village_id" for="text" id="village_id"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>
                <div class="text-right" x-transition
                    x-show="$wire.full_name != $wire.original.full_name || $wire.phone != $wire.original.phone || $wire.address != $wire.original.address || $wire.village_id != $wire.original.village_id">
                    <button
                        @click="$wire.full_name = $wire.original.full_name, $wire.phone = $wire.original.phone, $wire.address = $wire.original.address, $wire.village_id = $wire.original.village_id"
                        class="btn btn-border-warning bg-gradient-warning-soft flex-grow py-2 mr-3"> <i
                            class="bi bi-backspace-reverse-fill"></i></button>
                    <button @click="$wire.change_data()"
                        class="btn btn-border-success bg-gradient-success-soft flex-grow py-2 "> <i
                            class="bi bi-check mr-2"></i>Simpan</button>
                </div>

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
