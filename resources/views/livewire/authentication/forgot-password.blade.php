<div class="mx-auto p-6 md:p-12 tracking-wide-all">
    <div class="mb-14 sm:mb-28">
        <img height="10" src="{{ asset('logo.svg') }}" alt="">
    </div>
    <form class="mb-6">
        <div class="ms-7 sm:mb-14">
            <h1 class="text-3xl md:text-4xl font-bold text-white pb-1">Lupa Password</h1>
            <p class="font-light text-white/90">Gunakan email yang terdaftar untuk memulihkan akun</p>
        </div>
        <div class="relative z-0 w-full mb-8 group">
            <input type="email" name="floating_email" id="floating_email"
                class="bg-glass peer rounded-md block py-2.5 px-3 w-full text-sm text-white bg-transparent border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-white focus:outline-none focus:ring-0 focus:border-white"
                placeholder=" " required />
            <label for="floating_email"
                class="z-peer-focus:font-medium absolute text-sm text-gray-300 dark:text-gray-200 duration-300 transform -translate-y-9 translate-x-3 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-white peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-9 peer-focus:-translate-x-0">Email</label>
        </div>
        <div>
            <button type="submit" class="btn btn-ocean font-semibold w-full">Kirim</button>
        </div>
    </form>
    <p class="text-white font-light">Sudah selesai? <a href="/"
            class="font-bold underline hover-opacity-up">Masuk disini</a></p>
</div>
