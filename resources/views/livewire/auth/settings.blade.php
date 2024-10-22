<div class="mx-auto py-8 text-all-wide">
    <div class="text-center">
        <h5 id="drawer-right-label"
            class="inline-flex items-center mb-4 text-xl sm:text-2xl font-semibold text-gray-500 dark:text-gray-400">
            Pengaturan
        </h5>
    </div>
    <ul class="w-full flex flex-col border-b-4">
        <li class="px-4 mt-3 mx-2 font-normal text-gray-500">Akun</li>
        <a href="/settings/email">
            <li class="border-b py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-envelope text-ocean-500 mr-4"></i>Email
                </div>
            </li>
        </a>
        <a href="settings/personal-data" class="settings-soon">
            <li class="py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-person-vcard text-ocean-500 mr-4"></i>Data Diri
                </div>
            </li>
        </a>
        <a href="/settings/preferences" class="settings-soon">
            <li class="py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-pencil text-ocean-500 mr-4"></i>Preferensi
                </div>
            </li>
        </a>
    </ul>
    <ul class="w-full flex flex-col border-b-4">
        <li class="px-4 mt-3 mx-2 font-normal text-gray-500">Absensi & Keamanan</li>
        <a href="/settings/biometric-face" class="settings-soon">
            <li class="border-b py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-person-bounding-box text-ocean-500 mr-4"></i>Biometrik Wajah
                </div>
            </li>
        </a>
        <a href="/settings/pin">
            <li class="border-b py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-align-start text-ocean-500 mr-4"></i>PIN
                </div>
            </li>
        </a>
        <a href="/settings/password">
            <li class="py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-lock text-ocean-500 mr-4"></i>Password
                </div>
            </li>
        </a>
    </ul>
    <ul class="w-full flex flex-col border-b-4">
        <li class="px-4 mt-3 mx-2 font-normal text-gray-500">Perangkat</li>
        <a href="/settings/device-uuid">
            <li class="border-b py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-key text-ocean-500 mr-4"></i>UUID
                </div>
            </li>
        </a>
        <a href="/settings/push-notification" class="settings-soon">
            <li class="py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-bell text-ocean-500 mr-4"></i>Push Notifikasi
                </div>
            </li>
        </a>
    </ul>
    <ul class="w-full flex flex-col border-b-4">
        <li class="px-4 mt-3 mx-2 font-normal text-gray-500">Informasi</li>
        <a href="/settings/faq" class="settings-soon">
            <li class="border-b py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-question-circle text-ocean-500 mr-4"></i>FAQ
                </div>
            </li>
        </a>
        <a href="/settings/help-dev" class="settings-soon">
            <li class="py-4 px-7 hover-ocean-300">
                <div class="font-semibold text-gray-700">
                    <i class="bi bi-person-workspace text-ocean-500 mr-4"></i>Bantuan Developer
                </div>
            </li>
        </a>
    </ul>
    <ul x-data="" @click="LogoutConfirmationDrawer.show()" class="w-full flex flex-col">
        <li class=" py-4 px-7 hover-ocean-300">
            <div class="font-semibold text-cinnabar-500">
                <i class="bi bi-box-arrow-right  mr-4"></i>Log Out
            </div>
        </li>
    </ul>
</div>
