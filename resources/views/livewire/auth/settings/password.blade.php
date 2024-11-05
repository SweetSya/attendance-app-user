<div class="py-7">
    <div>
        <div class="relative">
            <a href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Password
        </h5>
    </div>
    <div class="px-5">
        <div class="mb-6 text-center">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Harap gunakan password yang dapat anda ingat dengan
                    baik.</p>
            </div>
            <form @submit.prevent="$wire.change_password()">
                {{-- <div x-data="{ open: false }" class="relative z-0 w-full group">
                    <div class="mb-2 text-left">
                        <label for="old_password" class="text-base text-ocean-400 font-semibold">Password Lama</label>
                        <input wire:model="old_password" :type="open ? 'text' : 'password'" id="old_password" required
                            placeholder="Password lama"
                            class="block p-2.5 mb-3 mt-1 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                        <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                            class="bi absolute z-10 right-3 top-9 text-ocean-900 hover-opacity-down"></i>
                    </div>
                </div> --}}
                <div x-data="{ open: false }" class="relative z-0 w-full group">
                    <div class="mb-4 text-left">
                        {{-- <label for="password" class="text-base text-ocean-400 font-semibold">Password Baru</label> --}}
                        <input wire:model="password" :type="open ? 'text' : 'password'" id="password" required
                            placeholder="Password baru"
                            class="block p-2.5 mb-3 mt-1 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                        <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                            class="bi absolute z-10 right-3 top-2 text-ocean-900 hover-opacity-down"></i>
                    </div>
                </div>
                <div x-data="{ open: false }" class="relative z-0 w-full group">
                    <div class="mb-2 text-left">
                        <input wire:model="re_password" :type="open ? 'text' : 'password'" id="re_password" required
                            placeholder="Ulangi password baru"
                            class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                        <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                            class="bi absolute z-10 right-3 top-2 text-ocean-900 hover-opacity-down"></i>
                    </div>
                </div>
                <div style="display: none;"
                    x-show="$wire.password != '' && $wire.re_password != '' && $wire.password != $wire.re_password"
                    class="mb-4 flex items-center gap-3 text-red-500">
                    <i class="bi bi-info-circle"></i>
                    <span class="text-sm leading-tight">Password yang digunakan<span class="font-bold"> tidak
                            sama</span>, harap dicek kembali.</span>
                </div>
                <div style="display: none;" class="text-right" x-transition
                    x-show="$wire.password != '' && $wire.re_password != '' && $wire.password == $wire.re_password">
                    <button type="button" @click=" $wire.password = '', $wire.re_password = ''"
                        class="btn btn-border-warning bg-gradient-warning-soft flex-grow py-2 mr-3"> <i
                            class="bi bi-backspace-reverse-fill"></i></button>
                    <button type="submit" class="btn btn-border-success bg-gradient-success-soft flex-grow py-2 px-10">
                        <i class="bi bi-check mr-2"></i>/button>
                </div>

            </form>
        </div>
    </div>
</div>
