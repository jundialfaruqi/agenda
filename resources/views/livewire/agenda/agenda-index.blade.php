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
                            <h4 class="text-lg font-semibold">Data Agenda</h4>
                        </div>
                        <span class="text-xs font-light text-gray-400 hidden md:block">
                            Halaman Agenda menampilkan seluruh data Agenda beserta OPD, tanggal, waktu, link, total
                            absensi, status, dan aksi.
                        </span>
                    </div>
                    <a href="{{ route('agenda.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Agenda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-3">
        <div>
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
                        Cari Agenda
                    </span>
                </label>
                <input type="text" wire:model.live="search" class="grow" placeholder="Ketik nama agenda" />
                <kbd class="kbd kbd-sm">⌘</kbd>
                <kbd class="kbd kbd-sm">K</kbd>
            </label>
        </div>


        <div class="form-control">
            <select wire:model.live="filterOpd" class="select select-bordered w-full">
                <option value="">Semua OPD</option>
                @foreach ($opds as $opd)
                    <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-control">
            <input type="date" wire:model.live="filterDate" class="input input-bordered w-full" />
        </div>

        <div class="form-control">
            <select wire:model.live="perPage" class="select select-bordered w-17">
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
                        Nama Agenda
                        @if ($sortField === 'name')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th>OPD</th>
                    <th wire:click="sortBy('date')" class="cursor-pointer">
                        Tanggal
                        @if ($sortField === 'date')
                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </th>
                    <th>Total Absensi</th>
                    <th>Status</th>
                    <th class="text-right"></th>
                </tr>
            </thead>

            <tbody>
                @forelse ($agendas as $agenda)
                    <tr>
                        <td class="align-middle">
                            <div class="min-w-0">
                                <div class="font-medium truncate" title="{{ $agenda->name }}">{{ $agenda->name }}</div>
                                <div class="text-xs text-gray-500">Oleh: {{ optional($agenda->user)->name }}</div>
                            </div>
                        </td>
                        <td>
                            <span
                                class="badge badge-primary font-bold">{{ data_get($agenda, 'opd.singkatan', '-') }}</span>
                        </td>
                        <td class="whitespace-nowrap">
                            <div>
                                {{ \Carbon\Carbon::parse($agenda->date)->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $agenda->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $agenda->jam_selesai)->format('H:i') }}
                                Wib
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="font-bold">{{ $agenda->absensis_count }}</span>
                        </td>
                        <td class="text-center whitespace-nowrap font-bold">
                            @php
                                $now = now();
                                $agendaDate = \Carbon\Carbon::parse($agenda->date);
                                $jamMulai = \Carbon\Carbon::parse($agenda->jam_mulai);
                                $jamSelesai = \Carbon\Carbon::parse($agenda->jam_selesai);
                            @endphp

                            @if ($agendaDate->isToday() && $now->between($jamMulai, $jamSelesai))
                                <span class="badge badge-success">Sedang Berlangsung</span>
                            @elseif ($agendaDate->isFuture())
                                <span class="badge badge-info">Akan Datang</span>
                            @elseif ($agendaDate->isToday() && $now->lt($jamMulai))
                                <span class="badge badge-warning">Menunggu</span>
                            @else
                                <span class="badge badge-neutral">Selesai</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('agenda.detail', $agenda->id) }}" wire:navigate
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-sky-500/20 hover:border-sky-500/40"
                                    title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('agenda.edit', $agenda->id) }}" wire:navigate
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-yellow-500/20 hover:border-yellow-500/40"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                <a href="{{ route('attendance.form', ['agendaId' => $agenda->id, 'slug' => $agenda->slug]) }}"
                                    wire:navigate
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-green-500/20 hover:border-green-500/40"
                                    title="Absensi">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" class="size-[1.2em]">
                                        <rect x="3" y="3" width="6" height="6" rx="1" />
                                        <rect x="15" y="3" width="6" height="6" rx="1" />
                                        <rect x="3" y="15" width="6" height="6" rx="1" />
                                        <path d="M15 15h6v6h-6zM17 17h2v2h-2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('agenda.rekap', $agenda->id) }}" wire:navigate
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-primary/20 hover:border-primary/40"
                                    title="Rekap Absensi">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 4.5A1.5 1.5 0 0 1 4.5 3h11.25A1.5 1.5 0 0 1 17.25 4.5V6H19.5A1.5 1.5 0 0 1 21 7.5v12A1.5 1.5 0 0 1 19.5 21H6A1.5 1.5 0 0 1 4.5 19.5V18H3a1.5 1.5 0 0 1-1.5-1.5v-9A1.5 1.5 0 0 1 3 6h1.5V4.5Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 9h6M9 12h6M9 15h3" />
                                    </svg>
                                </a>
                                <button type="button"
                                    onclick="document.getElementById('confirm-delete-{{ $agenda->id }}').showModal()"
                                    class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-red-500/20 hover:border-red-500/40"
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>

                                <!-- Modal Konfirmasi Hapus -->
                                <dialog id="confirm-delete-{{ $agenda->id }}" class="modal">
                                    <div class="modal-box text-center">
                                        <div class="card-title justify-center pb-3 border-b border-base-300">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6 text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                </svg>
                                                <h3 class="text-lg font-bold text-red-500">Hapus Agenda?</h3>
                                            </div>
                                        </div>
                                        <p class="mt-4 text-xs text-gray-500">Tindakan ini akan menghapus agenda
                                            beserta data terkait yang relevan. Proses tidak dapat dibatalkan.</p>

                                        <div class="mt-4 space-y-3">
                                            <div>
                                                <p class="text-sm font-medium">Nama Agenda</p>
                                                <p class="text-gray-600">{{ $agenda->name }}</p>
                                            </div>
                                        </div>

                                        <div class="modal-action justify-center mt-6 pt-4 border-t border-base-300">
                                            <form method="dialog">
                                                <button class="btn">Batal</button>
                                            </form>
                                            <button class="btn btn-error"
                                                onclick="document.getElementById('confirm-delete-{{ $agenda->id }}').close()"
                                                wire:click="deleteAgenda({{ $agenda->id }})">
                                                Ya, Hapus
                                            </button>
                                        </div>
                                    </div>
                                    <form method="dialog" class="modal-backdrop">
                                        <button>Tutup</button>
                                    </form>
                                </dialog>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data Agenda</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $agendas->links('custom-pagination') }}
    </div>
</div>
