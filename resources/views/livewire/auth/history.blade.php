<div>
    <div class="mx-auto py-8 px-4 sm:px-12 text-all-wide">
        <div class="mb-4">
            <a wire:navigate href="/home" class="text-ocean-500 hover-opacity-down"><i
                    class="bi bi-house-fill mr-2"></i>Beranda</a>
        </div>
        <div class="relative mb-5 p-4 text-white rounded bg-gradient-ocean">
            <div class="flex flex-col justify-center gap-1">
                <p class="font-bold text-xl xs:text-3xl">Histori</p>
                <p class="font-light text-base xs:text-lg">Kamu dapat melihat hingga 60 hari terakhir kegiatan presensimu
                </p>
            </div>
        </div>
        <div class="mb-5 flex items-center gap-3 text-gray-500">
            <i class="bi bi-info-circle"></i>
            <span class="text-sm leading-tight">Jika terdapat kesalahan, kamu dapat <span class="italic">menghubungi
                    pihak terkait</span> untuk
                dilakukasn perbaikan.</span>
        </div>
        <div class="relative mb-5">
            <div class="flex justify-between text-ocean-950 mb-2">
                <p class="font-bold text-base sm:text-xl">Histori Kehadiran</p>
                {{-- <p class="font-light text-base sm:text-xl hover-opacity-down"><i class="bi bi-filter mr-2"></i>Filter
                </p> --}}
            </div>
            <div class="flex flex-col gap-3">
                <template x-for ="(attendance, index) in $wire.shown_attendances" :key="index">
                    <div class="p-4 text-sm text-ocean-800 border border-ocean-300 rounded bg-gradient-ocean-soft">
                        <span class="sr-only">Info</span>
                        <div class="flex items-center justify-between">
                            <div class="rounded flex gap-3 sm:gap-7 px-1">
                                {{-- If absence --}}
                                <div x-show="!['kosong', 'sesuai', 'terlambat'].includes(attendance.type.name)"
                                    class="w-full text-center mx-auto">
                                    <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Tidak Hadir
                                    </p>
                                    <p class="font-bold text-xs sm:text-base capitalize" x-text="attendance.type.name">
                                    </p>
                                </div>
                                {{-- If present --}}
                                <div x-show="['kosong', 'sesuai', 'terlambat'].includes(attendance.type.name)"
                                    class="flex gap-3 sm:gap-7 px-1">
                                    <div class="w-1/2 text-center mx-auto">
                                        <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Clock
                                            In</p>
                                        <p class="font-bold text-xs sm:text-base" x-text="attendance.clock_in ?? '-'">
                                        </p>
                                    </div>
                                    <div class="w-[1px] border"></div>
                                    <div class="w-1/2 text-center mx-auto">
                                        <p class="opacity-70 text-xs sm:text-base text-nowrap font-light">Clock
                                            Out</p>
                                        <p class="font-bold text-xs sm:text-base" x-text="attendance.clock_out ?? '-'">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl sm:text-3xl font-bold" x-text="moment(attendance.date).format('DD')">
                                </p>
                                <p class="text-xs sm:text-base text-gray-500"
                                    x-text="moment(attendance.date).format('MMM YYYY')"></p>
                            </div>
                        </div>
                    </div>
                </template>
                <button wire:loading.remove x-show="$wire.pagination.count < $wire.attendances.length"
                    @click="$wire.pagination.count = $wire.pagination.count + $wire.pagination.per_page, $wire.load_show_attendaces()"
                    class="btn btn-outline-ocean flex-grow min-w-52 py-3">
                    <div>
                        Lebih banyak..
                        <i class="bi bi-chevron-double-down ml-2"></i>
                    </div>
                </button>
                <div class="flex justify-center items-center mt-2">
                    <div wire:loading class="small-loader"></div>
                    <p wire:loading.remove x-show="$wire.pagination.count >= $wire.attendances.length"
                        class="text-gray-500 text-sm leading-tight italic">- Akhir dari data -</p>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
@endpush
