<div>
    <div class="mx-auto py-8 px-4 sm:px-12 text-all-wide">
        <div class="mb-4">
            <a wire:navigate href="/home" class="text-ocean-500 hover-opacity-down"><i
                    class="bi bi-house-fill mr-2"></i>Beranda</a>
        </div>
        <div class="relative mb-2 p-4 text-white rounded bg-gradient-ocean">
            <div class="flex flex-col justify-center gap-1">
                <p class="font-bold text-xl xs:text-3xl">Notifikasi</p>
                <p class="font-light text-base">Kamu dapat melihat hingga 99 notifikasi terbaru.</p>
                </p>
            </div>
        </div>
        <div class="relative mb-5">
            <div class="flex flex-grow flex-wrap text-ocean-950 mb-4 gap-3">
                <button wire:click="mark_as_read('all')"
                    class="flex-grow btn-outline-ocean opacity-90 rounded p-2"><span wire:loading.remove
                        wire:target="mark_as_read('all')"><i class="bi bi-check-circle mr-1"></i>Sudah dibaca
                        semua</span>
                    <div wire:target="mark_as_read('all')" wire:loading class="small-loader"></div>
                </button>
            </div>
            <div class="flex flex-col gap-5">
                <template x-for ="(notification, index) in $wire.shown_notifications" :key="index">
                    <div class="text-sm text-ocean-900 border-b rounded-s-lg">
                        <div class="w-full">
                            <div class="rounded flex px-1 gap-2">
                                <div
                                    class="flex justify-center items-center bg-gradient-ocean text-white rounded-s px-3">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div class="w-full py-2">
                                    <div class="relative w-full flex justify-between items-center mb-2">
                                        <p class="font-semibold text-xs sm:text-base" x-text="notification.data.title">
                                        <div class="cursor-pointer">
                                            <p class="text-xs" x-text="moment(notification.created_at).fromNow()"></p>
                                            <p class=" absolute right-0 -top-4"
                                                :class="console.log(notification.read_at), notification.read_at != null ?
                                                    'text-ocean-500' : 'text-green-300'">
                                                <i class="bi"
                                                    :class="notification.read_at != null ? 'bi-check-all' : 'bi-bell-fill'"></i>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-xs font-light" x-text="notification.data.message">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <button wire:target="load_show_notifications()" wire:loading.remove
                    x-show="$wire.pagination.count < $wire.notifications.length" wire:click="load_show_notifications()"
                    class="btn btn-outline-ocean flex-grow min-w-52 py-3">
                    <div>
                        Lebih banyak..
                        <i class="bi bi-chevron-double-down ml-2"></i>
                    </div>
                </button>
                <div class="flex justify-center items-center mt-2">
                    <div wire:target="load_show_notifications()" wire:loading class="small-loader"></div>
                    <p wire:target="load_show_notifications()" wire:loading.remove
                        x-show="$wire.pagination.count >= $wire.notifications.length"
                        class="text-gray-500 text-sm leading-tight italic">- Akhir dari data -</p>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
@endpush
