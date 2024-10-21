<div class="px-2 py-7">
    <div class="mx-3">
        <div class="relative">
            <a href="/settings" class="absolute"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            PIN
        </h5>
    </div>
    <div class="px-7">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-base text-gray-500">Harap gunakan pin yang dapat anda ingat dengan baik.</p>
            </div>
            <div>
                <div x-data="{ open: false }" class="relative z-0 w-full mb-8 group">
                    <input wire:model="pin" :type="open ? 'text' : 'password'" id="pin" pattern="[0-9]*" required
                        inputmode="numeric"
                        class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                    <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                        class="bi absolute z-10 right-3 top-2 text-ocean-900 hover-opacity-down"></i>
                </div>
                <div class="text-right" x-transition x-show="$wire.pin != $wire.original.pin">
                    <button @click="$wire.pin = $wire.original.pin"
                        class="btn btn-border-warning bg-gradient-warning-soft flex-grow py-2 mr-3"> <i
                            class="bi bi-backspace-reverse-fill"></i></button>
                    <button @click="$wire.change_pin()"
                        class="btn btn-border-success bg-gradient-success-soft flex-grow py-2 "> <i
                            class="bi bi-check mr-2"></i>Simpan</button>
                </div>

            </div>
        </div>
    </div>
</div>
