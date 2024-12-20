<div class="py-7">
    <div>
        <div class="relative">
            <a href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            PIN
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Harap gunakan pin yang dapat anda ingat dengan baik.
                </p>
            </div>
            <form @submit.prevent="$wire.change_pin()">
                <div x-data="{ open: false }" class="relative z-0 w-full mb-8 group">
                    <input wire:model="pin" :type="open ? 'text' : 'password'" id="pin" pattern="[0-9]*" required
                        inputmode="numeric"
                        class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                    <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                        class="bi absolute z-10 right-3 top-2 text-ocean-900 hover-opacity-down"></i>
                </div>
                <div style="display: none;" class="text-right" x-transition x-show="$wire.pin != $wire.original.pin">
                    <button type="button" @click="$wire.pin = $wire.original.pin"
                        class="btn btn-cinnabar flex-grow py-2"> <i class="bi bi-back"></i></button>
                    <button type="submit" class="btn btn-ocean flex-grow py-2 "> <i class="bi bi-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
