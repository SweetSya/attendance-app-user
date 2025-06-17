<div class="py-7">
    <div>
        <div class="relative">
            <a wire:navigate href="/settings" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
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
            <div x-show="!$wire.new_email_issued">
                <form class="text-left" wire:submit.prevent="change_email">
                    <input :class="$wire.existing_issue == 'approval' ? 'pointer-events-none' : ''" wire:model="email"
                        type="text" id="email"
                        class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                    <div style="display: none;" class="text-right" x-transition
                        x-show="$wire.email != $wire.original.email">
                        <button wire:loading.remove type="button" @click="$wire.email = $wire.original.email"
                            class="btn btn-outline-cinnabar flex-grow py-2"> <i class="bi bi-back"></i>
                            Kembalikan</button>
                        <button type="submit" class="btn btn-outline-ocean flex-grow py-2 ">
                            <div wire:loading.class="hidden">
                                <i class="bi bi-check"></i>
                                Ajukan perubahan email
                            </div>
                            <div class="hidden text-center small-loader" wire:loading.class.remove="hidden"></div>
                        </button>
                    </div>
                </form>
                <div x-show="$wire.existing_issue === 'approval'">
                    <p class="mb-2 text-xs md:text-base text-gray-500">Email ini sedang dalam proses pengecekan</p>
                </div>
            </div>
            <div x-show="$wire.new_email_issued && !$wire.existing_issue_status" class="mb-3">
                <div class="flex justify-between">
                    <p class="text-base text-gray-500"><span class="font-bold">Status Email :</span></p>
                    <p class="text-base text-gray-500"><span class="text-green-500 font-bold">Menunggu Approval</span>
                </div>
                {{-- <p class="mb-6 text-xs md:text-base text-gray-500">Harap cek email baru dan isi kolom dengan kode
                    verifikasi
                    yang diberikan untuk melanjutkan</p> --}}
            </div>
            <div x-show="$wire.new_email_issued">
                <input wire:model="verify_issue_code" type="text" wire:target="verify_issue_new_email"
                    wire:loading.class="pointer-events-none opacity-50"
                    @input.debounce.500ms="$el.value.length == 6 ?  $wire.verify_issue_new_email() : ($el.value.length > 6 ? sendNotfy.error('Kode belum sesuai format') : '') "
                    id="verify_issue_code"
                    class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                <div wire:loading.remove wire:target="verify_issue_new_email">
                    <p class="mb-2 text-xs md:text-base text-gray-500">Harap cek email baru dan isi kolom dengan
                        kode
                        verifikasi
                        yang diberikan untuk melanjutkan</p>
                    <p class="mb-6 text-xs md:text-base text-gray-500">Token kadaluarsa? <span
                            class="text-ocean-600 underline font-semibold cursor-pointer"
                            wire:click="resend_change_email_token" wire:loading.remove
                            wire:target="resend_change_email_token">Kirim ulang</span>
                        <span class="text-ocean-600 font-semibold opacity-60 cursor-pointer"
                            wire:click="resend_change_email_token" wire:loading
                            wire:target="resend_change_email_token">Mengirimkan ulang..</span>
                    </p>
                </div>
                <div wire:loading wire:target="verify_issue_new_email"
                    class="flex gap-2 mb-6 text-xs md:text-base text-gray-500">
                    <div class="small-loader"></div>
                    Pengecekan kode
                </div>
            </div>
        </div>
        {{-- @if ($verified_at)
            <div class="flex items-center gap-3">
                <div class="w-full">
                    <div class="flex justify-between">
                        <p class="text-base text-gray-500"><span class="font-bold">Status :</span></p>
                        <p class="text-base text-gray-500"><span class="text-green-500 font-bold">Sudah
                                verifikasi</span>
                    </div>
                    <br>
                    <div class="flex justify-between">
                        <p class="text-base text-gray-500"><span class="font-bold">Waktu :</span></p>
                        <p class="text-base text-gray-500">
                            <span
                                class="pr-2">{{ \Carbon\Carbon::parse($verified_at)->isoFormat('DD MMMM YYYY, HH:mm:ss') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center gap-3">
                <form @submit.prevent="$wire.send_verification_email()" class="w-full">
                    <div class="flex justify-between">
                        <p class="text-base text-gray-500"><span class="font-bold">Status :</span></p>
                        <p class="text-base text-gray-500"><span class="text-red-500 font-bold">Belum
                                verifikasi</span>
                    </div>
                    <br>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-outline-ocean py-2"
                            wire:loading.class="pointer-events-none opacity-80">
                            <div wire:loading.class="hidden"><i class="bi bi-send mr-2"></i>Kirimkan
                                email verifikasi</div>
                            <div class="hidden text-center small-loader" wire:loading.class.remove="hidden"></div>
                        </button>
                    </div>
                </form>
            </div>
        @endif --}}
    </div>
</div>

@push('scripts')
@endpush
