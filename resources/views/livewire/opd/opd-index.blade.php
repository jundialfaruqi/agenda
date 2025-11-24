<div class="grid gap-4 md:gap-6">

    <div class="card bg-base-100 border border-base-300 rounded-xl">
        <div class="card-body">
            <div class="card-title">
                <div class="flex items-start justify-between w-full">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1 text-sm font-bold">
                            <svg class="size-4" fill="currentColor" width="12" height="12" viewBox="0 0 256 256"
                                id="Flat" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M216,148H172V108h44a12,12,0,0,0,0-24H172V40a12,12,0,0,0-24,0V84H108V40a12,12,0,0,0-24,0V84H40a12,12,0,0,0,0,24H84v40H40a12,12,0,0,0,0,24H84v44a12,12,0,0,0,24,0V172h40v44a12,12,0,0,0,24,0V172h44a12,12,0,0,0,0-24Zm-108,0V108h40v40Z">
                                </path>
                            </svg>
                            <h4 class="text-lg font-semibold">Data OPD</h4>
                        </div>
                        <span class="text-xs font-light text-gray-400 hidden md:block">
                            Halaman OPD menampilkan seluruh Data OPD berupa Nama, Singkatan, Alamat, No Telpn
                            dan total agenda yang dimiliki oleh OPD tersebut.
                        </span>
                    </div>
                    <a href="{{ route('opd.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah OPD
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-2">
        <label class="input">
            <label class="label">
                <span class="flex gap-1 items-center label-text">
                    <svg class="h-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    Cari OPD
                </span>
            </label>
            <input type="text" wire:model.live="search" class="grow" placeholder="Ketik Nama OPD" />
            <kbd class="kbd kbd-sm">⌘</kbd>
            <kbd class="kbd kbd-sm">K</kbd>
        </label>
        <div class="form-control">
            <select wire:model.live="perPage" class="select select-bordered w-full">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
        <table class="table table-md table-zebra table-compact text-sm md:text-base">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th wire:click="sortBy('name')" class="cursor-pointer">
                        Nama OPD
                        @if ($sortField === 'name')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th>Telp</th>
                    <th>Total Agenda</th>
                    <th>Total Absensi</th>
                    <th class="text-right"></th>
                </tr>
            </thead>

            <tbody>
                @forelse($opds as $opd)
                    <tr>
                        <td class="align-middle">
                            <div class="flex items-center gap-2">
                                @if ($opd->logo)
                                    <div class="avatar">
                                        <div class="w-10 rounded-lg">
                                            <img src="{{ asset('storage/' . $opd->logo) }}" alt="Logo OPD" />
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="bg-neutral text-neutral-content rounded-xl w-10 h-10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <div class="font-medium truncate" title="{{ $opd->name }}">{{ $opd->name }}
                                    </div>
                                    <div class="flex items-center text-xs">
                                        <span class="font-semibold">
                                            {{ $opd->singkatan }}
                                        </span>
                                        <span class="flex items-center ms-1 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            {{ Str::limit($opd->alamat, 50) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $opd->telp }}</td>
                        <td class="text-center">
                            <span class="badge badge-primary font-bold">{{ $opd->agendas_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success font-bold">{{ $opd->absensis_count }}</span>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('opd.edit', $opd->id) }}"
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-yellow-500/20 hover:border-yellow-500/40"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <button onclick="delete_modal_{{ $opd->id }}.showModal()"
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-red-500/20 hover:border-red-500/40 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data OPD</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $opds->links('custom-pagination') }}
    </div>

    <!-- Delete Confirmation Modals -->
    @if ($opds->count() > 0)
        @foreach ($opds as $opd)
            @can('delete-opd')
                <dialog id="delete_modal_{{ $opd->id }}" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box relative">
                        <!-- Close button -->
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <!-- Warning Icon -->
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-lg text-center mb-2">Hapus OPD?</h3>

                        <!-- Message -->
                        <div class="text-center mb-6">
                            <p class="text-gray-600 mb-2">Apakah Anda yakin ingin menghapus OPD:</p>
                            <p class="font-semibold text-lg">{{ $opd->name }}</p>
                            {{-- <p class="text-sm text-gray-500 mt-1">{{ $opd->email }}</p> --}}
                            <br>
                            <span class="text-sm text-red-600">Tindakan ini tidak dapat dibatalkan!</span>
                        </div>

                        <!-- Action buttons -->
                        <div class="modal-action justify-center gap-3">
                            <form method="dialog">
                                <button class="btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </button>
                            </form>
                            <button wire:click="deleteOpd({{ $opd->id }})"
                                onclick="delete_modal_{{ $opd->id }}.close()" class="btn btn-error text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Ya, Hapus OPD
                            </button>
                        </div>
                    </div>

                    <!-- Modal backdrop - click outside to close -->
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>
            @endcan
        @endforeach
    @endif
</div>
