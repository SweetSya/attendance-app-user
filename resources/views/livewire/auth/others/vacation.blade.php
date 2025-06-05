<div x-data="{ view: 'form' }" class="py-7">
    <div>
        <div class="relative">
            <a wire:navigate href="/home" class="absolute left-5 top-1"><i class="bi bi-chevron-left"></i></a>
        </div>
        <h5 id="drawer-right-label" class="text-center mb-5 text-xl sm:text-2xl font-semibold text-gray-500">
            Pengajuan Cuti
        </h5>
        <p class="mb-6 text-center text-xs md:text-base text-gray-500 px-10">Setelah mengajukan cuti, harap hubungi pihak
            yang
            bersangkutan untuk informasi selanjutnya.</p>

    </div>
    <div class="px-5">
        <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="me-2 flex-grow text-left" @click=" view = 'form'">
                    <button
                        :class="view == 'form' ?
                            'text-ocean-600 border-b-2 border-ocean-600 rounded-t-lg active dark:text-ocean-500 dark:border-ocean-500' :
                            'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                        class="w-full inline-flex items-center justify-center p-4 group" aria-current="page">
                        <i class="bi bi-card-list mr-2"></i>Form Pengajuan
                    </button>
                </li>
                <li class="me-2 flex-grow text-left" @click=" view = 'histori'">
                    <button
                        :class="view == 'histori' ?
                            'text-ocean-600 border-b-2 border-ocean-600 rounded-t-lg active dark:text-ocean-500 dark:border-ocean-500' :
                            'border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                        class="w-full inline-flex items-center justify-center p-4 group">
                        <i class="bi bi-ui-checks mr-2"></i>Histori
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div x-show="view == 'form'" class="px-5">
        <div class="mb-6 text-center">
            <form @submit.prevent="$wire.create()">
                <div class="mb-2 text-left">
                    <label for="start" class="text-base text-ocean-600 font-semibold">Dari Tanggal</label>
                    <input wire:model="start" id="start" type="date"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>
                <div class="mb-2 text-left">
                    <label for="end" class="text-base text-ocean-600 font-semibold">Hingga Tanggal</label>
                    <input wire:model="end" id="end" type="date"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500">
                </div>
                <div class="mb-2 text-left">
                    <label for="note" class="text-base text-ocean-600 font-semibold">Tinggalkan Pesan</label>
                    <textarea wire:model="note" cols="30" rows="10" id="note"
                        class="block p-2.5 mb-3 mt-2 w-full text-sm text-gray-600 bg-gray-50 rounded-lg border border-gray-300 focus:ring-ocean-500 focus:border-ocean-500"></textarea>
                </div>
                <button type="submit" class="btn btn-outline-ocean w-full min-w-52 py-3 mt-3">Kirimkan <i
                        class="bi bi-send"></i></button>
            </form>
        </div>
    </div>
    <div x-show="view == 'histori'" class="px-5">
        <p class="text-xs mb-2 text-right text-ocean-600">*Menampilkan 20 pengajuan teratas.</p>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Diajukan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Selama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vacations as $key => $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th class="px-6 py-4">
                                {{ $key + 1 }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD MMM YYYY') }}
                            </th>
                            <td class="px-6 py-4 text-nowrap">
                                ({{ $item->total }} Hari)
                                {{ \Carbon\Carbon::parse($item->start)->isoFormat('DD MMM YYYY') }}
                                -{{ \Carbon\Carbon::parse($item->end)->isoFormat('DD MMM YYYY') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'waiting')
                                    <span
                                        class="bg-blue-100 text-ocean-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-ocean-900 dark:text-ocean-300">Diproses</span>
                                @elseif($item->status == 'rejected')
                                    <span
                                        class="text-nowrap bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak
                                        / Dibatalkan</span>
                                @elseif($item->status == 'approved')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Berjalan</span>
                                @elseif($item->status == 'done')
                                    <span
                                        class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Selesai</span>
                                @else
                                    ?
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($item->status == 'waiting')
                                    <button @click=" $wire.cancel('{{ $item->id }}')"
                                        class="font-medium text-ocean-600 dark:text-ocean-500 hover:underline">Batalkan</button>
                                @else
                                    <span class="text-nowrap">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="flex justify-between mt-3">
            <div class="text-gray-500 text-xs font-light">
                Menampilkan halaman {{ $vacations->current_page }} dari {{ $vacations->last_page }} halaman ( Total
                {{ $vacations->total }} data)
            </div>
            <nav>
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a @click.prevent="$wire.paginate('{{ $vacations->prev_page_url }}')"
                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    <li>
                        <button
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $vacations->current_page }}</button>
                    </li>
                    <li>
                        <a @click.prevent="$wire.paginate('{{ $vacations->next_page_url }}')"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div> --}}
    </div>
</div>
