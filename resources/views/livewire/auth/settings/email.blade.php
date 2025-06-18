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
        <div class="mb-6 text-left">
            <div>
                <p class="mb-6 text-xs md:text-base text-gray-500">Harap gunakan email yang aktif, karena akan digunakan
                    pada saat
                    login, mengirimkan notifikasi, dan keperluan lainnya.</p>
            </div>
            <div x-show="!$wire.new_email_issued">
                <div x-show="$wire.issue_state === 'approval'" class="text-left">
                    <div class="mt-2 border p-3 rounded text-left flex items-center gap-3 bg-gray-50">
                        <i class="bi bi-info-circle text-ocean-500 text-lg md:text-2xl"></i>
                        <p class="text-xs md:text-base text-gray-500">Email ini sedang dalam <span
                                class="text-ocean-500">proses perubahan</span> dari <span class="text-ocean-500"
                                x-text="$wire.email"></span> menjadi <span x-text="$wire.existing_issue.email"
                                class="text-ocean-500"></span>
                        </p>
                    </div>
                </div>
                <form class="text-left" wire:submit.prevent="change_email">
                    <div class="mb-6">
                        <label for="email" class="text-ocean-500 font-semibold">Email</label>
                        <input x-show="$wire.issue_state != 'approval'" wire:model="email" type="text" id="email"
                            class="block p-2.5 mb-3 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                        <p x-show="$wire.issue_state != 'approval'" class="mb-2 text-xs md:text-base text-gray-500">
                            Untuk mengajukan perubahan
                            email, harap ubah
                            email berikut dengan email yang baru</p>
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
                    </div>
                </form>
                <div x-show="$wire.issue_state === 'approval'" class="text-center">
                    <p class="mb-3 text-xs md:text-base text-gray-500">Harap <span class=text-ocean-500">menunggu
                            konfirmasi</span> dari HR.
                        Setelah
                        dikonfirmasi, <span class="text-ocean-500">balasan akan
                            dikirimkan melalui email lama.</span></p>
                </div>

                <div x-show="$wire.issue_state && $wire.issue_state === 'pending'">
                    <p class="mb-2 text-xs md:text-base text-gray-500">Sudah memiliki kode pengajuan?</p>
                    <button type="button" @click="$wire.new_email_issued = true"
                        class="btn btn-outline-ocean flex-grow py-2">
                        Masukan kode Pengajuan <i class="bi bi-arrow-right"></i></button>
                </div>

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
                            class="text-ocean-600 underline cursor-pointer" wire:click="resend_change_email_token"
                            wire:loading.remove wire:target="resend_change_email_token">Kirim ulang</span>
                        <span class="text-ocean-600 opacity-60 cursor-pointer" wire:click="resend_change_email_token"
                            wire:loading wire:target="resend_change_email_token">Mengirimkan ulang..</span>
                    </p>
                </div>
                <div wire:loading wire:target="verify_issue_new_email"
                    class="flex gap-2 mb-6 text-xs md:text-base text-gray-500 text-center">
                    <div class="small-loader"></div>
                    Pengecekan kode
                </div>
                <p class="mb-2 text-xs md:text-base text-gray-500">Ajukan perubahan dengan email lain?</p>
                <button type="button" @click="$wire.new_email_issued = false"
                    class="btn btn-outline-ocean flex-grow py-2">
                    Ya, kembali <i class="bi bi-arrow-left"></i></button>
            </div>
        </div>

    </div>
</div>

@push('scripts')
@endpush
