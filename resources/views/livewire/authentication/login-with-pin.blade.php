<div class="mx-auto p-6 md:p-12 tracking-wide-all">
    <div class="mb-14 sm:mb-28">
        <img height="10" src="{{ asset('logo.svg') }}" alt="">
    </div>
    <form class="mb-6" wire:submit="login">
        <div class="mb-7 sm:mb-14">
            <h1 class="text-3xl md:text-4xl font-bold text-white pb-1">Gunakan PIN</h1>
            <p class="font-light text-white/90">Gunakan PIN yang sudah didaftarkan pada email <span
                    class="font-bold text-ocean-300">{{ $email_by_device }}</span></p>
        </div>
        <div x-data="{ open: false }" class="relative z-0 w-full mb-8 group">
            <input wire:model="pin" :type="open ? 'text' : 'password'" name="floating_pin" id="floating_pin"
                pattern="[0-9]*" inputmode="numeric"
                class="bg-glass peer rounded-md block py-2.5 pl-3 pr-9 w-full text-sm text-white bg-transparent border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white"
                placeholder="" required />
            <i @click="open = ! open" :class="open ? 'bi-eye' : 'bi-eye-slash'"
                class="bi absolute right-3 top-2 text-white hover-opacity-down"></i>
            <label for="floating_pin"
                class="z-peer-focus:font-medium absolute text-sm text-gray-300 dark:text-gray-200 duration-300 transform -translate-y-9 translate-x-3 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-9 peer-focus:-translate-x-0">PIN</label>
        </div>
        <div>
            <button type="submit" class="btn btn-ocean font-semibold w-full">Masuk</button>
        </div>
    </form>
    <p class="text-white font-light">Gunakan Email? <a href="/" class="font-bold underline hover-opacity-up">Klik
            disini</a></p>
</div>
