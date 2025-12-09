<div class="grid gap-4 md:gap-6">
    <div class="card bg-base-100 border border-base-300 rounded-xl">
        <div class="card-body">
            <div class="card-title">
                <div class="flex items-start justify-between w-full gap-2">
                    <div class="flex items-center gap-2">
                        <h4 class="text-lg font-semibold">{{ $agenda->name }}</h4>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('agenda.index') }}" class="btn btn-sm" wire:navigate>
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('agenda.rekap', $agenda->id) }}" class="btn btn-sm btn-info" target="_blank">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Rekap PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        <div class="lg:col-span-2">
            <div class="card bg-base-100 border border-base-300">
                <div class="card-body">
                    <div class="card-title pb-3 border-b border-base-300">Informasi Agenda</div>
                    <div class="grid pt-2 grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-base-content/70">Nama Agenda</p>
                            <p class="text-base text-base-content">{{ $agenda->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-base-content/70">OPD Penyelenggara</p>
                            <p class="text-base text-base-content">{{ data_get($agenda, 'opd.name', '-') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-base-content/70">Tanggal</p>
                            <p class="text-base text-base-content">
                                {{ \Carbon\Carbon::parse($agenda->date)->format('d F Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-base-content/70">Waktu</p>
                            <p class="text-base text-base-content">
                                {{ \Carbon\Carbon::parse($agenda->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($agenda->jam_selesai)->format('H:i') }} WIB</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-base-content/70">Status Waktu</p>
                            <div class="font-bold">
                                @if ($agenda->status_waktu == 'sedang_berlangsung')
                                    <span class="badge badge-warning">Sedang Berlangsung</span>
                                @elseif ($agenda->status_waktu == 'akan_datang')
                                    <span class="badge badge-info">Akan Datang</span>
                                @elseif ($agenda->status_waktu == 'menunggu')
                                    <span class="badge badge-neutral">Menunggu</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-base-content/70">Status Agenda</p>
                            <div class="font-bold">
                                @if ($agenda->status === 'aktif')
                                    <span class="badge badge-primary">Aktif</span>
                                @elseif ($agenda->status === 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-error">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-1 pt-1 space-y-3">
                        @if ($agenda->link_zoom)
                            <div
                                class="flex items-center justify-between rounded-lg border border-base-300 bg-base-100 p-3">
                                <span class="text-sm font-medium">Link Zoom</span>
                                <a href="{{ $agenda->link_zoom }}" target="_blank" rel="noopener"
                                    class="btn btn-primary btn-sm">
                                    Buka Zoom
                                </a>
                            </div>
                        @endif
                        @if ($agenda->link_paparan)
                            <div
                                class="flex items-center justify-between rounded-lg border border-base-300 bg-base-100 p-3">
                                <span class="text-sm font-medium">Link Paparan</span>
                                <a href="{{ $agenda->link_paparan }}" target="_blank" rel="noopener"
                                    class="btn btn-primary btn-sm">
                                    Buka Paparan
                                </a>
                            </div>
                        @endif
                        @if ($agenda->catatan)
                            <div class="alert bg-base-200 border border-base-300 mt-1    rounded-lg text-sm">
                                {{ $agenda->catatan }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Barcode -->
        <div class="card items-center">
            <div class="card-title">Isi Daftar Hadir</div>
            <p class="text-sm text-gray-500 mb-2">Isi daftar hadir scan disini.</p>
            @if ($agenda->barcode)
                <a href="{{ route('attendance.form', ['agendaId' => $agenda->id, 'slug' => $agenda->slug]) }}"
                    target="_blank" rel="noopener" class="group inline-block rounded-xl">
                    <img src="{{ asset($agenda->barcode) }}" alt="Barcode Agenda"
                        class="w-72 h-72 md:w-80 md:h-80 object-contain border border-base-300 rounded-xl p-1 bg-white cursor-pointer group-hover:border-primary group-hover:shadow-md transition" />
                </a>
            @else
                <span class="text-gray-400">Belum tersedia</span>
            @endif
        </div>
    </div>

    <!-- Card Statistik Kehadiran -->
    <div>
        <div class="text-lg font-bold mb-2">Statistik Peserta</div>
        <div class="grid grid-cols-3 gap-4 text-center">
            <div class="p-3 rounded-lg border border-success/30">
                <div class="text-2xl font-semibold text-success">{{ $hadirCount }}</div>
                <div class="text-sm text-gray-500">Hadir</div>
            </div>
            <div class="p-3 rounded-lg border border-error/30">
                <div class="text-2xl font-semibold text-error">{{ $tidakHadirCount }}</div>
                <div class="text-sm text-gray-500">Tidak Hadir</div>
            </div>
            <div class="p-3 rounded-lg border border-success/30">
                <div class="text-2xl font-semibold text-success">{{ $totalAttendance }}</div>
                <div class="text-sm text-gray-500">Total Peserta</div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="text-lg font-bold">Daftar Peserta</div>
        <div class="flex gap-2">
            <label class="input w-56">
                <input type="text" wire:model.live="search" class="grow" placeholder="Cari peserta…" />
                <kbd class="kbd kbd-sm">⌘</kbd>
                <kbd class="kbd kbd-sm">K</kbd>
            </label>
            <select wire:model.live="perPage" class="select select-bordered w-24">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-2">
        <table class="table table-md table-zebra table-compact text-sm md:text-base">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP/NIK</th>
                    <th>Jabatan</th>
                    <th>Instansi</th>
                    <th>Waktu Hadir</th>
                    <th>Status</th>
                    <th>Tanda Tangan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $index => $attendance)
                    <tr>
                        <td>{{ ($attendances->currentPage() - 1) * $attendances->perPage() + $index + 1 }}</td>
                        <td>{{ $attendance->name }}</td>
                        <td>{{ $attendance->nip_nik }}</td>
                        <td>{{ $attendance->jabatan }}</td>
                        <td>{{ $attendance->instansi }}</td>
                        <td>{{ $attendance->waktu_hadir ? \Carbon\Carbon::parse($attendance->waktu_hadir)->format('d F Y H:i') : '-' }}
                        </td>
                        <td>
                            @if ($attendance->status == 'hadir')
                                <span class="badge badge-success">Hadir</span>
                            @else
                                <span class="badge badge-error">Tidak Hadir</span>
                            @endif
                        </td>
                        <td>
                            @if ($attendance->ttd)
                                <img src="{{ asset('storage/' . $attendance->ttd) }}" alt="Tanda tangan"
                                    class="h-16 max-w-xs bg-white rounded" />
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <button wire:click="deleteAttendance({{ $attendance->id }})"
                                onclick="confirm('Apakah Anda yakin ingin menghapus absensi ini?') || event.stopImmediatePropagation()"
                                class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-red-500/20 hover:border-red-500/40">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-gray-400">Belum ada peserta yang mendaftar
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $attendances->links('custom-pagination') }}
    </div>
</div>
