<div class="mx-auto p-6 md:p-12 tracking-wide-all">
    <div class="mb-14 sm:mb-28">
        <img height="10" src="{{ asset('logo.svg') }}" alt="">
    </div>
    <form class="mb-6" wire:submit="change_password">
        <div class="mb-7 sm:mb-14">
            <h1 class="text-3xl md:text-4xl font-bold text-white pb-1">Pulihkan Akun</h1>
            <p class="font-light text-white/90">Masukkan password baru yang dapat kamu ingat dengan baik</p>
        </div>
        <div x-data="{ open: false }" class="relative z-0 w-full mb-8 group">
            <input wire:model="password" :type="open ? 'text' : 'password'" name="floating_password" id="new-password"
                class="bg-glass peer rounded-md block py-2.5 pl-3 pr-9 w-full text-sm text-white bg-transparent border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white"
                placeholder="" required />
            <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                class="bi absolute right-3 top-2 text-white hover-opacity-down"></i>
            <label for="new-password"
                class="z-peer-focus:font-medium absolute text-sm text-gray-300 dark:text-gray-200 duration-300 transform -translate-y-9 translate-x-3 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-9 peer-focus:-translate-x-0">Password
                baru</label>
        </div>
        <div class="relative z-0 w-full mb-8 group">
            <input wire:model="re_password" type="password" name="floating_password" id="renew-password"
                class="bg-glass peer rounded-md block py-2.5 pl-3 pr-9 w-full text-sm text-white bg-transparent border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white"
                placeholder="" required />
            <label for="renew-password"
                class="z-peer-focus:font-medium absolute text-sm text-gray-300 dark:text-gray-200 duration-300 transform -translate-y-9 translate-x-3 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-9 peer-focus:-translate-x-0">Ulangi
                password baru</label>
        </div>
        <div>
            <button type="submit" wire:loading.class="pointer-events-none opacity-80"
                class="btn btn-ocean font-semibold w-full">
                <div wire:loading.class="hidden">Simpan</div>
                <div class="hidden" wire:loading.class.remove="hidden">Loading..</div>
            </button>
        </div>
    </form>
    <p class="text-white/90 text-center">
        Valid hingga : <span
            class="font-bold">{{ \Carbon\Carbon::parse($data->valid_until)->isoFormat('DD MMMM YYYY, HH:mm:ss') }}</span>
    </p>
</div>
